<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //testestest
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // This will be player panel
        $quizs = new Player();
        $quiz_list = $quizs->getQuizs();
        
        return view('home', compact('quiz_list'));
    }
}
