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
        // $homes= page::find(44); //53  44

        $homes_video= page::where(['id' => 59])->get(); // serve 59      50
        $homes_contents= page::where(['id' => 54])->get(); //    54      45
        $homes_mission= page::where(['id' => 56])->get(); //     56      46
        $homes_value= page::where(['id' => 57])->get(); //       57      47
        $homes_vission= page::where(['id' => 45])->get(); //     58      45



        return view('frontend.index', compact('packages','all_news','homes_video','homes_contents','homes_mission','homes_value','homes_vission'));
      //  return view('frontend.index');
    }

    public function about()
    {
        $abouts= page::find(3); //3

        $homes_mission= page::where(['id' => 56])->get(); //     56      40
        $homes_value= page::where(['id' => 57])->get(); //       57      44  
        $homes_vission= page::where(['id' => 58])->get(); //     58      45

        return view('frontend.about', compact('abouts','homes_mission','homes_value','homes_vission'));
        //return view('frontend.about');
    }

    public function project()
    {
        $projects= page::where(['parent_id' => 38])->get(); //38
        return view('frontend.ongoing_project', compact('projects'));

    }

    public function upcomingProject()
    {
        $projects= page::where(['parent_id' => 47])->get(); //47
        return view('frontend.upcoming-project', compact('projects'));

    }

    public function howToWork()
    {
        $how_it_works= page::where(['parent_id' => 12])->get();  //12

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
