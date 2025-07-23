<?php
/**
 * CSV Reader Utility
 * Handles reading and caching CSV data
 */

class CsvReader
{
    private array $cache = [];
    private int $cacheTime = 0;
    private Logger $logger;
    
    public function __construct()
    {
        $this->logger = new Logger();
        $this->loadData();
    }
    
    /**
     * Load all CSV data into cache
     */
    private function loadData(): void
    {
        $currentTime = time();
        
        // Check if cache is still valid
        if (CACHE_ENABLED && !empty($this->cache) && ($currentTime - $this->cacheTime) < CACHE_TTL) {
            return;
        }
        
        try {
            $this->cache = [
                'provinces' => $this->readCsv('provinces.csv'),
                'regencies' => $this->readCsv('regencies.csv'),
                'districts' => $this->readCsv('districts.csv'),
                'villages' => $this->readCsv('villages.csv')
            ];
            
            $this->cacheTime = $currentTime;
            
            $this->logger->info('CSV data loaded successfully');
            
        } catch (Exception $e) {
            $this->logger->error('Failed to load CSV data: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Read CSV file
     */
    private function readCsv(string $filename): array
    {
        $filepath = DATA_PATH . '/' . $filename;
        
        if (!file_exists($filepath)) {
            throw new Exception("CSV file not found: {$filename}");
        }
        
        $data = [];
        $handle = fopen($filepath, 'r');
        
        if ($handle === false) {
            throw new Exception("Cannot open CSV file: {$filename}");
        }
        
        while (($row = fgetcsv($handle)) !== false) {
            // Handle different CSV structures
            if ($filename === 'provinces.csv' && count($row) >= 2) {
                // provinces.csv: id,name
                $data[] = [
                    'id' => trim($row[0]),
                    'name' => trim($row[1])
                ];
            } elseif (in_array($filename, ['regencies.csv', 'districts.csv', 'villages.csv']) && count($row) >= 3) {
                // regencies.csv, districts.csv, villages.csv: id,parent_id,name
                $data[] = [
                    'id' => trim($row[0]),
                    'name' => trim($row[2]) // Name is in the 3rd column
                ];
            }
        }
        
        fclose($handle);
        
        return $data;
    }
    
    /**
     * Get all provinces
     */
    public function getProvinces(): array
    {
        $this->loadData();
        return $this->cache['provinces'] ?? [];
    }
    
    /**
     * Get province by ID
     */
    public function getProvinceById(string $id): ?array
    {
        $provinces = $this->getProvinces();
        
        foreach ($provinces as $province) {
            if ($province['id'] === $id) {
                return $province;
            }
        }
        
        return null;
    }
    
    /**
     * Get regencies by province ID
     */
    public function getRegenciesByProvinceId(string $provinceId): array
    {
        $this->loadData();
        $regencies = $this->cache['regencies'] ?? [];
        $result = [];
        
        foreach ($regencies as $regency) {
            // Regency ID format: {province_id}{regency_code}
            if (str_starts_with($regency['id'], $provinceId)) {
                $result[] = $regency;
            }
        }
        
        return $result;
    }
    
    /**
     * Get regency by ID
     */
    public function getRegencyById(string $id): ?array
    {
        $this->loadData();
        $regencies = $this->cache['regencies'] ?? [];
        
        foreach ($regencies as $regency) {
            if ($regency['id'] === $id) {
                return $regency;
            }
        }
        
        return null;
    }
    
    /**
     * Get districts by regency ID
     */
    public function getDistrictsByRegencyId(string $regencyId): array
    {
        $this->loadData();
        $districts = $this->cache['districts'] ?? [];
        $result = [];
        
        foreach ($districts as $district) {
            // District ID format: {regency_id}{district_code}
            if (str_starts_with($district['id'], $regencyId)) {
                $result[] = $district;
            }
        }
        
        return $result;
    }
    
    /**
     * Get district by ID
     */
    public function getDistrictById(string $id): ?array
    {
        $this->loadData();
        $districts = $this->cache['districts'] ?? [];
        
        foreach ($districts as $district) {
            if ($district['id'] === $id) {
                return $district;
            }
        }
        
        return null;
    }
    
    /**
     * Get villages by district ID
     */
    public function getVillagesByDistrictId(string $districtId): array
    {
        $this->loadData();
        $villages = $this->cache['villages'] ?? [];
        $result = [];
        
        foreach ($villages as $village) {
            // Village ID format: {district_id}{village_code}
            if (str_starts_with($village['id'], $districtId)) {
                $result[] = $village;
            }
        }
        
        return $result;
    }
    
    /**
     * Get cache statistics
     */
    public function getCacheStats(): array
    {
        $this->loadData();
        
        return [
            'provinces' => count($this->cache['provinces'] ?? []),
            'regencies' => count($this->cache['regencies'] ?? []),
            'districts' => count($this->cache['districts'] ?? []),
            'villages' => count($this->cache['villages'] ?? []),
            'cache_time' => $this->cacheTime,
            'cache_age' => time() - $this->cacheTime
        ];
    }
}

?>