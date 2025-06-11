<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jadwalPeriksa extends Model
{
    protected $fillable = [
        'id',
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'is_active',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id');
    }

    public function daftarPoli()
    {
        return $this->hasMany(DaftarPoli::class, 'id_jadwal', 'id');
    }
}
