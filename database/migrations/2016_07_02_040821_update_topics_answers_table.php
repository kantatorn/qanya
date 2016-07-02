<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTopicsAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        #MODIFY TABLES
        #ADD TOTAL NUMBER OF COMMENTS
        Schema::table('topics_answers', function ($table) {
            $table->integer('replies_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics_answers', function ($table) {
            $table->dropColumn('replies_count');
        });
    }
}
