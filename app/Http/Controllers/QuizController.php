<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use Auth;

class QuizController extends Controller
{

    
    public function __construct() {
        
        $this->middleware('auth');

    }
    
    /*
     * Display basic info about quiz
     */
    
    public function start($quiz_id) {
        
        $model = new Quiz();
        
        $quiz = $model->startQuiz($quiz_id);
        
        return view('quiz.start', compact('quiz'));
        
    }
    /*
     * Display Question and save answers
     */
    
    public function showQuest($quiz_id, $quest_id) {
        
        $model = new Quiz();

        if(request()->next) {
        // Save Answer/s or update if already exists
           
            $answer = serialize(request('answer'));
            $model->saveAnswers($quiz_id, $quest_id-1, $answer, Auth::id());
        
        }
        
        $quest = $model->getQuest($quiz_id, $quest_id);
        $answers = $model->getAnswers($quiz_id, $quest_id);
        
        if($quest_id <= $model->getLastQuest($quiz_id)) { //check if this is not a last question
            
            $next_quest = $quest_id+1;
            return view('quiz.main', compact('quest', 'answers', 'quiz_id', 'next_quest'));
            
        }
        else {
            //$next_quest = "finish/end";
            
            $score = $model->getScore($quiz_id, Auth::id());
            
            return view('quiz.summary', compact('score'));
            
        }
        
        
        
    }
    
    /*
     * Get the score after finish the quiz
     */
    public function endQuiz($quiz_id) {
        
        $model = new Quiz();
        
        $score = $model->getScore($quiz_id, Auth::id());
        
        return view('quiz.summary', compact('score'));
    }
}
