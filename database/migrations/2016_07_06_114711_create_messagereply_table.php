<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagereplyTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('messagereply', function (Blueprint $table) {
      $table->increments('id');
      $table->text('reply');
      $table->integer('userId');
      $table->integer('receivedId');
      $table->integer('sendId');
      $table->string('ip', 30);
      $table->integer('time');
      $table->integer('conversationId');
      $table->enum('status', array('sent', 'received', 'trash'));
      $table->enum('read', array('yes', 'no'))->default('no');
      $table->text('userAction');
      $table->datetime('createdAt');
      $table->datetime('updatedAt');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    //
    Schema::drop('messagereply');
  }

}
