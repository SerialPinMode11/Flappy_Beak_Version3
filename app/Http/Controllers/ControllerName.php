<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactForm;

class ControllerName extends Controller
{
    public function contactUs(){
        return view("customer.contact");
    }
    public function contactPost(Request $request){
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            ContactForm::create($validatedData);
            return redirect()->route('contact')->with('success', 'Thank you for contacting us!');
        } catch (\Exception $e) {
            return redirect()->route('contact')->with('error', 'An error occurred. Please try again.');
        }
    }

    public function aboutUs(){
        return view("customer.about");
    }
    
}
