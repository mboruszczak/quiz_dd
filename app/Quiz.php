<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Quiz extends Model
{
    public function startQuiz($quiz_id) {
        
        $quiz = DB::table('quizs')->where('id',$quiz_id)->first();
        
        return $quiz;
        
    }
}
