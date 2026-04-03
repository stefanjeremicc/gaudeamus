<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Skill;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index(string $locale)
    {
        $user = auth()->user();
        $profile = $user->studentProfile;

        $recentApplications = $user->applications()
            ->with(['jobListing.company', 'jobListing.region'])
            ->latest()
            ->take(5)
            ->get();

        $bookmarksCount = $user->bookmarks()->count();
        $applicationsCount = $user->applications()->count();

        $stats = [
            'applications' => $applicationsCount,
            'bookmarks' => $bookmarksCount,
            'accepted' => $user->applications()->where('status', 'accepted')->count(),
            'pending' => $user->applications()->where('status', 'pending')->count(),
        ];

        return view('dashboard.student.index', compact('locale', 'user', 'profile', 'recentApplications', 'stats'));
    }

    public function profile(string $locale)
    {
        $user = auth()->user();
        $profile = $user->studentProfile;
        $regions = Region::orderBy('sort_order')->get();
        $skills = Skill::orderBy('category')->get();
        $userSkills = $profile ? $profile->skills->pluck('id')->toArray() : [];

        return view('dashboard.student.profile', compact('locale', 'user', 'profile', 'regions', 'skills', 'userSkills'));
    }

    public function updateProfile(string $locale, Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'university' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'year_of_study' => 'nullable|integer|min:1|max:6',
            'region_id' => 'nullable|exists:regions,id',
            'city' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $profile = $user->studentProfile;
        if ($profile) {
            $profile->update([
                'university' => $request->university,
                'faculty' => $request->faculty,
                'year_of_study' => $request->year_of_study,
                'region_id' => $request->region_id,
                'city' => $request->city,
                'bio' => $request->bio ? [$locale => $request->bio] : null,
            ]);

            if ($request->has('skills')) {
                $profile->skills()->sync($request->skills);
            }
        }

        return back()->with('success', 'Profil uspešno ažuriran!');
    }

    public function applications(string $locale)
    {
        $applications = auth()->user()->applications()
            ->with(['jobListing.company', 'jobListing.region', 'jobListing.category'])
            ->latest()
            ->paginate(10);

        return view('dashboard.student.applications', compact('locale', 'applications'));
    }

    public function bookmarks(string $locale)
    {
        $bookmarks = auth()->user()->bookmarks()
            ->with(['jobListing.company', 'jobListing.region', 'jobListing.category'])
            ->latest()
            ->paginate(12);

        return view('dashboard.student.bookmarks', compact('locale', 'bookmarks'));
    }
}
