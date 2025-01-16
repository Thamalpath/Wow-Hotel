<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('registration', function (Blueprint $table) {
        $table->id();
        $table->string('guest_type');
        $table->string('guest_name');
        $table->string('guest_country');
        $table->string('contact_no')->nullable();
        $table->string('email')->nullable();
        $table->string('id_pass')->nullable();
        $table->date('expire_date')->nullable();
        $table->text('address')->nullable();
        $table->string('guest_from_cat');
        $table->string('room_type');
        $table->string('meal_plan');
        $table->string('no_of_pax');
        $table->integer('total_pax_count');
        $table->integer('rooms_need');
        $table->decimal('us', 10, 2);
        $table->decimal('rs', 10, 2);
        $table->string('currency');
        $table->text('description')->nullable();
        $table->integer('adults')->nullable();
        $table->integer('children')->nullable();
        $table->integer('infants')->nullable();
        $table->date('reservation_date');
        $table->time('reservation_time');
        $table->date('departure_date');
        $table->time('departure_time')->nullable();
        $table->integer('no_of_day');
        $table->string('reservation_code');
        $table->string('profession')->nullable();
        $table->string('allocated_room_no')->nullable();
        $table->string('key_room')->nullable();
        $table->string('status')->nullable();
        $table->string('image')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration');
    }
};
