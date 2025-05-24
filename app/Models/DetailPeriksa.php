<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detailPeriksa extends Model
{
    protected $fillable = [
        'id',
        'id_periksa',
        'id_obat',
    ];

    public function obat(){
        return $this->belongsTo(Obat::class, 'id_obat', 'id');
    }
    
    public function periksa(){
        return $this->belongsTo(Periksa::class, 'id_periksa', 'id');
    }
    
}
