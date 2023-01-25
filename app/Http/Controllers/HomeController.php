<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::guest())
            return to_route('login');
            
        return Inertia::render('Dashboard/Dashboard');
    }
}
