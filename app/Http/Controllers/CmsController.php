<?php

namespace App\Http\Controllers;

use App\Models\Cms;

class CmsController extends Controller
{
    public function show(string $slug)
    {
        $page = Cms::where('slug', $slug)->where('status', 1)->firstOrFail();
        return view('frontend.cms', compact('page'));
    }
}
