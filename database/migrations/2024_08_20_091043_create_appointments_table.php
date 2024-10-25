<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('date_appointment');  // Appointment date
            $table->time('time_appointment');  // Appointment time
            $table->string('reason');  // Reason for the appointment
            $table->string('status');  // Appointment status (e.g. "Confirmed", "Cancelled")
            $table->foreignId('dog_id')->constrained('dogs')->onDelete('cascade');  // Foreign key to the dogs table
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');  // Foreign key to the professionals table
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}