<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'karyawan_id',
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
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jadwal_masuk' => 'datetime:H:i:s',
        'jadwal_pulang' => 'datetime:H:i:s',
        'jam_masuk' => 'datetime:H:i:s',
        'jam_pulang' => 'datetime:H:i:s',
        'latitude_masuk' => 'float',
        'longitude_masuk' => 'float',
        'latitude_pulang' => 'float',
        'longitude_pulang' => 'float',
    ];


    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }


    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', now()->toDateString());
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
