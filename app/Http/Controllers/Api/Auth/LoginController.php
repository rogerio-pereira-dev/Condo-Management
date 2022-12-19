<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {            
            return response()->json([
                'message' => 'Login successfull'
            ], 200);
        }

        return response()->json([
            'errors' => [
                'email' => ['Invalid credentials']
            ],
            'message' => 'Invalid credentials'
        ], 403);
    }
}
