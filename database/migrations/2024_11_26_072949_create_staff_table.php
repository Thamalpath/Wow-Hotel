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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('known_name', 255);
            $table->string('full_name', 255);
            $table->string('contact_no', 50);
            $table->text('address');
            $table->string('department', 100);
            $table->string('id_no', 50);
            $table->string('religion', 50);
            $table->string('blood_group', 50);
            $table->string('em_contact_no', 50);
            $table->string('account_no', 50);
            $table->string('account_name', 100);
            $table->string('bank', 100);
            $table->string('branch', 100);
            $table->text('special_skills')->nullable();
            $table->text('pre_worked')->nullable();
            $table->date('joined_date');
            $table->enum('currently_employed', ['Yes', 'No'])->default('Yes');
            $table->date('resign_date')->nullable();
            $table->text('reason')->nullable();
            $table->text('comments')->nullable();
            $table->string('image', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
