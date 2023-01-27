<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\ChangePasswordMail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\RequestChangePasswordRequest;

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

    public function requestChangePassword(RequestChangePasswordRequest $request)
    {
        $user = User::findOrFail($request->user_id);

        Mail::to($user->email)
            ->send(new ChangePasswordMail($user));

        return response()->json([
                        'message' => 'Email requesting password change sent.'
                    ], 200);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        
        $user = User::where('email', $data['email'])
                    ->where('uuid', $data['uuid'])
                    ->firstOrFail();
        $user->update($data);

        Auth::login($user);
        Session::regenerate();

        return response()->json([
                        'message' => 'Password reseted.'
                    ], 200);
    }
}
