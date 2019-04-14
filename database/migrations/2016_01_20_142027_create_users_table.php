<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

  public function up() {
    Schema::create('users', function(Blueprint $table) {
      $table->increments('id');
      $table->integer('parentId');
      $table->string('firstName', 32)->nullable();
      $table->string('lastName', 32)->nullable();
      $table->string('username', 32);
      $table->string('email', 128);
      $table->text('deviceToken');
      $table->text('deviceId');
      $table->string('address1', 64);
      $table->string('address2', 64);
      $table->integer('countryId');
      $table->integer('cityId');
      $table->string('cityName', 32)->nullable();
      $table->integer('stateId');
      $table->string('stateName', 100)->nullable();
      $table->string('zip', 10);
      $table->string('mobilePhone', 15);
      $table->integer('minPayment')->default(200);
      $table->string('payoneer', 200)->nullable();
      $table->string('paypal', 200)->nullable();
      $table->string('bankAccount', 255)->nullable();
      $table->tinyInteger('emailVerified')->default(0);
      $table->string('emailVerifyToken', 128)->nullable();
      $table->string('passwordHash', 128)->nullable();
      $table->string('passwordResetToken', 128)->nullable();
      $table->enum('gender', array('male', 'female'))->nullable();
      $table->date('birthdate')->nullable();
      $table->enum('role', array('member', 'model', 'studio', 'admin', 'superadmin'));
      $table->integer('tokens')->default(0);
      $table->longtext('avatar')->nullable();
      $table->longtext('smallAvatar')->nullable();
      $table->string('status', 100);
      $table->enum('accountStatus', array('active','suspend','notConfirmed','disable','waiting'))->default('notConfirmed');
      $table->text('suspendReason', 500)->nullable();
      $table->integer('location_id')->default(0);
      $table->text('bio');
      $table->text('userMeta');
      $table->text('userSettings');
      $table->enum('is_social', array('yes', 'no'))->default('no');
      $table->datetime('createdAt');
      $table->datetime('updatedAt');
    });
  }

  public function down() {
    Schema::drop('users');
  }

}