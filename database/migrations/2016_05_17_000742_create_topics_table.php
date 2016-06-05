<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        #Main topics table
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uuid')->index();
            $table->integer('flg')->default(1);
            $table->integer('anon')->default(0);
            $table->uuid('uid');
            $table->string('topic');
            $table->text('text')->nullable();
            $table->string('tags')->nullable();
            $table->tinyInteger('channel');
            $table->tinyInteger('verified')->default(0);
            $table->string('slug');
            $table->integer('answer')->default(0);
            $table->integer('follow')->default(0);
            $table->integer('views')->default(0);
            $table->integer('upvote')->default(0);
            $table->integer('downvote')->default(0);
            $table->timestamps();
        });

        #User vote table
        Schema::create('user_vote', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('activity');  //1 for upvote, 2 for downvote
            $table->integer('topic_uuid');
            $table->uuid('user_uuid');
            $table->timestamps();
        });

        #Channel table
        Schema::create('channel', function (Blueprint $table) {
            $table->integer('id')->index();
            $table->integer('flg')->default(1);
            $table->string('name');
            $table->string('slug');
            $table->timestamps();

            $table->primary('id');
        });

        #Tags table
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('topic_uuid')->index();
            $table->string('title');
            $table->timestamps();
        });

        #Experts table
        Schema::create('experts', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_uuid')->index();
            $table->string('slug');
            $table->string('title');
            $table->string('text')->nullable();
            $table->integer('endorsed')->default(0);;
            $table->integer('flg')->default(1);
            $table->timestamps();
        });

        #Endorsed Tracker
        Schema::create('endorsed_tracker', function (Blueprint $table) {
            $table->integer('from_uuid')->index();
            $table->integer('to_uuid')->index();
            $table->string('title');
            $table->integer('flg')->default(1);
            $table->timestamps();
        });


        #Follow Question topics
        Schema::create('topics_follow', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('flg')->default(1);
            $table->string('topic_id');
            $table->string('uuid');
            $table->timestamps();
        });


        #Log user IP
        Schema::create('ip_logger', function (Blueprint $table) {
            $table->increments('id');
            $table->string('obj_id');
            $table->string('action');       //reply, post etc
            $table->string('user_uuid');
            $table->string('ip')->nullable();
            $table->string('hostname')->nullable();
            $table->string('org')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('country')->nullable();
            $table->string('loc')->nullable();
            $table->string('postal')->nullable();
            $table->timestamps();
        });

        #Replies
        Schema::create('topics_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uuid')->index();
            $table->integer('flg')->default(1);
            $table->integer('expert_uuid')->index();
            $table->integer('topic_uuid')->index();
            $table->uuid('user_uuid')->index();
            $table->text('body');
            $table->integer('views')->default(0);
            $table->integer('upvote')->default(0);
            $table->integer('downvote')->default(0);
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
        Schema::drop('topics');
        Schema::drop('tags');
        Schema::drop('user_vote');
        Schema::drop('topics_follow');
        Schema::drop('ip_logger');
        Schema::drop('topics_answers');
        Schema::drop('experts');
        Schema::drop('endorsed_tracker');
        Schema::drop('channel');
    }
}
