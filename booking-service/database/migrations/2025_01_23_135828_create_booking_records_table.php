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
        Schema::create('booking_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")
                ->constrained("users")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId("booking_post_id")
                ->constrained("booking_posts")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->dateTime("start_date");
            $table->dateTime("end_date");
            $table->string("available_status");
            $table->string("payment_status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_records');
    }
};