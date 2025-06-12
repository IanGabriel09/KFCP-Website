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
        Schema::create('applicants_history', function (Blueprint $table) {
            $table->id(); 
            $table->string('application_id');
            $table->string('application_status')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('contact');

            // Ensure the data type matches UID
            $table->string('selected_position_id'); // FK to open_positions.UID
            $table->string('selected_position');

            $table->string('subject');
            $table->longText('mssg');
            $table->longText('gdrive_folderlink');
            $table->longText('cv_drive_name');
            $table->dateTime('interview_date')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants_history');
    }
};
