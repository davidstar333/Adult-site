<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarningsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('earnings', function(Blueprint $table) {
      $table->increments('id');
      $table->string('item');
      $table->integer('itemId');
      $table->integer('payFrom');
      $table->integer('payTo');
      $table->integer('tokens');
      $table->float('percent');
      $table->enum('type', array('referredMember', 'performerSiteMember', 'otherMember'));
      $table->string('status', 15)->nullable();
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
    Schedule::drop('earnings');
  }

}
