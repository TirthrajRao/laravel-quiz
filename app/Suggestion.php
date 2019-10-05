<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
	protected $table = 'suggestion';
    protected $fillable = [
        'user_id', 'quiz_id', 'suggestion'
    ];
}
