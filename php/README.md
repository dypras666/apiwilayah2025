# API Wilayah Indonesia 2025

Versi PHP dari API RESTful untuk data wilayah Indonesia (Provinsi, Kabupaten/Kota, Kecamatan, Desa/Kelurahan).

## 🎯 Fitur

- ✅ **PHP Native**: Menggunakan fitur terbaru PHP > 8
- ✅ **RESTful API**: Endpoint yang clean dan konsisten
- ✅ **CSV Data Source**: Menggunakan file CSV untuk performa optimal
- ✅ **Logging System**: Sistem logging yang informatif
- ✅ **Error Handling**: Penanganan error yang baik
- ✅ **CORS Support**: Mendukung Cross-Origin Resource Sharing
- ✅ **Security Headers**: Headers keamanan dengan .htaccess
- ✅ **Clean URLs**: URL rewriting untuk endpoint yang bersih
- ✅ **Interactive Docs**: Dokumentasi API yang interaktif

## 🚀 Quick Start

### 1. Requirements
- PHP >8 atau lebih tinggi
- Apache/Nginx dengan mod_rewrite
- Extension: json, fileinfo

### 2. Installation
```bash
# Clone atau copy folder php ke web server
cp -r php/ /path/to/webserver/

# Set permissions (Linux/Mac)
chmod -R 755 /path/to/webserver/php/
chmod -R 777 /path/to/webserver/php/logs/
```

### 3. Akses API
- **API Base URL**: http://localhost/apiwilayah/php
- **Interactive Docs**: http://localhost/apiwilayah/php/docs
- **Health Check**: http://localhost/apiwilayah/php/health

## 📡 API Endpoints

### Provinsi
| Method | Endpoint | Deskripsi |
|--------|----------|----------|
| GET | `/api/wilayah/provinces` | Mendapatkan semua provinsi |
| GET | `/api/wilayah/provinces/{id}` | Mendapatkan provinsi berdasarkan ID |

### Kabupaten/Kota
| Method | Endpoint | Deskripsi |
|--------|----------|----------|
| GET | `/api/wilayah/provinces/{province_id}/regencies` | Mendapatkan kabupaten/kota berdasarkan ID provinsi |

### Kecamatan
| Method | Endpoint | Deskripsi |
|--------|----------|----------|
| GET | `/api/wilayah/regencies/{regency_id}/districts` | Mendapatkan kecamatan berdasarkan ID kabupaten/kota |

### Desa/Kelurahan
| Method | Endpoint | Deskripsi |
|--------|----------|----------|
| GET | `/api/wilayah/districts/{district_id}/villages` | Mendapatkan desa/kelurahan berdasarkan ID kecamatan |

## 📋 Contoh Penggunaan

### 1. Mendapatkan Semua Provinsi
```bash
curl http://localhost/apiwilayah/php/api/wilayah/provinces
```

### 2. Mendapatkan Provinsi Berdasarkan ID
```bash
curl http://localhost/apiwilayah/php/api/wilayah/provinces/11
```

### 3. Mendapatkan Kabupaten/Kota di Provinsi
```bash
curl http://localhost/apiwilayah/php/api/wilayah/provinces/11/regencies
```

### 4. Menggunakan JavaScript
```javascript
// Fetch provinces
fetch('http://localhost/apiwilayah/php/api/wilayah/provinces')
  .then(response => response.json())
  .then(data => {
    console.log('Provinces:', data.data);
  });

// Fetch regencies
fetch('http://localhost/apiwilayah/php/api/wilayah/provinces/11/regencies')
  .then(response => response.json())
  .then(data => {
    console.log('Regencies:', data.data);
  });
```

## 📊 Response Format

### Success Response
```json
{
  "code": "200",
  "message": "Data berhasil diambil",
  "timestamp": "2025-01-23T02:30:00+07:00",
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
  "timestamp": "2025-01-23T02:30:00+07:00"
}
```

## 📁 Struktur Project

```
php/
├── assets/                  # Symlink ke data CSV
│   └── wilayah/
│       ├── provinces.csv
│       ├── regencies.csv
│       ├── districts.csv
│       └── villages.csv
├── config/
│   └── config.php          # Konfigurasi aplikasi
├── controllers/
│   └── WilayahController.php # Controller utama
├── utils/
│   ├── CsvReader.php       # CSV reader utility
│   ├── Response.php        # Response formatter
│   └── Logger.php          # Logging utility
├── views/
│   └── docs.php           # Dokumentasi interaktif
├── logs/                   # Log files
├── .htaccess              # URL rewriting & security
├── index.php              # Entry point
└── README.md
```

