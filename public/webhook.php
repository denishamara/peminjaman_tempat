<?php
/**
 * GitHub Webhook Auto Deploy - FIXED VERSION
 */

// ============ KONFIGURASI ============
define('SECRET_TOKEN', 'your_secret_token_here_ganti_dengan_random_string');
define('PROJECT_PATH', '/var/www/peminjaman_tempat');
define('LOG_FILE', PROJECT_PATH . '/writable/logs/webhook.log');
define('BRANCH', 'main');
define('PHP_FPM_SERVICE', 'php8.2-fpm');

// ============ FUNGSI LOG ============
function logMessage($message) {
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] {$message}\n";
    file_put_contents(LOG_FILE, $logEntry, FILE_APPEND | LOCK_EX);
    error_log($message); // Juga log ke system log
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
function executeCommand($command) {
    $fullCommand = 'cd ' . PROJECT_PATH . ' && ' . $command . ' 2>&1';
    $output = [];
    $returnCode = 0;
    
    exec($fullCommand, $output, $returnCode);
    
    // Log output
    foreach ($output as $line) {
        logMessage('CMD: ' . $line);
    }
    
    return [
        'success' => $returnCode === 0,
        'output' => $output,
        'return_code' => $returnCode
    ];
}

// ============ FUNGSI SETUP GIT ============
function setupGit() {
    logMessage('Setting up Git...');
    
    $commands = [
        'git config --global --add safe.directory ' . PROJECT_PATH,
        'git config --global user.name "Webhook Deploy"',
        'git config --global user.email "webhook@denishaamara.my.id"'
    ];
    
    $allOutput = [];
    
    foreach ($commands as $command) {
        $result = executeCommand($command);
        $allOutput = array_merge($allOutput, $result['output']);
    }
    
    return $allOutput;
}

// ============ FUNGSI GIT FORCE SYNC ============
function gitForceSync() {
    logMessage('Force syncing Git repository...');
    
    $commands = [
        'git fetch --all',
        'git reset --hard origin/' . BRANCH,
        'git clean -fd -x', // -x untuk hapus file ignored juga
        'git pull origin ' . BRANCH . ' --force'
    ];
    
    $allOutput = [];
    $success = true;
    
    foreach ($commands as $command) {
        $result = executeCommand($command);
        $allOutput = array_merge($allOutput, $result['output']);
        
        if (!$result['success'] && strpos($command, 'git pull') !== false) {
            $success = false;
        }
    }
    
    return [
        'success' => $success,
        'output' => $allOutput
    ];
}

// ============ FUNGSI SET PERMISSIONS ============
function setPermissions() {
    logMessage('Setting permissions...');
    
    $commands = [
        'chmod -R 755 writable/',
        'chmod 755 app/',
        'chmod 755 public/',
        'chown -R www-data:www-data writable/',
        'chmod -R 775 writable/cache/',
        'chmod -R 775 writable/logs/',
        'chmod -R 775 writable/uploads/'
    ];
    
    $allOutput = [];
    
    foreach ($commands as $command) {
        $result = executeCommand($command);
        $allOutput = array_merge($allOutput, $result['output']);
    }
    
    return $allOutput;
}

// ============ FUNGSI CLEAR CACHE ============
function clearCache() {
    logMessage('Clearing cache...');
    
    $commands = [
        'rm -rf writable/cache/*',
        'rm -rf writable/logs/*.log',
        'php spark cache:clear',
        'php spark config:clear',
        'php spark route:clear'
    ];
    
    $allOutput = [];
    
    foreach ($commands as $command) {
        $result = executeCommand($command);
        $allOutput = array_merge($allOutput, $result['output']);
    }
    
    return $allOutput;
}

// ============ FUNGSI RUN MIGRATIONS ============
function runMigrations() {
    logMessage('Running database migrations...');
    
    $result = executeCommand('php spark migrate');
    
    if ($result['success']) {
        logMessage('SUCCESS: Database migrations completed');
    } else {
        logMessage('WARNING: Database migrations may have issues');
    }
    
    return $result;
}

// ============ FUNGSI RESTART SERVICES ============
function restartServices() {
    logMessage('Restarting services...');
    
    $commands = [
        'sudo systemctl restart ' . PHP_FPM_SERVICE,
        'sudo systemctl reload nginx'
    ];
    
    $allOutput = [];
    $success = true;
    
    foreach ($commands as $command) {
        $result = executeCommand($command);
        $allOutput = array_merge($allOutput, $result['output']);
        
        if (!$result['success']) {
            $success = false;
            logMessage('WARNING: Failed to execute: ' . $command);
        }
    }
    
    return [
        'success' => $success,
        'output' => $allOutput
    ];
}

// ============ FUNGSI DEPLOY ============
function runDeployment() {
    $allOutput = [];
    $allOutput[] = '=== DEPLOYMENT STARTED ===';
    
    try {
        // 1. Setup Git
        $allOutput = array_merge($allOutput, setupGit());
        
        // 2. Force Git Sync
        $gitResult = gitForceSync();
        $allOutput = array_merge($allOutput, $gitResult['output']);
        
        if (!$gitResult['success']) {
            throw new Exception('Git sync failed');
        }
        
        // 3. Set Permissions
        $allOutput = array_merge($allOutput, setPermissions());
        
        // 4. Clear Cache
        $allOutput = array_merge($allOutput, clearCache());
        
        // 5. Run Migrations
        $migrationResult = runMigrations();
        $allOutput = array_merge($allOutput, $migrationResult['output']);
        
        // 6. Restart Services
        $serviceResult = restartServices();
        $allOutput = array_merge($allOutput, $serviceResult['output']);
        
        $allOutput[] = '=== DEPLOYMENT COMPLETED SUCCESSFULLY ===';
        return [true, $allOutput];
        
    } catch (Exception $e) {
        logMessage('ERROR: ' . $e->getMessage());
        $allOutput[] = 'ERROR: ' . $e->getMessage();
        $allOutput[] = '=== DEPLOYMENT FAILED ===';
        return [false, $allOutput];
    }
}

// ============ MAIN LOGIC ============
header('Content-Type: application/json');

// Enable error logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', PROJECT_PATH . '/writable/logs/webhook_errors.log');

try {
    // Log request
    logMessage('Webhook triggered from IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
    
    // Ambil payload
    $payload = file_get_contents('php://input');
    $signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
    
    // Verifikasi signature
    if (!verifySignature($payload, $signature)) {
        throw new Exception('Invalid signature');
    }
    
    // Parse payload
    $data = json_decode($payload, true);
    
    // Cek apakah ini push event ke branch main
    if (!isset($data['ref']) || $data['ref'] !== 'refs/heads/main') {
        echo json_encode(['status' => 'skipped', 'message' => 'Not a push to main branch']);
        exit;
    }
    
    // Log info commit
    $commitId = $data['head_commit']['id'] ?? 'unknown';
    $commitMessage = $data['head_commit']['message'] ?? 'No message';
    $committer = $data['head_commit']['committer']['name'] ?? 'unknown';
    
    logMessage("Processing push to main - Commit: {$commitId} - By: {$committer} - Message: {$commitMessage}");
    
    // Jalankan deployment
    list($success, $output) = runDeployment();
    
    if ($success) {
        logMessage('SUCCESS: Deployment completed');
        echo json_encode([
            'status' => 'success',
            'message' => 'Deployment completed',
            'commit' => $commitId,
            'committer' => $committer,
            'commit_message' => $commitMessage,
            'output' => $output
        ]);
    } else {
        throw new Exception('Deployment process failed');
    }
    
} catch (Exception $e) {
    logMessage('ERROR: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>