<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettingsFaviconCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `settings` 
ADD COLUMN `favicon` varchar(100) NULL AFTER `description`,
ADD COLUMN `code_before_head_tag` varchar(100) NULL AFTER `favicon`,
ADD COLUMN `code_before_body_tag` varchar(100) NULL AFTER `code_before_head_tag`;');
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
