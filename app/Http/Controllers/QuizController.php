<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAnswer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class QuizController extends Controller
{
    public function index(Request $request, $uuid, $id = 0)
    {

        try {
            $quiz = Quiz::where('uuid', $uuid)->with(['QuizAnswer'])->firstOrFail();
            return view('quiz.finish', compact('quiz'));
        } catch (ModelNotFoundException  $e) {
            abort(404);
        }


    }

    //------------------------------------------------>
    public function step(Request $request, $uuid, $step)
    {
        try {
            $quiz = Quiz::where('uuid', $uuid)->with([
                'QuizAnswer' => function ($query) use ($step) {
                    $query->where('inc', $step)->with(['Question']);
                }
            ])->firstOrFail();

            if (count($quiz->QuizAnswer) != 1) {
                abort(404);
            }

            //TODO::FIX
            if ($quiz->QuizAnswer[0]->status) {
                if ($quiz->QuizAnswer[0]->inc == 5)
                    return redirect()->route('quiz.index', $uuid);

                return redirect()->route('quiz.step', [$uuid, ($quiz->QuizAnswer[0]->inc + 1)]);
            }

            if (!$quiz->QuizAnswer[0]->is_started) {
                $now = Carbon::now();
                QuizAnswer::where(['id' => $quiz->QuizAnswer[0]->id])->update(['start_datetime' => $now, 'is_started' => true]);
                $quiz->QuizAnswer[0]->start_datetime = $now;
            }

            //dd($quiz->QuizAnswer[0]->is_started);
            return view('quiz.form', ['quiz' => $quiz, 'answer' => $quiz->QuizAnswer[0]]);
        } catch (ModelNotFoundException  $e) {
            abort(404);
        }
    }

    //------------------------------------------------>
    public function stepSave(Request $request, $uuid, $step)
    {
        try {
            $quiz = Quiz::where('uuid', $uuid)->with([
                'QuizAnswer' => function ($query) use ($step) {
                    $query->where('inc', $step)->with(['Question']);
                }
            ])->firstOrFail();

            if (count($quiz->QuizAnswer) != 1) {
                abort(404);
            }


            $is_correct = $quiz->QuizAnswer[0]->Question->correct_answer == $request->get('answer', 9);

            QuizAnswer::where(['id' => $quiz->QuizAnswer[0]->id, 'answer' => 0])->update([
                'answer' => $request->get('answer', 9),
                'is_correct' => $is_correct,
                'status' => true,
                'end_datetime' => Carbon::now()
            ]);

            if ($quiz->QuizAnswer[0]->inc > 0 && $quiz->QuizAnswer[0]->inc < 5) {
                return redirect()->route('quiz.step', [$uuid, ($quiz->QuizAnswer[0]->inc + 1)]);
            } elseif ($quiz->QuizAnswer[0]->inc == 5) {


                //CALC
                $quizNew = Quiz::findOrFail($quiz->id);
                $total = 0;
                $correct = 0;
                $correct_reward = 900000;//180000;

                foreach ($quizNew->QuizAnswer as $ans) {
                    if (!$ans->is_correct)
                        continue;

                    $interval = $ans->end_datetime->diff($ans->start_datetime);
                    $totalMS = 0;
                    $totalMS += $interval->m * 2630000000;
                    $totalMS += $interval->d * 86400000;
                    $totalMS += $interval->h * 3600000;
                    $totalMS += $interval->i * 60000;
                    $totalMS += $interval->s * 1000;

                    $total += $totalMS;
                    $correct++;
                }

                if($total >= 890000){
                    $total = 890000;
                }

                $score = (($correct * $correct_reward) - $total) / 1000;

                if($score < 0){
                    $score = 0;
                }
                //CALC

                $quizNew->score = $score;
                $quizNew->status = true;
                $quizNew->duration = $total;
                $quizNew->save();
                //dd('done');
                return redirect()->route('quiz.index', $uuid);

            } else {
                return redirect()->route('quiz.index', $uuid);
            }


        } catch (ModelNotFoundException  $e) {
            abort(404);
        }
    }

    //------------------------------------------------>
    public function templateLoader()
    {
        abort(404);
    }

    //------------------------------------------------>
    public function templateLoaderId(Request $request, $id = null)
    {


        if(in_array(intval($id),[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25])){
            try {
                return view('templates.v' . $id);
            }catch (\Exception $e){
                abort(404);
            }

        }
        abort(404);
        /*
        switch ($id) {
            case 'v1':
                return view('templates.v1');
            case 'v2':
                return view('templates.v2');
            case 'v3':
                return view('templates.v3');
            case 'v4':
                return view('templates.v4');
            case 'v5':
                return view('templates.v5');

            default:
                abort(404);
        }
        */
    }


    //------------------------------------------------>
}
