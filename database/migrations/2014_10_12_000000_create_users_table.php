<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug', 100)->unique(); // website-url
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('facebook_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->boolean('respondant')->default(0); // can this person take questions?
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->string('i_am_a')->nullable();
            $table->string('from')->nullable();
            $table->text('description')->nullable();

            // websites + social media
            $table->string('website_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('profiles');
    }
}
