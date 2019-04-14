<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerPayoutRequestComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performer_payout_request_comments', function (Blueprint $table) {
          $table->increments('id');
          $table->enum('sentBy', ['admin', 'performer'])->default('performer');
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
        Schema::drop('performer_payout_request_comments');
    }
}
