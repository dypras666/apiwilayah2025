<?php
/**
 * Configuration file for API Wilayah Indonesia
 */

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Memory limit
ini_set('memory_limit', '128M');

// Constants
define('APP_NAME', 'API Wilayah Indonesia');
define('APP_VERSION', '1.0.0');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');

// Paths
define('BASE_PATH', dirname(__DIR__));
define('DATA_PATH', BASE_PATH . '/assets/wilayah');
define('LOG_PATH', BASE_PATH . '/logs');

// Create logs directory if not exists
if (!is_dir(LOG_PATH)) {
    mkdir(LOG_PATH, 0755, true);
}

// Cache settings
define('CACHE_ENABLED', true);
define('CACHE_TTL', 300); // 5 minutes

// Response settings
define('DEFAULT_LIMIT', 100);
define('MAX_LIMIT', 1000);

// CORS settings
define('CORS_ORIGINS', '*');
define('CORS_METHODS', 'GET, POST, OPTIONS');
define('CORS_HEADERS', 'Content-Type, Authorization');

?>