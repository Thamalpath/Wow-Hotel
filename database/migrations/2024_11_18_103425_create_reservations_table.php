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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('guest_type', 50);
            $table->string('guest_name', 100);
            $table->string('guest_country', 100);
            $table->string('contact_no', 45)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('agent_code', 50)->nullable();
            $table->string('guest_from_cat', 50);
            $table->string('room_type', 50);
            $table->string('meal_plan', 50);
            $table->string('no_of_pax');
            $table->string('total_pax_count');
            $table->string('rooms_need');
            $table->decimal('us', 10, 2);
            $table->decimal('rs', 10, 2);
            $table->text('description')->nullable();
            $table->string('adults');
            $table->string('children')->nullable();
            $table->string('infants')->nullable();
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->date('departure_date');
            $table->string('no_of_day');
            $table->string('reservation_code', 255);
            $table->enum('status', ['Reservation', 'Registered'])->default('Reservation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
