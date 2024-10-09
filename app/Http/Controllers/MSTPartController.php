<?php

namespace App\Http\Controllers;

use App\Models\MSTPart;
use App\Models\MSTModel;
use Illuminate\Http\Request;

class MSTPartController extends Controller
{
    // Menampilkan semua parts
    public function index()
    {
        $parts = MSTPart::with('model')->get();
        return view('parts.index', compact('parts'));
    }

    // Menampilkan form untuk membuat part baru
    public function create()
    {
        $models = MSTModel::all();
        return view('parts.create', compact('models'));
    }

    // Menyimpan part baru
    public function store(Request $request)
    {
        $request->validate([
            'model_id' => 'required|exists:mst_models,id',
            'part_name' => 'required',
            'part_code' => 'required',
            'part_number' => 'nullable',
            'capacity_in_cart' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        MSTPart::create($request->all());
        return redirect()->route('parts.index')->with('success', 'Part berhasil ditambahkan');
    }

    // Menampilkan detail part
    public function show($id)
    {
        $part = MSTPart::findOrFail($id);
        return view('parts.show', compact('part'));
    }

    // Menampilkan form untuk mengedit part
    public function edit($id)
    {
        $part = MSTPart::findOrFail($id);
        $models = MSTModel::all();
        return view('parts.edit', compact('part', 'models'));
    }

    // Mengupdate part yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'model_id' => 'required|exists:mst_models,id',
            'part_name' => 'required',
            'part_code' => 'required',
            'part_number' => 'nullable',
            'capacity_in_cart' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $part = MSTPart::findOrFail($id);
        $part->update($request->all());
        return redirect()->route('parts.index')->with('success', 'Part berhasil diperbarui');
    }

    // Menghapus part
    public function destroy($id)
    {
        $part = MSTPart::findOrFail($id);
        $part->delete();
        return redirect()->route('parts.index')->with('success', 'Part berhasil dihapus');
    }
}
