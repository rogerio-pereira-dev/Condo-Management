<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) { 
            Session::regenerate();

            $user = Auth::user();

            return response()->json([
                    'message' => 'Login successfull',
                    'user' => new UserResource($user),
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
