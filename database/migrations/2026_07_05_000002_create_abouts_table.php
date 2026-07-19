<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->default('Sekilas tentang');
            $table->string('judul')->default('ServisMotor');
            $table->string('subtitle')->default('Bengkel Motor Profesional & Online');
            $table->text('deskripsi');
            $table->text('deskripsi_2')->nullable();
            $table->string('image')->nullable();
            $table->json('highlights')->nullable();
            $table->string('tombol_text')->default('Daftar Servis Online');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
