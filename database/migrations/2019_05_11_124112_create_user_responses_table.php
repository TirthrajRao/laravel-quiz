<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_responses', function (Blueprint $table) {
            $table->increments('responseid');
            $table->integer('user_id')->unsigned();
            $table->integer('userData_appear')->unsigned();
            $table->integer('quiz_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->string('user_response');
            $table->boolean('correct')->default(false);
            $table->integer('time_taken');
            $table->timestamps();
        });
        
        Schema::table('user_responses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('quiz_id')->references('quizid')->on('quizzes')->onDelete('cascade');
            $table->foreign('question_id')->references('questionid')->on('questions')->onDelete('cascade');
            $table->foreign('userData_appear')->references('quizAppearid')->on('quiz_appears')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_responses');
    }
}
