<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerPayoutRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performer_payout_requests', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('performerId');
          $table->integer('payoutAccountId');
          $table->text('payoutInfo');
          $table->date('dateFrom');
          $table->date('dateTo');
          $table->text('comment');
          $table->text('note');
          $table->enum('status', ['pending', 'approved', 'cancelled', 'done'])->default('pending');
          $table->enum('type', ['performer', 'studio'])->default('performer');
          $table->integer('studioRequestId');
          $table->string('uuid', 200);
          $table->float('payout')->nullable();
          $table->float('previousPayout')->nullable();
          $table->float('pendingBalance')->nullable();
          $table->string('paymentAccount', 100)->nullable();
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
        Schema::drop('performer_payout_requests');
    }
}
