<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            $table->boolean('is_void')->default(false)->after('status');
            $table->foreignId('voided_by')->nullable()->constrained('users')->nullOnDelete()->after('is_void');
            $table->timestamp('voided_at')->nullable()->after('voided_by');
            $table->text('alasan_void')->nullable()->after('voided_at');
        });
    }

    public function down(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            $table->dropColumn(['is_void', 'voided_by', 'voided_at', 'alasan_void']);
        });
    }
};
