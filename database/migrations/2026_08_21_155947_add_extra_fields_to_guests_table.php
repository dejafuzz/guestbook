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
        Schema::table('guests', function (Blueprint $table) {
            $table->string('jabatan')->nullable();
            $table->string('keterangan_undangan')->nullable(); // VIP, biasa, dll.
            $table->string('kehadiran')->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'keterangan_undangan', 'kehadiran', 'keterangan']);
        });
    }
};
