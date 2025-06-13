<?php

namespace App\Http\Controllers;

use App\Models\Klasemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KlasemenController extends Controller
{
    public function index()
    {
        $klasemen = Klasemen::with('tim')->get();
        return response()->json(['message' => 'Berhasil diambil', 'data' => $klasemen]);
    }

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

    public function show($id)
    {
        $klasemen = Klasemen::with('tim')->findOrFail($id);
        return response()->json(['data' => $klasemen]);
    }

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

    public function destroy($id)
    {
        $klasemen = Klasemen::findOrFail($id);
        $klasemen->delete();
        return response()->json(['message' => 'Klasemen dihapus']);
    }
}
