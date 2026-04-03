<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobListing;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(string $locale, string $slug, Request $request)
    {
        $job = JobListing::where('slug', $slug)->firstOrFail();

        $request->validate([
            'cover_letter' => 'nullable|string|max:5000',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Check if already applied
        $exists = Application::where('user_id', auth()->id())
            ->where('job_listing_id', $job->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Već ste se prijavili na ovaj oglas.');
        }

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'private');
        }

        Application::create([
            'job_listing_id' => $job->id,
            'user_id' => auth()->id(),
            'cover_letter' => $request->input('cover_letter'),
            'cv_path' => $cvPath,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Prijava je uspešno poslata!');
    }
}
