<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Page;

class FrontendController extends Controller
{
    public function index() 
    {
        
        $welcomes= page::find(1);
        return view('frontend.index', compact('welcomes'));
      //  return view('frontend.index');
    }

    public function about() 
    {
        $abouts= page::find(3);
        return view('frontend.about', compact('abouts'));
        //return view('frontend.about');
    }

    public function project() 
    {
        $projects= page::find(19);
        return view('frontend.project', compact('projects'));
        //return view('frontend.project');
    }

    public function howToWork() 
    {   
        $how_it_works= page::find(17);
        return view('frontend.how_to_work', compact('how_it_works'));
       // return view('frontend.how_to_work');
    }

    public function pricing() 
    {   
        $packages= page::find(15);
        return view('frontend.pricing', compact('packages'));
        // return view('frontend.pricing');
    }

    public function faq() 
    {
        $faqs= page::find(21);
        return view('frontend.faq', compact('faqs'));
        ///return view('frontend.faq');
    }

    public function contact() 
    {
        $all_contact_us= page::find(6);
        return view('frontend.contact', compact('all_contact_us'));
       // return view('frontend.contact');
    }

 

}