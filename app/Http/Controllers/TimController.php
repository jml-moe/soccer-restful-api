<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TimController extends Controller
{
    public function index()
    {
        return response()->json(Tim::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kota' => 'required|string|max:255'
        ]);
        $tim = Tim::create($request->all());
        return response()->json($tim);
    }

    public function show($id)
    {
        $tim = Tim::find($id);
        if (!$tim) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        return response()->json($tim);
    }

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

    public function destroy($id)
    {
        $tim = Tim::find($id);
        if (!$tim) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        $tim->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
