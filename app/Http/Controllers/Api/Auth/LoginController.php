<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

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
