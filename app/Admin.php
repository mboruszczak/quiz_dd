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
    
    public function addQuestion($data, $quiz_id)
    {
        $answers = [];
        
        $question_id = DB::table('questions')->insertGetId([
            'question'  =>  $data->quest,
            'quiz_id'   =>  $quiz_id,
            'type'      =>  $data->quest_type
        ]);
        
        foreach($data->answers as $k=>$v) {
            
            if($data->answers[$k] != '') {
                $answers[$k]['answer'] = $v;
            }

            if(isset($data->correct[$k]) && $data->answers[$k] != '') {
                $answers[$k]['correct'] = 1;
            }
            elseif(!isset($data->correct[$k]) && $data->answers[$k] != '') {
                $answers[$k]['correct'] = 0;
            }
        }
        
        foreach($answers as $answer) {
            DB::table('answers')->insert([
                'answer'        =>  $answer['answer'],
                'quiz_id'       => $quiz_id,
                'question_id'   =>  $question_id,
                'correct'       =>  $answer['correct']
            ]);
        }
                    
        return 2;
    }
    
    public function getSingleQuest($quest_id) 
    {
        $question = DB::table('questions')
                ->where('id', $quest_id)
                ->first();
        
        if($question->type == 1) {
            $type_1 = 'checked';
            $type_2 = '';
        }
        else {
            $type_1 = '';
            $type_2 = 'checked';
        }
        
        $raw_answers = DB::table('answers')
                ->where('question_id', $quest_id)
                ->orderBy('id', 'asc')
                ->get();
        
        $answers = $this->cookAnswers($raw_answers);

        return [
            'question'          =>  $question->question,
            'question_type_1'   =>  $type_1,
            'question_type_2'   =>  $type_2,
            'answer_1'          =>  $answers[0],
            'answer_2'          =>  $answers[1],
            'answer_3'          =>  $answers[2],
            'answer_4'          =>  $answers[3],
            ];
    }
    
    public function cookAnswers($raw_answers)
    {
        $cooked_answers= [];
        
        for($i = 0; $i < 4; $i++) {
            if(isset($raw_answers[$i])) {
                $cooked_answers[$i]['answer'] = $raw_answers[$i]->answer;
            }
            else {
                $cooked_answers[$i]['answer'] = '';
            }
            
            if(isset($raw_answers[$i]) && $raw_answers[$i]->correct == 1) {
                $cooked_answers[$i]['correct'] = 'checked';
            }
            else {
                $cooked_answers[$i]['correct'] = '';
            }
        }

        return $cooked_answers;
    }
    
    public function editQuest($quiz_id, $quest_id, $data) 
    {
        DB::table('questions')
                ->where('id', $quest_id)
                ->update([
                    'question'  =>  $data->quest,
                    'type'      =>  $data->quest_type
                ]);
       
        $prev_answers = DB::table('answers')
                ->select('id', 'answer', 'correct')
                ->where('question_id', $quest_id)
                ->orderBy('id', 'asc')
                ->get();
        
        
        for($i = 0; $i < 4; $i++) {
            if(isset($prev_answers[$i]) && $data->answers[$i] != '') { // Update answer
                DB::table('answers')
                        ->where('id', $prev_answers[$i]->id)
                        ->update([
                            'answer'    =>  $data->answers[$i],
                            'correct'   =>  $this->cacthCorrectAnswer($data->correct, $i)
                        ]);
            }
            elseif(isset($prev_answers[$i]) && $data->answers[$i] == '') { // Delete answer if new is empty
                DB::table('answer')
                        ->where('id', $prev_answers[$i]->id)
                        ->delete();
            }
            elseif(!isset($prev_answers[$i]) && $data->answers[$i] != '') { // Add new answer
                DB::table('answer')->insert([
                    'answer'            =>  $data->answers[$i],
                    'quiz_id'           =>  $quiz_id,
                    'question_id'       =>  $quest_id,
                    'correct'           =>  $this->cacthCorrectAnswer($data->correct, $i),
                ]);
            }
        }
        return true;
    }
    
    public function cacthCorrectAnswer($data_array, $index)
    {
        if(in_array($index, $data_array)) {
            $correct = 1;
        }
        else {
            $correct = 0;
        }
        
        //var_dump($a);
        return $correct;
    }
}


