# API Wilayah Indonesia

API RESTful untuk data wilayah Indonesia (Provinsi, Kabupaten/Kota, Kecamatan, Desa/Kelurahan) dengan dokumentasi Swagger.

## 🎯 Fitur

- ✅ **RESTful API**: Endpoint yang clean dan konsisten
- ✅ **Swagger Documentation**: Dokumentasi API yang lengkap dan interaktif
- ✅ **CSV Data Source**: Menggunakan file CSV untuk performa optimal
- ✅ **Logging System**: Sistem logging yang informatif
- ✅ **Error Handling**: Penanganan error yang baik
- ✅ **CORS Support**: Mendukung Cross-Origin Resource Sharing
- ✅ **Security Headers**: Menggunakan Helmet untuk keamanan
- ✅ **Compression**: Response compression untuk performa

## 🚀 Quick Start

### 1. Install Dependencies
```bash
npm install
```

### 2. Jalankan Server
```bash
# Development mode
npm run dev

# Production mode
npm start
```

### 3. Akses API
- **API Base URL**: http://localhost:3000
- **Swagger Docs**: http://localhost:3000/api-docs
- **Health Check**: http://localhost:3000/health

## 📡 API Endpoints

### Provinsi
| Method | Endpoint | Deskripsi |
|--------|----------|----------|
| GET | `/api/wilayah/provinces` | Mendapatkan semua provinsi |
| GET | `/api/wilayah/provinces/:id` | Mendapatkan provinsi berdasarkan ID |

### Kabupaten/Kota
| Method | Endpoint | Deskripsi |
|--------|----------|----------|
| GET | `/api/wilayah/provinces/:province_id/regencies` | Mendapatkan kabupaten/kota berdasarkan ID provinsi |

### Kecamatan
| Method | Endpoint | Deskripsi |
|--------|----------|----------|
| GET | `/api/wilayah/regencies/:regency_id/districts` | Mendapatkan kecamatan berdasarkan ID kabupaten/kota |

### Desa/Kelurahan
| Method | Endpoint | Deskripsi |
|--------|----------|----------|
| GET | `/api/wilayah/districts/:district_id/villages` | Mendapatkan desa/kelurahan berdasarkan ID kecamatan |

## 📋 Contoh Penggunaan

### 1. Mendapatkan Semua Provinsi
```bash
curl http://localhost:3000/api/wilayah/provinces
```

### 2. Mendapatkan Provinsi Berdasarkan ID
```bash
curl http://localhost:3000/api/wilayah/provinces/11
```

### 3. Mendapatkan Kabupaten/Kota di Provinsi
```bash
curl http://localhost:3000/api/wilayah/provinces/11/regencies
```

### 4. Mendapatkan Kecamatan di Kabupaten
```bash
curl http://localhost:3000/api/wilayah/regencies/1101/districts
```

### 5. Mendapatkan Desa/Kelurahan di Kecamatan
```bash
curl http://localhost:3000/api/wilayah/districts/1101010/villages
```

## 📊 Response Format

### Success Response
```json
{
  "code": "200",
  "message": "Data berhasil diambil",
  "data": [
    {
      "id": "11",
      "name": "ACEH"
    }
  ],
  "total": 1,
  "response_time": "15ms"
}
```

### Error Response
```json
{
  "code": "404",
  "message": "Data tidak ditemukan",
  "error": "Not Found"
}
```

## 📁 Struktur Project

```
├── assets/wilayah/          # Data CSV
│   ├── provinces.csv
│   ├── regencies.csv
│   ├── districts.csv
│   └── villages.csv
├── config/
│   └── swagger.js           # Konfigurasi Swagger
├── controllers/
│   └── WilayahController.js # Controller utama
├── routes/
│   └── wilayah.js          # Route definitions
├── utils/
│   └── logger.js           # Logging utility
├── server.js               # Entry point
└── package.json
```

## 🔧 Konfigurasi

### Environment Variables
```bash
# .env file
PORT=3000
NODE_ENV=development
```

### Package.json Scripts
```json
{
  "scripts": {
    "start": "node server.js",
    "dev": "nodemon server.js"
  }
}
```

## 📚 Dokumentasi API

Dokumentasi lengkap tersedia di Swagger UI:
- **URL**: http://localhost:3000/api-docs
- **Format**: OpenAPI 3.0
- **Fitur**: Interactive testing, schema definitions, example responses

## 🛠️ Development

### Menambah Endpoint Baru
1. Tambahkan method di `controllers/WilayahController.js`
2. Tambahkan route di `routes/wilayah.js`
3. Tambahkan dokumentasi Swagger dengan JSDoc

### Logging
Sistem logging tersedia di `utils/logger.js`:
```javascript
const logger = require('../utils/logger');

logger.info('Info message');
logger.error('Error message');
logger.warn('Warning message');
logger.debug('Debug message');
```

## 🔍 Health Check

Endpoint health check tersedia di `/health`:
```bash
curl http://localhost:3000/health
```

Response:
```json
{
  "status": "OK",
  "timestamp": "2025-01-23T01:49:42.644Z",
  "uptime": 123.456
}
```

## 🚀 Deployment

### Production
```bash
# Set environment
export NODE_ENV=production

# Install dependencies
npm ci --only=production

# Start server
npm start
```

### Docker (Opsional)
```dockerfile
FROM node:18-alpine
WORKDIR /app
COPY package*.json ./
RUN npm ci --only=production
COPY . .
EXPOSE 3000
CMD ["npm", "start"]
```

## 📈 Performance

- **Data Loading**: CSV files dimuat ke memory saat startup
- **Response Time**: Rata-rata < 50ms
- **Memory Usage**: ~50MB untuk semua data wilayah
- **Compression**: Gzip compression aktif
- **Caching**: Data di-cache di memory

## 🔐 Security

- **Helmet**: Security headers
- **CORS**: Cross-origin resource sharing
- **Rate Limiting**: Bisa ditambahkan jika diperlukan
- **Input Validation**: Parameter validation
- **Error Handling**: Tidak expose internal errors

## 📝 License

MIT License - Silakan gunakan untuk project apapun.

## 👨‍💻 Contact

- **Email**: mosys.id@gmail.com
- **Phone**: 081373350813
- **Brand**: SedotPHP

---

**Note**: API ini menggunakan data wilayah Indonesia yang akurat dan up-to-date. Cocok untuk aplikasi yang membutuhkan data wilayah Indonesia yang lengkap dan terstruktur.