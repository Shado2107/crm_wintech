<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasserTestsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passer_tests', function (Blueprint $table) {
            $table->id('id');
            $table->integer('roue_de_vie_id');
            $table->integer('canva_mini_disq_id');
            $table->integer('quizz_id');
            $table->integer('competence_id');
            $table->integer('user_id');
            $table->integer('point_id');
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
        Schema::drop('passer_tests');
    }
}
