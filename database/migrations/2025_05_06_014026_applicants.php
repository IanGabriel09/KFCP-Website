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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id(); 
            $table->string('application_id');
            $table->string('application_status')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('contact');

            // Ensure the data type matches UID in open_positions
            $table->string('selected_position_id'); // FK to open_positions.UID
            $table->foreign('selected_position_id')
                ->references('UID')
                ->on('open_positions')
                ->onDelete('cascade'); // Enables cascading delete

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
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropForeign(['selected_position_id']);
        });

        Schema::dropIfExists('applicants');
    }

};
