<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class JobListing extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, HasSlug;

    public array $translatable = ['title', 'description', 'requirements', 'additional_conditions'];

    protected $fillable = [
        'company_id',
        'created_by',
        'job_category_id',
        'region_id',
        'title',
        'slug',
        'description',
        'requirements',
        'additional_conditions',
        'employment_status_required',
        'hourly_rate_min',
        'hourly_rate_max',
        'positions_count',
        'working_hours_per_week',
        'shift_type',
        'ad_type',
        'currency',
        'city',
        'status',
        'is_featured',
        'views_count',
        'applications_count',
        'published_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'hourly_rate_min' => 'decimal:2',
            'hourly_rate_max' => 'decimal:2',
            'is_featured' => 'boolean',
            'views_count' => 'integer',
            'applications_count' => 'integer',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    // Relationships

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    // Scopes

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where('published_at', '<=', now())
            ->where(function (Builder $q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeByRegion(Builder $query, int $regionId): Builder
    {
        return $query->where('region_id', $regionId);
    }

    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('job_category_id', $categoryId);
    }

    public function scopeByEmploymentStatus(Builder $query, string $status): Builder
    {
        return $query->where(function (Builder $q) use ($status) {
            $q->where('employment_status_required', $status)
                ->orWhere('employment_status_required', 'both');
        });
    }

    // Methods

    public function isActive(): bool
    {
        return $this->status === 'active'
            && $this->published_at <= now()
            && ($this->expires_at === null || $this->expires_at > now());
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
