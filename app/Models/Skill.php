<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Skill extends Model
{
    use HasFactory, HasTranslations, HasSlug;

    public array $translatable = ['name'];

    protected $fillable = [
        'name',
        'slug',
        'category',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Relationships

    public function jobListings(): BelongsToMany
    {
        return $this->belongsToMany(JobListing::class);
    }

    public function studentProfiles(): BelongsToMany
    {
        return $this->belongsToMany(StudentProfile::class, 'skill_student_profile');
    }
}
