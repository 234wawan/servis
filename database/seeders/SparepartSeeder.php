<?php

namespace Database\Seeders;

use App\Models\Sparepart;
use Illuminate\Database\Seeder;

class SparepartSeeder extends Seeder
{
    public function run(): void
    {
        // Oli & Pelumas (kategori_id = 1)
        Sparepart::create(['kategori_id' => 1, 'kode_sparepart' => 'OLI-MPN-1L', 'nama_sparepart' => 'Oli Mesin MPN 1L', 'satuan' => 'Botol', 'stok' => 25, 'stok_minimum' => 5, 'harga_beli' => 35000, 'harga_jual' => 45000]);
        Sparepart::create(['kategori_id' => 1, 'kode_sparepart' => 'OLI-MPN-800ML', 'nama_sparepart' => 'Oli Mesin MPN 800ml', 'satuan' => 'Botol', 'stok' => 30, 'stok_minimum' => 5, 'harga_beli' => 28000, 'harga_jual' => 37000]);
        Sparepart::create(['kategori_id' => 1, 'kode_sparepart' => 'OLI-FDR-1L', 'nama_sparepart' => 'Oli Mesin FDR 1L', 'satuan' => 'Botol', 'stok' => 20, 'stok_minimum' => 5, 'harga_beli' => 40000, 'harga_jual' => 52000]);
        Sparepart::create(['kategori_id' => 1, 'kode_sparepart' => 'OLI-ENI-1L', 'nama_sparepart' => 'Oli Mesin ENI 1L', 'satuan' => 'Botol', 'stok' => 15, 'stok_minimum' => 5, 'harga_beli' => 45000, 'harga_jual' => 58000]);
        Sparepart::create(['kategori_id' => 1, 'kode_sparepart' => 'OLI-GAR', 'nama_sparepart' => 'Oli Gardan 120ml', 'satuan' => 'Botol', 'stok' => 12, 'stok_minimum' => 3, 'harga_beli' => 15000, 'harga_jual' => 22000]);

        // Filter (kategori_id = 2)
        Sparepart::create(['kategori_id' => 2, 'kode_sparepart' => 'FLT-UDG', 'nama_sparepart' => 'Filter Udara Universal', 'satuan' => 'Pcs', 'stok' => 10, 'stok_minimum' => 3, 'harga_beli' => 15000, 'harga_jual' => 25000]);
        Sparepart::create(['kategori_id' => 2, 'kode_sparepart' => 'FLT-OLI', 'nama_sparepart' => 'Filter Oli', 'satuan' => 'Pcs', 'stok' => 8, 'stok_minimum' => 3, 'harga_beli' => 12000, 'harga_jual' => 20000]);
        Sparepart::create(['kategori_id' => 2, 'kode_sparepart' => 'FLT-BNS', 'nama_sparepart' => 'Filter Bensin', 'satuan' => 'Pcs', 'stok' => 15, 'stok_minimum' => 5, 'harga_beli' => 5000, 'harga_jual' => 10000]);

        // Busi & Pengapian (kategori_id = 3)
        Sparepart::create(['kategori_id' => 3, 'kode_sparepart' => 'BUS-NGK', 'nama_sparepart' => 'Busi NGK Standar', 'satuan' => 'Pcs', 'stok' => 30, 'stok_minimum' => 10, 'harga_beli' => 12000, 'harga_jual' => 20000]);
        Sparepart::create(['kategori_id' => 3, 'kode_sparepart' => 'BUS-NGK-IR', 'nama_sparepart' => 'Busi NGK Iridium', 'satuan' => 'Pcs', 'stok' => 10, 'stok_minimum' => 3, 'harga_beli' => 45000, 'harga_jual' => 65000]);
        Sparepart::create(['kategori_id' => 3, 'kode_sparepart' => 'KBL-BSI', 'nama_sparepart' => 'Kabel Busi Standar', 'satuan' => 'Set', 'stok' => 5, 'stok_minimum' => 2, 'harga_beli' => 25000, 'harga_jual' => 40000]);
        Sparepart::create(['kategori_id' => 3, 'kode_sparepart' => 'KPL-BSI', 'nama_sparepart' => 'Koil Pengapian Universal', 'satuan' => 'Pcs', 'stok' => 4, 'stok_minimum' => 2, 'harga_beli' => 55000, 'harga_jual' => 80000]);

        // Rem (kategori_id = 4)
        Sparepart::create(['kategori_id' => 4, 'kode_sparepart' => 'KMP-RM-DPN', 'nama_sparepart' => 'Kampas Rem Depan', 'satuan' => 'Set', 'stok' => 15, 'stok_minimum' => 5, 'harga_beli' => 18000, 'harga_jual' => 30000]);
        Sparepart::create(['kategori_id' => 4, 'kode_sparepart' => 'KMP-RM-BLK', 'nama_sparepart' => 'Kampas Rem Belakang', 'satuan' => 'Set', 'stok' => 15, 'stok_minimum' => 5, 'harga_beli' => 15000, 'harga_jual' => 25000]);
        Sparepart::create(['kategori_id' => 4, 'kode_sparepart' => 'MNYK-RM', 'nama_sparepart' => 'Minyak Rem DOT 3', 'satuan' => 'Botol', 'stok' => 8, 'stok_minimum' => 3, 'harga_beli' => 12000, 'harga_jual' => 20000]);
        Sparepart::create(['kategori_id' => 4, 'kode_sparepart' => 'SLNG-RM', 'nama_sparepart' => 'Seal Rem Tromol', 'satuan' => 'Pcs', 'stok' => 6, 'stok_minimum' => 2, 'harga_beli' => 8000, 'harga_jual' => 15000]);

        // Ban & Roda (kategori_id = 5)
        Sparepart::create(['kategori_id' => 5, 'kode_sparepart' => 'BAN-DLM-80', 'nama_sparepart' => 'Ban Dalam 80/90', 'satuan' => 'Pcs', 'stok' => 10, 'stok_minimum' => 3, 'harga_beli' => 25000, 'harga_jual' => 40000]);
        Sparepart::create(['kategori_id' => 5, 'kode_sparepart' => 'BAN-DLM-90', 'nama_sparepart' => 'Ban Dalam 90/90', 'satuan' => 'Pcs', 'stok' => 10, 'stok_minimum' => 3, 'harga_beli' => 28000, 'harga_jual' => 43000]);
        Sparepart::create(['kategori_id' => 5, 'kode_sparepart' => 'PTL-BAN', 'nama_sparepart' => 'Pentil Ban', 'satuan' => 'Pcs', 'stok' => 20, 'stok_minimum' => 5, 'harga_beli' => 3000, 'harga_jual' => 7000]);
        Sparepart::create(['kategori_id' => 5, 'kode_sparepart' => 'BAN-LUAR-80', 'nama_sparepart' => 'Ban Luar 80/90-17', 'satuan' => 'Pcs', 'stok' => 3, 'stok_minimum' => 2, 'harga_beli' => 180000, 'harga_jual' => 250000]);

        // Rantai & Gir (kategori_id = 6)
        Sparepart::create(['kategori_id' => 6, 'kode_sparepart' => 'RTAI-428', 'nama_sparepart' => 'Rantai 428 Standar', 'satuan' => 'Set', 'stok' => 8, 'stok_minimum' => 3, 'harga_beli' => 35000, 'harga_jual' => 55000]);
        Sparepart::create(['kategori_id' => 6, 'kode_sparepart' => 'RTAI-428-O', 'nama_sparepart' => 'Rantai 428 O-Ring', 'satuan' => 'Set', 'stok' => 5, 'stok_minimum' => 2, 'harga_beli' => 65000, 'harga_jual' => 95000]);
        Sparepart::create(['kategori_id' => 6, 'kode_sparepart' => 'GIR-DPN', 'nama_sparepart' => 'Gir Depan Standar', 'satuan' => 'Pcs', 'stok' => 8, 'stok_minimum' => 3, 'harga_beli' => 20000, 'harga_jual' => 35000]);
        Sparepart::create(['kategori_id' => 6, 'kode_sparepart' => 'GIR-BLK', 'nama_sparepart' => 'Gir Belakang Standar', 'satuan' => 'Pcs', 'stok' => 8, 'stok_minimum' => 3, 'harga_beli' => 30000, 'harga_jual' => 50000]);

        // Lampu & Kelistrikan (kategori_id = 7)
        Sparepart::create(['kategori_id' => 7, 'kode_sparepart' => 'LMP-DPN', 'nama_sparepart' => 'Bohlam Lampu Depan 12V', 'satuan' => 'Pcs', 'stok' => 15, 'stok_minimum' => 5, 'harga_beli' => 8000, 'harga_jual' => 15000]);
        Sparepart::create(['kategori_id' => 7, 'kode_sparepart' => 'LMP-SEN', 'nama_sparepart' => 'Bohlam Lampu Sein', 'satuan' => 'Pcs', 'stok' => 20, 'stok_minimum' => 5, 'harga_beli' => 4000, 'harga_jual' => 8000]);
        Sparepart::create(['kategori_id' => 7, 'kode_sparepart' => 'AKI-GS', 'nama_sparepart' => 'Aki GS 12V 5Ah', 'satuan' => 'Pcs', 'stok' => 5, 'stok_minimum' => 2, 'harga_beli' => 85000, 'harga_jual' => 120000]);
        Sparepart::create(['kategori_id' => 7, 'kode_sparepart' => 'AKI-YU', 'nama_sparepart' => 'Aki Yuasa 12V 7Ah', 'satuan' => 'Pcs', 'stok' => 4, 'stok_minimum' => 2, 'harga_beli' => 95000, 'harga_jual' => 135000]);
        Sparepart::create(['kategori_id' => 7, 'kode_sparepart' => 'SKL-BK', 'nama_sparepart' => 'Saklar Lampu Universal', 'satuan' => 'Pcs', 'stok' => 6, 'stok_minimum' => 2, 'harga_beli' => 10000, 'harga_jual' => 18000]);

        // Velg & Spoke (kategori_id = 8)
        Sparepart::create(['kategori_id' => 8, 'kode_sparepart' => 'JR-JRJ', 'nama_sparepart' => 'Jari-Jari Velg 18in', 'satuan' => 'Set', 'stok' => 10, 'stok_minimum' => 5, 'harga_beli' => 15000, 'harga_jual' => 25000]);
        Sparepart::create(['kategori_id' => 8, 'kode_sparepart' => 'AS-RODA', 'nama_sparepart' => 'As Roda Belakang', 'satuan' => 'Pcs', 'stok' => 3, 'stok_minimum' => 1, 'harga_beli' => 45000, 'harga_jual' => 70000]);

        // Aksesoris (kategori_id = 9)
        Sparepart::create(['kategori_id' => 9, 'kode_sparepart' => 'SPN-KNM', 'nama_sparepart' => 'Spion Kanan Universal', 'satuan' => 'Pcs', 'stok' => 8, 'stok_minimum' => 3, 'harga_beli' => 12000, 'harga_jual' => 22000]);
        Sparepart::create(['kategori_id' => 9, 'kode_sparepart' => 'SPN-KRM', 'nama_sparepart' => 'Spion Kiri Universal', 'satuan' => 'Pcs', 'stok' => 8, 'stok_minimum' => 3, 'harga_beli' => 12000, 'harga_jual' => 22000]);
        Sparepart::create(['kategori_id' => 9, 'kode_sparepart' => 'GAG-EOS', 'nama_sparepart' => 'Handle Gas EOS', 'satuan' => 'Pcs', 'stok' => 5, 'stok_minimum' => 2, 'harga_beli' => 15000, 'harga_jual' => 28000]);
        Sparepart::create(['kategori_id' => 9, 'kode_sparepart' => 'STANG', 'nama_sparepart' => 'Stang Setang Universal', 'satuan' => 'Pcs', 'stok' => 3, 'stok_minimum' => 1, 'harga_beli' => 35000, 'harga_jual' => 55000]);

        // Lainnya (kategori_id = 10)
        Sparepart::create(['kategori_id' => 10, 'kode_sparepart' => 'KLEP-BENSIN', 'nama_sparepart' => 'Kran Bensin Universal', 'satuan' => 'Pcs', 'stok' => 6, 'stok_minimum' => 2, 'harga_beli' => 12000, 'harga_jual' => 20000]);
        Sparepart::create(['kategori_id' => 10, 'kode_sparepart' => 'SKRUP', 'nama_sparepart' => 'Sekrup Mur Baut Set', 'satuan' => 'Paket', 'stok' => 10, 'stok_minimum' => 3, 'harga_beli' => 8000, 'harga_jual' => 15000]);
        Sparepart::create(['kategori_id' => 10, 'kode_sparepart' => 'KABEL-VAR', 'nama_sparepart' => 'Kabel Serbaguna 1m', 'satuan' => 'Meter', 'stok' => 15, 'stok_minimum' => 5, 'harga_beli' => 5000, 'harga_jual' => 10000]);
    }
}
