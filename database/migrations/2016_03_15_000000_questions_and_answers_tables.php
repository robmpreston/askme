<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionsAndAnswersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('to_user_id')->unsigned()->references('id')->on('users');
            $table->integer('from_user_id')->unsigned()->references('id')->on('users');
            $table->string('user_from')->nullable();
            $table->text('text_response');
            $table->integer('weight')->default(0);
            $table->integer('net_votes')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned()->references('id')->on('questions');
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->text('text_response')->nullable();
            $table->string('video_url')->nullable();
            $table->boolean('is_video')->default(0);
            $table->integer('net_votes')->default(0);
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
        Schema::drop('questions');
        Schema::drop('answers');
    }
}
