<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

// Redirect root to default locale
Route::get('/', function () {
    return redirect('/' . config('app.locale', 'sr'));
});

// Localized routes
Route::prefix('{locale}')
    ->where(['locale' => 'sr|en|ru'])
    ->middleware(SetLocale::class)
    ->group(function () {

        // Home
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Jobs
        Route::get('/poslovi', [JobListingController::class, 'index'])->name('jobs.index');
        Route::get('/poslovi/{slug}', [JobListingController::class, 'show'])->name('jobs.show');

        // Blog
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

        // Static pages
        Route::get('/o-nama', [PageController::class, 'about'])->name('pages.about');
        Route::get('/kontakt', [PageController::class, 'contact'])->name('pages.contact');
        Route::get('/za-poslodavce', [PageController::class, 'employers'])->name('pages.employers');

        // Auth routes
        Route::middleware('guest')->group(function () {
            Route::get('/prijava', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
            Route::post('/prijava', [App\Http\Controllers\Auth\LoginController::class, 'login']);
            Route::get('/registracija', [App\Http\Controllers\Auth\RegisterController::class, 'showStudentForm'])->name('register');
            Route::post('/registracija', [App\Http\Controllers\Auth\RegisterController::class, 'registerStudent']);
            Route::get('/registracija-poslodavac', [App\Http\Controllers\Auth\RegisterController::class, 'showEmployerForm'])->name('register.employer');
            Route::post('/registracija-poslodavac', [App\Http\Controllers\Auth\RegisterController::class, 'registerEmployer']);
        });

        Route::middleware('auth')->group(function () {
            Route::post('/odjava', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

            // Bookmarks (AJAX)
            Route::post('/poslovi/{jobListing}/bookmark', [App\Http\Controllers\BookmarkController::class, 'toggle'])->name('bookmark.toggle');

            // Applications
            Route::post('/poslovi/{slug}/prijava', [App\Http\Controllers\ApplicationController::class, 'store'])->name('application.store');

            // Student Dashboard
            Route::middleware('role:student')->prefix('moj-nalog')->group(function () {
                Route::get('/', [App\Http\Controllers\Dashboard\StudentDashboardController::class, 'index'])->name('student.dashboard');
                Route::get('/profil', [App\Http\Controllers\Dashboard\StudentDashboardController::class, 'profile'])->name('student.profile');
                Route::put('/profil', [App\Http\Controllers\Dashboard\StudentDashboardController::class, 'updateProfile'])->name('student.profile.update');
                Route::get('/prijave', [App\Http\Controllers\Dashboard\StudentDashboardController::class, 'applications'])->name('student.applications');
                Route::get('/sacuvano', [App\Http\Controllers\Dashboard\StudentDashboardController::class, 'bookmarks'])->name('student.bookmarks');
            });

            // Employer Dashboard
            Route::middleware('role:employer')->prefix('poslodavac')->group(function () {
                Route::get('/', [App\Http\Controllers\Dashboard\EmployerDashboardController::class, 'index'])->name('employer.dashboard');
                Route::get('/objavi-posao', [App\Http\Controllers\Dashboard\EmployerDashboardController::class, 'createJob'])->name('employer.jobs.create');
                Route::post('/objavi-posao', [App\Http\Controllers\Dashboard\EmployerDashboardController::class, 'storeJob'])->name('employer.jobs.store');
                Route::get('/oglasi', [App\Http\Controllers\Dashboard\EmployerDashboardController::class, 'myJobs'])->name('employer.jobs');
                Route::get('/oglasi/{jobListing}/prijave', [App\Http\Controllers\Dashboard\EmployerDashboardController::class, 'jobApplications'])->name('employer.jobs.applications');
                Route::put('/oglasi/{jobListing}/prijave/{application}', [App\Http\Controllers\Dashboard\EmployerDashboardController::class, 'updateApplicationStatus'])->name('employer.applications.update');
                Route::get('/kompanija', [App\Http\Controllers\Dashboard\EmployerDashboardController::class, 'companyProfile'])->name('employer.company');
                Route::put('/kompanija', [App\Http\Controllers\Dashboard\EmployerDashboardController::class, 'updateCompany'])->name('employer.company.update');
            });
        });
    });
