<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('documents', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('ownerId');
      $table->string('idImage', 200);
      $table->string('faceId', 200);
      $table->string('releaseForm', 200);
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
    Schema::drop('documents');
  }

}
