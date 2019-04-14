<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('payments', function(Blueprint $table) {
      $table->increments('id');
      $table->integer('memberId');
      $table->integer('packageId');
      $table->string('type', 30);
      $table->integer('price');
      $table->text('description');
      $table->text('parameters');
      $table->integer('accessTime');
      $table->enum('status', array('approved', 'rejected', 'denial', 'error'))->default('approved');
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
    Schema::drop('payments');
    //
  }

}
