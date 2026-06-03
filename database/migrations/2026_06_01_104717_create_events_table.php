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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nama_event');
            $table->string('slug')->unique()->nullable();
            $table->string('template')->default('classic');
            $table->date('tanggal');
            $table->string('lokasi')->nullable();
            $table->enum('souvenir_mode', ['per_orang', 'per_undangan'])->default('per_undangan');
            $table->string('receptionist_pin');
            $table->string('souvenir_pin');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

// use App\Models\Event;
// use App\Models\User;

// Event::create([
//     'nama_event' => 'Pernikahan Test',
//     'tanggal' => '2025-12-01',
//     'lokasi' => 'Jakarta',
//     'souvenir_mode' => 'per_undangan',
//     'receptionist_pin' => '123456',
//     'souvenir_pin' => '654321',
//     'created_by' => User::first()->id,
// ]);

// use App\Models\Guest;

// $event = Event::first();

// Guest::insert([
//     ['id' => \Illuminate\Support\Str::uuid(), 'event_id' => $event->id, 'nama_utama' => 'Budi Santoso', 'jumlah_tamu' => 2, 'qr_code' => \Illuminate\Support\Str::uuid(), 'status' => 'terdaftar', 'created_at' => now(), 'updated_at' => now()],
//     ['id' => \Illuminate\Support\Str::uuid(), 'event_id' => $event->id, 'nama_utama' => 'Siti Rahayu', 'jumlah_tamu' => 3, 'qr_code' => \Illuminate\Support\Str::uuid(), 'status' => 'terdaftar', 'created_at' => now(), 'updated_at' => now()],
//     ['id' => \Illuminate\Support\Str::uuid(), 'event_id' => $event->id, 'nama_utama' => 'Ahmad Fauzi', 'jumlah_tamu' => 1, 'qr_code' => \Illuminate\Support\Str::uuid(), 'status' => 'terdaftar', 'created_at' => now(), 'updated_at' => now()],
// ]);