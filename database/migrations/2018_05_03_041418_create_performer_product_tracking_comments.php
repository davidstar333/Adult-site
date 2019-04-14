<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerProductTrackingComments extends Migration
{

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('performer_product_tracking_comments', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('senderId');
      $table->integer('orderId');
      $table->string('text');
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
    Schema::drop('performer_product_tracking_comments');
  }

}
