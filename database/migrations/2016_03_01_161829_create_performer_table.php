<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {

    Schema::create('performer', function(Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id');
      $table->integer('category_id');
      $table->enum('sex', array('male', 'female'))->nullable();
      $table->integer('age');
      $table->enum('sexualPreference', array('lesbian','transsexual','female','no_comment','male','couple'))->nullable();
      $table->enum('ethnicity', array('white','asian','black','indian','latin','unknown'))->nullable();
      $table->enum('eyes', array('blue', 'brown', 'green', 'unknown'))->nullable();
      $table->enum('hair', array('brown', 'blonde', 'black', 'red','unknown'))->nullable();
      $table->enum('pubic', array('trimmed', 'shaved', 'hairy', 'no_comment'))->nullable();
      $table->string('languages');
      $table->string('height', 30)->nullable();
      $table->enum('bust', array('large', 'medium', 'small', 'no_comment'));
      $table->string('width')->nullable();
      $table->enum('pubit', array('trimmed', 'shaved', 'hairy', 'no_comment'))->default('no_comment');
      $table->string('weight', 200);
      $table->integer('country_id')->nullable();
      $table->integer('state_id')->nullable();
      $table->integer('city_id')->nullable();
      $table->string('state_name', 100);
      $table->string('city_name', 32);
      $table->text('about_me');
      $table->string('blog', 255);
      $table->string('blogname', 100);
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
    Schema::drop(countries1);
  }

}
