<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Log;

class LogInController extends Controller
{
    public function createRegister()
    {
        return view('auth.register');
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_by' => auth()->id(),
        ]);

        event(new Registered($user));

        Log::info('User registered', ['user_id' => $user->id, 'created_by' => auth()->id()]);

        return redirect()->route('users.index')->with('success', 'User registered successfully.');
    }

    public function create()
    {
        Log::info('Login form accessed', ['intended' => session()->get('url.intended')]);
        session()->forget('url.intended');
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            Log::info('Login successful', [
                'user_id' => Auth::id(),
                'email_verified' => Auth::user()->hasVerifiedEmail(),
                'intended' => $request->session()->get('url.intended'),
            ]);

            if (Auth::user()->hasVerifiedEmail()) {
                return redirect()->intended('/dashboard');
            }

            return redirect()->route('verification.notice');
        }

        Log::info('Login failed', ['email' => $request->email]);
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function createForgotPassword()
    {
        Log::info('Forgot password form accessed');
        return view('auth.forgot-password');
    }

    public function storeForgotPassword(Request $request)
    {
        Log::info('Forgot password request', ['email' => $request->email]);
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        Log::info('Forgot password status', ['status' => $status]);

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function createResetPassword($token)
    {
        Log::info('Reset password form accessed', ['token' => $token]);
        return view('auth.reset-password', ['token' => $token]);
    }

    public function storeResetPassword(Request $request)
    {
        Log::info('Reset password attempt', ['email' => $request->email]);
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        Log::info('Reset password status', ['status' => $status]);

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function showVerificationPrompt()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('verification.notice')->withErrors(['error' => 'Invalid verification link.']);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended('/dashboard')->with('status', 'Email verified successfully.');
    }

    public function sendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Verification link sent!');
    }

    public function showConfirmPassword()
    {
        return view('auth.confirm-password');
    }

    public function storeConfirmPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended('/dashboard');
    }
}
