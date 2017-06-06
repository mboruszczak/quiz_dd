<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    
    public function isAdmin($user_id)
    {
        $user_admin = $user_id.'-admin';
        
        if(request()->session()->exists($user_admin))
        {
            $permision = request()->session()->get($user_admin);
        }
        else
        {
            $rights = DB::table('users')
                ->select('admin')
                ->where('id', $user_id)
                ->first();
            
            $permision = $rights->admin;
            
            request()->session()->put($user_admin, $permision);
        }
        
        return $permision;
    }
    
    public function getQuizList() 
    {
       $quiz_list = DB::table('quizs')
                ->select('id', 'title', 'teaser')
                ->simplePaginate(9);
       
       return $quiz_list;
    }
    
    public function checkByTitle($title)
    {
        $quiz = DB::table('quizs')
                ->where('title', $title)
                ->count();
        
        return $quiz;
    }
    
    public function addQuiz($title, $teaser, $treshold)
    {
        if($this->checkByTitle($title) == 0) {
            $add_quiz = DB::table('quizs')->insertGetId([
                'title' => $title,
                'teaser' => $teaser,
                'num_of_questions' => 0,
                'treshold' => $treshold,
            ]);
        }
        else {
            $add_quiz = 0;
        }
        
        return $add_quiz;
    }
    
    public function getSingleQuiz($id)
    {
        $quiz = DB::table('quizs')
                ->where('id', $id)
                ->first();
    
        return $quiz;
    }
    
    public function editQuiz($id, $title, $teaser, $treshold)
    {
        DB::table('quizs')
                ->where('id', $id)
                ->update([
                    'title'     =>  $title,
                    'teaser'    =>  $teaser,
                    'treshold'  =>  $treshold
                ]);
        
        return true;
    }
    
    public function getQuestionsList($quiz_id)
    {
        $questions_list = DB::table('questions')
                ->select('id', 'question')
                ->where('quiz_id', $quiz_id)
                ->get();
        
        return $questions_list;
                
    }
    
}


