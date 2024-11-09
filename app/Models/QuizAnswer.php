<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'is_started' => 'boolean',
        'status' => 'boolean',
    ];
    public function Question() : \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\Question','id','question_id');
    }

    public function QuestionV2() : \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\QuestionV2','id','question_id');
    }
}
