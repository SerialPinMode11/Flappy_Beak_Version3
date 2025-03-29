<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function Page404(){
        
        return view("errors.404");
    }
}
