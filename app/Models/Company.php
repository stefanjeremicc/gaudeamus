<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Company extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, HasTranslations, HasSlug, InteractsWithMedia;

    public array $translatable = ['description'];

    protected $fillable = [
        'name',
        'slug',
        'logo_path',
        'description',
        'website',
        'pib',
        'address',
        'city',
        'region_id',
        'is_verified',
        'avg_rating',
        'reviews_count',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }

    // Relationships

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function employerProfiles(): HasMany
    {
        return $this->hasMany(EmployerProfile::class);
    }

    public function jobListings(): HasMany
    {
        return $this->hasMany(JobListing::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(CompanyReview::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(CompanyReview::class)->where('is_approved', true);
    }

    public function updateRating(): void
    {
        $approved = $this->reviews()->where('is_approved', true);
        $this->update([
            'avg_rating' => round($approved->avg('rating'), 1),
            'reviews_count' => $approved->count(),
        ]);
    }
}
