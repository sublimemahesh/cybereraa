<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;


class TutorialController extends Controller
{
    public function index(Request $request)
    {

        $tutorials = Page::where(['slug' =>'tutorials'])->firstOrNew();



        return view('backend.user.tutorials.index',compact('tutorials'));
    }
}
