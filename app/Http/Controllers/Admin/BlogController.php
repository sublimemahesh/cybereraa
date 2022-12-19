<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Auth;
use Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('backend.admin.blogs.index', compact('blogs'));
    }

    public function edit(Blog $blog)
    {
        return view('backend.admin.blogs.edit', compact('blog'));
    }

    public function destroy(Blog $blog)
    {
        $role = Auth::user()->getRoleNames()->first();

        if ($role !== 'admin') {
            $json['status'] = false;
            $json['code'] = '403';
            $json['message'] = 'Access denied';
            $json['icon'] = 'error';
            return response()->json($json, 403);
        }

        $blog->delete();
        Storage::delete('blogs/' . $blog->image);
        $json['status'] = true;
        $json['message'] = 'Blog record deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $blog;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }
}
