<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsettingsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('paymentsettings', function(Blueprint $table) {
      $table->increments('id');
      $table->string('name', 100);
      $table->string('shortname', 5);
      $table->text('description');
      $table->string('accountNumber', 15);
      $table->string('subAccount', 10);
      $table->string('formName', 10);
      $table->string('currencyCode', 4);
      $table->string('saltKey', 50);
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
  }

}
