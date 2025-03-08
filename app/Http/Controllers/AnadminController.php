<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AnadminController extends Controller
{
    /**
     * Show the admin login form
     */
    public function login()
    {
        return view('admin.login');
    }

    /**
     * Handle admin login request
     */
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if(Auth::attempt($credentials)){
            return redirect()->intended(route ("admin.index"));
        }

        return back()->with('error', 'Invalid login credentials');
    }

    public function registerPost(Request $request) {
        $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required"
        ]);
        $user = new Admin();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($user->save()){
            return redirect()->route('login')->with('success', 'USer Registration Successful');
        }
        return redirect()->route('register')->with('error', 'User Registration Failed');

        // Store user data in the database

    }

    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        return view('admin.index');
    }

    /**
     * Log the admin out
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}
