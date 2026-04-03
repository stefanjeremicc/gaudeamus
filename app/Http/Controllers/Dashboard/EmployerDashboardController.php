<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobCategory;
use App\Models\JobListing;
use App\Models\Region;
use Illuminate\Http\Request;

class EmployerDashboardController extends Controller
{
    private function getCompany()
    {
        return auth()->user()->employerProfile->company;
    }

    public function index(string $locale)
    {
        $company = $this->getCompany();

        $activeJobs = $company->jobListings()->where('status', 'active')->count();
        $totalApplications = Application::whereHas('jobListing', fn($q) => $q->where('company_id', $company->id))->count();
        $pendingApplications = Application::whereHas('jobListing', fn($q) => $q->where('company_id', $company->id))->where('status', 'pending')->count();

        $recentJobs = $company->jobListings()
            ->withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'active_jobs' => $activeJobs,
            'total_applications' => $totalApplications,
            'pending' => $pendingApplications,
        ];

        return view('dashboard.employer.index', compact('locale', 'company', 'recentJobs', 'stats'));
    }

    public function createJob(string $locale)
    {
        $categories = JobCategory::whereNull('parent_id')->orderBy('sort_order')->get();
        $regions = Region::orderBy('sort_order')->get();

        return view('dashboard.employer.create-job', compact('locale', 'categories', 'regions'));
    }

    public function storeJob(string $locale, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'requirements' => 'nullable|string',
            'additional_conditions' => 'nullable|string',
            'job_category_id' => 'required|exists:job_categories,id',
            'region_id' => 'required|exists:regions,id',
            'city' => 'nullable|string|max:255',
            'positions_count' => 'required|integer|min:1|max:100',
            'hourly_rate_min' => 'nullable|numeric|min:0',
            'hourly_rate_max' => 'nullable|numeric|min:0',
            'working_hours_per_week' => 'nullable|integer|min:1|max:60',
            'shift_type' => 'required|in:morning,afternoon,night,flexible',
            'ad_type' => 'required|in:full_time,part_time,seasonal,one_time',
            'employment_status_required' => 'required|in:student,unemployed,both',
        ]);

        $company = $this->getCompany();

        $job = JobListing::create([
            'company_id' => $company->id,
            'created_by' => auth()->id(),
            'title' => [$locale => $validated['title']],
            'slug' => \Illuminate\Support\Str::slug($validated['title']),
            'description' => [$locale => $validated['description']],
            'requirements' => $validated['requirements'] ? [$locale => $validated['requirements']] : null,
            'additional_conditions' => $validated['additional_conditions'] ? [$locale => $validated['additional_conditions']] : null,
            'job_category_id' => $validated['job_category_id'],
            'region_id' => $validated['region_id'],
            'city' => $validated['city'],
            'positions_count' => $validated['positions_count'],
            'hourly_rate_min' => $validated['hourly_rate_min'],
            'hourly_rate_max' => $validated['hourly_rate_max'],
            'working_hours_per_week' => $validated['working_hours_per_week'],
            'shift_type' => $validated['shift_type'],
            'ad_type' => $validated['ad_type'],
            'employment_status_required' => $validated['employment_status_required'],
            'status' => 'draft',
        ]);

        return redirect()->route('employer.jobs', $locale)->with('success', 'Oglas je kreiran kao draft. Admin će ga pregledati i aktivirati.');
    }

    public function myJobs(string $locale)
    {
        $jobs = $this->getCompany()->jobListings()
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('dashboard.employer.my-jobs', compact('locale', 'jobs'));
    }

    public function jobApplications(string $locale, JobListing $jobListing)
    {
        // Ensure employer owns this job
        if ($jobListing->company_id !== $this->getCompany()->id) {
            abort(403);
        }

        $applications = $jobListing->applications()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('dashboard.employer.applications', compact('locale', 'jobListing', 'applications'));
    }

    public function updateApplicationStatus(string $locale, JobListing $jobListing, Application $application, Request $request)
    {
        if ($jobListing->company_id !== $this->getCompany()->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,reviewing,accepted,rejected',
            'employer_notes' => 'nullable|string|max:1000',
        ]);

        $application->update([
            'status' => $request->status,
            'employer_notes' => $request->employer_notes,
        ]);

        return back()->with('success', 'Status prijave ažuriran.');
    }

    public function companyProfile(string $locale)
    {
        $company = $this->getCompany();
        $regions = Region::orderBy('sort_order')->get();

        return view('dashboard.employer.company', compact('locale', 'company', 'regions'));
    }

    public function updateCompany(string $locale, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'region_id' => 'nullable|exists:regions,id',
            'pib' => 'nullable|string|max:20',
        ]);

        $company = $this->getCompany();
        $company->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ? [$locale => $validated['description']] : null,
            'website' => $validated['website'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'region_id' => $validated['region_id'],
            'pib' => $validated['pib'],
        ]);

        return back()->with('success', 'Podaci kompanije ažurirani.');
    }
}
