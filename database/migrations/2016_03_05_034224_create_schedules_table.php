<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('schedules', function(Blueprint $table) {
      $table->increments('id');
      $table->integer('modelId');
      $table->dateTime('nextLiveShow')->nullable();
      $table->string('timezone', 32)->nullable();
      $table->time('monday')->nullable();
      $table->time('tuesday')->nullable();
      $table->time('wednesday')->nullable();
      $table->time('thursday')->nullable();
      $table->time('friday')->nullable();
      $table->time('saturday')->nullable();
      $table->time('sunday')->nullable();
      $table->dateTime('createdAt');
      $table->dateTime('updatedAt');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    //
    Schedule::drop('schedules');
  }

}
