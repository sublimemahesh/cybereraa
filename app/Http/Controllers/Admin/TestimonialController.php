<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Storage;
use Validator;

class TestimonialController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Testimonial::class);
        $testimonials = Testimonial::all();
        return view('backend.admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('backend.admin.testimonials.create');
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Testimonial $testimonial)
    {
        $this->authorize('update', $testimonial);
        return view('backend.admin.testimonials.edit', compact('testimonial'));
    }


    public function destroy(Request $request, Testimonial $testimonial)
    {
        if (Auth::user()->cannot('delete', $testimonial)) {
            $json['status'] = false;
            $json['code'] = '403';
            $json['message'] = 'Access denied';
            $json['icon'] = 'error';
            return response()->json($json, 403);
        }

        $testimonial->delete();
        Storage::delete('testimonials/' . $testimonial->image);

        $json['status'] = true;
        $json['message'] = 'Testimonial deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $testimonial;
        return response()->json($json);
    }
}
