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
        Schema::create('invitation_contents', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('event_id')->constrained()->cascadeOnDelete();
            
            // Pengantin
            $table->string('groom_name');
            $table->string('bride_name');
            $table->string('groom_photo')->nullable();
            $table->string('bride_photo')->nullable();
            $table->string('hero_photo')->nullable();
            
            // Cerita
            $table->text('love_story')->nullable();
            $table->date('first_met_date')->nullable();
            $table->date('engagement_date')->nullable();
            
            // Akad
            $table->string('akad_location')->nullable();
            $table->string('akad_address')->nullable();
            $table->datetime('akad_datetime')->nullable();
            $table->string('akad_maps_url')->nullable();

            // Resepsi
            $table->string('reception_location')->nullable();
            $table->string('reception_address')->nullable();
            $table->datetime('reception_datetime')->nullable();
            $table->string('reception_maps_url')->nullable();

            // Quotes / penutup
            $table->text('opening_quote')->nullable();
            $table->text('closing_quote')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_contents');
    }
};