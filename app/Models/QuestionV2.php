<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
/**
 * @property mixed $question
 * @property mixed $answer_1
 * @property mixed $answer_2
 * @property mixed $answer_3
 * @property mixed $answer_4
 * @property mixed $correct_answer
 * @property mixed $security_level
 * @property mixed $environment
 */
class QuestionV2 extends Model
{
    protected $table = 'questions_v2';
}
