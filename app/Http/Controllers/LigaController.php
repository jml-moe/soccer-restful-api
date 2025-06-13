<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LigaController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Daftar Liga',
            'data' => Liga::all()
        ]);
    }

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
