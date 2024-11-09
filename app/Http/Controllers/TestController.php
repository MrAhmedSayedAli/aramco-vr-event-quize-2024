<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {


        $data = Quiz::with([
            'Player' => function ($q) {
                $q->select('id', 'name');
            },
            'QuizAnswer'
        ])->where('status',true)->orderBy('score', 'desc')->get()->unique('player_id');

        echo '<ul>';
        $i = 1;
        foreach ($data as $row){

            if($row->id > 131){
                echo '<li style="background-color: yellow">';
            }else{
                echo '<li>';
            }
                //continue;

            //echo '<li>';
            echo $i .' - '. $row->Player->name . ' - ';
//            echo $i .' - '. $row->Player->name . ' ( '. $row->created_at->format('Y-m-d-H:i:s') .' ) - ';
            $i++;


            $total = 0;
            $correct = 0;
            $correct_reward = 900000;//180000;
            $newTotal = 0;


            foreach ($row->QuizAnswer as $ans){
                //echo 'QN('.$ans->inc.') ';

                if (!$ans->is_correct) {
                    //echo '<span style="color:red;">(WRONG)</span> / ';
                    continue;
                }

                $interval = $ans->end_datetime->diff($ans->start_datetime);
                $totalMS = 0;
                $totalMS += $interval->m * 2630000000;
                $totalMS += $interval->d * 86400000;
                $totalMS += $interval->h * 3600000;
                $totalMS += $interval->i * 60000;
                $totalMS += $interval->s * 1000;
                //echo '<span style="color:green;">('.$totalMS.')</span> / ';
                $total += $totalMS;
                $correct++;
            }

            $lastAnd = $row->QuizAnswer[4];
            $newInterval = $lastAnd->end_datetime->diff($lastAnd->start_datetime);
            //$newInterval = $row->updated_at->diff($row->created_at);
            $newTotalMS = 0;
            $newTotalMS += $newInterval->m * 2630000000;
            $newTotalMS += $newInterval->d * 86400000;
            $newTotalMS += $newInterval->h * 3600000;
            $newTotalMS += $newInterval->i * 60000;
            $newTotalMS += $newInterval->s * 1000;


            //$total = $newTotal;
            echo '<span style="color:darkgoldenrod;">TOTAL:('.$newTotalMS.')</span> / ';

            if($total >= 890000){
                echo '<span style="color:red;">XTOTAL>890000:('.$total.')</span> / ';
                $total = 890000;
            }else{
                echo '<span style="color:blue;">XTOTAL:('.$total.')</span> / ';
            }


            echo ' <span style="color:blue;">CORRECT:('.$correct.')</span> / ';

            $score = (($correct * $correct_reward) - $total) / 1000;
            $newScore = (($correct * $correct_reward) - $newTotalMS) / 1000;

            //echo '(('.$correct.'*'.$correct_reward.')-'.$total.')/1000 = ';
            echo '<span style="color:red;">('.$score.')</span> ';


            echo '<span style="color:green;">('.$newScore.')</span> ';
            echo '<span style="color:#228798;">('.$score-$newScore.')</span> ';

            echo '</li>';


        }
        echo '</ul>';






       return '';

        $data = Quiz::select(['id', 'player_id', 'score', 'duration'])->with([
            'Player' => function ($q) {
                $q->select('id', 'name');
            },
            'QuizAnswer'
        ])->orderBy('score', 'desc')->where('status',true)->get()->unique('player_id');

        echo '<ul>';
        $i = 1;
        foreach ($data as $row){

            echo '<li>';
            echo $i .' - '. $row->Player->name . ' - ';
            $i++;
            $total = 0;
            $correct = 0;
            $correct_reward = 900000;//180000;

            foreach ($row->QuizAnswer as $ans){
                echo 'QN('.$ans->inc.') ';

                if (!$ans->is_correct) {
                    echo '<span style="color:red;">(WRONG)</span> / ';
                    continue;
                }

                $interval = $ans->end_datetime->diff($ans->start_datetime);
                $totalMS = 0;
                $totalMS += $interval->m * 2630000000;
                $totalMS += $interval->d * 86400000;
                $totalMS += $interval->h * 3600000;
                $totalMS += $interval->i * 60000;
                $totalMS += $interval->s * 1000;
                echo '<span style="color:green;">('.$totalMS.')</span> / ';
                $total += $totalMS;
                $correct++;
            }

            if($total >= 600000){
                echo '<span style="color:red;">TOTAL>600000:('.$total.')</span> / ';
                $total = 600000;
            }else{
                echo '<span style="color:blue;">TOTAL:('.$total.')</span> / ';
            }


            echo ' <span style="color:blue;">CORRECT:('.$correct.')</span> / ';

            $score = (($correct * $correct_reward) - $total) / 1000;

           echo '(('.$correct.'*'.$correct_reward.')-'.$total.')/1000 = ';
            echo '<span style="color:blue;">('.$score.')</span> ';

            echo '</li>';


        }
        echo '</ul>';


        return '';
    }
}
