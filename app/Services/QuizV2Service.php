<?php

namespace App\Services;


use App\Models\Player;
use App\Models\Question;
use App\Models\QuestionV2;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuizV2Service
{
    public function store(Player $player): array
    {
        try {
            DB::beginTransaction();

            $types = QuestionV2::select('environment')->groupBy('environment')->get()->pluck('environment')->toArray();
            $queries = [];
            $returnArrayData = [];
            $returnArrayData['questions'] = [];
            foreach ($types as $key => $type) {
                $query = QuestionV2::query()->where('environment', $type)->limit(3)->inRandomOrder();
                if ($key === 0) {
                    $queries[] = $query;
                } else {
                    $queries[] = $queries[0]->union($query);
                }
            }

            $finalQuery = array_pop($queries);
            $questions = $finalQuery->get();


            $quiz = new Quiz;
            $quiz->player_id = $player->id;
            $uuid = Str::replace('-','',Str::uuid());
            $quiz->uuid = $uuid;
            $quiz->save();
            $returnArrayData['quiz_hash'] = $quiz->uuid;
            $inc = 0;
            foreach ($questions as $question) {

                $quiz_answer = new QuizAnswer;
                $quiz_answer->quiz_id = $quiz->id;
                $quiz_answer->question_id = $question->id;
                $quiz_answer->inc = ++$inc;
                $quiz_answer->save();

                $returnArrayData['questions'][] = [
                    'id' => $quiz_answer->inc,
                    'question' => $question->question,
                    'answer_1' => $question->answer_1,
                    'answer_2' => $question->answer_2,
                    'answer_3' => $question->answer_3,
                    'environment' => $question->environment,
                ];
            }

            DB::commit();
            return $returnArrayData;
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return [];
        }
    }

}
