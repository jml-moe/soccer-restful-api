<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Liga",
 *     description="Manajemen data liga sepak bola"
 * )
 *
 * @OA\Schema(
 *     schema="Liga",
 *     title="Liga",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nama", type="string", example="Liga 1 Indonesia"),
 *     @OA\Property(property="tahun_mulai", type="string", example="2023"),
 *     @OA\Property(property="tahun_selesai", type="string", example="2024")
 * )
 */
class LigaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/liga",
     *     tags={"Liga"},
     *     summary="Menampilkan daftar liga",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar liga",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Daftar Liga"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Liga"))
     *         ),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthenticated.")),
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
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Daftar Liga',
            'data' => Liga::all()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/liga",
     *     tags={"Liga"},
     *     summary="Menambah liga baru",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama","tahun_mulai","tahun_selesai"},
     *             @OA\Property(property="nama", type="string", example="Liga 1 Indonesia"),
     *             @OA\Property(property="tahun_mulai", type="string", example="2023"),
     *             @OA\Property(property="tahun_selesai", type="string", example="2024")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liga berhasil ditambahkan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Liga berhasil ditambahkan"),
     *             @OA\Property(property="data", ref="#/components/schemas/Liga")
     *         ),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         ),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthenticated.")),
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
        $data = $request->validate([
            'nama' => 'required|string',
            'tahun_mulai' => 'required|string|size:4',
            'tahun_selesai' => 'required|string|size:4',
        ]);

        $Liga = Liga::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Liga berhasil ditambahkan',
            'data' => $Liga
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/liga/{id}",
     *     tags={"Liga"},
     *     summary="Menampilkan detail liga",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Liga",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail Liga",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Detail Liga"),
     *             @OA\Property(property="data", ref="#/components/schemas/Liga")
     *         ),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Liga tidak ditemukan",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=false), @OA\Property(property="message", type="string", example="Liga tidak ditemukan")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthenticated.")),
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
        $Liga = Liga::find($id);

        if (!$Liga) {
            return response()->json(['success' => false, 'message' => 'Liga tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Liga',
            'data' => $Liga
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/liga/{id}",
     *     tags={"Liga"},
     *     summary="Update data liga",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Liga",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama","tahun_mulai","tahun_selesai"},
     *             @OA\Property(property="nama", type="string", example="Liga 1 Indonesia"),
     *             @OA\Property(property="tahun_mulai", type="string", example="2023"),
     *             @OA\Property(property="tahun_selesai", type="string", example="2024")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liga berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Liga berhasil diupdate"),
     *             @OA\Property(property="data", ref="#/components/schemas/Liga")
     *         ),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Liga tidak ditemukan",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=false), @OA\Property(property="message", type="string", example="Liga tidak ditemukan")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         ),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthenticated.")),
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
            'nama' => 'required|string',
            'tahun_mulai' => 'required|string|size:4',
            'tahun_selesai' => 'required|string|size:4',
        ]);
        $Liga = Liga::find($id);

        if (!$Liga) {
            return response()->json(['success' => false, 'message' => 'Liga tidak ditemukan'], 404);
        }

        $Liga->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Liga berhasil diupdate',
            'data' => $Liga
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/liga/{id}",
     *     tags={"Liga"},
     *     summary="Hapus liga",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Liga",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liga berhasil dihapus",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=true), @OA\Property(property="message", type="string", example="Liga berhasil dihapus")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Liga tidak ditemukan",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean", example=false), @OA\Property(property="message", type="string", example="Liga tidak ditemukan")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthenticated.")),
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
        $Liga = Liga::find($id);

        if (!$Liga) {
            return response()->json(['success' => false, 'message' => 'Liga tidak ditemukan'], 404);
        }

        $Liga->delete();

        return response()->json([
            'success' => true,
            'message' => 'Liga berhasil dihapus'
        ]);
    }
}
