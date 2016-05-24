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
            $table->string('uuid')->index();
            $table->string('ext_source')->nullable();
            $table->string('ext_id')->index();
            $table->boolean('ext_verified')->nullable();
            $table->string('displayname')->index();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('gender')->nullable();
            $table->string('avatar')->nullable();
            $table->string('description')->nullable();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->integer('questions')->nullable();
            $table->integer('answers')->nullable();
            $table->integer('followers')->nullable();
            $table->integer('following')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
