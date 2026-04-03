<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CVBuilderController extends Controller
{
    public function index(string $locale)
    {
        $user = auth()->user();
        $profile = $user->studentProfile;

        return view('dashboard.student.cv-builder', compact('locale', 'user', 'profile'));
    }

    public function generate(string $locale, Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:2000',
            'education' => 'nullable|array',
            'education.*.institution' => 'nullable|string',
            'education.*.degree' => 'nullable|string',
            'education.*.year' => 'nullable|string',
            'experience' => 'nullable|array',
            'experience.*.company' => 'nullable|string',
            'experience.*.position' => 'nullable|string',
            'experience.*.period' => 'nullable|string',
            'experience.*.description' => 'nullable|string',
            'skills' => 'nullable|string',
            'languages' => 'nullable|string',
        ]);

        $pdf = Pdf::loadView('pdf.cv', ['data' => $data]);
        $pdf->setPaper('A4');

        $filename = 'CV_' . str_replace(' ', '_', $data['full_name']) . '_' . date('Y') . '.pdf';

        return $pdf->download($filename);
    }
}
