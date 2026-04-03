<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\JobListing;
use App\Models\Region;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(string $locale)
    {
        $featuredJobs = JobListing::active()
            ->featured()
            ->with(['company', 'region', 'category'])
            ->latest('published_at')
            ->take(6)
            ->get();

        $newJobs = JobListing::active()
            ->with(['company', 'region', 'category'])
            ->latest('published_at')
            ->take(9)
            ->get();

        $categories = JobCategory::withCount(['jobListings' => function ($query) {
                $query->where('status', 'active');
            }])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $regions = Region::orderBy('sort_order')->get();

        $stats = [
            'active_jobs' => JobListing::active()->count(),
            'cities' => JobListing::active()->distinct('city')->count('city'),
            'students' => \App\Models\User::where('role', 'student')->count(),
        ];

        return view('home', compact(
            'featuredJobs', 'newJobs', 'categories', 'regions', 'stats', 'locale'
        ));
    }
}
