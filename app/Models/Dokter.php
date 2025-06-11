<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Dokter extends Authenticatable
{
    protected $fillable = [
        'id',
        'nama',
        'alamat',
        'no_hp',
        'id_poli',
    ];

    public function Poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli', 'id');
    }
    public function jadwalPeriksa()
    {
        return $this->hasMany(JadwalPeriksa::class, 'id_dokter', 'id');
    }
}
