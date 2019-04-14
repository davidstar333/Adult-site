<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarningsettingsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('earningsettings', function(Blueprint $table) {
      $table->increments('id');
      $table->integer('userId');
      $table->double('referredMember', 8, 2);
      $table->double('performerSiteMember', 8, 2);
      $table->double('otherMember', 8, 2);
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
    Schedule::drop('earningsettings');
  }

}
