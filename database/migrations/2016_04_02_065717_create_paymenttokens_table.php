<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymenttokensTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('paymenttokens', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('ownerId');
      $table->string('item', 32);
      $table->integer('itemId');
      $table->integer('tokens');
      $table->enum('status', array('processing', 'approved', 'reject'))->default('processing');
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
    Schema::drop('paymenttokens');
  }

}
