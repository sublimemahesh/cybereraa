<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Storage;

class PageController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Page::class, 'page');
    }

    public function index()
    {
        $parent = new Page;
        $pages = Page::withCount('children')->whereNull('parent_id')->get();
        return view('backend.admin.pages.index', compact('pages', 'parent'));
    }

    public function edit(Page $page)
    {
        $parent = $page->parent ?? new Page;
        return view('backend.admin.pages.edit', compact('page', 'parent'));
    }

    public function destroy(Page $page)
    {
        $page->loadCount('children');
        if ($page->children_count > 0) {
            $json['status'] = false;
            $json['code'] = '403';
            $json['message'] = 'Please delete sub pages first!';
            $json['icon'] = 'error';
            return response()->json($json, 403);
        }

        $page->delete();
        Storage::delete('pages/' . $page->image);
        $json['status'] = true;
        $json['message'] = 'Page record deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $page;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }
}
