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
        Schema::create('rate', function (Blueprint $table) {
            $table->id();
            $table->decimal('us_rate', 10, 2);
            $table->decimal('euro_rate', 10, 2);
            $table->integer('svat');
            $table->integer('vat1');
            $table->integer('service_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate');
    }
};
