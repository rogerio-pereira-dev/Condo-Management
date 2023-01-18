<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        Auth::user()
            ->update([
                'password' => bcrypt($request->new_password)
            ]);
        
        return response()->json([
            'message' => 'Password changed.'
        ], 200);
    }
}
