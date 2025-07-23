const fs = require('fs');
const path = require('path');
const logger = require('../utils/logger');

class WilayahController {
  constructor() {
    this.dataPath = path.join(__dirname, '../assets/wilayah');
    this.provinces = null;
    this.regencies = null;
    this.districts = null;
    this.villages = null;
  }

  static getInstance() {
    if (!WilayahController.instance) {
      WilayahController.instance = new WilayahController();
      WilayahController.instance.loadData();
    }
    return WilayahController.instance;
  }

  // Load and parse CSV data
  loadData() {
    try {
      // Initialize with empty arrays to prevent crashes
      this.provinces = [];
      this.regencies = [];
      this.districts = [];
      this.villages = [];
      
      // Load provinces
      const provincesPath = path.join(__dirname, '../assets/wilayah/provinces.csv');
      this.provinces = this.parseCSV(provincesPath, ['id', 'name']);
      
      // Load regencies
      const regenciesPath = path.join(__dirname, '../assets/wilayah/regencies.csv');
      this.regencies = this.parseCSV(regenciesPath, ['id', 'province_id', 'name']);
      
      // Load districts
      const districtsPath = path.join(__dirname, '../assets/wilayah/districts.csv');
      this.districts = this.parseCSV(districtsPath, ['id', 'regency_id', 'name']);
      
      // Load villages
      const villagesPath = path.join(__dirname, '../assets/wilayah/villages.csv');
      this.villages = this.parseCSV(villagesPath, ['id', 'district_id', 'name']);
      
      logger.info('Wilayah data loaded successfully', {
        provinces: this.provinces?.length || 0,
        regencies: this.regencies?.length || 0,
        districts: this.districts?.length || 0,
        villages: this.villages?.length || 0
      });
    } catch (error) {
      logger.error('Error loading wilayah data:', error);
      // Initialize with empty arrays on error to prevent crashes
      this.provinces = this.provinces || [];
      this.regencies = this.regencies || [];
      this.districts = this.districts || [];
      this.villages = this.villages || [];
    }
  }

  // Parse CSV file
  parseCSV(filePath, headers) {
    try {
      if (!fs.existsSync(filePath)) {
        logger.warn(`CSV file not found: ${filePath}`);
        return [];
      }
      
      const content = fs.readFileSync(filePath, 'utf8');
      const lines = content.split('\n').filter(line => line.trim());
      
      return lines.map(line => {
        const values = line.split(',');
        const obj = {};
        headers.forEach((header, index) => {
          obj[header] = values[index]?.trim() || '';
        });
        return obj;
      });
    } catch (error) {
      logger.error(`Error parsing CSV file ${filePath}:`, error);
      return [];
    }
  }

  // Get all provinces
  static async getProvinces(req, res) {
    const startTime = Date.now();
    const clientIP = req.ip || req.connection.remoteAddress || 'unknown';
    
    try {
      logger.info(`[WILAYAH] Get provinces request from IP: ${clientIP}`);
      
      const controller = WilayahController.getInstance();
      
      if (!controller.provinces || controller.provinces.length === 0) {
        return res.status(500).json({
          code: '500',
          message: 'Data provinsi tidak tersedia',
          error: 'Internal Server Error'
        });
      }
      
      const responseTime = Date.now() - startTime;
      logger.info(`[WILAYAH] Provinces retrieved successfully in ${responseTime}ms`);
      
      res.json({
        code: '200',
        message: 'Data provinsi berhasil diambil',
        data: controller.provinces,
        total: controller.provinces.length,
        response_time: `${responseTime}ms`
      });
      
    } catch (error) {
      const responseTime = Date.now() - startTime;
      logger.error('[WILAYAH] Error getting provinces:', error);
      
      res.status(500).json({
        code: '500',
        message: 'Gagal mengambil data provinsi',
        error: error.message,
        response_time: `${responseTime}ms`
      });
    }
  }

  // Get regencies by province ID
  static async getRegencies(req, res) {
    const startTime = Date.now();
    const clientIP = req.ip || req.connection.remoteAddress || 'unknown';
    const provinceId = req.params.province_id;
    
    try {
      logger.info(`[WILAYAH] Get regencies for province ${provinceId} from IP: ${clientIP}`);
      
      if (!provinceId) {
        return res.status(400).json({
          code: '400',
          message: 'Province ID diperlukan',
          error: 'Bad Request'
        });
      }
      
      const controller = WilayahController.getInstance();
      
      if (!controller.regencies || controller.regencies.length === 0) {
        return res.status(500).json({
          code: '500',
          message: 'Data kabupaten/kota tidak tersedia',
          error: 'Internal Server Error'
        });
      }
      
      const filteredRegencies = controller.regencies.filter(regency => 
        regency.province_id === provinceId
      );
      
      const responseTime = Date.now() - startTime;
      logger.info(`[WILAYAH] Regencies for province ${provinceId} retrieved successfully in ${responseTime}ms`);
      
      res.json({
        code: '200',
        message: `Data kabupaten/kota untuk provinsi ${provinceId} berhasil diambil`,
        data: filteredRegencies,
        total: filteredRegencies.length,
        province_id: provinceId,
        response_time: `${responseTime}ms`
      });
      
    } catch (error) {
      const responseTime = Date.now() - startTime;
      logger.error(`[WILAYAH] Error getting regencies for province ${provinceId}:`, error);
      
      res.status(500).json({
        code: '500',
        message: 'Gagal mengambil data kabupaten/kota',
        error: error.message,
        response_time: `${responseTime}ms`
      });
    }
  }

