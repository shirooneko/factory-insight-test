<?php

namespace App\Http\Controllers;

use App\Models\MSTModel;
use Illuminate\Http\Request;

class MSTModelController extends Controller
{
    // Menampilkan semua model
    public function index()
    {
        $models = MSTModel::all();
        return view('models.index', compact('models'));
    }

    // Menampilkan form untuk membuat model baru
    public function create()
    {
        return view('models.create');
    }

    // Menyimpan model baru
    public function store(Request $request)
    {
        $request->validate([
            'model_name' => 'required',
            'model_description' => 'nullable',
            'is_active' => 'required|boolean',
        ]);

        MSTModel::create($request->all());
        return redirect()->route('models.index')->with('success', 'Model berhasil ditambahkan');
    }

    // Menampilkan detail model
    public function show($id)
    {
        $model = MSTModel::findOrFail($id);
        return view('models.show', compact('model'));
    }

    // Menampilkan form untuk mengedit model
    public function edit($id)
    {
        $model = MSTModel::findOrFail($id);
        return view('models.edit', compact('model'));
    }

    // Mengupdate model yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'model_name' => 'required',
            'model_description' => 'nullable',
            'is_active' => 'required|boolean',
        ]);

        $model = MSTModel::findOrFail($id);
        $model->update($request->all());
        return redirect()->route('models.index')->with('success', 'Model berhasil diperbarui');
    }

    // Menghapus model
    public function destroy($id)
    {
        $model = MSTModel::findOrFail($id);
        $model->delete();
        return redirect()->route('models.index')->with('success', 'Model berhasil dihapus');
    }
}
