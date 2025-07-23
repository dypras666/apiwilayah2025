<?php
/**
 * API Wilayah Indonesia - PHP 8 Version
 * RESTful API untuk data wilayah Indonesia
 * 
 * @author SedotPHP
 * @email mosys.id@gmail.com
 * @phone 081373350813
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'config/config.php';
require_once 'controllers/WilayahController.php';
require_once 'utils/Logger.php';
require_once 'utils/Response.php';

$logger = new Logger();
$response = new Response();

try {
    $requestUri = $_SERVER['REQUEST_URI'];
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    
    // Remove query string
    $path = parse_url($requestUri, PHP_URL_PATH);
    
    // Remove base path if exists
    $basePath = '/apiwilayah/php';
    if (strpos($path, $basePath) === 0) {
        $path = substr($path, strlen($basePath));
    }
    
    $logger->info("Request: {$requestMethod} {$path}");
    
    // Route handling
    $controller = new WilayahController();
    
    switch ($path) {
        case '/':
        case '':
            $response->success([
                'message' => 'API Wilayah Indonesia',
                'version' => '1.0.0',
                'endpoints' => [
                    'provinces' => '/api/wilayah/provinces',
                    'regencies' => '/api/wilayah/provinces/{province_id}/regencies',
                    'districts' => '/api/wilayah/regencies/{regency_id}/districts',
                    'villages' => '/api/wilayah/districts/{district_id}/villages',
                    'health' => '/health',
                    'docs' => '/docs'
                ]
            ]);
            break;
            
        case '/health':
            $response->success([
                'status' => 'OK',
                'timestamp' => date('c'),
                'uptime' => time() - $_SERVER['REQUEST_TIME'],
                'php_version' => PHP_VERSION,
                'memory_usage' => memory_get_usage(true)
            ]);
            break;
            
        case '/docs':
            require_once 'views/docs.php';
            break;
            
        case '/api/wilayah/provinces':
            if ($requestMethod === 'GET') {
                $controller->getProvinces();
            } else {
                $response->error('Method not allowed', 405);
            }
            break;
            
        default:
            // Handle dynamic routes
            if (preg_match('/^\/api\/wilayah\/provinces\/(\d+)$/', $path, $matches)) {
                if ($requestMethod === 'GET') {
                    $controller->getProvinceById($matches[1]);
                } else {
                    $response->error('Method not allowed', 405);
                }
            } elseif (preg_match('/^\/api\/wilayah\/provinces\/(\d+)\/regencies$/', $path, $matches)) {
                if ($requestMethod === 'GET') {
                    $controller->getRegencies($matches[1]);
                } else {
                    $response->error('Method not allowed', 405);
                }
            } elseif (preg_match('/^\/api\/wilayah\/regencies\/([\d\.]+)$/', $path, $matches)) {
                if ($requestMethod === 'GET') {
                    $controller->getRegencyById($matches[1]);
                } else {
                    $response->error('Method not allowed', 405);
                }
            } elseif (preg_match('/^\/api\/wilayah\/regencies\/([\d\.]+)\/districts$/', $path, $matches)) {
                if ($requestMethod === 'GET') {
                    $controller->getDistricts($matches[1]);
                } else {
                    $response->error('Method not allowed', 405);
                }
            } elseif (preg_match('/^\/api\/wilayah\/districts\/([\d\.]+)$/', $path, $matches)) {
                if ($requestMethod === 'GET') {
                    $controller->getDistrictById($matches[1]);
                } else {
                    $response->error('Method not allowed', 405);
                }
            } elseif (preg_match('/^\/api\/wilayah\/districts\/([\d\.]+)\/villages$/', $path, $matches)) {
                if ($requestMethod === 'GET') {
                    $controller->getVillages($matches[1]);
                } else {
                    $response->error('Method not allowed', 405);
                }
            } else {
                $response->error('Endpoint not found', 404);
            }
            break;
    }
    
} catch (Exception $e) {
    $logger->error('Error: ' . $e->getMessage());
    $response->error('Internal server error', 500);
}
?>