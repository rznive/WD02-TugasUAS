<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pasien extends Authenticatable
{
    protected $fillable = [
        'id',
        'nama',
        'alamat',
        'no_ktp',
        'no_hp',
        'no_rm'
    ];

    public function daftarPoli()
    {
        return $this->hasMany(Poli::class, 'id_user', 'id');
    }
}
