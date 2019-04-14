<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatThreadUsersTable extends Migration {

  public function up() {
    Schema::create('chatthreadusers', function(Blueprint $table) {
      $table->increments('id');
      $table->integer('threadId');
      $table->integer('userId');
      $table->boolean('isStreaming')->default(0);
      $table->datetime('lastStreamingTime')->nullable();
      $table->integer('streamingTime');
      $table->datetime('createdAt');
      $table->datetime('updatedAt');
    });
  }

  public function down() {
    Schema::drop('chatTheadUsers');
  }

}
