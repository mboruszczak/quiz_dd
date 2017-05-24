<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Player extends Model
{
    public function getQuizs($user_id) 
    {
        $quizs_and_status = [];
        
        $quizs = DB::table('quizs')
                ->select('id', 'title' , 'teaser')
                ->get();
        
        $info = DB::table('user_quizs')
                ->select('quiz_id', 'status')
                ->where('user_id', $user_id)
                ->get();

        foreach($quizs as $quiz)
        {
            $quizs_and_status[$quiz->id] = [
                    'id' => $quiz->id,
                    'title' => $quiz->title,
                    'teaser' => $quiz->teaser,
                    'status' => '',
            ];
            
            foreach($info as $status)
            {
                if($status->quiz_id == $quiz->id)
                {
                    $quizs_and_status[$quiz->id]['status'] = $status->status;
                }
            }
        }
        
        return $quizs_and_status;
    }
}
