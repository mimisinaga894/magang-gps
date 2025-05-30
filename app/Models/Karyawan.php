<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Authenticatable
{
    protected $table = 'karyawan';
    protected $primaryKey = 'nik';
    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'id_departemen',
        'nama_lengkap',
        'jabatan',
        'telepon',
        'email',
        'password'
    ];

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class, 'id_departemen', 'id');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'id_karyawan', 'nik');
    }
}
