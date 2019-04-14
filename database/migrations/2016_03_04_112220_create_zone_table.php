<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZoneTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('zone', function(Blueprint $table) {
      $table->increments('zone_id');
      $table->string('country_code', 3);
      $table->string('zone_name', 100);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    //
    Schema::drop('zone');
  }

}
