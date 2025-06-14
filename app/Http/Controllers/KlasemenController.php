<?php

namespace App\Http\Controllers;

use App\Models\Klasemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Klasemen",
 *     description="Manajemen data klasemen sepak bola"
 * )
 *
 * @OA\Schema(
 *     schema="Klasemen",
 *     title="Klasemen",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="tim_id", type="integer", example=1),
 *     @OA\Property(property="points", type="integer", example=30),
 *     @OA\Property(property="wins", type="integer", example=10),
 *     @OA\Property(property="draws", type="integer", example=5),
 *     @OA\Property(property="losses", type="integer", example=3),
 *     @OA\Property(property="goals_for", type="integer", example=25),
 *     @OA\Property(property="goals_against", type="integer", example=15)
 * )
 */
class KlasemenController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/klasemen",
     *     tags={"Klasemen"},
     *     summary="Menampilkan daftar klasemen",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar klasemen",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Klasemen")),
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
        $klasemen = Klasemen::with('tim')->get();
        return response()->json(['message' => 'Berhasil diambil', 'data' => $klasemen]);
    }

    /**
     * @OA\Post(
     *     path="/api/klasemen",
     *     tags={"Klasemen"},
     *     summary="Menambah klasemen baru",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"tim_id","points","wins","draws","losses","goals_for","goals_against"},
     *             @OA\Property(property="tim_id", type="integer", example=1),
     *             @OA\Property(property="points", type="integer", example=30),
     *             @OA\Property(property="wins", type="integer", example=10),
     *             @OA\Property(property="draws", type="integer", example=5),
     *             @OA\Property(property="losses", type="integer", example=3),
     *             @OA\Property(property="goals_for", type="integer", example=25),
     *             @OA\Property(property="goals_against", type="integer", example=15)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Klasemen berhasil ditambahkan",
     *         @OA\JsonContent(ref="#/components/schemas/Klasemen"),
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
            $validated = $request->validate([
                'tim_id' => 'required|exists:tim,id',
                'points' => 'required|integer',
                'wins' => 'required|integer',
                'draws' => 'required|integer',
                'losses' => 'required|integer',
                'goals_for' => 'required|integer',
                'goals_against' => 'required|integer',
            ]);
    
            $klasemen = Klasemen::create($validated);
            return response()->json(['message' => 'Klasemen ditambahkan', 'data' => $klasemen]);
    }

    /**
     * @OA\Get(
     *     path="/api/klasemen/{id}",
     *     tags={"Klasemen"},
     *     summary="Menampilkan detail klasemen",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Klasemen",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail Klasemen",
     *         @OA\JsonContent(ref="#/components/schemas/Klasemen"),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Klasemen tidak ditemukan",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Klasemen tidak ditemukan")),
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
        $klasemen = Klasemen::with('tim')->findOrFail($id);
        return response()->json(['data' => $klasemen]);
    }

    /**
     * @OA\Put(
     *     path="/api/klasemen/{id}",
     *     tags={"Klasemen"},
     *     summary="Update data klasemen",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Klasemen",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"tim_id","points","wins","draws","losses","goals_for","goals_against"},
     *             @OA\Property(property="tim_id", type="integer", example=1),
     *             @OA\Property(property="points", type="integer", example=30),
     *             @OA\Property(property="wins", type="integer", example=10),
     *             @OA\Property(property="draws", type="integer", example=5),
     *             @OA\Property(property="losses", type="integer", example=3),
     *             @OA\Property(property="goals_for", type="integer", example=25),
     *             @OA\Property(property="goals_against", type="integer", example=15)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Klasemen berhasil diupdate",
     *         @OA\JsonContent(ref="#/components/schemas/Klasemen"),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Klasemen tidak ditemukan",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Klasemen tidak ditemukan")),
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
        $klasemen = Klasemen::findOrFail($id);

        $validated = $request->validate([
            'tim_id' => 'required|exists:tim,id',
            'points' => 'required|integer',
            'wins' => 'required|integer',
            'draws' => 'required|integer',
            'losses' => 'required|integer',
            'goals_for' => 'required|integer',
            'goals_against' => 'required|integer',
        ]);

        $klasemen->update($validated);
        return response()->json(['message' => 'Klasemen diupdate', 'data' => $klasemen]);
    }

    /**
     * @OA\Delete(
     *     path="/api/klasemen/{id}",
     *     tags={"Klasemen"},
     *     summary="Hapus klasemen",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Klasemen",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Klasemen berhasil dihapus",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Klasemen dihapus")),
     *         content={"application/json":{}}
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Klasemen tidak ditemukan",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Klasemen tidak ditemukan")),
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
        $klasemen = Klasemen::findOrFail($id);
        $klasemen->delete();
        return response()->json(['message' => 'Klasemen dihapus']);
    }
}
