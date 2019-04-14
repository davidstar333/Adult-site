<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettingsPlaceholderAvatars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `settings` ADD `placeholderAvatar1` TEXT NOT NULL AFTER `tipSound`, ADD `placeholderAvatar2` TEXT NOT NULL AFTER `placeholderAvatar1`, ADD `placeholderAvatar3` TEXT NOT NULL AFTER `placeholderAvatar2`;');
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
