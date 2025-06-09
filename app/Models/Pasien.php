<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
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
