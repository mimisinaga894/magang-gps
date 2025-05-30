<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemen';

    protected $fillable = [
        'kode',
        'nama'
    ];

    public function karyawan(): HasMany
    {
        return $this->hasMany(Karyawan::class);
    }
}
