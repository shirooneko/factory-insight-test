<?php

namespace App\Http\Controllers;

use App\Models\MSTModel;
use Illuminate\Http\Request;

class MSTModelController extends Controller
{
    public function index()
    {
        $models = MSTModel::all();
        return view('models.index', compact('models'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'model_name' => 'required',
            'model_description' => 'nullable',
        ]);

        $data = $request->all();
        $data['is_active'] = isset($data['is_active']) ? $data['is_active'] : 1;

        MSTModel::create($data);

        return redirect()->route('models.index')->with('success', 'Model berhasil ditambahkan');
    }

    public function show($id)
    {
        $model = MSTModel::findOrFail($id);
        return view('models.show', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'model_name' => 'required',
            'model_description' => 'nullable',
        ]);

        $model = MSTModel::findOrFail($id);

        if ($request->has('model_name') || $request->has('model_description')) {
            $model->model_name = $request->input('model_name');
            $model->model_description = $request->input('model_description');
        }

        $model->updated_at = now();
        $model->save();

        return redirect()->route('models.index')->with('success', 'Model berhasil diperbarui');
    }

    public function destroy($id)
    {
        $model = MSTModel::findOrFail($id);
        $model->is_active = 0;
        $model->save();
        return redirect()->route('models.index')->with('success', 'Model berhasil dinonaktifkan');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $models = MSTModel::where('model_name', 'LIKE', "%{$query}%")
                          ->orWhere('model_description', 'LIKE', "%{$query}%")
                          ->get();

        return response()->json($models);
    }
}
