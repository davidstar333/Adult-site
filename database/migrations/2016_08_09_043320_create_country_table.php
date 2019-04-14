<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('countries', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 50);
      $table->string('alpha_2', 2);
      $table->string('alpha_3', 3);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    //
    Schema::drop('countries');
  }

}
