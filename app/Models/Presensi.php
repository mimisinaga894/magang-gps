<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $fillable = [
        'nik',
        'tanggal_presensi',
        'jam_masuk',
        'jam_keluar',
        'lokasi_masuk',
        'lokasi_keluar',
        'keterangan',
        'jabatan',
        'departemen',
    ];

    public $timestamps = true;
}
