<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Quiz extends Model
{
    
    public $user_answers_array = [];
    public $matrix_answers_array = [];
    
    public function startQuiz($quiz_id) 
    {
        $quiz = DB::table('quizs')
                ->where('id',$quiz_id)
                ->first();
        
        return $quiz;
        
    }
    
    public function getQuest($quiz_id, $quest_id) 
    {
        $question = DB::table('questions')
                ->where('id',$quest_id)
                ->where('quiz_id', $quiz_id)
                ->first();
        
        return $question;
        
    }
    
    public function getAnswers($quiz_id, $quest_id) 
    {
        $answers = DB::table('answers')
                ->where('question_id',$quest_id)
                ->where('quiz_id', $quiz_id)
                ->get();
                
        return $answers;
    }
    
    public function getLastQuest($quiz_id) 
    {
        $last_quest_id = DB::table('questions')
                ->select('id')
                ->where('quiz_id', $quiz_id)
                ->orderBy('id', 'desc')
                ->first();
        
        return $last_quest_id->id;
    }
    
    public function saveAnswers($quiz_id, $quest_id, $answer, $user_id) 
    {
        $find_answer = DB::table('users_score')
                ->where('quiz_id', $quiz_id)
                ->where('question_id', $quest_id)
                ->where('user_id', $user_id)
                ->first();
        
        if(!$find_answer) 
        {
            // add new answer
            DB::table('users_score')->insert([
                'quiz_id' => $quiz_id,
                'question_id' => $quest_id,
                'answer' => $answer,
                'user_id' => $user_id,
            ]);
        }
        else 
        {
             // update existsing answer
            DB::table('users_score')
                ->where('quiz_id', $quiz_id)
                ->where('question_id', $quest_id)
                ->where('user_id', $user_id)
                ->update(['answer' => $answer]);    
        }
        
    }
    
    public function getUserAnswers($user_id, $quiz_id) 
    {
       $user_answers = DB::table('users_score')
                ->select('question_id', 'answer')
                ->where('user_id', $user_id)
                ->where('quiz_id', $quiz_id)
                ->orderBy('question_id', 'asc')
                ->get();
        
        foreach($user_answers as $user_answer) 
        {
            $temp = unserialize($user_answer->answer);
            $this->user_answers_array[$user_answer->question_id] = $temp;
        }
        
    }
    
    public function getQuizPoints($quiz_id) 
    {
        $treshold = DB::table('quizs')
                ->select('treshold')
                ->where('id', $quiz_id)
                ->first();
        
        $count_points = DB::table('answers')
                ->select(DB::raw('count(*) as max_points'))
                ->where('quiz_id', $quiz_id)
                ->where('correct', 1)
                ->first();
        
        return ['treshold' => $treshold->treshold, 'max_points' => $count_points->max_points];
    }
    
    public function getQuizKey($quiz_id) 
    {
        $i = 0;
        $temp = [];
        $answers_matrix = DB::table('answers')
                ->select('question_id', 'id')
                ->where('quiz_id', $quiz_id)
                ->where('correct', 1)
                ->orderBy('question_id', 'asc')
                ->get();
        
        foreach($answers_matrix as $correct_answer) 
        {
            $current_quest_id = $correct_answer->question_id;
            
            foreach($answers_matrix as $ca) 
            {
                if($current_quest_id == $ca->question_id) 
                {
                    $temp[$i] = $ca->id;
                    $i++;
                }
            }
            
            $this->matrix_answers_array[$correct_answer->question_id] = $temp;
            $i=0;
        }
    }
    
    public function checkAnswers() 
    {
        $user_points = 0;
        foreach($this->matrix_answers_array as $maa_key=>$maa_value) //@mma_key = question_id, @mma_value = array of answers
        {
            foreach($this->user_answers_array[$maa_key] as $user_answer)
            {
                if(in_array($user_answer, $maa_value))
                {
                    $user_points++;
                }
                else
                {
                    $user_points--;
                }
            }
        }
        
        if($user_points < 0 )
        {
            $user_points = 0;
        }
        
        return $user_points;
    }
    
    // Summary of the quiz
    public function getScore($quiz_id, $user_id) 
    {
        $this->getUserAnswers($user_id, $quiz_id);
        $points = $this->getQuizPoints($quiz_id);
        $this->getQuizKey($quiz_id);
        $user_points = $this->checkAnswers();
        
        $score = ($user_points / $points['max_points'])*100;
        if($score < $points['treshold'])
        {
            $status = 0;
        }
        else
        {
            $status = 1;
        }
        
        $this->setQuziStatus($quiz_id, $user_id, $status, $score);
        
        return ['score' => $score, 'status' => $status];
    }
    
    public function setQuziStatus($quiz_id, $user_id, $status, $score)
    {
        $find_status = DB::table('user_quizs')
                ->where('quiz_id', $quiz_id)
                ->where('user_id', $user_id)
                ->first();
        
        if(!$find_status)
        {
            DB::table('user_quizs')->insert([
                'quiz_id' => $quiz_id,
                'user_id' => $user_id,
                'status'  => $status,
                'score'   => $score
            ]);
        }
        else
        {
            DB::table('user_quizs')
                    ->where('quiz_id', $quiz_id)
                    ->where('user_id', $user_id)
                    ->update([
                        'status'=> $status,
                        'score' => $score
                    ]);
        }
    }
    
}
