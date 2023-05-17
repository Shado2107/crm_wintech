<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesQuizzsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses_quizzs', function (Blueprint $table) {
            $table->id('id');
            $table->string('valeur');
            $table->unsignedInteger('question_quizz_id');
            $table->integer('bonne_reponse');
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
        Schema::drop('responses_quizzs');
    }
}
