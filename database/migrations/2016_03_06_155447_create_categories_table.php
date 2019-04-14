<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('categories', function(Blueprint $table) {
      $table->increments('id');
      $table->string('name', 100);
      $table->string('slug', 200);
      $table->dateTime('createdAt');
      $table->dateTime('updatedAt');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    //
    Schema::drop('categories');
  }

}
