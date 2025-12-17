<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function pricing()
    {
        return view('pages.pricing');
    }

    public function help()
    {
        return view('pages.help');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function docs()
    {
        return view('pages.docs');
    }
}