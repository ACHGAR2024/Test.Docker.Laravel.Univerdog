<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->text('message');
        $table->date('date_notification');
        $table->boolean('read')->default(false);
        $table->foreignId('user_id')->constrained('users');
        $table->timestamps();
    });
    
}

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};