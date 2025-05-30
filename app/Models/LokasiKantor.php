<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LokasiKantor extends Model
{
    use HasFactory;

    protected $table = 'lokasi_kantor';

    protected $fillable = [
        'kota',
        'alamat',
        'latitude',
        'longitude',
        'radius',
        'is_used'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'radius' => 'integer',
        'is_used' => 'boolean'
    ];
}
