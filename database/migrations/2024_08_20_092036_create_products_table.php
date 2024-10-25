<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_product');  
            $table->text('description_product')->nullable();  
            $table->decimal('price', 10, 2);  
            $table->string('affiliation_link')->nullable();  
            $table->foreignId('products_category_id')->constrained('products_category')->onDelete('cascade');  
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}