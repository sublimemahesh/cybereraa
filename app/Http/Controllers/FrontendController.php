<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Package;
use App\Models\Page;
use App\Models\StakingPackage;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function index()
    {

        $how_it_work = Page::where(['slug' => 'how-to-it-works'])->first();
        $how_it_work = $how_it_work->children;
        $awesome_facts = Page::where(['slug' => 'company-detail'])->first();
        $welcome = Page::where(['slug' => 'welcome'])->first();

        $benefits = Page::where(['slug' => 'benefit'])->first();
        $benefits = $benefits->children;

        return view('frontend.index', compact('benefits', 'welcome', 'how_it_work', 'awesome_facts'));

    }

    public function about()
    {
        $abouts = Page::where(['slug' => 'about-us-page'])->first();
        return view('frontend.about', compact('abouts'));
    }

    public function project()
    {
        $projects = Page::where(['slug' => 'projects'])->first();
        $projects = $projects->children;
        return view('frontend.ongoing_project', compact('projects'));

    }

    public function upcomingProject()
    {
        $projects = Page::where(['slug' => 'upcoming-projects'])->first();
        $projects = $projects->children;
        return view('frontend.upcoming-project', compact('projects'));

    }

    public function pricing()
    {
        $packages = Package::all();
        return view('frontend.pricing', compact('packages'));

    }

    public function staking()
    {
        $stakingpackages = StakingPackage::activePackages()->orderBy('order')->get();
        return view('frontend.staking', compact('stakingpackages'));

    }

    public function faq()
    {
        $faqs = page::all();

        $faq1 = Page::where(['slug' => 'faq-sing-up-and-sign-in'])->first();
        $faq2 = Page::where(['slug' => 'faq-buy-packages'])->first();
        $faq3 = Page::where(['slug' => 'faq-invite-members'])->first();
        $faq4 = Page::where(['slug' => 'faq-withdraw-money'])->first();


        $faqs = array(
            'faq1' => $faq1,
            'faq2' => $faq2,
            'faq3' => $faq3,
            'faq4' => $faq4,
            
        );
        




        return view('frontend.faq', compact('faqs'));

    }

    public function contact()
    {

    }

    public function news()
    {
        $all_news = Blog::all();
        return view('frontend.news', compact('all_news'));

    }

    public function showNews(Request $request, Blog $news)
    {
        $all_news = Blog::all();
        return view('frontend.news-post', compact('news', 'all_news'));
    }

    public function termsConditions()
    {
        $terms_and_conditions = $this->getDatePage('terms-and-conditions');
        $terms_and_conditions_content = page::where(['id' => 77])->get();

        return view('frontend.terms-and-conditions', compact('terms_and_conditions', 'terms_and_conditions_content'));

    }

    public function disclaimer()
    {
        $disclaimers = $this->getDatePage('disclaimer');
        $disclaimers_content = page::where(['id' => 80])->get();

        return view('frontend.disclaimer', compact('disclaimers', 'disclaimers_content'));

    }

}
