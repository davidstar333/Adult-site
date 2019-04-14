<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('attachment', function(Blueprint $table) {
      $table->increments('id');
      $table->string('type', 30);
      $table->enum('media_type', array('profile', 'image', 'video', 'poster', 'trailer', 'feed'))->nullable();
      $table->text('mediaMeta');
      $table->integer('owner_id');
      $table->integer('parent_id');
      $table->string('path', 256);
      $table->string('size', 50);
      $table->string('length', 200);
      $table->string('dimensions', 200);
      $table->string('status', 50)->default('active');
      $table->enum('main', array('yes', 'no'))->default('no');
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
    Schema::drop('attachment');
  }

}
