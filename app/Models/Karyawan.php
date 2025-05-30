<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $fillable = [
        'nik',
        'user_id',
        'departemen_id',
        'nama_lengkap',
        'jabatan'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class);
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
