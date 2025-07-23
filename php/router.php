<?php
/**
 * Router for PHP Built-in Server
 * Handles URL rewriting since .htaccess is not supported
 */

$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Handle static files
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg)$/', $requestPath)) {
    return false; // Let the built-in server handle static files
}

// Check if it's a real file
if (file_exists(__DIR__ . $requestPath) && is_file(__DIR__ . $requestPath)) {
    return false; // Let the built-in server handle it
}

// Route everything else to index.php
$_SERVER['REQUEST_URI'] = $requestUri;
require __DIR__ . '/index.php';
?>