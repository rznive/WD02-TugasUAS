<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarPoli extends Model
{
    protected $fillable = [
        'id',
        'id_pasien',
        'id_jadwal',
        'keluhan',
        'no_antrian',
    ];
    
    public function jadwalPeriksa()
    {
        return $this->belongsTo(jadwalPeriksa::class, 'id_jadwal', 'id');
    }

    public function Periksa()
    {
        return $this->hasMany(Periksa::class, 'id_daftar_poli', 'id');
    }
    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien', 'id');
    }
}
