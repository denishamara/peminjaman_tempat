# Test Webhook PowerShell Script
# Usage: .\test-webhook.ps1

# Configuration
$webhookUrl = "https://denishaamara.my.id/webhook.php"
$secretToken = "your_secret_token_here_ganti_dengan_random_string"  # GANTI dengan token yang sama di webhook.php

# Payload
$payload = @{
    ref = "refs/heads/main"
    repository = @{
        name = "peminjaman_tempat"
        full_name = "denishamara/peminjaman_tempat"
    }
} | ConvertTo-Json -Compress

Write-Host "================================" -ForegroundColor Cyan
Write-Host "Testing Webhook Deployment" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

# Test 1: Basic connectivity
Write-Host "[1] Testing basic connectivity..." -ForegroundColor Yellow
try {
    $headResponse = Invoke-WebRequest -Uri $webhookUrl -Method HEAD -UseBasicParsing
    Write-Host "✓ Webhook URL accessible" -ForegroundColor Green
    Write-Host "  Status: $($headResponse.StatusCode)" -ForegroundColor Gray
} catch {
    Write-Host "✗ Cannot reach webhook URL" -ForegroundColor Red
    Write-Host "  Error: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}

Write-Host ""

# Test 2: Without signature (should fail with "Invalid signature")
Write-Host "[2] Testing without signature..." -ForegroundColor Yellow
try {
    $headers = @{
        "Content-Type" = "application/json"
    }
    $response = Invoke-WebRequest -Uri $webhookUrl -Method POST -Headers $headers -Body $payload -UseBasicParsing
    Write-Host "✗ Unexpected success (should reject without signature)" -ForegroundColor Red
} catch {
    if ($_.Exception.Response.StatusCode -eq 403) {
        Write-Host "✓ Correctly rejected request without signature" -ForegroundColor Green
    } else {
        Write-Host "? Unexpected response" -ForegroundColor Yellow
        Write-Host "  Status: $($_.Exception.Response.StatusCode)" -ForegroundColor Gray
    }
}

Write-Host ""

# Test 3: With invalid signature (should fail with "Invalid signature")
Write-Host "[3] Testing with invalid signature..." -ForegroundColor Yellow
try {
    $headers = @{
        "Content-Type" = "application/json"
        "X-Hub-Signature-256" = "sha256=invalid_signature"
    }
    $response = Invoke-WebRequest -Uri $webhookUrl -Method POST -Headers $headers -Body $payload -UseBasicParsing
    Write-Host "✗ Unexpected success (should reject invalid signature)" -ForegroundColor Red
} catch {
    if ($_.Exception.Response.StatusCode -eq 403) {
        Write-Host "✓ Correctly rejected invalid signature" -ForegroundColor Green
    } else {
        Write-Host "? Unexpected response" -ForegroundColor Yellow
        Write-Host "  Status: $($_.Exception.Response.StatusCode)" -ForegroundColor Gray
    }
}

Write-Host ""

# Test 4: With correct signature
Write-Host "[4] Testing with correct signature..." -ForegroundColor Yellow

# Generate HMAC-SHA256 signature
$hmacsha = New-Object System.Security.Cryptography.HMACSHA256
$hmacsha.Key = [Text.Encoding]::UTF8.GetBytes($secretToken)
$signatureBytes = $hmacsha.ComputeHash([Text.Encoding]::UTF8.GetBytes($payload))
$signature = "sha256=" + [System.BitConverter]::ToString($signatureBytes).Replace('-', '').ToLower()

Write-Host "  Payload: $payload" -ForegroundColor Gray
Write-Host "  Signature: $signature" -ForegroundColor Gray
Write-Host ""

try {
    $headers = @{
        "Content-Type" = "application/json"
        "X-Hub-Signature-256" = $signature
        "X-GitHub-Event" = "push"
    }
    
    $response = Invoke-WebRequest -Uri $webhookUrl -Method POST -Headers $headers -Body $payload -UseBasicParsing
    
    Write-Host "✓ Webhook accepted request!" -ForegroundColor Green
    Write-Host "  Status: $($response.StatusCode)" -ForegroundColor Gray
    Write-Host ""
    Write-Host "Response:" -ForegroundColor Cyan
    Write-Host $response.Content -ForegroundColor White
    
} catch {
    Write-Host "✗ Request failed" -ForegroundColor Red
    Write-Host "  Status: $($_.Exception.Response.StatusCode.value__)" -ForegroundColor Red
    
    # Try to read error response
    try {
        $stream = $_.Exception.Response.GetResponseStream()
        $reader = New-Object System.IO.StreamReader($stream)
        $errorBody = $reader.ReadToEnd()
        Write-Host "  Response: $errorBody" -ForegroundColor Yellow
    } catch {
        Write-Host "  Error: $($_.Exception.Message)" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "================================" -ForegroundColor Cyan
Write-Host "Test Complete" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "1. Check webhook log: tail -f writable/logs/webhook.log" -ForegroundColor Gray
Write-Host "2. Check deployment worked: git log on VPS" -ForegroundColor Gray
Write-Host "3. Verify cache cleared and services restarted" -ForegroundColor Gray
