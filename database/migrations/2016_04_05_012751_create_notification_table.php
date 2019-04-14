<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('notification', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('ownerId');
      $table->enum('item', array('comment', 'notify'));
      $table->integer('itemId');
      $table->string('itemType', 50);
      $table->string('content');
      $table->enum('status', array('read', 'unread'))->default('unread');
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
    Schedule::drop('notification');
  }

}
