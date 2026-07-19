<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            $table->foreignId('master_servis_id')->nullable()->constrained()->nullOnDelete()->after('kendaraan_id');
        });
    }

    public function down(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            $table->dropForeign(['master_servis_id']);
            $table->dropColumn('master_servis_id');
        });
    }
};
