<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSTPart extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'mst_parts';

    // Jika id primary key bukan `id`, tentukan di sini
    protected $primaryKey = 'id';

    // Jika tidak ada timestamps di tabel
    public $timestamps = false;

    // Kolom-kolom yang bisa diisi
    protected $fillable = [
        'model_id', 
        'part_name', 
        'part_code', 
        'part_number', 
        'image_filename',
        'image_blob',
        'capacity_in_cart',
        'created_at',
        'updated_at', 
        'is_active'
    ];

    public function model()
    {
        return $this->belongsTo(MSTModel::class, 'model_id');
    }
}
