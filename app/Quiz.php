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
        
        $answers = DB::table('answers')
                ->where('question_id',$quest_id)
                ->where('quiz_id', $quiz_id)
                ->get();
                
        return $answers;
    }
    
    public function getLastQuest($quiz_id) {
        $last_quest_id = DB::table('questions')
                ->select('id')
                ->where('quiz_id', $quiz_id)
                ->orderBy('id', 'desc')
                ->first();
        
        return $last_quest_id->id;
    }
    
    public function saveAnswers($quiz_id, $quest_id, $answer, $user_id) {
        
        $find_answer = DB::table('users_score')
                ->where('quiz_id', $quiz_id)
                ->where('question_id', $quest_id)
                ->where('user_id', $user_id)
                ->first();
        
        if($find_answer) {
            // update existsing answer
            DB::table('users_score')
                ->where('quiz_id', $quiz_id)
                ->where('question_id', $quest_id)
                ->where('user_id', $user_id)
                ->update(['answer' => $answer]);        
        }
        else {
            // add new answer
            DB::table('users_score')->insert([
                'quiz_id' => $quiz_id,
                'question_id' => $quest_id,
                'answer' => $answer,
                'user_id' => $user_id,
            ]);
        }
        
    }
    
    public function getScore($quiz_id, $user_id) {
        // Summary of the quiz
    }
}
