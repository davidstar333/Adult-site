<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('threadId');
            $table->integer('messageformId');
            $table->integer('messagetoId');
            $table->string('messageSubject',300);
            $table->string('text', 1024);
            $table->enum('status', array('trash', 'sent', 'received'));
            $table->enum('read', array('yes', 'no'))->default('no');
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
        Schema::drop('messages');
    }
}
