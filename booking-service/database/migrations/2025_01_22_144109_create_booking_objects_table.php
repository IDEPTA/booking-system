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
        Schema::create('booking_objects', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("address");
            $table->string("city");
            $table->time("working_hours_from");
            $table->time("working_hours_up_to");
            $table->string("booking_type");
            $table->string("booking_object");
            $table->foreignId("user_id")
                ->constrained("users")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->boolean("available");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_objects');
    }
};