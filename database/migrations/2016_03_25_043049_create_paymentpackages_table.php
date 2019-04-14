<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentpackagesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('paymentpackages', function(Blueprint $table) {
      $table->increments('id');
      $table->string('paymentSystem', 5);
      $table->string('packageId', 100);
      $table->float('price');
      $table->integer('tokens');
      $table->text('description');
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
    Schema::drop('paymentpackages');
  }

}
