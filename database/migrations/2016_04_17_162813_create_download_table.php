<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('download', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('ownerId');
      $table->enum('item', array('video', 'image'));
      $table->string('path', 200);
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
    Schema::drop('download');
  }

}
