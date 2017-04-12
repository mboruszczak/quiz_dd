<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Player extends Model
{
    public function getQuizs() {
        $quizs = DB::table('quizs')->get();
        
        return $quizs;
    }
}
