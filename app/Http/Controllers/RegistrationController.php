<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;


class RegistrationController extends Controller
{
    public function Index()
    {
        return view('static.registration');
    }

    public function ResendingVerificationPage()
    {
        return view('static.verify-email');
    }

    public function ResendLink(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'min:5', 'max:100', 'email']
        ],
        [
            'email.unique' => 'A user with this email is already registered.',
            'email.required' => 'The email field cannot be empty.',
            'email.email' => 'The email field must be a valid email address.',
            'email.min' => 'The email field must be at least 5 characters.'
        ]);

        $user = User::where('email', strtolower(trim(strip_tags($validated['email']))))->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email.'
            ], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already verified.'
            ]);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'success' => true,
            'message' => 'Verification link sent! Please check your email.',
            'redirect' => route('home')
        ]);

    }

    public function registrationAjax(Request $request)
    {

       $validated = $request->validate([
            'Name' => ['required', 'min:2', 'max:30'],
            'email' => ['required', 'min:5', 'max:100', 'email', 'unique:users,email'],
            'password' => ['required', Password::min(5)
            ->letters()
            ->numbers()
            ->mixedCase(), 'confirmed']
        ],
        [
            'email.unique' => 'A user with this email is already registered.',
            'email.required' => 'The email field cannot be empty.',
            'email.email' => 'The email field must be a valid email address.',
            'email.min' => 'The email field must be at least 5 characters.',
            'password.required' => 'The password field cannot be empty.',
            'password.min' => 'The password field must be at least 5 characters.',
            'password.confirmed' => 'The password field confirmation does not match.',
        ]);

        try {

            $user = User::create([
                'name' => trim(strip_tags($validated['Name'])), 
                'email' => strtolower(trim(strip_tags($validated['email']))),
                'password' => Hash::make($validated['password'])
            ]);

            $user->sendEmailVerificationNotification();

            return response()->json(['success' => true, 'message' => 'Registration successful. Please check your email to verify your account.',
            'redirect' => route('home')]);

        } catch (QueryException $e) {

            
            if ($e->getCode() === '23000') {
                return response()->json(['success' => false, 'message' => 'A user with this email is already registered.'], 422);
            }

           
            return response()->json([
                'success' => false,
                'message' => 'Database error'
            ], 500);
        }


        
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        
        $user = User::findOrFail($id);

       
        if (!URL::hasValidSignature($request)) {
            abort(403, 'Invalid or expired verification link.');
        }

       
        if (! hash_equals((string) $hash, sha1($user->email))) {
            abort(403, 'Invalid verification hash.');
        }

        
        $user->markEmailAsVerified();

        
        return redirect('/')->with('message', 'Email verified!');
    }

    public function RedirectLogin()
    {
        return redirect('/');
    }

    
}
