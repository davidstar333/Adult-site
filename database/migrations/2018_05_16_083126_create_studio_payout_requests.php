<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudioPayoutRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studio_payout_requests', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('studioId');
          $table->integer('payoutAccountId');
          $table->text('payoutInfo');
          $table->date('dateFrom');
          $table->date('dateTo');
          $table->text('comment');
          $table->text('note');
          $table->enum('status', ['pending', 'approved', 'cancelled', 'done'])->default('pending');
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
        Schema::drop('studio_payout_requests');
    }
}
