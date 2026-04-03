<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Region extends Model
{
    use HasFactory, HasTranslations, HasSlug;

    public array $translatable = ['name'];

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Relationships

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function studentProfiles(): HasMany
    {
        return $this->hasMany(StudentProfile::class);
    }

    public function jobListings(): HasMany
    {
        return $this->hasMany(JobListing::class);
    }
}
