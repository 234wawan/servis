<?php

namespace Database\Seeders;

use App\Models\MasterServis;
use Illuminate\Database\Seeder;

class MasterServisSeeder extends Seeder
{
    public function run(): void
    {
        MasterServis::create([
            'nama_paket' => 'Servis Total',
            'keterangan' => 'Servis kendaraan secara total dan ganti oli',
            'biaya' => 200000,
        ]);

        MasterServis::create([
            'nama_paket' => 'Ganti Oli',
            'keterangan' => 'Ganti oli mesin',
            'biaya' => 50000,
        ]);

        MasterServis::create([
            'nama_paket' => 'Servis Ringan',
            'keterangan' => 'Servis ringan, setel rantai, bersihkan karburator',
            'biaya' => 75000,
        ]);

        MasterServis::create([
            'nama_paket' => 'Servis Besar',
            'keterangan' => 'Servis besar, ganti oli, busi, filter udara, setel klep',
            'biaya' => 300000,
        ]);
    }
}
