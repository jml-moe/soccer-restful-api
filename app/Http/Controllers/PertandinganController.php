<?php

namespace App\Http\Controllers;

use App\Models\Pertandingan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Pertandingan",
 *     description="Manajemen data pertandingan sepak bola"
 * )
 *
 * @OA\Schema(
 *     schema="Pertandingan",
 *     title="Pertandingan",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="tanggal", type="string", format="date", example="2023-08-01"),
 *     @OA\Property(property="waktu", type="string", example="15:30"),
 *     @OA\Property(property="lokasi", type="string", example="Stadion Utama"),
 *     @OA\Property(property="tim_home_id", type="integer", example=1),
 *     @OA\Property(property="tim_away_id", type="integer", example=2),
 *     @OA\Property(property="skor_home", type="integer", example=2),
 *     @OA\Property(property="skor_away", type="integer", example=1),
 *     @OA\Property(property="liga_id", type="integer", example=1)
 * )
 */
class PertandinganController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pertandingan",
     *     tags={"Pertandingan"},
     *     summary="Menampilkan daftar pertandingan",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar pertandingan",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Pertandingan")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Access Denied")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Terjadi kesalahan pada server.")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tidak ada data pertandingan ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Tidak ada data pertandingan ditemukan"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         ),
     *         content={"application/json":{}}
     *     )
     * )
     */
    public function index()
    {
        $data = Pertandingan::all();
        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data pertandingan ditemukan',
                'data' => []
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Pertandingan',
            'data' => $data
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/pertandingan",
     *     tags={"Pertandingan"},
     *     summary="Menambah pertandingan baru",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"tanggal","waktu","lokasi","tim_home_id","tim_away_id","liga_id"},
     *             @OA\Property(property="tanggal", type="string", format="date", example="2023-08-01"),
     *             @OA\Property(property="waktu", type="string", example="15:30"),
     *             @OA\Property(property="lokasi", type="string", example="Stadion Utama"),
     *             @OA\Property(property="tim_home_id", type="integer", example=1),
     *             @OA\Property(property="tim_away_id", type="integer", example=2),
     *             @OA\Property(property="skor_home", type="integer", example=2),
     *             @OA\Property(property="skor_away", type="integer", example=1),
     *             @OA\Property(property="liga_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pertandingan berhasil dibuat",
     *         @OA\JsonContent(ref="#/components/schemas/Pertandingan"),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             
     *         ),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Access Denied")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Terjadi kesalahan pada server.")),
     *         content={"application/json":{}}
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'tim_home_id' => 'required|exists:tim,id',
            'tim_away_id' => 'required|exists:tim,id',
            'skor_home' => 'nullable|integer',
            'skor_away' => 'nullable|integer',
            'liga_id' => 'required|exists:liga,id'
        ]);
        $pertandingan = Pertandingan::create($request->all());
        return response()->json(['message' => 'Data berhasil dibuat', 'data' => $pertandingan], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/pertandingan/{id}",
     *     tags={"Pertandingan"},
     *     summary="Menampilkan detail pertandingan",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Pertandingan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail Pertandingan",
     *         @OA\JsonContent(ref="#/components/schemas/Pertandingan"),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pertandingan tidak ditemukan",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Data tidak ditemukan")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Access Denied")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Terjadi kesalahan pada server.")),
     *         content={"application/json":{}}
     *     )
     * )
     */
    public function show($id)
    {
        $pertandingan = Pertandingan::find($id);
        if (!$pertandingan) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        return response()->json(['message' => 'Data berhasil ditemukan', 'data' => $pertandingan]);
    }

    /**
     * @OA\Put(
     *     path="/api/pertandingan/{id}",
     *     tags={"Pertandingan"},
     *     summary="Update data pertandingan",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Pertandingan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"tanggal","waktu","lokasi","tim_home_id","tim_away_id","liga_id"},
     *             @OA\Property(property="tanggal", type="string", format="date", example="2023-08-01"),
     *             @OA\Property(property="waktu", type="string", example="15:30"),
     *             @OA\Property(property="lokasi", type="string", example="Stadion Utama"),
     *             @OA\Property(property="tim_home_id", type="integer", example=1),
     *             @OA\Property(property="tim_away_id", type="integer", example=2),
     *             @OA\Property(property="skor_home", type="integer", example=2),
     *             @OA\Property(property="skor_away", type="integer", example=1),
     *             @OA\Property(property="liga_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pertandingan berhasil diupdate",
     *         @OA\JsonContent(ref="#/components/schemas/Pertandingan"),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pertandingan tidak ditemukan",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Data tidak ditemukan")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             
     *         ),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Access Denied")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Terjadi kesalahan pada server.")),
     *         content={"application/json":{}}
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'lokasi' => 'required|string|max:255',
            'tim_home_id' => 'required|exists:tim,id',
            'tim_away_id' => 'required|exists:tim,id',
            'skor_home' => 'nullable|integer',
            'skor_away' => 'nullable|integer',
            'liga_id' => 'required|exists:liga,id'
        ]);
        $pertandingan = Pertandingan::find($id);
        if (!$pertandingan) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        $pertandingan->update($request->all());
        return response()->json(['message' => 'Data berhasil diupdate', 'data' => $pertandingan]);
    }

    /**
     * @OA\Delete(
     *     path="/api/pertandingan/{id}",
     *     tags={"Pertandingan"},
     *     summary="Hapus pertandingan",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Pertandingan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pertandingan berhasil dihapus",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Data berhasil dihapus")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pertandingan tidak ditemukan",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Data tidak ditemukan")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Access Denied")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Terjadi kesalahan pada server.")),
     *         content={"application/json":{}}
     *     )
     * )
     */
    public function destroy($id)
    {
        $pertandingan = Pertandingan::find($id);
        if (!$pertandingan) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        $pertandingan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
