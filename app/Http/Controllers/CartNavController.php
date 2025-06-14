<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartNavController extends Controller
{
    public function toHogCart(){
        
        return view("customer.cartoption.hog");
    }
    public function toWineCart(){
        
        return view("customer.cartoption.wine");
    }

     public function CartOption(){
        
        return view("customer.cartoptions");
    }

     public function toFAQ(){
        
        return view("customer.question");
    }
    public function toPrivacy(){
        
        return view("customer.privacy");
    }
}
