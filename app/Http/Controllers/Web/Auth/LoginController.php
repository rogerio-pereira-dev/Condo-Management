<?php

namespace App\Http\Controllers\Web\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if(!Auth::guest())
            return to_route('home');

        return Inertia::render('Auth/Login');
    }
}
