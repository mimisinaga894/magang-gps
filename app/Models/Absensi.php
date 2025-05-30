<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
<<<<<<< HEAD
        'karyawan_id',
=======
        'user_id',
>>>>>>> origin/main
        'tanggal',
        'jadwal_masuk',
        'jadwal_pulang',
        'jam_masuk',
        'jam_pulang',
        'latitude_masuk',
        'longitude_masuk',
        'latitude_pulang',
        'longitude_pulang',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jadwal_masuk' => 'datetime',
        'jadwal_pulang' => 'datetime',
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }
}
