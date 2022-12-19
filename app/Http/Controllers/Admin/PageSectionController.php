<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageSectionController extends Controller
{
    public function index(Request $request)
    {
        $parent = Page::whereSlug($request->get('page'))->firstOrFail();
        $pages = Page::where('parent_id', $parent->id)->get();
        return view('backend.admin.pages.index', compact('pages', 'parent'));
    }

}
