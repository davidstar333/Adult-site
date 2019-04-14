<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlacklistTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('blacklist', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('locker');
      $table->integer('userId');
      $table->enum('lock', array('yes', 'no'))->default('yes');
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
    Schedule::drop('blacklist');
  }

}
