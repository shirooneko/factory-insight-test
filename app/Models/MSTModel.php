<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSTModel extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'mst_models';

    // Jika id primary key bukan `id`, tentukan di sini
    protected $primaryKey = 'id';

    // Jika tidak ada timestamps di tabel
    public $timestamps = false;

    protected $fillable = [
        'model_name', 
        'model_description', 
        'created_at',
        'updated_at',
        'is_active',
    ];
}
