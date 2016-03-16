<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned()->references('id')->on('questions');
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->text('text');
            $table->boolean('is_down_vote')->default(0);
            $table->timestamps();
        });

        Schema::create('answer_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('answer_id')->unsigned()->references('id')->on('answers');
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->text('text');
            $table->boolean('is_down_vote')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('question_votes');
        Schema::drop('answer_votes');
    }
}
