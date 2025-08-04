<?php
/**
 * Application Configuration File
 * 
 * IMPORTANT: This file contains sensitive information.
 * - Never commit this file to version control
 * - Set proper file permissions (644)
 * - Consider using environment variables for production
 */

// Prevent direct access to this file
if (!defined('ALLOW_CONFIG_ACCESS')) {
    define('ALLOW_CONFIG_ACCESS', true);
}

// =======================
// Environment Detection
// =======================
$is_local = (
    $_SERVER['SERVER_NAME'] === 'localhost' || 
    $_SERVER['SERVER_ADDR'] === '127.0.0.1' ||
    strpos($_SERVER['HTTP_HOST'], 'localhost') !== false
);

define('ENVIRONMENT', $is_local ? 'development' : 'production');
define('DEBUG_MODE', true);

// =======================
// Path Configuration
// =======================
// Dynamic path detection (works on any server)
define('ROOT_PATH', dirname(__FILE__));
define('FULL_PATH', ROOT_PATH); // Alias for compatibility

// URL Configuration with automatic protocol detection
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'employee.tidyrabbit.com';
define('PROJECT_URL', $protocol . $host . '/');

// Additional useful paths
define('INC_PATH', ROOT_PATH . '/inc/');
define('ASSETS_PATH', ROOT_PATH . '/assets/');
define('UPLOADS_PATH', ROOT_PATH . '/uploads/');

// URLs for assets
define('ASSETS_URL', PROJECT_URL . 'assets/');
define('UPLOADS_URL', PROJECT_URL . 'uploads/');

// =======================
// Database Configuration
// =======================
if (ENVIRONMENT === 'development') {
    // Local development database
    define('DATABASE_HOST', 'localhost');
    define('DATABASE_NAME', 'local_database');
    define('DATABASE_USER', 'root');
    define('DATABASE_PASSWORD', '');
} else {
    // Production database
    define('DATABASE_HOST', 'localhost'); // Fixed typo: was 'locahost'
    define('DATABASE_NAME', 'u984874713_zwindia_soft');
    define('DATABASE_USER', 'u984874713_zwindia_root');
    define('DATABASE_PASSWORD', 'UEws49t2iM@EhAa');
}

// Database configuration
define('DATABASE_CHARSET', 'utf8mb4');
define('DATABASE_PORT', 3306);

// =======================
// Security Configuration
// =======================
// Session configuration
define('SESSION_NAME', 'EMPLOYEE_SESS_' . md5(PROJECT_URL));
define('SESSION_LIFETIME', 3600); // 1 hour
define('SESSION_PATH', '/');
define('SESSION_SECURE', !$is_local); // Use secure cookies in production
define('SESSION_HTTPONLY', true);

// CSRF Protection
define('CSRF_TOKEN_NAME', 'csrf_token');
define('CSRF_TOKEN_LENGTH', 32);

// Password hashing
define('PASSWORD_ALGO', PASSWORD_BCRYPT);
define('PASSWORD_OPTIONS', ['cost' => 12]);

// =======================
// Application Settings
// =======================
define('APP_NAME', 'Employee Portal');
define('APP_VERSION', '1.0.0');
define('APP_TIMEZONE', 'Asia/Kolkata'); // Set your timezone

// Email configuration
define('MAIL_FROM_EMAIL', 'noreply@employee.tidyrabbit.com');
define('MAIL_FROM_NAME', APP_NAME);

// Upload limits
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']);

// Pagination
define('RECORDS_PER_PAGE', 20);

define('LOGO_URL', PROJECT_URL . 'assets/logo.svg');
define('CERT_BG_URL', PROJECT_URL . 'sub/epr/assets/img/cert_bg.jpeg');
define('JOHN_SIGN_URL', PROJECT_URL . 'assets/johnsign.png');
define('ZW_SIGIL_URL', PROJECT_URL . 'assets/zwsigil.png');

// =======================
// Error Handling
// =======================
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT_PATH . '/logs/error.log');
}

// =======================
// Timezone Setting
// =======================
date_default_timezone_set(APP_TIMEZONE);

// =======================
// Helper Functions
// =======================
/**
 * Get configuration value with fallback
 */
function config($key, $default = null) {
    return defined($key) ? constant($key) : $default;
}

/**
 * Check if running in development mode
 */
function is_development() {
    return ENVIRONMENT === 'development';
}

/**
 * Check if running in production mode
 */
function is_production() {
    return ENVIRONMENT === 'production';
}

// =======================
// Autoload Function (Optional)
// =======================
spl_autoload_register(function ($class) {
    $file = ROOT_PATH . '/classes/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Prevent any output if this file is accessed directly
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header('HTTP/1.0 403 Forbidden');
    exit('Direct access not permitted');
}