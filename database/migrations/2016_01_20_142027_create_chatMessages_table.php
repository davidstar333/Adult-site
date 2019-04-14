<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatMessagesTable extends Migration {

  public function up() {
    Schema::create('chatmessages', function(Blueprint $table) {
      $table->increments('id');
      $table->enum('type', array('private', 'group', 'public'))->default('public');
      $table->enum('tip', array('yes', 'no'))->default('no');
      $table->integer('ownerId');
      $table->integer('threadId');
      $table->string('text', 1024);
      $table->datetime('createdAt');
      $table->datetime('updatedAt');
    });
  }

  public function down() {
    Schema::drop('chatMessages');
  }

}
