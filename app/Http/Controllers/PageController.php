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

    public function calculator(string $locale)
    {
        return view('pages.calculator', compact('locale'));
    }

    public function employers(string $locale)
    {
        $page = Page::where('slug', 'za-poslodavce')->published()->first();
        return view('pages.employers', compact('page', 'locale'));
    }

    public function companyProfile(string $locale, string $slug)
    {
        $company = \App\Models\Company::where('slug', $slug)->firstOrFail();
        $jobs = $company->jobListings()->active()->with(['region', 'category'])->get();
        $reviews = $company->approvedReviews()->with('user')->latest()->get();

        return view('pages.company', compact('locale', 'company', 'jobs', 'reviews'));
    }
}
