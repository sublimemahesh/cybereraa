<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PageSectionController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('page.viewAny'), Response::HTTP_FORBIDDEN);

        $parent = Page::whereSlug($request->get('page'))->firstOrFail();
        $pages = Page::where('parent_id', $parent->id)->get();
        return view('backend.admin.pages.index', compact('pages', 'parent'));
    }

}
