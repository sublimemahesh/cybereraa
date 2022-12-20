<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Page;

class FrontendController extends Controller
{
    public function index() 
    {
       
        return view('frontend.index');
    }

    public function about() 
    {
        $abouts= page::find(3);
        
        return view('frontend.about', compact('abouts'));
        //return view('frontend.about');
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