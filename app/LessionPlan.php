<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessionPlan extends Model
{
    protected $table = 'lession_plan';
    protected $dates = ['created_at'];

    protected $fillable = [
        'lession_no','user_id','school_name', 'subject','topic','date_lession','period_no','time','time_to','general_objectives','approach_technique','teaching_aids','text_book','refernce_books','author_book','assignment','observers_remark','author_ref_book','draft_page','reference_manual','reference','observers_sign'
    ];
}
