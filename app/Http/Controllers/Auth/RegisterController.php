<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\EmployerProfile;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showStudentForm(string $locale)
    {
        return view('auth.register-student', compact('locale'));
    }

    public function registerStudent(string $locale, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'locale' => $locale,
        ]);

        StudentProfile::create([
            'user_id' => $user->id,
            'employment_status' => 'student',
            'is_active_member' => true,
            'cooperative_member_since' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('home', $locale)->with('success', 'Registracija uspešna! Dobrodošli u Gaudeamus.');
    }

    public function showEmployerForm(string $locale)
    {
        return view('auth.register-employer', compact('locale'));
    }

    public function registerEmployer(string $locale, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'company_name' => 'required|string|max:255',
            'pib' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'employer',
            'locale' => $locale,
        ]);

        $company = Company::create([
            'name' => $validated['company_name'],
            'slug' => \Str::slug($validated['company_name']),
            'pib' => $validated['pib'] ?? null,
        ]);

        EmployerProfile::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
        ]);

        Auth::login($user);

        return redirect()->route('home', $locale)->with('success', 'Registracija uspešna! Dobrodošli u Gaudeamus.');
    }
}
