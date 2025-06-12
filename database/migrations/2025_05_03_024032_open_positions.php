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
        Schema::create('open_positions', function (Blueprint $table) {
            $table->id();
            $table->string('UID')->unique(); // Ensuring UID is unique
            $table->string('pos_name');
            $table->string('pos_quantity');
            $table->string('job_type');
            $table->longText('job_description');
            $table->json('qualifications');
            $table->json('benefits');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_positions');
    }
};
