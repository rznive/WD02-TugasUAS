<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $fillable = [
       'id',
       'nama_poli',
       'keterangan'
    ];

}
