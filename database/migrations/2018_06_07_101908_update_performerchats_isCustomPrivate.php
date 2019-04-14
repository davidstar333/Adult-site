<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePerformerchatsIsCustomPrivate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement('ALTER TABLE `performerchats` ADD `isCustomPrivate` INT(1) NULL DEFAULT NULL AFTER `welcome_message`, ADD `isCustomGroup` INT(1) NULL DEFAULT NULL AFTER `isCustomPrivate`;');
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
