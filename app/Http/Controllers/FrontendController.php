<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index() 
    {
        return view('frontend.index');
    }

    public function about() 
    {
        return view('frontend.about');
    }

    public function project() 
    {
        return view('frontend.project');
    }

    public function howToWork() 
    {
        return view('frontend.how_to_work');
    }

    public function pricing() 
    {
        return view('frontend.pricing');
    }

    public function faq() 
    {
        return view('frontend.faq');
    }

    public function contact() 
    {
        return view('frontend.contact');
    }

}