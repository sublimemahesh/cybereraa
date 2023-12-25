<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\ContactReplyMail;
use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function index()
    {

        return view('frontend.contact');
    }

    public function sendMail(Request $request)
    {
        $details = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'phone' => 'required',
        ]);

        Mail::to('info@tycoon1m.com')->send(new ContactMail($details));
        Mail::to($request->get('email'))->send(new ContactReplyMail());
        return response()->json(true);
    }
}
