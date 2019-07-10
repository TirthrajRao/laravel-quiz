<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('questionid');
            $table->string('question');
            $table->enum('question_type', ['mcq','tf', 'fib'])->default('mcq');
            $table->string('option_1')->nullable();
            $table->string('option_2')->nullable();
            $table->string('option_3')->nullable();
            $table->string('option_4')->nullable();
            $table->string('answer');
            $table->integer('quiz_id')->unsigned()->index();
            $table->foreign('quiz_id')->references('quizid')->on('quizzes');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('questions',  function(Blueprint $table){

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
