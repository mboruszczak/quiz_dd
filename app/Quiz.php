<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Quiz extends Model
{
    
    public $user_answers_array = [];
    public $matrix_answers_array = [];
    
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
        
        if(!$find_answer) {
            // add new answer
            DB::table('users_score')->insert([
                'quiz_id' => $quiz_id,
                'question_id' => $quest_id,
                'answer' => $answer,
                'user_id' => $user_id,
            ]);
        }
        else {
             // update existsing answer
            DB::table('users_score')
                ->where('quiz_id', $quiz_id)
                ->where('question_id', $quest_id)
                ->where('user_id', $user_id)
                ->update(['answer' => $answer]);    
        }
        
    }
    
    public function getScore($quiz_id, $user_id) {
        // Summary of the quiz
        $user_answers = DB::table('users_score')
                ->select('question_id', 'answer')
                ->where('user_id', $user_id)
                ->where('quiz_id', $quiz_id)
                ->orderBy('question_id', 'asc')
                ->get();
        
        foreach($user_answers as $user_answer) {
            $temp = unserialize($user_answer->answer);
            $this->user_answers_array[$user_answer->question_id] = $temp;
        }
        
        
        $treshold = DB::table('quizs')
                ->select('treshold')
                ->where('id', $quiz_id)
                ->first();
        
        $count_points = DB::table('answers')
                ->select(DB::raw('count(*) as max_points'))
                ->where('quiz_id', $quiz_id)
                ->where('correct', 1)
                ->first();
        
        $answers_matrix = DB::table('answers')
                ->select('question_id', 'id')
                ->where('quiz_id', $quiz_id)
                ->where('correct', 1)
                ->orderBy('question_id', 'asc')
                ->get();
        
        $max_points = $count_points->max_points;
       
        
        
        
        
        
        $first_lap = true;
        $temp_id = 0;
        $temp2 = [];
        $i = 0;
        
        foreach($answers_matrix as $correct_answer) {
            
            if($correct_answer->question_id == $temp_id || $first_lap === true) {
                $temp2[$i] = $correct_answer->id;
                var_dump($temp2);
                $i+=1;
            }
            else {
                $this->matrix_answers_array[$correct_answer->question_id] = $temp2;
                $i = 0;
                //clear temp2 array

            }
            
            $temp_id = $correct_answer->question_id;
            $first_lap= false;
        }
        
        // var_dump($this->matrix_answers_array);

        
        exit();
    }
}
