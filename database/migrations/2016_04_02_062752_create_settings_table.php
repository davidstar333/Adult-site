<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //
    Schema::create('settings', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('modelDefaultReferredPercent')->default(0);
      $table->integer('studioDefaultReferredPercent')->default(0);
      $table->integer('modelDefaultPerformerPercent')->default(0);
      $table->integer('studioDefaultPerformerPercent')->default(0);
      $table->integer('modelDefaultOtherPercent')->default(0);
      $table->integer('studioDefaultOtherPercent')->default(0);
      $table->integer('memberJoinBonus')->default(0);
      $table->integer('messagePrice')->default(0);
      $table->integer('group_price')->default(10);
      $table->integer('private_price')->default(10);
      $table->integer('min_tip_amount')->default(30);
      $table->string('mailFrom', 64);
      $table->float('conversionRate');
      $table->string('tracking_id', 30)->nullable();
      $table->string('title', 100)->nullable();
      $table->string('siteName', 100)->nullable();
      $table->string('logo', 200);
      $table->string('registerImage', 255)->nullable();
      $table->string('offlineImage', 255)->nullable();
	  $table->string('groupImage', 255)->nullable();
	  $table->string('privateImage', 255)->nullable();
	  $table->string('banner', 255)->nullable();
      $table->string('bannerLink', 255)->nullable();
      $table->string('keywords', 160)->nullable();
      $table->string('description', 160)->nullable();
//      $table->string('fb_client_id', 50)->nullable();
//      $table->string('fb_client_secret', 50)->nullable();
//      $table->string('google_client_id', 100)->nullable();
//      $table->string('google_client_secret', 50)->nullable();
//      $table->string('tw_client_id', 50)->nullable();
//      $table->string('tw_client_secret', 100)->nullable();
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
    Schema::drop('settings');
  }

}
