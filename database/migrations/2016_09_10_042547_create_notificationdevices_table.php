<?php

  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateNotificationdevicesTable extends Migration {

      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up() {
          //
          Schema::create('notificationdevices', function (Blueprint $table) {
              $table->increments('id');
              $table->enum('deviceType', array('IOS', 'ANDROID'))->nullable();
              $table->integer('userId');
              $table->text('deviceToken')->nullable();
              $table->text('deviceId')->nullable();
              $table->enum('push', array('YES', 'NO'))->default('NO');
              $table->datetime('createdAt');
              $table->datetime('updatedAt');
          });
      }

      /**
       * Reverse the migrations.
       *
       * @return void
       */
      public function down() {
          //
        Schema::drop('notificationdevices');
      }

  }
  