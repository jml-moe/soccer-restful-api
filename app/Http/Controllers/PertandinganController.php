<?php

namespace App\Http\Controllers;

use App\Models\Pertandingan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PertandinganController extends Controller
{
    public function index()
    {
        return response()->json(Pertandingan::all());
    }

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

    public function show($id)
    {
        $pertandingan = Pertandingan::find($id);
        if (!$pertandingan) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        return response()->json(['message' => 'Data berhasil ditemukan', 'data' => $pertandingan]);
    }

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

    public function destroy($id)
    {
        $pertandingan = Pertandingan::find($id);
        if (!$pertandingan) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        $pertandingan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
