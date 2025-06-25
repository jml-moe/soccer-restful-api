<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Tim",
 *     description="Manajemen data tim sepak bola"
 * )
 *
 * @OA\Schema(
 *     schema="Tim",
 *     title="Tim",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nama", type="string", example="Persija Jakarta"),
 *     @OA\Property(property="kota", type="string", example="Jakarta")
 * )
 */
class TimController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tim",
     *     tags={"Tim"},
     *     summary="Menampilkan daftar tim",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar tim",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Tim")),
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
     *         description="Tidak ada data tim ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Tidak ada data tim ditemukan")
     *         ),
     *         content={"application/json":{}}
     *     )
     * )
     */
    public function index()
    {
        $data = Tim::all();
        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data tim ditemukan',
                
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar Tim',
            'data' => $data
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/tim",
     *     tags={"Tim"},
     *     summary="Menambah tim baru",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama","kota"},
     *             @OA\Property(property="nama", type="string", example="Persija Jakarta"),
     *             @OA\Property(property="kota", type="string", example="Jakarta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tim berhasil ditambahkan",
     *         @OA\JsonContent(ref="#/components/schemas/Tim"),
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
            'nama' => 'required|string|max:255',
            'kota' => 'required|string|max:255'
        ]);
        $tim = Tim::create($request->all());
        return response()->json($tim);
    }

    /**
     * @OA\Get(
     *     path="/api/tim/{id}",
     *     tags={"Tim"},
     *     summary="Menampilkan detail tim",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Tim",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail Tim",
     *         @OA\JsonContent(ref="#/components/schemas/Tim"),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tim tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Data tidak ditemukan")
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
    public function show($id)
    {
        $tim = Tim::find($id);
        if (!$tim) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        return response()->json($tim);
    }

    /**
     * @OA\Put(
     *     path="/api/tim/{id}",
     *     tags={"Tim"},
     *     summary="Update data tim",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Tim",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama","kota"},
     *             @OA\Property(property="nama", type="string", example="Persija Jakarta"),
     *             @OA\Property(property="kota", type="string", example="Jakarta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tim berhasil diupdate",
     *         @OA\JsonContent(ref="#/components/schemas/Tim"),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tim tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Data tidak ditemukan")
     *         ),
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
            'nama' => 'required|string|max:255',
            'kota' => 'required|string|max:255'
        ]);
        $tim = Tim::find($id);
        if (!$tim) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        $tim->update($request->all());
        return response()->json($tim);
    }

    /**
     * @OA\Delete(
     *     path="/api/tim/{id}",
     *     tags={"Tim"},
     *     summary="Hapus tim",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Tim",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tim berhasil dihapus",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Data berhasil dihapus")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tim tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Data tidak ditemukan")
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
    public function destroy($id)
    {
        $tim = Tim::find($id);
        if (!$tim) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        $tim->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
