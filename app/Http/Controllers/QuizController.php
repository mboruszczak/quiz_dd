<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;

class QuizController extends Controller
{
    public function __construct() {
        
        $this->middleware('auth');
        
    }
    
    public function start($quiz_id) {
        
        $model = new Quiz();
        
        $quiz = $model->startQuiz($quiz_id);
        
        return view('quiz.start', compact('quiz'));
        
    }
    
    public function showQuest($quiz_id, $quest_id) {
        
        $model = new Quiz();
        
        $quest = $model->getQuest($quiz_id, $quest_id);
        $answers = $model->getAnswers($quiz_id, $quest_id);
        
        return view('quiz.main', compact('quest', 'answers'));
        
    }
}
