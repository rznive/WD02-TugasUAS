<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
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
