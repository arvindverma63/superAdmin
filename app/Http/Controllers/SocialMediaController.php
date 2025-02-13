<?php

namespace App\Http\Controllers;

use App\Logic\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function addData(Request $request, SocialMedia $socialMedia)
    {
        $socialMedia->adduser($request);

        return redirect()->back()->with('success', 'User added successfully');
    }
}
