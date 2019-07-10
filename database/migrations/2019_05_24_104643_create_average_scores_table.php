<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAverageScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('average_scores', function (Blueprint $table) {
            $table->increments('avgid');
            $table->integer('user_id')->unsigned();
            $table->integer('quiz_id')->unsigned();
            $table->decimal('avg_score', 5, 2);
            $table->timestamps();
        });

        Schema::table('average_scores', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('quiz_id')->references('quizid')->on('quizzes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('average_scores');
    }
}