## 🔧 Konfigurasi

### Environment Variables
Edit `config/config.php` untuk konfigurasi:

```php
// Cache settings
define('CACHE_ENABLED', true);
define('CACHE_TTL', 300); // 5 minutes

// Response settings
define('DEFAULT_LIMIT', 100);
define('MAX_LIMIT', 1000);

// CORS settings
define('CORS_ORIGINS', '*');
```

### Apache Configuration
Pastikan mod_rewrite aktif:
```apache
LoadModule rewrite_module modules/mod_rewrite.so

<Directory "/path/to/webserver">
    AllowOverride All
    Require all granted
</Directory>
```

### Nginx Configuration
```nginx
location /apiwilayah/php {
    try_files $uri $uri/ /apiwilayah/php/index.php?$query_string;
    
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🛠️ Development

### Menambah Endpoint Baru
1. Tambahkan method di `controllers/WilayahController.php`
2. Tambahkan route di `index.php`
3. Update dokumentasi di `views/docs.php`

### Logging
```php
$logger = new Logger();

$logger->info('Info message');
$logger->error('Error message');
$logger->warning('Warning message');
$logger->debug('Debug message'); // Only in development
```

### Custom Response
```php
$response = new Response();

// Success response
$response->success([
    'data' => $data,
    'total' => count($data)
]);

// Error response
$response->error('Custom error message', 400);

// JSON response
$response->json(['custom' => 'data']);
```

## 🔍 Health Check

Endpoint health check tersedia di `/health`:
```bash
curl http://localhost/apiwilayah/php/health
```

Response:
```json
{
  "code": "200",
  "message": "Data berhasil diambil",
  "timestamp": "2025-01-23T02:30:00+07:00",
  "status": "OK",
  "uptime": 123,
  "php_version": "8.x.x",
  "memory_usage": 2097152
}
```

## 📈 Performance

- **Data Loading**: CSV files dimuat ke memory dengan caching
- **Response Time**: Rata-rata < 30ms
- **Memory Usage**: ~20MB untuk semua data wilayah
- **Compression**: Gzip compression aktif via .htaccess
- **Caching**: Data di-cache di memory selama 5 menit

## 🔐 Security

- **Security Headers**: X-Content-Type-Options, X-Frame-Options, X-XSS-Protection
- **CORS**: Configurable cross-origin resource sharing
- **File Protection**: Sensitive files protected via .htaccess
- **Input Validation**: Parameter validation dan sanitization
- **Error Handling**: Tidak expose internal errors

## 🚀 Deployment

### Shared Hosting
1. Upload folder `php/` ke public_html
2. Pastikan PHP 8.+ tersedia
3. Set permissions untuk folder `logs/`
4. Akses via domain.com/php/

### VPS/Dedicated Server
1. Setup Apache/Nginx dengan PHP 8.x+
2. Clone repository ke document root
3. Set virtual host jika diperlukan
4. Configure SSL certificate

### Docker
```dockerfile
FROM php:8.x-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy application
COPY php/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/
RUN chmod -R 777 /var/www/html/logs/

EXPOSE 80
```

## 🐛 Troubleshooting

### Error: 500 Internal Server Error
- Cek PHP error log di `logs/php_errors.log`
- Pastikan permissions folder `logs/` writable
- Cek PHP version (minimal 8.x.x)

### Error: 404 Not Found
- Pastikan mod_rewrite aktif
- Cek file `.htaccess` ada dan readable
- Cek virtual host configuration

### Error: CSV file not found
- Pastikan symlink `assets/` mengarah ke data CSV
- Cek permissions folder assets
- Pastikan file CSV ada dan readable

## 📝 License

MIT License - Silakan gunakan untuk project apapun.

## 👨‍💻 Contact

- **Email**: mosys.id@gmail.com
- **Phone**: 081373350813
- **Brand**: SedotPHP

---

**Note**: Versi PHP ini kompatibel dengan shared hosting dan mudah di-deploy. Cocok untuk aplikasi yang membutuhkan data wilayah Indonesia dengan performa tinggi tanpa database.