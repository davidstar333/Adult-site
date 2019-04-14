<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerchatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performerchats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id');
            $table->integer('private_price')->default(10);
            $table->integer('group_price')->default(10);
            $table->string('welcome_message', 200);
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
        Schema::drop('performerchats');
    }
}
