<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBarang extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function spareparts(): HasMany
    {
        return $this->hasMany(Sparepart::class, 'kategori_id');
    }
}
