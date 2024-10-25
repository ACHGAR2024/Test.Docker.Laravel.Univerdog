<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilityTable extends Migration
{
    /**
     * Run the migrations. 
     */
    public function up()
    {
        Schema::create('availability', function (Blueprint $table) {
            $table->id();
            $table->string('day');  // Day of the week (e.g. "Monday" or "Saturday")
            $table->time('start_time');  // Start time
            $table->time('end_time');  // End time
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');  // Foreign key to the professionals table
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('availability');
    }
}