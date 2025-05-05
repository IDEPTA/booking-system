<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trigger_logs', function (Blueprint $table) {
            $table->id();
            $table->text('data');
            $table->timestamps();
        });

        DB::statement("
            CREATE TRIGGER trg_booking_insert
            AFTER INSERT ON booking_records
            FOR EACH ROW
            BEGIN
                INSERT INTO trigger_logs (data, created_at, updated_at)
                VALUES (
                    JSON_OBJECT(
                        'event', 'insert',
                        'id', NEW.id,
                        'user_id', NEW.user_id,
                        'booking_post_id', NEW.booking_post_id,
                        'available_status', NEW.available_status,
                        'created_at', NEW.created_at,
                        'updated_at', NEW.updated_at
                    ),
                    NOW(), NOW()
                );
            END;
        ");

        // AFTER UPDATE → сохраняем OLD (старую запись)
        DB::statement("
            CREATE TRIGGER trg_booking_update
            AFTER UPDATE ON booking_records
            FOR EACH ROW
            BEGIN
                INSERT INTO trigger_logs (data, created_at, updated_at)
                VALUES (
                    JSON_OBJECT(
                        'event', 'update',
                        'id', OLD.id,
                        'user_id', OLD.user_id,
                        'old_available_status', OLD.available_status,
                        'new_available_status', NEW.available_status,
                        'booking_post_id', OLD.booking_post_id,
                        'created_at', OLD.created_at,
                        'updated_at', OLD.updated_at
                    ),
                    NOW(), NOW()
                );
            END;
        ");
    }

    public function down()
    {
        Schema::dropIfExists('trigger_logs');

        DB::statement('DROP TRIGGER IF EXISTS trg_booking_insert');
        DB::statement('DROP TRIGGER IF EXISTS trg_booking_update');
    }
};