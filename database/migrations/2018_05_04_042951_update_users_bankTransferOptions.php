<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersBankTransferOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `users` ADD `bankTransferOptions` TEXT NULL DEFAULT NULL AFTER `updatedAt`, ADD `directDeposit` TEXT NULL DEFAULT NULL AFTER `bankTransferOptions`, ADD `paxum` TEXT NULL DEFAULT NULL AFTER `directDeposit`, ADD `bitpay` TEXT NULL DEFAULT NULL AFTER `paxum`;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
