<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('likes', function(Blueprint $table) {
      $table->increments('id');
      $table->string('item', 100);
      $table->integer('item_id');
      $table->integer('owner_id');
      $table->enum('status', array('like', 'dislike'))->default('like');
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
    Schema::drop('likes');
  }

}
