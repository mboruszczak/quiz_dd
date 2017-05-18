<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Player extends Model
{
    public function getQuizs($user_id) {

        $quizs = DB::table('quizs')
                ->leftJoin('user_quizs', 'quizs.id', '=', 'user_quizs.quiz_id')
                ->select('quizs.id as id', 'quizs.title as title', 'quizs.teaser as teaser', 'user_quizs.status as status')
                ->whereNull('user_quizs.status')
                ->orWhere('user_quizs.user_id', $user_id)
                ->get();
        
        return $quizs;
    }
}
