<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class AuthController extends Controller
{
    public function login(){
        return view("auth.login");
    }
    public function home(){
        return view("customer.home");
    }
    public function register(){
        return view("auth.register");
    }
    public function loginPost(Request $request) {
        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);
        $credentials = $request->only("email", "password");
        // Check database credentials first
        if(Auth::attempt($credentials)){
            return redirect()->intended(route ("home"));
        }
        // If database login fails, check hardcoded credentials
        $validEmail = 'jmcasabarsuccess@gmail.com';
        $validPassword = '0147K!0147.';

        if ($request->email === $validEmail && $request->password === $validPassword) {
            // Successful login with hardcoded credentials
            $request->session()->put('admin_logged_in', true);
            $request->session()->put('admin_email', $validEmail);
            $request->session()->put('admin_name', 'JM Casabar');
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with("error", "Invalid email or password");
    }

    public function registerPost(Request $request) {
        $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required"
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($user->save()){
            return redirect()->route('login')->with('success', 'USer Registration Successful');
        }
        return redirect()->route('register')->with('error', 'User Registration Failed');

        // Store user data in the database

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function redirectToGoogle()
    {
        if (! config('services.google.client_id') || ! config('services.google.client_secret')) {
            return redirect()->route('login')->with('error', 'Google sign-in is not configured.');
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect()->route('login')->with('error', 'Google sign-in was cancelled or failed. Please try again.');
        }

        $email = $googleUser->getEmail();
        if (! $email) {
            return redirect()->route('login')->with('error', 'Your Google account does not share an email address.');
        }

        $user = User::where('google_id', $googleUser->getId())->first();

        if (! $user) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }
        }

        if (! $user) {
            $name = $googleUser->getName()
                ?: $googleUser->getNickname()
                ?: (string) str($email)->before('@');

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'password' => Str::password(64),
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended(route('home'));
    }

    public function redirectToFacebook()
    {
        if (! config('services.facebook.client_id') || ! config('services.facebook.client_secret')) {
            return redirect()->route('login')->with('error', 'Facebook sign-in is not configured.');
        }

        return Socialite::driver('facebook')
            ->scopes(['email', 'public_profile'])
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $fbUser = Socialite::driver('facebook')->user();
        } catch (Throwable $e) {
            return redirect()->route('login')->with('error', 'Facebook sign-in was cancelled or failed. Please try again.');
        }

        $email = $fbUser->getEmail();
        if (! $email) {
            return redirect()->route('login')->with('error', 'Your Facebook account does not share an email address. Add an email to your Facebook profile or use another sign-in method.');
        }

        $user = User::where('facebook_id', $fbUser->getId())->first();

        if (! $user) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->facebook_id = $fbUser->getId();
                $user->save();
            }
        }

        if (! $user) {
            $name = $fbUser->getName()
                ?: $fbUser->getNickname()
                ?: (string) str($email)->before('@');

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'facebook_id' => $fbUser->getId(),
                'password' => Str::password(64),
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended(route('home'));
    }
}
