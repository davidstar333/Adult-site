<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudioPayoutRequestComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studio_payout_request_comments', function (Blueprint $table) {
          $table->increments('id');
          $table->enum('sentBy', ['admin', 'studio'])->default('studio');
          $table->integer('senderId');
          $table->integer('payoutRequestId');
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
    public function down()
    {
        Schema::drop('studio_payout_request_comments');
    }
}
