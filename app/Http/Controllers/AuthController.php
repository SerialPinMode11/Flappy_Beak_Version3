<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
