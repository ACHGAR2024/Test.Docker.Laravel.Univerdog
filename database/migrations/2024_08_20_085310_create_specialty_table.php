<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialtyTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('specialty', function (Blueprint $table) {
            $table->id();
            $table->string('name_speciality');  
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');  
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations. 
     */
    public function down()
    {
        Schema::dropIfExists('specialty');
    }
}