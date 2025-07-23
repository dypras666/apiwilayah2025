<?php
/**
 * Wilayah Controller
 * Handles all wilayah-related API endpoints
 */

require_once __DIR__ . '/../utils/CsvReader.php';
require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/../utils/Logger.php';

class WilayahController
{
    private CsvReader $csvReader;
    private Response $response;
    private Logger $logger;
    private array $cache = [];
    
    public function __construct()
    {
        $this->csvReader = new CsvReader();
        $this->response = new Response();
        $this->logger = new Logger();
    }
    
    /**
     * Get all provinces
     */
    public function getProvinces(): void
    {
        $startTime = microtime(true);
        
        try {
            $provinces = $this->csvReader->getProvinces();
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2) . 'ms';
            
            $this->response->success([
                'data' => $provinces,
                'total' => count($provinces),
                'response_time' => $responseTime
            ]);
            
        } catch (Exception $e) {
            $this->logger->error('Error getting provinces: ' . $e->getMessage());
            $this->response->error('Failed to get provinces', 500);
        }
    }
    
    /**
     * Get province by ID
     */
    public function getProvinceById(string $id): void
    {
        $startTime = microtime(true);
        
        try {
            $province = $this->csvReader->getProvinceById($id);
            
            if (!$province) {
                $this->response->error('Province not found', 404);
                return;
            }
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2) . 'ms';
            
            $this->response->success([
                'data' => $province,
                'response_time' => $responseTime
            ]);
            
        } catch (Exception $e) {
            $this->logger->error('Error getting province by ID: ' . $e->getMessage());
            $this->response->error('Failed to get province', 500);
        }
    }
    
    /**
     * Get regencies by province ID
     */
    public function getRegencies(string $provinceId): void
    {
        $startTime = microtime(true);
        
        try {
            // Validate province exists
            $province = $this->csvReader->getProvinceById($provinceId);
            if (!$province) {
                $this->response->error('Province not found', 404);
                return;
            }
            
            $regencies = $this->csvReader->getRegenciesByProvinceId($provinceId);
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2) . 'ms';
            
            $this->response->success([
                'data' => $regencies,
                'total' => count($regencies),
                'province' => $province,
                'response_time' => $responseTime
            ]);
            
        } catch (Exception $e) {
            $this->logger->error('Error getting regencies: ' . $e->getMessage());
            $this->response->error('Failed to get regencies', 500);
        }
    }
    
    /**
     * Get regency by ID
     */
    public function getRegencyById(string $id): void
    {
        $startTime = microtime(true);
        
        try {
            $regency = $this->csvReader->getRegencyById($id);
            
            if (!$regency) {
                $this->response->error('Regency not found', 404);
                return;
            }
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2) . 'ms';
            
            $this->response->success([
                'data' => $regency,
                'response_time' => $responseTime
            ]);
            
        } catch (Exception $e) {
            $this->logger->error('Error getting regency by ID: ' . $e->getMessage());
            $this->response->error('Failed to get regency', 500);
        }
    }
    
    /**
     * Get districts by regency ID
     */
    public function getDistricts(string $regencyId): void
    {
        $startTime = microtime(true);
        
        try {
            // Validate regency exists
            $regency = $this->csvReader->getRegencyById($regencyId);
            if (!$regency) {
                $this->response->error('Regency not found', 404);
                return;
            }
            
            $districts = $this->csvReader->getDistrictsByRegencyId($regencyId);
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2) . 'ms';
            
            $this->response->success([
                'data' => $districts,
                'total' => count($districts),
                'regency' => $regency,
                'response_time' => $responseTime
            ]);
            
        } catch (Exception $e) {
            $this->logger->error('Error getting districts: ' . $e->getMessage());
            $this->response->error('Failed to get districts', 500);
        }
    }
    
    /**
     * Get district by ID
     */
    public function getDistrictById(string $id): void
    {
        $startTime = microtime(true);
        
        try {
            $district = $this->csvReader->getDistrictById($id);
            
            if (!$district) {
                $this->response->error('District not found', 404);
                return;
            }
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2) . 'ms';
            
            $this->response->success([
                'data' => $district,
                'response_time' => $responseTime
            ]);
            
        } catch (Exception $e) {
            $this->logger->error('Error getting district by ID: ' . $e->getMessage());
            $this->response->error('Failed to get district', 500);
        }
    }
    
    /**
     * Get villages by district ID
     */
    public function getVillages(string $districtId): void
    {
        $startTime = microtime(true);
        
        try {
            // Validate district exists
            $district = $this->csvReader->getDistrictById($districtId);
            if (!$district) {
                $this->response->error('District not found', 404);
                return;
            }
            
            $villages = $this->csvReader->getVillagesByDistrictId($districtId);
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2) . 'ms';
            
            $this->response->success([
                'data' => $villages,
                'total' => count($villages),
                'district' => $district,
                'response_time' => $responseTime
            ]);
            
        } catch (Exception $e) {
            $this->logger->error('Error getting villages: ' . $e->getMessage());
            $this->response->error('Failed to get villages', 500);
        }
    }
}

?>