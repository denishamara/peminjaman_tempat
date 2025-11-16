<?php
/**
 * GitHub Webhook Auto Deploy
 * 
 * Script ini akan otomatis:
 * 1. Pull perubahan dari GitHub
 * 2. Clear cache CodeIgniter
 * 3. Run database migrations
 * 4. Restart PHP-FPM dan Nginx
 * 
 * Setup:
 * 1. Upload file ini ke public/webhook.php di VPS
 * 2. Tambahkan webhook di GitHub repo settings
 * 3. Webhook URL: https://denishaamara.my.id/webhook.php
 * 4. Secret: ganti SECRET_TOKEN di bawah dengan token rahasia kamu
 */

// ============ KONFIGURASI ============
define('SECRET_TOKEN', 'aku-suka-rama-rudi'); // GANTI INI!
define('PROJECT_PATH', '/var/www/peminjaman_tempat');
define('LOG_FILE', PROJECT_PATH . '/writable/logs/webhook.log');
define('BRANCH', 'main');

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

// ============ FUNGSI DEPLOY ============
function runDeployment() {
    $allOutput = [];
    $success = true;
    
    logMessage('=== STARTING DEPLOYMENT ===');
    
    // 1. Git pull latest changes
    logMessage('Pulling latest changes from ' . BRANCH . ' branch...');
    if (!executeCommand('git pull origin ' . BRANCH, $output, $returnCode)) {
        $success = false;
        logMessage('ERROR: Git pull failed');
    }
    $allOutput = array_merge($allOutput, $output);
    
    if (!$success) return [false, $allOutput];
    
    // 2. Set proper permissions
    logMessage('Setting permissions...');
    executeCommand('chmod -R 755 writable/');
    executeCommand('chown -R www-data:www-data writable/');
    
    // 3. Clear CodeIgniter cache
    logMessage('Clearing CodeIgniter cache...');
    executeCommand('rm -rf writable/cache/*');
    
    // 4. Run database migrations
    logMessage('Running database migrations...');
    if (!executeCommand('php spark migrate', $output, $returnCode)) {
        $success = false;
        logMessage('ERROR: Database migration failed');
    }
    $allOutput = array_merge($allOutput, $output);
    
    if (!$success) return [false, $allOutput];
    
    // 5. Clear all caches
    logMessage('Clearing all caches...');
    executeCommand('php spark cache:clear');
    executeCommand('php spark config:clear');
    executeCommand('php spark route:clear');
    
    // 6. Install/update Composer dependencies (jika menggunakan Composer)
    if (file_exists(PROJECT_PATH . '/composer.json')) {
        logMessage('Installing Composer dependencies...');
        if (!executeCommand('composer install --no-dev --optimize-autoloader', $output, $returnCode)) {
            logMessage('WARNING: Composer install failed, but continuing...');
        }
        $allOutput = array_merge($allOutput, $output);
    }
    
    // 7. Restart PHP-FPM (perlu sudo)
    logMessage('Restarting PHP-FPM...');
    if (!executeCommand('sudo systemctl restart php8.1-fpm', $output, $returnCode)) {
        logMessage('WARNING: Failed to restart PHP-FPM, but continuing...');
    }
    $allOutput = array_merge($allOutput, $output);
    
    // 8. Reload Nginx (perlu sudo)
    logMessage('Reloading Nginx...');
    if (!executeCommand('sudo systemctl reload nginx', $output, $returnCode)) {
        logMessage('WARNING: Failed to reload Nginx, but continuing...');
    }
    $allOutput = array_merge($allOutput, $output);
    
    // 9. Update permissions again to ensure everything is correct
    executeCommand('chmod -R 755 writable/');
    executeCommand('chown -R www-data:www-data writable/');
    
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