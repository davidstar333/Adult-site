<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerProductTracking extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('performer_product_tracking', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('performerId');
      $table->integer('userId');
      $table->integer('productId');
      $table->integer('quantity')->default(1);
      $table->string('productName')->nullable();
      $table->integer('token');
      $table->string('status')->default('open');
      $table->string('purchaseStatus')->nullable();
      $table->string('shippingStatus')->default('pending');
      $table->string('shippingAddress1')->nullable();
      $table->string('shippingAddress2')->nullable();
      $table->string('note')->nullable();
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
    Schema::drop('performer_product_tracking');
  }
}
