<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseUserQuizzsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_user_quizzs', function (Blueprint $table) {
            $table->id('id');
            $table->integer('note');
            $table->integer('question_quizz_id');
            $table->integer('user_id');
            $table->integer('passer_test_id');
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
        Schema::drop('response_user_quizzs');
    }
}
