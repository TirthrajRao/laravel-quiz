<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;
use App\User;

class Quiz extends Model
{
    //
    protected $dates = ['created_at'];
	protected $primaryKey = 'quizid';

    public function questions()
    {
    	return $this->hasMany(Question::class);
    }
}

