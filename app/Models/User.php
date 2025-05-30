<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'gender',
        'phone',
        'address',
        'password',
        'role',
        'google_id',
        'google_token',
        'google_refresh_token',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google_token',
        'google_refresh_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class);
    }
}
