<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $fillable = [
        'key',
        'label',
        'value',
        'tipe',
        'icon',
        'urutan',
        'is_active',
    ];
}
