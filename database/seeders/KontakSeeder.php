<?php

namespace Database\Seeders;

use App\Models\Kontak;
use Illuminate\Database\Seeder;

class KontakSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['key' => 'no_telepon', 'label' => 'No. Telepon', 'value' => '0812-3456-7890', 'tipe' => 'telepon', 'icon' => 'bi-telephone', 'urutan' => 1],
            ['key' => 'email', 'label' => 'Email', 'value' => 'bengkelmotor@email.com', 'tipe' => 'email', 'icon' => 'bi-envelope', 'urutan' => 2],
            ['key' => 'alamat', 'label' => 'Alamat', 'value' => 'Jl. Merdeka No. 123, Jakarta', 'tipe' => 'alamat', 'icon' => 'bi-geo-alt', 'urutan' => 3],
            ['key' => 'no_wa', 'label' => 'No. WhatsApp', 'value' => '0812-3456-7890', 'tipe' => 'telepon', 'icon' => 'bi-whatsapp', 'urutan' => 4],
            ['key' => 'facebook', 'label' => 'Facebook', 'value' => '#', 'tipe' => 'sosmed', 'icon' => 'bi-facebook', 'urutan' => 5],
            ['key' => 'twitter', 'label' => 'Twitter / X', 'value' => '#', 'tipe' => 'sosmed', 'icon' => 'bi-twitter-x', 'urutan' => 6],
            ['key' => 'youtube', 'label' => 'YouTube', 'value' => '#', 'tipe' => 'sosmed', 'icon' => 'bi-youtube', 'urutan' => 7],
            ['key' => 'instagram', 'label' => 'Instagram', 'value' => '#', 'tipe' => 'sosmed', 'icon' => 'bi-instagram', 'urutan' => 8],
            ['key' => 'deskripsi_footer', 'label' => 'Deskripsi Footer', 'value' => 'Bengkel motor profesional melayani jasa perbaikan dan perawatan segala jenis dan tipe motor. Menerima jasa service online maupun datang langsung.', 'tipe' => 'teks', 'icon' => null, 'urutan' => 0],
        ];

        foreach ($data as $item) {
            Kontak::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
