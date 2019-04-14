<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerProducts extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('performer_products', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('performerId')->nullable();
      $table->string('name', 255)->nullable();
      $table->string('description')->nullable();
      $table->integer('token')->nullable();
      $table->integer('inStock')->nullable()->default(-1);
      $table->string('imageId')->nullable(); //link to attachment
      $table->tinyInteger('isActive')->default(1);
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
    Schema::drop('performer_products');
  }

}
