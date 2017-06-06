<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $admin = new Admin();
        
        if($admin->isAdmin(Auth::id())) {
            
            $quiz_list = $admin->getQuizList();
            
            return view('admin.dashboard', compact('quiz_list'));
        }
        else{
            return redirect()->action('HomeController@index');
        }
    }
    
    public function addQuiz(Request $request) 
    {
        $admin = new Admin();
        
        if($admin->isAdmin(Auth::id())) {
            
            $action = "";
            
            if($request->add) {
               $action = $admin->addQuiz($request->title, $request->teaser, $request->treshold);
            }
            
            return view('admin.add', compact('action'));
        }
        else{
            return redirect()->action('HomeController@index');
        }
    }
    
    public function editQuiz($id, Request $request)
    {
        $admin = new Admin();
        
        if($admin->isAdmin(Auth::id())) {
            
            $status = "";
            
            if($request->edit) {
                $status = $admin->editQuiz($id, $request->title, $request->teaser, $request->treshold);
            }
            
            $quiz = $admin->getSingleQuiz($id);
            $questions = $admin->getQuestionsList($id);
            
            return view('admin.edit', compact('quiz', 'status', 'questions'));
        }
        else {
            return redirect()->action('HomeController@index');
        }
    }
}
