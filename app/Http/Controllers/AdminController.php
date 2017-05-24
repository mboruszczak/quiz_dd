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
        
        if($admin->isAdmin(Auth::id()))
        {
            return view('admin.dashboard');
        }
        else
        {
            return redirect()->action('HomeController@index');
        }
        
    }
}
