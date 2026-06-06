<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('event_id')->constrained()->cascadeOnDelete();
            $table->string('nama_utama');
            $table->string('nomor_undangan')->nullable();
            $table->integer('jumlah_tamu')->default(1);
            $table->string('qr_code')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->enum('status', ['terdaftar', 'hadir', 'souvenir_diambil'])->default('terdaftar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};