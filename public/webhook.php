<?php
/**
 * GitHub Webhook Auto Deploy
 * 
 * Script ini akan otomatis:
 * 1. Pull perubahan dari GitHub
 * 2. Clear cache CodeIgniter
 * 3. Run database migrations
 * 4. Restart PHP-FPM 8.2 dan Nginx
 * 
 * Setup:
 * 1. Upload file ini ke public/webhook.php di VPS
 * 2. Tambahkan webhook di GitHub repo settings
 * 3. Webhook URL: https://denishaamara.my.id/webhook.php
 * 4. Secret: ganti SECRET_TOKEN di bawah dengan token rahasia kamu
 */

// ============ KONFIGURASI ============
define('SECRET_TOKEN', 'your_secret_token_here_ganti_dengan_random_string'); // GANTI INI!
define('PROJECT_PATH', '/var/www/peminjaman_tempat');
define('LOG_FILE', PROJECT_PATH . '/writable/logs/webhook.log');
define('BRANCH', 'main');
define('PHP_FPM_SERVICE', 'php8.2-fpm'); // Sesuai dengan PHP 8.2

// ============ FUNGSI LOG ============
function logMessage($message) {
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] {$message}\n";
    file_put_contents(LOG_FILE, $logEntry, FILE_APPEND | LOCK_EX);
}

// ============ VERIFIKASI SIGNATURE ============
function verifySignature($payload, $signature) {
    if (empty($signature)) {
        return false;
    }
    
    $hash = 'sha256=' . hash_hmac('sha256', $payload, SECRET_TOKEN);
    return hash_equals($hash, $signature);
}

// ============ FUNGSI EXECUTE COMMAND ============
function executeCommand($command, &$output = null, &$returnCode = null) {
    $fullCommand = 'cd ' . PROJECT_PATH . ' && ' . $command . ' 2>&1';
    exec($fullCommand, $output, $returnCode);
    
    // Log output
    foreach ($output as $line) {
        logMessage('CMD: ' . $line);
    }
    
    return $returnCode === 0;
}

// ============ FUNGSI SETUP GIT SAFETY ============
function setupGitSafety() {
    logMessage('Setting up Git safety...');
    
    // Set safe directory untuk Git
    $commands = [
        'git config --global --add safe.directory ' . PROJECT_PATH,
        'git config --global user.name "Webhook Deploy"',
        'git config --global user.email "webhook@denishaamara.my.id"'
    ];
    
    foreach ($commands as $command) {
        executeCommand($command);
    }
}

