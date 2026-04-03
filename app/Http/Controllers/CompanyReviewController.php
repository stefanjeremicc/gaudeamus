<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyReview;
use Illuminate\Http\Request;

class CompanyReviewController extends Controller
{
    public function store(string $locale, Company $company, Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $existing = CompanyReview::where('company_id', $company->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', 'Vec ste ostavili recenziju za ovu kompaniju.');
        }

        CompanyReview::create([
            'company_id' => $company->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // needs admin approval
        ]);

        return back()->with('success', 'Vasa recenzija je poslata na pregled. Hvala!');
    }
}
