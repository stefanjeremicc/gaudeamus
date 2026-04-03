<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\JobListing;
use App\Models\Region;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index(string $locale, Request $request)
    {
        $query = JobListing::active()
            ->with(['company', 'region', 'category']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereRaw("JSON_EXTRACT(title, '$.sr') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(title, '$.en') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(description, '$.sr') LIKE ?", ["%{$search}%"]);
            });
        }

        if ($request->filled('region')) {
            $query->byRegion($request->input('region'));
        }

        if ($request->filled('category')) {
            $query->byCategory($request->input('category'));
        }

        if ($request->filled('status')) {
            $query->byEmploymentStatus($request->input('status'));
        }

        if ($request->filled('shift')) {
            $query->where('shift_type', $request->input('shift'));
        }

        if ($request->filled('ad_type')) {
            $query->where('ad_type', $request->input('ad_type'));
        }

        if ($request->filled('rate_min')) {
            $query->where('hourly_rate_min', '>=', $request->input('rate_min'));
        }

        if ($request->filled('rate_max')) {
            $query->where('hourly_rate_max', '<=', $request->input('rate_max'));
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        $query = match ($sort) {
            'rate_high' => $query->orderByDesc('hourly_rate_max'),
            'rate_low' => $query->orderBy('hourly_rate_min'),
            'popular' => $query->orderByDesc('views_count'),
            default => $query->latest('published_at'),
        };

        $jobs = $query->paginate(12)->withQueryString();

        $categories = JobCategory::withCount(['jobListings' => fn($q) => $q->where('status', 'active')])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $regions = Region::orderBy('sort_order')->get();

        return view('jobs.index', compact('jobs', 'categories', 'regions', 'locale'));
    }

    public function show(string $locale, string $slug)
    {
        $job = JobListing::where('slug', $slug)
            ->with(['company', 'region', 'category', 'skills'])
            ->firstOrFail();

        $job->incrementViews();

        $relatedJobs = JobListing::active()
            ->where('job_category_id', $job->job_category_id)
            ->where('id', '!=', $job->id)
            ->with(['company', 'region'])
            ->take(3)
            ->get();

        $isBookmarked = auth()->check()
            ? auth()->user()->hasBookmarked($job)
            : false;

        return view('jobs.show', compact('job', 'relatedJobs', 'isBookmarked', 'locale'));
    }
}
