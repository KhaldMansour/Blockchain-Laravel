<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function getProfile()
    {
        return view('auth.profile' , ['user' => auth()->user()] );
    }
}
