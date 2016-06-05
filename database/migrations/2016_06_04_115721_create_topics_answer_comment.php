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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topics_answers_comments');
    }
}
