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
        Schema::create('booking_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("booking_object_id")
                ->constrained("booking_objects")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->integer("price");
            $table->integer("available_slots");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_posts');
    }
};
