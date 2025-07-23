const swaggerJsdoc = require('swagger-jsdoc');
const swaggerUi = require('swagger-ui-express');

const options = {
  definition: {
    openapi: '3.0.0',
    info: {
      title: 'API Wilayah Indonesia',
      version: '1.0.0',
      description: 'API untuk data wilayah Indonesia (Provinsi, Kabupaten/Kota, Kecamatan, Desa/Kelurahan)',
      contact: {
        name: 'API Support',
        email: 'support@example.com'
      },
      license: {
        name: 'MIT',
        url: 'https://opensource.org/licenses/MIT'
      }
    },
    servers: [
      {
        url: 'http://localhost:3000',
        description: 'Development server'
      }
    ],
    components: {
      schemas: {
        Province: {
          type: 'object',
          properties: {
            kode: {
              type: 'string',
              description: 'Kode provinsi',
              example: '11'
            },
            nama: {
              type: 'string',
              description: 'Nama provinsi',
              example: 'ACEH'
            }
          }
        },
        Regency: {
          type: 'object',
          properties: {
            kode: {
              type: 'string',
              description: 'Kode kabupaten/kota',
              example: '11.01'
            },
            nama: {
              type: 'string',
              description: 'Nama kabupaten/kota',
              example: 'KABUPATEN SIMEULUE'
            }
          }
        },
        District: {
          type: 'object',
          properties: {
            kode: {
              type: 'string',
              description: 'Kode kecamatan',
              example: '11.01.01'
            },
            nama: {
              type: 'string',
              description: 'Nama kecamatan',
              example: 'TEUPAH SELATAN'
            }
          }
        },
        Village: {
          type: 'object',
          properties: {
            kode: {
              type: 'string',
              description: 'Kode desa/kelurahan',
              example: '11.01.01.2001'
            },
            nama: {
              type: 'string',
              description: 'Nama desa/kelurahan',
              example: 'LATIUNG'
            }
          }
        },
        ApiResponse: {
          type: 'object',
          properties: {
            code: {
              type: 'string',
              description: 'Response code',
              example: '200'
            },
            message: {
              type: 'string',
              description: 'Response message',
              example: 'Success'
            },
            data: {
              type: 'array',
              description: 'Response data'
            }
          }
        },
        ErrorResponse: {
          type: 'object',
          properties: {
            code: {
              type: 'string',
              description: 'Error code',
              example: '404'
            },
            message: {
              type: 'string',
              description: 'Error message',
              example: 'Data tidak ditemukan'
            },
            error: {
              type: 'string',
              description: 'Error type',
              example: 'Not Found'
            }
          }
        }
      }
    }
  },
  apis: ['./routes/*.js', './controllers/*.js']
};

const specs = swaggerJsdoc(options);

module.exports = specs;