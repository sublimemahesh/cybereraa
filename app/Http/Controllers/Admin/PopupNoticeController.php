<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PopupNotice;
use Storage;

class PopupNoticeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PopupNotice::class, 'blog');
    }

    public function index()
    {
        $popups = PopupNotice::all();
        return view('backend.admin.popups.index', compact('popups'));
    }

    public function edit(PopupNotice $popup)
    {
        return view('backend.admin.popups.edit', compact('popup'));
    }

    public function destroy(PopupNotice $popup)
    {
        $popup->delete();
        Storage::delete('popups/' . $popup->image_name);
        $json['status'] = true;
        $json['message'] = 'Popup Notice record deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $popup;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }
}
