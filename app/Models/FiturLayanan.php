<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiturLayanan extends Model
{
    protected $fillable = [
        'icon',
        'badge',
        'judul',
        'deskripsi',
        'urutan',
        'is_active',
    ];
}
