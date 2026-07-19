<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sparepart extends Model
{
    protected $fillable = [
        'kategori_id',
        'kode_sparepart',
        'nama_sparepart',
        'satuan',
        'stok',
        'stok_minimum',
        'harga_beli',
        'harga_jual',
        'deskripsi',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    public function servis(): BelongsToMany
    {
        return $this->belongsToMany(Servis::class, 'servis_sparepart')
            ->withPivot('qty', 'harga_jual', 'subtotal')
            ->withTimestamps();
    }

    public function isStockLow(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }
}
