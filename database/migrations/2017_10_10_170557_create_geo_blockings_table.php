<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoBlockingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('geo_blockings', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('userId');
              $table->string('iso_code', 4);
              $table->boolean('isBlock')->default(false);
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
          Schema::drop('geo_blockings');
    }
}
