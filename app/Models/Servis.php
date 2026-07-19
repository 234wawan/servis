<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servis extends Model
{
    protected $fillable = [
        'no_antrian',
        'kendaraan_id',
        'master_servis_id',
        'tipe_barang',
        'tgl_masuk',
        'tgl_selesai',
        'keluhan',
        'kelengkapan',
        'catatan',
        'biaya',
        'tipe_diskon',
        'diskon',
        'total_bayar',
        'metode_pembayaran',
        'tgl_pembayaran',
        'status',
        'is_void',
        'voided_by',
        'voided_at',
        'alasan_void',
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function masterServis(): BelongsTo
    {
        return $this->belongsTo(MasterServis::class, 'master_servis_id');
    }

    public function voidedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'voided_by');
    }

    public function spareparts(): BelongsToMany
    {
        return $this->belongsToMany(Sparepart::class, 'servis_sparepart')
            ->withPivot('qty', 'harga_jual', 'subtotal')
            ->withTimestamps();
    }

    public function getDiskonRupiah(): float
    {
        if ($this->tipe_diskon === 'persen') {
            return $this->biaya * ($this->diskon / 100);
        }
        return $this->diskon;
    }
}
