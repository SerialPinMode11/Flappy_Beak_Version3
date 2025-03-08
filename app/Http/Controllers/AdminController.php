<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $validEmail = 'jmcasabarsuccess@gmail.com';
    private $validPassword = '0147K!0147.';


    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === $this->validEmail && $password === $this->validPassword) {
            // Successful login
            $request->session()->put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        } else {
            // Failed login
            return redirect()->route('login')->with('error', 'Invalid credentials. Please try again.');
        }
    }

    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function tologin()
    {
        return view('auth.adlogin');
    }
    public function toregister()
    {
        return view('auth.adregister');
    }
    public function toPersonal()
    {
        return view('admin.personal');
    }

    public function toHardware()
    {
        return view('admin.hardware');
    }
    
}