<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatThreadsTable extends Migration {

  public function up() {
    Schema::create('chatthreads', function(Blueprint $table) {
      $table->increments('id');
      $table->enum('type', array('private', 'group', 'public'))->default('public');
      $table->integer('ownerId');
      $table->integer('requesterId')->default(0);
      $table->string('virtualId', 100)->nullable();
      $table->boolean('isStreaming')->default(false);
      $table->datetime('lastStreamingTime')->nullable();
      $table->integer('streamingTime')->default(0);
      $table->datetime('createdAt');
      $table->datetime('updatedAt');
    });
  }

  public function down() {
    Schema::drop('chatThreads');
  }

}
