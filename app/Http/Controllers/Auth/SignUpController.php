<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignUpVerification;

class SignUpController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/SignUp');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'accept_terms' => 'required|accepted',
        ]);

        // Create a temporary token
        $token = Str::random(64);

        // Store the signup data in cache for 24 hours
        cache()->put("signup_{$token}", [
            'full_name' => $request->full_name,
            'email' => $request->email,
        ], now()->addHours(24));

        // Generate signed URL for email verification
        $verificationUrl = URL::temporarySignedRoute(
            'signup.verify',
            now()->addHours(24),
            ['token' => $token]
        );

        // Send verification email
        Mail::to($request->email)->send(new SignUpVerification($verificationUrl));

        return back()->with('status', 'verification-link-sent');
    }

    public function verify(Request $request, $token)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $signupData = cache()->get("signup_{$token}");
        
        if (!$signupData) {
            abort(404);
        }

        return Inertia::render('Auth/CompleteSignUp', [
            'email' => $signupData['email'],
            'token' => $token,
        ]);
    }

    public function complete(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string',
        ]);

        $signupData = cache()->get("signup_{$request->token}");
        
        if (!$signupData) {
            abort(404);
        }

        $user = User::create([
            'name' => $signupData['full_name'],
            'username' => $request->username,
            'email' => $signupData['email'],
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        auth()->login($user);

        cache()->forget("signup_{$request->token}");

        return redirect()->route('dashboard');
    }
} 