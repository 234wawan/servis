<?php

namespace App\Livewire;

use App\Models\Servis;
use Livewire\Component;

class CekStatusServis extends Component
{
    public string $no_antrian = '';
    public ?Servis $servis = null;
    public bool $searched = false;

    public function mount(): void
    {
        if ($q = request('q')) {
            $this->no_antrian = $q;
            $this->cari();
        }
    }

    public function cari(): void
    {
        $this->validate(['no_antrian' => 'required|string']);

        $this->servis = Servis::with('kendaraan.pelanggan', 'masterServis', 'spareparts')
            ->where('no_antrian', strtoupper($this->no_antrian))
            ->first();

        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.cek-status-servis');
    }
}
