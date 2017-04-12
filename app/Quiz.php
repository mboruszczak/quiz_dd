<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Quiz extends Model
{
    public function startQuiz($quiz_id) {
        
        $quiz = DB::table('quizs')
                ->where('id',$quiz_id)
                ->first();
        
        return $quiz;
        
    }
    
    public function getQuest($quiz_id, $quest_id) {
        
        $question = DB::table('questions')
                ->where('id',$quest_id)
                ->where('quiz_id', $quiz_id)
                ->first();
        
        return $question;
        
    }
    
    public function getAnswers($quiz_id, $quest_id) {
        
        $answer = DB::table('answers')
                ->where('question_id',$quest_id)
                ->where('quiz_id', $quiz_id)
                ->get();
                
        return $answer;
    }
    
}