  // Get districts by regency ID
  static async getDistricts(req, res) {
    const startTime = Date.now();
    const clientIP = req.ip || req.connection.remoteAddress || 'unknown';
    const regencyId = req.params.regency_id;
    
    try {
      logger.info(`[WILAYAH] Get districts for regency ${regencyId} from IP: ${clientIP}`);
      
      if (!regencyId) {
        return res.status(400).json({
          code: '400',
          message: 'Regency ID diperlukan',
          error: 'Bad Request'
        });
      }
      
      const controller = WilayahController.getInstance();
      
      if (!controller.districts || controller.districts.length === 0) {
        return res.status(500).json({
          code: '500',
          message: 'Data kecamatan tidak tersedia',
          error: 'Internal Server Error'
        });
      }
      
      const filteredDistricts = controller.districts.filter(district => 
        district.regency_id === regencyId
      );
      
      const responseTime = Date.now() - startTime;
      logger.info(`[WILAYAH] Districts for regency ${regencyId} retrieved successfully in ${responseTime}ms`);
      
      res.json({
        code: '200',
        message: `Data kecamatan untuk kabupaten/kota ${regencyId} berhasil diambil`,
        data: filteredDistricts,
        total: filteredDistricts.length,
        regency_id: regencyId,
        response_time: `${responseTime}ms`
      });
      
    } catch (error) {
      const responseTime = Date.now() - startTime;
      logger.error(`[WILAYAH] Error getting districts for regency ${regencyId}:`, error);
      
      res.status(500).json({
        code: '500',
        message: 'Gagal mengambil data kecamatan',
        error: error.message,
        response_time: `${responseTime}ms`
      });
    }
  }

  // Get villages by district ID
  static async getVillages(req, res) {
    const startTime = Date.now();
    const clientIP = req.ip || req.connection.remoteAddress || 'unknown';
    const districtId = req.params.district_id;
    
    try {
      logger.info(`[WILAYAH] Get villages for district ${districtId} from IP: ${clientIP}`);
      
      if (!districtId) {
        return res.status(400).json({
          code: '400',
          message: 'District ID diperlukan',
          error: 'Bad Request'
        });
      }
      
      const controller = WilayahController.getInstance();
      
      if (!controller.villages || controller.villages.length === 0) {
        return res.status(500).json({
          code: '500',
          message: 'Data desa/kelurahan tidak tersedia',
          error: 'Internal Server Error'
        });
      }
      
      const filteredVillages = controller.villages.filter(village => 
        village.district_id === districtId
      );
      
      const responseTime = Date.now() - startTime;
      logger.info(`[WILAYAH] Villages for district ${districtId} retrieved successfully in ${responseTime}ms`);
      
      res.json({
        code: '200',
        message: `Data desa/kelurahan untuk kecamatan ${districtId} berhasil diambil`,
        data: filteredVillages,
        total: filteredVillages.length,
        district_id: districtId,
        response_time: `${responseTime}ms`
      });
      
    } catch (error) {
      const responseTime = Date.now() - startTime;
      logger.error(`[WILAYAH] Error getting villages for district ${districtId}:`, error);
      
      res.status(500).json({
        code: '500',
        message: 'Gagal mengambil data desa/kelurahan',
        error: error.message,
        response_time: `${responseTime}ms`
      });
    }
  }

  // Get specific province by ID
  static async getProvinceById(req, res) {
    const startTime = Date.now();
    const clientIP = req.ip || req.connection.remoteAddress || 'unknown';
    const provinceId = req.params.id;
    
    try {
      logger.info(`[WILAYAH] Get province ${provinceId} from IP: ${clientIP}`);
      
      if (!provinceId) {
        return res.status(400).json({
          code: '400',
          message: 'Province ID diperlukan',
          error: 'Bad Request'
        });
      }
      
      const controller = WilayahController.getInstance();
      
      if (!controller.provinces || controller.provinces.length === 0) {
        return res.status(500).json({
          code: '500',
          message: 'Data provinsi tidak tersedia',
          error: 'Internal Server Error'
        });
      }
      
      const province = controller.provinces.find(p => p.id === provinceId);
      
      if (!province) {
        return res.status(404).json({
          code: '404',
          message: `Provinsi dengan ID ${provinceId} tidak ditemukan`,
          error: 'Not Found'
        });
      }
      
      const responseTime = Date.now() - startTime;
      logger.info(`[WILAYAH] Province ${provinceId} retrieved successfully in ${responseTime}ms`);
      
      res.json({
        code: '200',
        message: `Data provinsi ${provinceId} berhasil diambil`,
        data: province,
        response_time: `${responseTime}ms`
      });
      
    } catch (error) {
      const responseTime = Date.now() - startTime;
      logger.error(`[WILAYAH] Error getting province ${provinceId}:`, error);
      
      res.status(500).json({
        code: '500',
        message: 'Gagal mengambil data provinsi',
        error: error.message,
        response_time: `${responseTime}ms`
      });
    }
  }
}

module.exports = WilayahController;