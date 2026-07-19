<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            $table->string('no_antrian', 30)->nullable()->unique()->after('id');
            $table->string('tipe_barang', 50)->nullable()->after('kendaraan_id');
            $table->text('kelengkapan')->nullable()->after('keluhan');
            $table->enum('tipe_diskon', ['nominal', 'persen'])->nullable()->after('biaya');
            $table->decimal('diskon', 12, 2)->default(0)->after('tipe_diskon');
            $table->decimal('total_bayar', 12, 2)->default(0)->after('diskon');
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'qris'])->nullable()->after('total_bayar');
            $table->timestamp('tgl_pembayaran')->nullable()->after('metode_pembayaran');
        });

        DB::statement("ALTER TABLE servis MODIFY COLUMN status ENUM('pending','proses','selesai','diambil') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE servis MODIFY COLUMN status ENUM('pending','proses','selesai') NOT NULL DEFAULT 'pending'");

        Schema::table('servis', function (Blueprint $table) {
            $table->dropColumn(['no_antrian', 'tipe_barang', 'kelengkapan', 'tipe_diskon', 'diskon', 'total_bayar', 'metode_pembayaran', 'tgl_pembayaran']);
        });
    }
};
