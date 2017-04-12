<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;

class QuizController extends Controller
{
    public function __construct() {
        
        $this->middleware('auth');
        
    }
    
    public function index($quiz_id) {
        $model = new Quiz();
        
        $quiz = $model->startQuiz($quiz_id);
        
        return view('quiz.index', compact('quiz'));
    }
}
