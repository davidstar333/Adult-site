<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionGenderSexUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `gender` enum('male','female','transgender') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `passwordResetToken`;");
        DB::statement("ALTER TABLE `performer` MODIFY COLUMN `sex` enum('male','female','transgender') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `user_id`;
");
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
