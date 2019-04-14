<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('posts', function(Blueprint $table) {
      $table->increments('id');
      $table->string('title', 200);
      $table->text('text');
      $table->enum('type', array('private', 'public'));
      $table->integer('owner_id');
      $table->integer('total_likes');
      $table->integer('total_comments');
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
    Schema::drop('posts');
  }

}
