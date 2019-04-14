<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('videos', function(Blueprint $table) {
      $table->increments('id');
      $table->string('title');
      $table->integer('galleryId');
      $table->integer('trailer');
      $table->integer('poster');
      $table->integer('fullMovie');
      $table->integer('price');
      $table->integer('ownerId');
      $table->text('description', 500);
      $table->string('length', 200);
      $table->integer('download')->default(0);
      $table->string('seo_url');
      $table->enum('status', array('active','inactive','processing','success'))->default('processing');
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
    Schema::drop('videos');
  }

}
