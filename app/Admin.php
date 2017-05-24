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
    
}
