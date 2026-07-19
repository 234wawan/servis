<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_servis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->text('keterangan')->nullable();
            $table->decimal('biaya', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_servis');
    }
};
