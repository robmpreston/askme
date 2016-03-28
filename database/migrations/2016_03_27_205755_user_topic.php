<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Topic;
use App\User;
use Illuminate\Support\Facades\DB;

class UserTopic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->string('name');
            $table->string('slug');
            $table->dateTime('opens_at');
            $table->string('timezone')->default('America/New_York');
            $table->boolean('closed')->default(0);
            $table->boolean('default')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('topic_views', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->references('id')->on('users')->default(0);
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->integer('topic_id')->unsigned()->default(0)->references('id')->on('topics')->after('id');
        });

        // UPDATE CURRENT QUESTIONS AND ADD FIRST TOPIC
        $user = User::find(5); // DeRay
        $topic = Topic::makeOne($user, [
            'name' => 'Housing & Neighborhoods/Community Prosperity/Infrastructure & Sustainability',
            'slug' => 'housing-community-prosperity-infrastructure',
            'start_now' => false,
            'start_date' => '2016-03-31',
            'start_time' => '12:00',
            'default' => true,
        ]);
        DB::table('questions')->update(['topic_id' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topics');
        Schema::drop('topic_views');
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('topic_id');
        });
    }
}
