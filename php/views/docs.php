<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Wilayah Indonesia 2025  Documentation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 0;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 10px;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .section {
            background: white;
            margin-bottom: 30px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .section h2 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.8em;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .endpoint {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .method {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .url {
            font-family: 'Courier New', monospace;
            background: #e9ecef;
            padding: 5px 10px;
            border-radius: 3px;
            display: inline-block;
        }
        
        .response {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            overflow-x: auto;
        }
        
        .try-button {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }
        
        .try-button:hover {
            background: #5a6fd8;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            border-top: 1px solid #dee2e6;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🇮🇩 API Wilayah Indonesia</h1>
            <p>RESTful API untuk Data Wilayah Indonesia</p>
            <p>Provinsi • Kabupaten/Kota • Kecamatan • Desa/Kelurahan</p>
        </div>
        
        <div class="section">
            <h2>📊 Statistik Data</h2>
            <div class="stats" id="stats">
                <div class="stat-card">
                    <div class="stat-number" id="provinces-count">-</div>
                    <div>Provinsi</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="regencies-count">-</div>
                    <div>Kabupaten/Kota</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="districts-count">-</div>
                    <div>Kecamatan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="villages-count">-</div>
                    <div>Desa/Kelurahan</div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <h2>🚀 Quick Start</h2>
            <p>Base URL: <code><?= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) ?></code></p>
            <p>Semua response dalam format JSON dengan encoding UTF-8.</p>
        </div>
        
        <div class="section">
            <h2>📡 API Endpoints</h2>
            
            <div class="endpoint">
                <h3>1. Mendapatkan Semua Provinsi</h3>
                <p><span class="method">GET</span> <span class="url">/api/wilayah/provinces</span></p>
                <p>Mengembalikan daftar semua provinsi di Indonesia.</p>
                <button class="try-button" onclick="tryEndpoint('/api/wilayah/provinces')">Coba Sekarang</button>
                <div class="response" id="response-provinces" style="display:none;"></div>
            </div>
            
            <div class="endpoint">
                <h3>2. Mendapatkan Provinsi Berdasarkan ID</h3>
                <p><span class="method">GET</span> <span class="url">/api/wilayah/provinces/{id}</span></p>
                <p>Mengembalikan detail provinsi berdasarkan ID.</p>
                <p>Contoh: <code>/api/wilayah/provinces/11</code> (Provinsi Aceh)</p>
                <button class="try-button" onclick="tryEndpoint('/api/wilayah/provinces/11')">Coba Sekarang</button>
                <div class="response" id="response-province-detail" style="display:none;"></div>
            </div>
            
            <div class="endpoint">
                <h3>3. Mendapatkan Kabupaten/Kota</h3>
                <p><span class="method">GET</span> <span class="url">/api/wilayah/provinces/{province_id}/regencies</span></p>
                <p>Mengembalikan daftar kabupaten/kota dalam provinsi tertentu.</p>
                <p>Contoh: <code>/api/wilayah/provinces/11/regencies</code></p>
                <button class="try-button" onclick="tryEndpoint('/api/wilayah/provinces/11/regencies')">Coba Sekarang</button>
                <div class="response" id="response-regencies" style="display:none;"></div>
            </div>
            
            <div class="endpoint">
                <h3>4. Mendapatkan Kecamatan</h3>
                <p><span class="method">GET</span> <span class="url">/api/wilayah/regencies/{regency_id}/districts</span></p>
                <p>Mengembalikan daftar kecamatan dalam kabupaten/kota tertentu.</p>
                <p>Contoh: <code>/api/wilayah/regencies/1101/districts</code></p>
                <button class="try-button" onclick="tryEndpoint('/api/wilayah/regencies/1101/districts')">Coba Sekarang</button>
                <div class="response" id="response-districts" style="display:none;"></div>
            </div>
            
            <div class="endpoint">
                <h3>5. Mendapatkan Desa/Kelurahan</h3>
                <p><span class="method">GET</span> <span class="url">/api/wilayah/districts/{district_id}/villages</span></p>
                <p>Mengembalikan daftar desa/kelurahan dalam kecamatan tertentu.</p>
                <p>Contoh: <code>/api/wilayah/districts/1101010/villages</code></p>
                <button class="try-button" onclick="tryEndpoint('/api/wilayah/districts/1101010/villages')">Coba Sekarang</button>
                <div class="response" id="response-villages" style="display:none;"></div>
            </div>
        </div>
        
        <div class="section">
            <h2>📋 Format Response</h2>
            <h3>Success Response:</h3>
            <div class="response">
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
            </div>
            
            <h3>Error Response:</h3>
            <div class="response">
{
  "code": "404",
  "message": "Data tidak ditemukan",
  "timestamp": "2025-01-23T02:30:00+07:00"
}
            </div>
        </div>
        
        <div class="section">
            <h2>🔍 Health Check</h2>
            <p><span class="method">GET</span> <span class="url">/health</span></p>
            <p>Endpoint untuk mengecek status API.</p>
            <button class="try-button" onclick="tryEndpoint('/health')">Coba Sekarang</button>
            <div class="response" id="response-health" style="display:none;"></div>
        </div>
        
        <div class="footer">
            <p>© 2025 SedotPHP - API Wilayah Indonesia 2025</p>
            <p>Email: mosys.id@gmail.com | Phone: 081373350813</p>
        </div>
    </div>
    
    <script>
        // Load statistics on page load
        window.onload = function() {
            loadStats();
        };
        
        function loadStats() {
            fetch('/api/wilayah/provinces')
                .then(response => response.json())
                .then(data => {
                    if (data.total) {
                        document.getElementById('provinces-count').textContent = data.total;
                    }
                })
                .catch(error => console.error('Error loading provinces:', error));
        }
        
        function tryEndpoint(endpoint) {
            const baseUrl = window.location.origin + window.location.pathname.replace('/docs', '');
            const url = baseUrl + endpoint;
            
            // Show loading
            const responseId = 'response-' + endpoint.split('/').pop().replace(/[^a-z]/gi, '-');
            const responseElement = document.getElementById(responseId) || 
                                  document.querySelector(`[id*="${endpoint.split('/').pop()}"]`) ||
                                  document.querySelector('.response[style*="display:none"]');
            
            if (responseElement) {
                responseElement.style.display = 'block';
                responseElement.textContent = 'Loading...';
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (responseElement) {
                        responseElement.textContent = JSON.stringify(data, null, 2);
                    }
                })
                .catch(error => {
                    if (responseElement) {
                        responseElement.textContent = 'Error: ' + error.message;
                    }
                });
        }
    </script>
</body>
</html>
<?php exit; ?>