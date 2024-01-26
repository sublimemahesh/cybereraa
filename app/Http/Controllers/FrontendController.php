<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Package;
use App\Models\Page;
use App\Models\StakingPackage;
use Illuminate\Http\Request;
use App\Models\Testimonial;


class FrontendController extends Controller
{

    public function index()
    {

        $how_it_work = Page::where(['slug' => 'how-to-it-works-home-page'])->firstOrNew();
       // $how_it_work = $how_it_work->children;
        $awesome_facts = Page::where(['slug' => 'company-detail'])->firstOrNew();
        $welcome = Page::where(['slug' => 'welcome'])->firstOrNew();

        $benefits = Page::where(['slug' => 'benefit'])->firstOrNew();
        //$benefits = $benefits?->children;

        $any_query = Page::where(['slug' => 'any-query'])->firstOrNew();
        $contact_us = Page::where(['slug' => 'contact-us-in-home-page'])->firstOrNew();
        $testimonials = Testimonial::all();





        return view('frontend.index', compact('benefits', 'welcome', 'how_it_work','awesome_facts','any_query','contact_us','testimonials'));

    }

    public function about()
    {
        $abouts = Page::where(['slug' => 'about-us-page'])->firstOrNew();
        $benefits = Page::where(['slug' => 'benefit'])->firstOrNew();
        $benefits = $benefits?->children;

        return view('frontend.about', compact('abouts','benefits'));


    }

    public function project()
    {
        $projects = Page::where(['slug' => 'projects'])->firstOrNew();
        $projects = $projects->children;
        return view('frontend.ongoing_project', compact('projects'));

    }

    public function upcomingProject()
    {
        $projects = Page::where(['slug' => 'upcoming-projects'])->firstOrNew();
        $projects = $projects->children;
        return view('frontend.upcoming-project', compact('projects'));

    }

    public function pricing()
    {
        $packages = Package::activePackages()->get();;
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

        $faq1 = Page::where(['slug' => 'faq-sing-up-and-sign-in'])->firstOrNew();
        $faq2 = Page::where(['slug' => 'faq-buy-packages'])->firstOrNew();
        $faq3 = Page::where(['slug' => 'faq-invite-members'])->firstOrNew();
        $faq4 = Page::where(['slug' => 'faq-withdraw-money'])->firstOrNew();


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
        $terms_and_conditions = Page::where(['slug' => 'terms-and-conditions'])->firstOrNew();

        return view('frontend.terms-and-conditions', compact('terms_and_conditions'));

    }

    public function disclaimer()
    {

       $disclaimer = Page::where(['slug' => 'disclaimer'])->firstOrNew();

        return view('frontend.disclaimer', compact('disclaimer'));

    }

    public function privacyAndPolicy()
    {

       $privacys = Page::where(['slug' => 'privacy-and-policy'])->firstOrNew();

        return view('frontend.privacy-and-policy', compact('privacys'));

    }


    public function howItWorkPage()
    {
        $how_it_work = Page::where(['slug' => 'how-to-it-works'])->firstOrNew();
        $how_it_work = $how_it_work->children;
        return view('frontend.how-it-work',compact('how_it_work'));

    }


}
