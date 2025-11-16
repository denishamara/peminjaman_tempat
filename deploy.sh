#!/bin/bash

# ============================================
# Auto Deploy Script untuk Peminjaman Tempat
# ============================================

# Set warna untuk output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Log function
log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

error() {
    echo -e "${RED}[$(date +'%Y-%m-%d %H:%M:%S')] ERROR:${NC} $1"
}

warn() {
    echo -e "${YELLOW}[$(date +'%Y-%m-%d %H:%M:%S')] WARNING:${NC} $1"
}

# Set project directory
PROJECT_DIR="/var/www/peminjaman_tempat"

log "Starting deployment process..."

# 1. Navigate to project directory
cd $PROJECT_DIR || { error "Failed to navigate to project directory"; exit 1; }
log "Changed to project directory: $PROJECT_DIR"

# 2. Stash any local changes
log "Stashing local changes (if any)..."
git stash

# 3. Pull latest changes from GitHub
log "Pulling latest changes from GitHub..."
git pull origin main || { error "Git pull failed"; exit 1; }
log "Git pull completed successfully"

# 4. Install/Update Composer dependencies (optional, uncomment if needed)
# log "Updating Composer dependencies..."
# composer install --no-dev --optimize-autoloader

# 5. Clear CodeIgniter cache
log "Clearing CodeIgniter cache..."
rm -rf writable/cache/* 2>/dev/null
rm -rf writable/debugbar/* 2>/dev/null
log "Cache cleared"

# 6. Set proper permissions
log "Setting proper permissions..."
chown -R www-data:www-data writable/ 2>/dev/null || warn "Failed to set ownership (may need sudo)"
chmod -R 775 writable/ 2>/dev/null || warn "Failed to set permissions (may need sudo)"

# 7. Restart PHP-FPM (detect version)
log "Restarting PHP-FPM..."
if systemctl is-active --quiet php8.2-fpm; then
    systemctl restart php8.2-fpm || warn "Failed to restart PHP 8.2-FPM"
    log "PHP 8.2-FPM restarted"
elif systemctl is-active --quiet php8.1-fpm; then
    systemctl restart php8.1-fpm || warn "Failed to restart PHP 8.1-FPM"
    log "PHP 8.1-FPM restarted"
elif systemctl is-active --quiet php8.3-fpm; then
    systemctl restart php8.3-fpm || warn "Failed to restart PHP 8.3-FPM"
    log "PHP 8.3-FPM restarted"
else
    warn "PHP-FPM service not found or not running"
fi

# 8. Restart Nginx
log "Restarting Nginx..."
systemctl restart nginx || warn "Failed to restart Nginx"
log "Nginx restarted"

# 9. Optional: Run migrations (uncomment if needed)
# log "Running database migrations..."
# php spark migrate || warn "Migration failed"

log "Deployment completed successfully! 🚀"
exit 0
