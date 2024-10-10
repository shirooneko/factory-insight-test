<?php
// app/Http/Controllers/MSTPartController.php

namespace App\Http\Controllers;

use App\Models\MSTPart;
use App\Models\MSTModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class MSTPartController extends Controller
{
    // Menampilkan semua parts
    public function index(Request $request)
    {
        $perPage = 10; // Anda dapat mengubah ini sesuai kebutuhan
        $parts = MSTPart::with('model')->paginate($perPage);
        $models = MSTModel::all(); // Ambil semua data model
        $nextPartNumber = $this->generateNextPartNumber();
    
        // Decode JSON menjadi array atau objek
        foreach ($parts as $part) {
            $part->illustration_filenames = json_decode($part->image_filename, true);
        }
    
        return view('parts.index', compact('parts', 'models', 'nextPartNumber'));
    }
     

    // Menyimpan part baru

    public function store(Request $request)
    {
        $request->validate([
            'part_name' => 'required|string|max:255',
            'model_id' => 'required|integer',
            'part_code' => 'required|string|max:255',
            'part_number' => 'required|string|max:255|unique:mst_parts,part_number',
            'illustration_fix' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'illustration_move' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'illustration_core' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'capacity' => 'required|integer',
        ]);
    
        // Array untuk menyimpan nama file yang disimpan
        $illustrations = ['illustration_fix', 'illustration_move', 'illustration_core'];
        $imageFilenames = [];
    
        foreach ($illustrations as $illustration) {
            // Generate nama acak 5 karakter untuk file
            $randomName = Str::random(5) . '.' . $request->file($illustration)->extension();
            $path = $request->file($illustration)->move(public_path('illustrations'), $randomName);
            $imageFilenames[$illustration] = $randomName; // Simpan nama file ke array
        }
    
        $data = [
            'part_name' => $request->part_name,
            'model_id' => $request->model_id,
            'part_code' => $request->part_code,
            'part_number' => $request->part_number,
            'image_filename' => json_encode($imageFilenames), // Simpan nama file sebagai JSON
            'capacity_in_cart' => $request->capacity,
            'is_active' => 1,
        ];
    
        MSTPart::create($data);
    
        return redirect()->route('parts.index')->with('success', 'Part created successfully.');
    }
    
    

    // Fungsi untuk menghasilkan nomor part berikutnya
    private function generateNextPartNumber()
    {
        $lastPart = MSTPart::orderBy('id', 'desc')->first();
        if (!$lastPart) {
            return 'P0001';
        }

        $lastNumber = (int) substr($lastPart->part_number, 1);
        $nextNumber = $lastNumber + 1;
        return 'P' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    // Mengupdate part yang sudah ada
    public function update(Request $request, $id)
    {
        // Temukan part berdasarkan ID
        $part = MSTPart::findOrFail($id);

        // Validasi input
        $request->validate([
            'part_name' => 'required|string|max:255',
            'model_id' => 'required|integer',
            'part_code' => 'required|string|max:255',
            'part_number' => 'nullable|string|max:255|unique:mst_parts,part_number,' . $part->id, // Unique kecuali untuk part ini
            'illustration_fix' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'illustration_move' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'illustration_core' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'capacity' => 'required|integer',
        ]);

        // Persiapkan data yang akan diupdate
        $data = [
            'part_name' => $request->part_name,
            'model_id' => $request->model_id,
            'part_code' => $request->part_code,
            'part_number' => $request->part_number ?: $this->generateNextPartNumber(), // Generate jika tidak ada
            'capacity_in_cart' => $request->capacity,
            'is_active' => 1,
            'updated_at' => now(), // Tambahkan updated_at dengan waktu sekarang
        ];

        // Array untuk menyimpan nama file yang disimpan
        $illustrations = ['illustration_fix', 'illustration_move', 'illustration_core'];
        $imageFilenames = json_decode($part->image_filename, true);

        foreach ($illustrations as $illustration) {
            // Cek jika ada file yang diupload untuk gambar
            if ($request->hasFile($illustration)) {
                // Generate nama acak 5 karakter untuk file
                $randomName = Str::random(5) . '.' . $request->file($illustration)->extension();
                $request->file($illustration)->move(public_path('illustrations'), $randomName);
                $imageFilenames[$illustration] = $randomName; // Simpan nama file ke array
            }
        }

        // Update data part
        $data['image_filename'] = json_encode($imageFilenames); // Simpan nama file sebagai JSON
        $part->update($data);

        return redirect()->route('parts.index')->with('success', 'Part updated successfully.');
    }

    

    // Menghapus part
    public function destroy($id)
    {
        $part = MSTPart::findOrFail($id);
        $part->is_active = 0;
        $part->save();
        return redirect()->route('parts.index')->with('success', 'Part berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // Melakukan pencarian berdasarkan nama bagian
        // Dengan melakukan join untuk mendapatkan model yang terkait
        $parts = MSTPart::with('model') // Mengambil model yang terkait dengan nama metode relasi
            ->where('part_name', 'LIKE', '%' . $query . '%')
            ->get();
    
        // Untuk memastikan kita mengembalikan data yang relevan
        return response()->json($parts);
    }
    
    

}
