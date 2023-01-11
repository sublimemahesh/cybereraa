<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Package;
use App\Models\Blog;
use App\Models\Testimonial;


class FrontendController extends Controller
{
    public function index()
    {

        $all_news= Blog::all();
        $packages = page::find(66) ; // 66  48


        $homes_video= page::where(['id' => 59])->get(); // serve 59      50
        $homes_contents= page::where(['id' => 54])->get(); //    54      45
        $testimonials = Testimonial::all();
        $benefits = page::find(70); //   70      38

        return view('frontend.index', compact('benefits','testimonials','packages','all_news','homes_video','homes_contents'));

    }

    public function about()
    {
        $abouts= page::find(3); //3

        $homes_mission= page::where(['id' => 56])->get(); //     56      40
        $homes_value= page::where(['id' => 57])->get(); //       57      44
        $homes_vission= page::where(['id' => 58])->get(); //     58      45

        return view('frontend.about', compact('abouts','homes_mission','homes_value','homes_vission'));

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

    }

    public function pricing()
    {
        $packages = Package::all();
        return view('frontend.pricing', compact('packages'));

    }

    public function faq()
    {
        $faqs= page::all();
        return view('frontend.faq', compact('faqs'));

    }

    public function contact()
    {
        $all_contact_us= page::find(6);
        return view('frontend.contact', compact('all_contact_us'));

    }

    public function news()
    {
        $all_news= Blog::all();
        return view('frontend.news', compact('all_news'));

    }


    public function showNews(Request $request, Blog $news)
    {
        $all_news= Blog::all();
        return view('frontend.news-post', compact('news','all_news'));
    }




}
