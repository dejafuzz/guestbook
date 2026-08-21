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
        Schema::table('invitation_contents', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitation_contents', function (Blueprint $table) {
            $table->string('groom_full_name')->nullable()->after('groom_name');
            $table->string('groom_father')->nullable()->after('groom_full_name');
            $table->string('groom_mother')->nullable()->after('groom_father');
            $table->string('groom_child_order')->nullable()->after('groom_mother');
            $table->string('groom_instagram')->nullable()->after('groom_child_order');
            $table->string('bride_full_name')->nullable()->after('bride_name');
            $table->string('bride_father')->nullable()->after('bride_full_name');
            $table->string('bride_mother')->nullable()->after('bride_father');
            $table->string('bride_child_order')->nullable()->after('bride_mother');
            $table->string('bride_instagram')->nullable()->after('bride_child_order');
        });
    }
};