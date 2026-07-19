<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'no_polisi',
        'merek',
        'model',
        'tahun',
        'warna',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function servis(): HasMany
    {
        return $this->hasMany(Servis::class);
    }
}
