<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as PasswordBroker;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    public function Index()
    {
        return view('static.home');
    }

    public function Password_Request()
    {
        return view('static.password-request');
    }

    public function Dashboard()
    {
        return view('static.dashboard');
    }

    public function showResetForm(string $token, Request $request)
    {
        return view('static.reset-password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function loginAjax(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'min:5', 'max:100', 'email'],
            'password' => ['required']
        ],
        [
            'email.required' => 'The email field cannot be empty.',
            'email.email' => 'The email field must be a valid email address.',
            'email.min' => 'The email field must be at least 5 characters.',
            'password.required' => 'The password field cannot be empty.',
        ]);

        $email = strtolower(trim(strip_tags($validated['email'])));
        $password = trim($validated['password']);

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 404);
        }

       

        $user = Auth::user();

        if (!$user->hasVerifiedEmail()) {

            Auth::logout();

            return response()->json([
                'success' => false,
                'message' => 'Please confirm your email address before logging in. <a href="'.route('verification.notice').'">On this page</a>',
            ], 404);
        }

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'redirect' => route('dashboard'),
        ]);




    }


    public function RecoveryPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'min:5', 'max:100', 'email']
        ],
        [
            'email.required' => 'The email field cannot be empty.',
            'email.email' => 'The email field must be a valid email address.',
            'email.min' => 'The email field must be at least 5 characters.'
        ]);

        $email = strtolower(trim(strip_tags($validated['email'])));

        $user = User::where('email', $email)->first();

        if (! $user) 
        {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email.'
            ], 404);
        }

        $status = PasswordBroker::sendResetLink(['email' => $email]);

        if ($status === PasswordBroker::RESET_LINK_SENT) 
        {
            return response()->json([
                'success' => true,
                'message' => 'Password recovery link has been sent to your email.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unable to send recovery email.'
        ], 500);

    }

    public function ResetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', PasswordRule::min(5)
            ->letters()
            ->numbers()
            ->mixedCase(), 'confirmed']
        ],
        [
            'email.required' => 'The email field cannot be empty.',
            'email.email' => 'The email field must be a valid email address.',
            'password.required' => 'The password field cannot be empty.',
            'password.min' => 'The password field must be at least 5 characters.',
            'password.confirmed' => 'The password field confirmation does not match.',
        ]);

        $status = PasswordBroker::reset($request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === PasswordBroker::PASSWORD_RESET) {
            return response()->json([
                'success' => true,
                'message' => 'Password has been reset successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired reset token.'
        ], 400);
    }

    public function logout(Request $request)
    {
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
            'redirect' => route('home') 
        ]);
    }
    
}
