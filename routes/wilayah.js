const express = require('express');
const WilayahController = require('../controllers/WilayahController');

const router = express.Router();

/**
 * @swagger
 * /api/new-wilayah/provinces:
 *   get:
 *     summary: Mendapatkan semua provinsi (New Controller)
 *     tags: [New Provinces]
 *     responses:
 *       200:
 *         description: Berhasil mendapatkan data provinsi
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 code:
 *                   type: string
 *                   example: "200"
 *                 message:
 *                   type: string
 *                   example: "Data provinsi berhasil diambil"
 *                 data:
 *                   type: array
 *                   items:
 *                     type: object
 *                     properties:
 *                       id:
 *                         type: string
 *                         example: "11"
 *                       name:
 *                         type: string
 *                         example: "Aceh"
 *                 total:
 *                   type: integer
 *                   example: 38
 *                 response_time:
 *                   type: string
 *                   example: "15ms"
 *       500:
 *         description: Server error
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/ErrorResponse'
 */
router.get('/provinces', WilayahController.getProvinces);

/**
 * @swagger
 * /api/new-wilayah/provinces/{id}:
 *   get:
 *     summary: Mendapatkan provinsi berdasarkan ID (New Controller)
 *     tags: [New Provinces]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *         description: ID provinsi
 *         example: "11"
 *     responses:
 *       200:
 *         description: Berhasil mendapatkan data provinsi
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 code:
 *                   type: string
 *                   example: "200"
 *                 message:
 *                   type: string
 *                   example: "Data provinsi 11 berhasil diambil"
 *                 data:
 *                   type: object
 *                   properties:
 *                     id:
 *                       type: string
 *                       example: "11"
 *                     name:
 *                       type: string
 *                       example: "Aceh"
 *                 response_time:
 *                   type: string
 *                   example: "10ms"
 *       404:
 *         description: Provinsi tidak ditemukan
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/ErrorResponse'
 */
router.get('/provinces/:id', WilayahController.getProvinceById);

/**
 * @swagger
 * /api/new-wilayah/provinces/{province_id}/regencies:
 *   get:
 *     summary: Mendapatkan kabupaten/kota berdasarkan ID provinsi (New Controller)
 *     tags: [New Regencies]
 *     parameters:
 *       - in: path
 *         name: province_id
 *         required: true
 *         schema:
 *           type: string
 *         description: ID provinsi
 *         example: "11"
 *     responses:
 *       200:
 *         description: Berhasil mendapatkan data kabupaten/kota
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 code:
 *                   type: string
 *                   example: "200"
 *                 message:
 *                   type: string
 *                   example: "Data kabupaten/kota untuk provinsi 11 berhasil diambil"
 *                 data:
 *                   type: array
 *                   items:
 *                     type: object
 *                     properties:
 *                       id:
 *                         type: string
 *                         example: "11.01"
 *                       province_id:
 *                         type: string
 *                         example: "11"
 *                       name:
 *                         type: string
 *                         example: "Kabupaten Aceh Selatan"
 *                 total:
 *                   type: integer
 *                   example: 23
 *                 province_id:
 *                   type: string
 *                   example: "11"
 *                 response_time:
 *                   type: string
 *                   example: "12ms"
 *       400:
 *         description: Province ID diperlukan
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/ErrorResponse'
 */
router.get('/provinces/:province_id/regencies', WilayahController.getRegencies);

/**
 * @swagger
 * /api/new-wilayah/regencies/{regency_id}/districts:
 *   get:
 *     summary: Mendapatkan kecamatan berdasarkan ID kabupaten/kota (New Controller)
 *     tags: [New Districts]
 *     parameters:
 *       - in: path
 *         name: regency_id
 *         required: true
 *         schema:
 *           type: string
 *         description: ID kabupaten/kota
 *         example: "11.01"
 *     responses:
 *       200:
 *         description: Berhasil mendapatkan data kecamatan
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 code:
 *                   type: string
 *                   example: "200"
 *                 message:
 *                   type: string
 *                   example: "Data kecamatan untuk kabupaten/kota 11.01 berhasil diambil"
 *                 data:
 *                   type: array
 *                   items:
 *                     type: object
 *                     properties:
 *                       id:
 *                         type: string
 *                         example: "11.01.01"
 *                       regency_id:
 *                         type: string
 *                         example: "11.01"
 *                       name:
 *                         type: string
 *                         example: "Teupah Selatan"
 *                 total:
 *                   type: integer
 *                   example: 18
 *                 regency_id:
 *                   type: string
 *                   example: "11.01"
 *                 response_time:
 *                   type: string
 *                   example: "8ms"
 *       400:
 *         description: Regency ID diperlukan
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/ErrorResponse'
 */
router.get('/regencies/:regency_id/districts', WilayahController.getDistricts);

/**
 * @swagger
 * /api/new-wilayah/districts/{district_id}/villages:
 *   get:
 *     summary: Mendapatkan desa/kelurahan berdasarkan ID kecamatan (New Controller)
 *     tags: [New Villages]
 *     parameters:
 *       - in: path
 *         name: district_id
 *         required: true
 *         schema:
 *           type: string
 *         description: ID kecamatan
 *         example: "11.01.01"
 *     responses:
 *       200:
 *         description: Berhasil mendapatkan data desa/kelurahan
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 code:
 *                   type: string
 *                   example: "200"
 *                 message:
 *                   type: string
 *                   example: "Data desa/kelurahan untuk kecamatan 11.01.01 berhasil diambil"
 *                 data:
 *                   type: array
 *                   items:
 *                     type: object
 *                     properties:
 *                       id:
 *                         type: string
 *                         example: "11.01.01.2001"
 *                       district_id:
 *                         type: string
 *                         example: "11.01.01"
 *                       name:
 *                         type: string
 *                         example: "Latiung"
 *                 total:
 *                   type: integer
 *                   example: 15
 *                 district_id:
 *                   type: string
 *                   example: "11.01.01"
 *                 response_time:
 *                   type: string
 *                   example: "5ms"
 *       400:
 *         description: District ID diperlukan
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/ErrorResponse'
 */
router.get('/districts/:district_id/villages', WilayahController.getVillages);

module.exports = router;