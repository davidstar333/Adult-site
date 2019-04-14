<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
      Schema::create('pages', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 255);
      $table->string('alias', 255);
      $table->string('title', 255);
      $table->string('keyword', 160);
      $table->string('metaDescription', 160);
      $table->text('description');
      $table->enum('status', array('active', 'inactive'));
      $table->tinyInteger('sort');
      $table->datetime('createdAt');
      $table->datetime('updatedAt');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
      Schema::drop('pages');
    }
}
