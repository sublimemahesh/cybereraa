<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Package;
use App\Models\Blog;

class FrontendController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        $all_news= Blog::all();
        $homes= page::find(53);

        return view('frontend.index', compact('homes','packages','all_news'));
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
        $projects= page::where(['parent_id' => 38])->get();
        return view('frontend.ongoing_project', compact('projects'));
        
    }

    public function upcomingProject()
    {
        $projects= page::where(['parent_id' => 47])->get();
        return view('frontend.upcoming-project', compact('projects'));
        
    }

    public function howToWork()
    {
        $how_it_works= page::where(['parent_id' => 12])->get();

        return view('frontend.how_to_work', compact('how_it_works'));
       // return view('frontend.how_to_work');
    }

    public function pricing()
    {
        $packages = Package::all();
        return view('frontend.pricing', compact('packages'));
        // return view('frontend.pricing');
    }

    public function faq()
    {
        $faqs= page::all();
        return view('frontend.faq', compact('faqs'));
        ///return view('frontend.faq');
    }

    public function contact()
    {
        $all_contact_us= page::find(6);
        return view('frontend.contact', compact('all_contact_us'));
       // return view('frontend.contact');
    }

    public function news()
    {
        $all_news= Blog::all();
        return view('frontend.news', compact('all_news'));
        //return view('frontend.blog');
    }


    public function showNews(Request $request, Blog $news)
    {

        $all_news= Blog::all();
        return view('frontend.news-post', compact('news','all_news'));

    }

}
