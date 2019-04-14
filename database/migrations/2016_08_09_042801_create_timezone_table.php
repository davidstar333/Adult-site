<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimezoneTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('timezone', function (Blueprint $table) {
      $table->integer('zone_id');
      $table->string('abbreviation', 6);
      $table->string('time_start', 11);
      $table->string('gmt_offset', 11);
      $table->string('dst', 1);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    //
    Schema::drop('timezone');
  }

}