// ============ FUNGSI DEPLOY ============
function runDeployment() {
    $allOutput = [];
    
    logMessage('=== STARTING DEPLOYMENT ===');
    
    // 1. Setup Git safety first
    setupGitSafety();
    
    // 2. Reset any local changes dan pull latest changes
    logMessage('Resetting any local changes and pulling latest changes...');
    $gitCommands = [
        'git fetch origin',
        'git reset --hard origin/' . BRANCH,
        'git clean -fd'
    ];
    
    foreach ($gitCommands as $gitCommand) {
        if (!executeCommand($gitCommand, $output, $returnCode)) {
            logMessage('WARNING: Git command failed: ' . $gitCommand);
        }
        $allOutput = array_merge($allOutput, $output);
    }
    
    // 3. Set proper permissions
    logMessage('Setting permissions...');
    $permissionCommands = [
        'chmod -R 755 writable/',
        'chmod 755 app/',
        'chmod 755 public/'
    ];
    
    foreach ($permissionCommands as $cmd) {
        executeCommand($cmd);
    }
    
    // Change ownership to www-data
    executeCommand('chown -R www-data:www-data writable/');
    
    // 4. Clear CodeIgniter cache
    logMessage('Clearing CodeIgniter cache...');
    $cacheCommands = [
        'rm -rf writable/cache/*',
        'rm -rf writable/logs/*.log',
        'rm -rf writable/session/*'
    ];
    
    foreach ($cacheCommands as $cmd) {
        executeCommand($cmd);
    }
    
    // 5. Run database migrations
    logMessage('Running database migrations...');
    if (!executeCommand('php spark migrate', $output, $returnCode)) {
        logMessage('WARNING: Database migration might have issues');
    }
    $allOutput = array_merge($allOutput, $output);
    
    // 6. Clear all caches
    logMessage('Clearing all caches...');
    $sparkCommands = [
        'php spark cache:clear',
        'php spark config:clear', 
        'php spark route:clear'
    ];
    
    foreach ($sparkCommands as $cmd) {
        executeCommand($cmd);
    }
    
    // 7. Install/update Composer dependencies (jika menggunakan Composer)
    if (file_exists(PROJECT_PATH . '/composer.json')) {
        logMessage('Installing Composer dependencies...');
        if (!executeCommand('composer install --no-dev --optimize-autoloader', $output, $returnCode)) {
            logMessage('WARNING: Composer install failed');
        }
        $allOutput = array_merge($allOutput, $output);
    }
    
    // 8. Set final permissions
    logMessage('Setting final permissions...');
    executeCommand('chmod -R 755 writable/');
    executeCommand('chown -R www-data:www-data writable/');
    
    // 9. Restart PHP-FPM 8.2 (perlu sudo)
    logMessage('Restarting PHP-FPM 8.2...');
    if (!executeCommand('sudo systemctl restart ' . PHP_FPM_SERVICE, $output, $returnCode)) {
        logMessage('WARNING: Failed to restart PHP-FPM 8.2');
    }
    $allOutput = array_merge($allOutput, $output);
    
    // 10. Reload Nginx (perlu sudo)
    logMessage('Reloading Nginx...');
    if (!executeCommand('sudo systemctl reload nginx', $output, $returnCode)) {
        logMessage('WARNING: Failed to reload Nginx');
    }
    $allOutput = array_merge($allOutput, $output);
    
    // 11. Verify deployment
    logMessage('Verifying deployment...');
    executeCommand('php --version', $output);
    $allOutput = array_merge($allOutput, $output);
    
    logMessage('=== DEPLOYMENT COMPLETED SUCCESSFULLY ===');
    
    return [true, $allOutput];
}

// ============ MAIN LOGIC ============
// Set header
header('Content-Type: application/json');

// Log request
logMessage('Webhook triggered from IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));

// Ambil payload
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

// Verifikasi signature
if (!verifySignature($payload, $signature)) {
    logMessage('ERROR: Invalid signature');
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Invalid signature']);
    exit;
}

// Parse payload
$data = json_decode($payload, true);

// Cek apakah ini push event ke branch main
if (!isset($data['ref']) || $data['ref'] !== 'refs/heads/main') {
    logMessage('INFO: Not a push to main branch, skipping deployment');
    echo json_encode(['status' => 'skipped', 'message' => 'Not a push to main branch']);
    exit;
}

// Log info commit
$commitId = $data['head_commit']['id'] ?? 'unknown';
$commitMessage = $data['head_commit']['message'] ?? 'No message';
$committer = $data['head_commit']['committer']['name'] ?? 'unknown';
logMessage("INFO: Processing push to main - Commit: {$commitId} - By: {$committer} - Message: {$commitMessage}");

// Jalankan deployment
list($success, $output) = runDeployment();

if ($success) {
    logMessage('SUCCESS: Deployment completed successfully');
    echo json_encode([
        'status' => 'success',
        'message' => 'Deployment completed',
        'commit' => $commitId,
        'committer' => $committer,
        'commit_message' => $commitMessage,
        'output' => $output
    ]);
} else {
    logMessage('ERROR: Deployment failed');
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Deployment failed',
        'commit' => $commitId,
        'committer' => $committer,
        'commit_message' => $commitMessage,
        'output' => $output
    ]);
}
?>