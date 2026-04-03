<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about(string $locale)
    {
        $page = Page::where('slug', 'o-nama')->published()->first();
        return view('pages.about', compact('page', 'locale'));
    }

    public function contact(string $locale)
    {
        return view('pages.contact', compact('locale'));
    }

    public function employers(string $locale)
    {
        $page = Page::where('slug', 'za-poslodavce')->published()->first();
        return view('pages.employers', compact('page', 'locale'));
    }
}
