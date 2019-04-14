<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('galleries', function(Blueprint $table) {
      $table->increments('id');
      $table->enum('type', array('image', 'video'));
      $table->enum('status', array('public', 'private', 'invisible'))->default('invisible');
      $table->integer('ownerId');
      $table->string('name', 255);
      $table->string('slug', 255);
      $table->text('description', 500);
      $table->integer('price')->nullable();
      $table->integer('previewImage')->nullable();
      $table->integer('download')->default(0);
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
    Schema::drop('galleries');
  }

}
