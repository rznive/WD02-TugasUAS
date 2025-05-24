<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = [
        'id',
        'nama_obat',
        'kemasan',
        'harga',
    ];
    public function detailPeriksa()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_obat', 'id');
    }
    
}
