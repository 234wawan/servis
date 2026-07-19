<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'badge_text',
        'judul',
        'subtitle',
        'deskripsi',
        'deskripsi_2',
        'image',
        'highlights',
        'tombol_text',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'highlights' => 'array',
        ];
    }
}
