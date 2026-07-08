<?php
// ==========================================
// DATABASE CONFIGURATION
// ==========================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'toko_kita');

// ==========================================
// APP CONFIGURATION
// ==========================================
define('APP_URL', 'http://localhost:8000');
define('APP_NAME', 'TokoKita');

// ==========================================
// SESSION CONFIGURATION
// ==========================================
define('SESSION_NAME', 'toko_kita_session');
define('SESSION_TIMEOUT', 3600); // 1 hour

// ==========================================
// UPLOAD CONFIGURATION
// ==========================================
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', '/vanilla-php/uploads/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);
?>
