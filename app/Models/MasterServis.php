<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterServis extends Model
{
    protected $fillable = [
        'nama_paket',
        'keterangan',
        'biaya',
    ];
}
