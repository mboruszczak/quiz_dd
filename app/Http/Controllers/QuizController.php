<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use Auth;
use Symfony\Component\HttpFoundation\Cookie;

class QuizController extends Controller
{

    
    public function __construct() {
        
        $this->middleware('auth');

    }
    
    /*
     * Display basic info about quiz
     */
    
    public function start($quiz_id) 
    {
        $model = new Quiz();
        
        $quiz = $model->startQuiz($quiz_id);
        
        return view('quiz.start', compact('quiz'));
    }
    
    
    /*
     * Display Question and save answers
     */
    public function showQuest(Request $request) 
    {
        $model = new Quiz();
        
        if($request->tq && $request->cq)
        {
            $quiz_id = $request->tq;
            $quest_id = $request->cq;
            $request->session()->put('quiz_id', $quiz_id);
            $request->session()->put('quest_id', $quest_id);
        }
        else
        {
            $quiz_id = $request->session()->get('quiz_id');
            $quest_id = $request->session()->get('quest_id');
        }

        if($request->prev) {$quest_id -= 2;}
        
        if($request->next && $quest_id > 1 && $request->answer) 
        {
        // Save Answer/s or update if already exists
            $answer = serialize(request('answer'));
            $model->saveAnswers($quiz_id,$quest_id-1, $answer, Auth::id());
        }
        
        $quest = $model->getQuest($quiz_id, $quest_id);
        $answers = $model->getAnswers($quiz_id, $quest_id);
        
        if($quest_id <= $model->getLastQuest($quiz_id)) 
        { //check if this is not a last question
            $next_quest = $quest_id+1;
            return view('quiz.main', compact('quest', 'answers', 'quiz_id', 'next_quest'));
        }
        else 
        {
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
