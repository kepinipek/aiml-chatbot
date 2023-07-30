<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function about()
    {
        return view('home');
    }

    public function news()
    {
        return view('news');
    }
}
