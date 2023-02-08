<?php

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth/ChangePassword');
    }

    public function reset($uuid)
    {
        if(Auth::user()) {
            Auth::logout();

            return to_route('reset-password', [$uuid]);    //Required to avoid user seeing the
        }

        return Inertia::render('Auth/ResetPassword', ['uuid' => $uuid]);
    }
}
