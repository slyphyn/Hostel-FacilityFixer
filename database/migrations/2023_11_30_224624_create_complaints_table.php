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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('block_number');
            $table->string('location_type'); // 'room' or 'toilet'
            $table->string('room_number')->nullable();
            $table->string('toilet_location')->nullable();
            $table->string('category');
            $table->string('damage_description');
            $table->string('damage_description_other')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('status')->default('pending'); // 'pending', 'in progress', 'resolved'
            $table->string('assigned_staff_name')->nullable();
            $table->string('assigned_staff_contact')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
