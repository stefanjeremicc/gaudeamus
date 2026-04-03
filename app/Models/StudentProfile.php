<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class StudentProfile extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = ['bio'];

    protected $fillable = [
        'user_id',
        'region_id',
        'date_of_birth',
        'jmbg',
        'phone',
        'address',
        'city',
        'university',
        'faculty',
        'study_program',
        'year_of_study',
        'student_id_number',
        'employment_status',
        'bio',
        'cv_path',
        'bank_account',
        'is_active_member',
        'cooperative_member_since',
    ];

    protected function casts(): array
    {
        return [
            'employment_status' => 'string',
            'date_of_birth' => 'date',
            'is_active_member' => 'boolean',
            'cooperative_member_since' => 'date',
            'jmbg' => 'encrypted',
            'bank_account' => 'encrypted',
        ];
    }

    // Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'skill_student_profile');
    }
}
