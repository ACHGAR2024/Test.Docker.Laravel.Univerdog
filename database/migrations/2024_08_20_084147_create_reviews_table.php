<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('rating');  // Review rating
            $table->text('comment')->nullable();  // Review comment
            $table->date('date_review');  // Review date
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');  // Foreign key to the professionals table
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}