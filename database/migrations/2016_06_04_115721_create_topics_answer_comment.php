<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsAnswerComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        #Replies
        Schema::create('topics_answers_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('topic_answers_uuid')->index();
            $table->integer('flg')->default(1);
            $table->uuid('user_uuid')->index();
            $table->text('body');
            $table->integer('upvote')->default(0);
            $table->integer('downvote')->default(0);
            $table->timestamps();
        });


        #MODIFY TABLES
        Schema::table('tags', function ($table) {
            $table->integer('channel_id')->index();
        });

        //Adding channels to users table
        Schema::table('users', function ($table) {
            $table->string('channels');
            $table->boolean('init_setup')->default(FALSE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topics_answers_comments');

        Schema::table('tags', function ($table) {
            $table->dropColumn('channel_id');
        });

        Schema::table('users', function ($table) {
            $table->dropColumn('channels');
            $table->boolean('init_setup');
        });
    }
}
