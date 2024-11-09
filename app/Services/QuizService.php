<?php

namespace App\Services;


use App\Models\Player;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuizService
{
    public function store(Player $player): string
    {
        try {
            DB::beginTransaction();
            $quiz = new Quiz;

            $quiz->player_id = $player->id;
            $quiz->uuid = Str::uuid();
            //$quiz->score = 0;

            $quiz->save();
            $inc = 0;
            foreach ($this->randAnswers() as $question) {

                $quiz_answer = new QuizAnswer;
                $quiz_answer->quiz_id = $quiz->id;
                $quiz_answer->question_id = $question;
                $quiz_answer->inc = ++$inc;

                $quiz_answer->save();
                //$inc++;
            }
            DB::commit();
            return $quiz->uuid;
        } catch (\Exception $e) {
            report($e);
            DB::rollBack(); // <= Rollback in case of an exception
            return 'ERROR';
        }
    }


    public function randAnswers(): array
    {
        $rna = range(1, 25);

        //dump($rna);

        shuffle($rna);
        //dump($rna);

        return array_slice($rna, 0, 5);
    }
}
