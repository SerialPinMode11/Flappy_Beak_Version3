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
            return redirect()->intended(route("admin.index"));
        }

        return back()->with('error', 'Invalid login credentials');
    }

    public function registerPost(Request $request) {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:admins",
            "password" => "required"
        ]);
        $user = new Admin();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($user->save()){
            return redirect()->route('login')->with('success', 'User Registration Successful');
        }
        return redirect()->route('register')->with('error', 'User Registration Failed');
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

    //Next Page Function
    public function index(){
        $users = Admin::latest()->paginate(10);

        return view('admin.personal', compact('users'));
    }

    public function create(){
        return view('admin.personal.create');
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:admins",
            "password" => "required",
            "role" => "required"
        ]);

        // Create new admin user
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->role = $request->role;
        $admin->save();

        return redirect()->route('admin.personal')->with('success', 'Admin User added successfully!');
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.personal')->with('success', 'Admin User deleted successfully!');
    }
}

