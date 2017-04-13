<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use Auth;

class QuizController extends Controller
{
    protected $user_id;
    
    public function __construct() {
        
        $this->middleware('auth');
        $this->user_id = Auth::id();
        
    }
    
    public function start($quiz_id) {
        
        $model = new Quiz();
        
        $quiz = $model->startQuiz($quiz_id);
        
        return view('quiz.start', compact('quiz'));
        
    }
    
    public function showQuest($quiz_id, $quest_id) {
        
        $model = new Quiz();
        
        if(request()->next) {
            
        
        }
        
        $quest = $model->getQuest($quiz_id, $quest_id);
        $answers = $model->getAnswers($quiz_id, $quest_id);
        $next_quest = $quest_id+1;
        
        return view('quiz.main', compact('quest', 'answers', 'quiz_id', 'next_quest'));
        
    }
}
