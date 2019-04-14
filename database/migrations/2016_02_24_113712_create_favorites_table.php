<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('favorites', function(Blueprint $table) {
      $table->increments('id');
      $table->string('type', 30);
      $table->enum('status', array('like', 'unlike'))->default('like');
      $table->integer('ownerId');
      $table->integer('favoriteId');
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
    Schema::drop('favorites');
  }

}
