<?php
/**
 * GitHub Webhook Auto Deploy
 * 
 * Script ini akan otomatis:
 * 1. Pull perubahan dari GitHub
 * 2. Clear cache CodeIgniter
 * 3. Restart PHP-FPM dan Nginx
 * 
 * Setup:
 * 1. Upload file ini ke public/webhook.php di VPS
 * 2. Set permission: chmod +x deploy.sh
 * 3. Tambahkan webhook di GitHub repo settings
 * 4. Webhook URL: https://denishaamara.my.id/webhook.php
 * 5. Secret: ganti SECRET_TOKEN di bawah dengan token rahasia kamu
 */

// ============ KONFIGURASI ============
define('SECRET_TOKEN', 'your_secret_token_here_ganti_dengan_random_string'); // GANTI INI!
define('PROJECT_PATH', '/var/www/peminjaman_tempat');
define('DEPLOY_SCRIPT', PROJECT_PATH . '/deploy.sh');
define('LOG_FILE', PROJECT_PATH . '/writable/logs/webhook.log');

// ============ FUNGSI LOG ============
function logMessage($message) {
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] {$message}\n";
    file_put_contents(LOG_FILE, $logEntry, FILE_APPEND);
}

// ============ VERIFIKASI SIGNATURE ============
function verifySignature($payload, $signature) {
    if (empty($signature)) {
        return false;
    }
    
    $hash = 'sha256=' . hash_hmac('sha256', $payload, SECRET_TOKEN);
    return hash_equals($hash, $signature);
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

// Cek apakah deploy script ada
if (!file_exists(DEPLOY_SCRIPT)) {
    logMessage('ERROR: Deploy script not found at ' . DEPLOY_SCRIPT);
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Deploy script not found']);
    exit;
}

// Jalankan deploy script
logMessage('INFO: Running deployment script...');
$output = [];
$returnCode = 0;

// Execute deploy script
exec('bash ' . DEPLOY_SCRIPT . ' 2>&1', $output, $returnCode);

// Log output
foreach ($output as $line) {
    logMessage('DEPLOY: ' . $line);
}

if ($returnCode === 0) {
    logMessage('SUCCESS: Deployment completed successfully');
    echo json_encode([
        'status' => 'success',
        'message' => 'Deployment completed',
        'output' => $output
    ]);
} else {
    logMessage('ERROR: Deployment failed with return code ' . $returnCode);
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Deployment failed',
        'output' => $output,
        'return_code' => $returnCode
    ]);
}
