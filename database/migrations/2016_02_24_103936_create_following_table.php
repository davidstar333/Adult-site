<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowingTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('following', function(Blueprint $table) {
      $table->increments('id');
      $table->string('type', 30);
      $table->enum('status', array('follow', 'disfollow'))->default('follow');
      $table->integer('owner_id');
      $table->integer('follower');
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
    Schema::drop('following');
  }

}
