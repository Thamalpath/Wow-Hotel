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
        Schema::create('billing_item', function (Blueprint $table) {
            $table->id();
            $table->string('item_code');
            $table->string('item_name');
            $table->decimal('price', 10, 2);
            $table->string('allocated_room_no');
            $table->date('bill_date');
            $table->integer('qty');
            $table->decimal('bill_total', 10, 2);
            $table->string('bill_no');
            $table->string('guest_name');
            $table->date('reservation_date');
            $table->string('item_cat');
            $table->string('reservation_code');
            $table->string('key_room');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_item');
    }
};
