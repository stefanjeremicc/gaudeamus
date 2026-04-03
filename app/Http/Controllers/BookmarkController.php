<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\JobListing;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle(string $locale, JobListing $jobListing)
    {
        $user = auth()->user();

        $existing = Bookmark::where('user_id', $user->id)
            ->where('job_listing_id', $jobListing->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['bookmarked' => false]);
        }

        Bookmark::create([
            'user_id' => $user->id,
            'job_listing_id' => $jobListing->id,
        ]);

        return response()->json(['bookmarked' => true]);
    }
}
