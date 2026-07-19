<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use Illuminate\Database\Seeder;

class KategoriBarangSeeder extends Seeder
{
    public function run(): void
    {
        KategoriBarang::create(['nama_kategori' => 'Oli & Pelumas', 'deskripsi' => 'Oli mesin, oli gardan, pelumas']);
        KategoriBarang::create(['nama_kategori' => 'Filter', 'deskripsi' => 'Filter udara, filter oli, filter bensin']);
        KategoriBarang::create(['nama_kategori' => 'Busi & Pengapian', 'deskripsi' => 'Busi, koil, kabel busi']);
        KategoriBarang::create(['nama_kategori' => 'Rem', 'deskripsi' => 'Kampas rem, minyak rem, cakram']);
        KategoriBarang::create(['nama_kategori' => 'Ban & Roda', 'deskripsi' => 'Ban dalam, ban luar, pentil']);
        KategoriBarang::create(['nama_kategori' => 'Rantai & Gir', 'deskripsi' => 'Rantai, gir depan, gir belakang']);
        KategoriBarang::create(['nama_kategori' => 'Lampu & Kelistrikan', 'deskripsi' => 'Bohlam, aki, kabel, saklar']);
        KategoriBarang::create(['nama_kategori' => 'Velg & Spoke', 'deskripsi' => 'Velg, jari-jari, as roda']);
        KategoriBarang::create(['nama_kategori' => 'Aksesoris', 'deskripsi' => 'Spion, handle, bodi']);
        KategoriBarang::create(['nama_kategori' => 'Lainnya', 'deskripsi' => 'Sparepart lain-lain']);
    }
}
