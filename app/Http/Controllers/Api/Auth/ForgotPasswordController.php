<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // public function sendResetLink(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email'
    //     ]);

    //     $status = Password::sendResetLink($request->only('email'));

    //     if ($status === Password::RESET_LINK_SENT) {
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Reset link sent to your email'
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Unable to send reset link'
    //     ], 400);
    // }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // find user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        // generate token manually
        $token = \Illuminate\Support\Str::random(64);

        // save token to password_resets table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => bcrypt($token),
                'created_at' => now()
            ]
        );

        // optionally send email notification
        $user->sendPasswordResetNotification($token);

        // return token in API response for testing
        return response()->json([
            'status' => true,
            'message' => 'Reset token generated',
            'token' => $token,
            'email' => $user->email
        ]);
    }
}
