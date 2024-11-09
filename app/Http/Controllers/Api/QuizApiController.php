<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\PlayerQueue;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Services\QuizV2Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use function PHPUnit\Framework\isNull;

class QuizApiController extends Controller
{

    public function newQuiz(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|integer',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'input error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $code = $request->input('code');
        try {
            $player = Player::where('uuid', $code)->firstOrFail();
            /*
                        $quiz = Quiz::where('player_id', $player->id)->where('status', false)->whereDate('created_at', Carbon::today())
                            ->with([
                                'QuizAnswer' => function ($q) {
                                    $q->where('status', false);
                                    $q->with(['QuestionV2']);
                                }
                            ])
                            ->first();

                        if ($quiz == null) {
            */
            //----------->
            $debug  = $request->has('debug');
            $queue = PlayerQueue::where('player_id', $player->id)->where('status', 0)->whereDate('created_at', Carbon::today())->first();
            if ($queue == null && !$debug) {
                return response()->json([
                    'success' => false,
                    'message' => 'You Must Check-in First',
                    'errors' => [],
                ], 401);
            }
            //----------->
            $quizData = (new QuizV2Service)->store($player);
            //PlayerQueue::where('player_id', $player->id)->whereDate('created_at', Carbon::today())->update(['status' => 1]);

            //--->
            $queue->status = 1;
            $queue->save();
            //--->
            return response()->json([
                'success' => true,
                'data' => $quizData,
                'message' => 'success',
                'errors' => []
            ], 200);
            /*
                        }

                        $returnArrayData = [];
                        $returnArrayData['questions'] = [];
                        $returnArrayData['quiz_hash'] = $quiz->uuid;
                        foreach ($quiz->QuizAnswer as $quizAnswer) {
                            $question = $quizAnswer->QuestionV2;
                            $returnArrayData['questions'][] = [
                                'id' => $quizAnswer->inc,
                                'question' => $question->question,
                                'answer_1' => $question->answer_1,
                                'answer_2' => $question->answer_2,
                                'answer_3' => $question->answer_3,
                                'environment' => $question->environment,
                            ];
                        }


                        return response()->json([
                            'success' => true,
                            'data' => $returnArrayData,
                            'message' => 'success',
                            'errors' => []
                        ], 200);
                        //------>
            */

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'user not found',
                'errors' => []
            ], 404);
        }


    }

    //------------------------------------------------>
    public function checkQuiz(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quiz_hash' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'input error',
                'errors' => $validator->errors(),
            ], 400);
        }
        $quizHash = $request->input('quiz_hash');
        try {
            $quiz = Quiz::where('uuid', $quizHash)->with(['QuizAnswer'])->firstOrFail();
            $quizData = [];

            foreach ($quiz->QuizAnswer as $quizAnswer) {
                $quizData[] = [
                    'id' => $quizAnswer->inc,
                    'duration' => $quizAnswer->seconds,
                    'status' => (bool)$quizAnswer->status,
                    'is_correct' => (bool)$quizAnswer->is_correct,
                ];
            }

            if ($quiz->status) {
                return response()->json([
                    'success' => true,
                    'data' => $quizData,
                    'score' => $quiz->score,
                    'duration' => $quiz->duration,
                    'message' => 'success',
                    'errors' => []
                ], 200);
            }

            //CALC
            $total = 0;
            $correct = 0;
            $correct_reward = 900000;//180000;

            foreach ($quiz->QuizAnswer as $ans) {
                if (!$ans->is_correct)
                    continue;
                $total += $ans->seconds * 1000;
                $correct++;
            }

            if ($total >= 890000) {
                $total = 890000;
            }

            $score = (($correct * $correct_reward) - $total) / 1000;

            if ($score < 0) {
                $score = 0;
            }


            $quiz->score = $score;
            $quiz->status = true;
            $quiz->duration = $total;
            $quiz->save();
            //CALC
            PlayerQueue::where('player_id', $quiz->player_id)->update(['status' => 2]);

            return response()->json([
                'success' => true,
                'data' => $quizData,
                'score' => $quiz->score,
                'duration' => $quiz->duration,
                'message' => 'success',
                'errors' => []
            ], 200);
        } catch (ModelNotFoundException  $e) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz Not Found',
                'errors' => [],
            ], 404);
        }
    }

    //------------------------------------------------>
    public function submitQuizAnswer(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'question_id' => 'required|integer',
            'answer_id' => 'required|integer',
            'seconds' => 'required|integer',
            'quiz_hash' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'input error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $quizHash = $request->input('quiz_hash');
        $questionId = $request->input('question_id');
        $answerId = $request->input('answer_id');
        $seconds = $request->input('seconds');

        try {

            $quiz = Quiz::where('uuid', $quizHash)->where('status', 0)->with([
                'QuizAnswer' => function ($query) use ($questionId) {
                    $query->where('inc', $questionId)->with(['QuestionV2']);
                }
            ])->firstOrFail();


            if (count($quiz->QuizAnswer) != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Question Not Found',
                    'errors' => [],
                ], 404);
            }
            $is_correct = $quiz->QuizAnswer[0]->QuestionV2->correct_answer == $answerId;

            $update = QuizAnswer::where(['id' => $quiz->QuizAnswer[0]->id, 'answer' => 0])->update([
                'answer' => $answerId,
                'is_correct' => $is_correct,
                'seconds' => $seconds,
                'status' => true,
                'end_datetime' => Carbon::now()
            ]);

            if (!$update) {
                return response()->json([
                    'success' => false,
                    'message' => 'Answer Not Found',
                    'errors' => [],
                ], 400);
            }

            return response()->json([
                'success' => true,
                'is_correct' => $is_correct,
                'message' => '',
                'errors' => [],
            ], 200);

        } catch (ModelNotFoundException  $e) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz Not Found',
                'errors' => [],
            ], 404);
        }
    }
    //------------------------------------------------>
    //------------------------------------------------>
}
