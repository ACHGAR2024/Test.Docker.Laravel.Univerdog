<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->string('name_dog');  // Dog's name 
            $table->string('breed');  // Dog's breed
            $table->date('birth_date');  // Dog's birth date
            $table->decimal('weight', 5, 2);  // Dog's weight
            $table->string('sex');  // Dog's sex
            $table->text('medical_info')->nullable();  // Dog's medical informations, optional
            $table->string('qr_code')->nullable();  // Dog's qr code, optional
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Foreign key to the users table
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('dogs');
    }
}