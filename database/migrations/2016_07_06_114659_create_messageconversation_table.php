<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageconversationTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('messageconversation', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('userOne');
      $table->integer('userTwo');
      $table->string('subject', 200);
      $table->string('ip', 30);
      $table->integer('time');
      $table->enum('status', array('active', 'trash', 'delete'));
      $table->text('deleteUser');
      $table->enum('read', array('yes', 'no'));
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
    Schema::drop('messageconversation');
  }

}
