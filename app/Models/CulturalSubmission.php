<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CulturalSubmission extends Model
{
    /**
     * Status constants
     */
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_ADMINISTRATIVE_REVIEW = 'administrative_review';
    const STATUS_FIELD_VERIFICATION = 'field_verification';
    const STATUS_VERIFIED = 'verified';
    const STATUS_PUBLISHED = 'published';
    const STATUS_REJECTED = 'rejected';
    const STATUS_REVISION = 'revision';

    /**
     * Category constants (10+1 Objek Kebudayaan Indonesia)
     */
    const CATEGORY_TRADISI_LISAN = 'Tradisi Lisan';
    const CATEGORY_MANUSKRIP = 'Manuskrip';
    const CATEGORY_ADAT_ISTIADAT = 'Adat Istiadat';
    const CATEGORY_RITUS = 'Ritus';
    const CATEGORY_PENGETAHUAN_TRADISIONAL = 'Pengetahuan Tradisional';
    const CATEGORY_TEKNOLOGI_TRADISIONAL = 'Teknologi Tradisional';
    const CATEGORY_SENI = 'Seni';
    const CATEGORY_BAHASA = 'Bahasa';
    const CATEGORY_PERMAINAN_RAKYAT = 'Permainan Rakyat';
    const CATEGORY_OLAHRAGA_TRADISIONAL = 'Olahraga Tradisional';
    const CATEGORY_CAGAR_BUDAYA = 'Cagar Budaya';

    /**
     * Category slug mapping
     */
    const CATEGORY_SLUGS = [
        'tradisi-lisan' => self::CATEGORY_TRADISI_LISAN,
        'manuskrip' => self::CATEGORY_MANUSKRIP,
        'adat-istiadat' => self::CATEGORY_ADAT_ISTIADAT,
        'ritus' => self::CATEGORY_RITUS,
        'pengetahuan-tradisional' => self::CATEGORY_PENGETAHUAN_TRADISIONAL,
        'teknologi-tradisional' => self::CATEGORY_TEKNOLOGI_TRADISIONAL,
        'seni' => self::CATEGORY_SENI,
        'bahasa' => self::CATEGORY_BAHASA,
        'permainan-rakyat' => self::CATEGORY_PERMAINAN_RAKYAT,
        'olahraga-tradisional' => self::CATEGORY_OLAHRAGA_TRADISIONAL,
        'cagar-budaya' => self::CATEGORY_CAGAR_BUDAYA,
    ];

    /**
     * All valid categories
     */
    const CATEGORIES = [
        self::CATEGORY_TRADISI_LISAN,
        self::CATEGORY_MANUSKRIP,
        self::CATEGORY_ADAT_ISTIADAT,
        self::CATEGORY_RITUS,
        self::CATEGORY_PENGETAHUAN_TRADISIONAL,
        self::CATEGORY_TEKNOLOGI_TRADISIONAL,
        self::CATEGORY_SENI,
        self::CATEGORY_BAHASA,
        self::CATEGORY_PERMAINAN_RAKYAT,
        self::CATEGORY_OLAHRAGA_TRADISIONAL,
        self::CATEGORY_CAGAR_BUDAYA,
    ];

    /**
     * Category descriptions for display
     */
    const CATEGORY_DESCRIPTIONS = [
        self::CATEGORY_TRADISI_LISAN => 'Tuturan turun-temurun, seperti pantun, cerita rakyat, atau sejarah lisan.',
        self::CATEGORY_MANUSKRIP => 'Naskah kuno seperti babad, serat, atau catatan sejarah.',
        self::CATEGORY_ADAT_ISTIADAT => 'Kebiasaan masyarakat, tata kelola lingkungan, dan penyelesaian sengketa.',
        self::CATEGORY_RITUS => 'Tata cara upacara atau ritual keagamaan/kepercayaan.',
        self::CATEGORY_PENGETAHUAN_TRADISIONAL => 'Pengetahuan tentang alam, obat-obatan tradisional, makanan lokal, dan jamu.',
        self::CATEGORY_TEKNOLOGI_TRADISIONAL => 'Alat pengolah sawah, metode irigasi, atau rumah adat.',
        self::CATEGORY_SENI => 'Seni rupa, pertunjukan, sastra, film, dan seni media.',
        self::CATEGORY_BAHASA => 'Ragam bahasa daerah dan bahasa isyarat.',
        self::CATEGORY_PERMAINAN_RAKYAT => 'Permainan tradisional seperti congklak, gasing, dan bentengan.',
        self::CATEGORY_OLAHRAGA_TRADISIONAL => 'Aktivitas fisik/mental tradisional seperti pencak silat, karapan sapi, atau debus.',
        self::CATEGORY_CAGAR_BUDAYA => 'Benda atau tempat bersejarah seperti candi, keris, atau situs arkeologi.',
    ];

    /**
     * Category icons (SVG path data)
     */
    const CATEGORY_ICONS = [
        self::CATEGORY_TRADISI_LISAN => 'chat-bubble',
        self::CATEGORY_MANUSKRIP => 'document-text',
        self::CATEGORY_ADAT_ISTIADAT => 'users',
        self::CATEGORY_RITUS => 'fire',
        self::CATEGORY_PENGETAHUAN_TRADISIONAL => 'beaker',
        self::CATEGORY_TEKNOLOGI_TRADISIONAL => 'wrench',
        self::CATEGORY_SENI => 'paint-brush',
        self::CATEGORY_BAHASA => 'language',
        self::CATEGORY_PERMAINAN_RAKYAT => 'puzzle',
        self::CATEGORY_OLAHRAGA_TRADISIONAL => 'trophy',
        self::CATEGORY_CAGAR_BUDAYA => 'building-library',
    ];

    /**
     * Get category-specific fields definition (full config with sub-categories)
     */
    public static function getCategoryFields(string $category): array
    {
        $allConfig = config('category_fields', []);
        $config = $allConfig[$category] ?? null;

        if (!$config) {
            return [];
        }

        // If has sub-categories, return the full config structure
        if (!empty($config['has_sub'])) {
            return $config;
        }

        // For categories without sub, return fields directly (backward compat)
        return $config['fields'] ?? [];
    }

    /**
     * Get flat fields for a category (resolves sub-category if needed)
     * Used for validation and display in show.blade.php
     */
    public static function getFlatCategoryFields(string $category, ?string $subCategory = null): array
    {
        $allConfig = config('category_fields', []);
        $config = $allConfig[$category] ?? null;

        if (!$config) {
            return [];
        }

        if (!empty($config['has_sub'])) {
            if ($subCategory && isset($config['fields'][$subCategory])) {
                return $config['fields'][$subCategory];
            }
            // Return all fields merged if no sub-category specified
            $merged = [];
            foreach ($config['fields'] as $subFields) {
                $merged = array_merge($merged, $subFields);
            }
            return $merged;
        }

        return $config['fields'] ?? [];
    }

    /**
     * Get the slug for a category name
     */
    public static function getCategorySlug(string $category): ?string
    {
        return array_search($category, self::CATEGORY_SLUGS) ?: null;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'category',
        'description',
        'category_data',
        'address',
        'status',
        'reviewed_by',
        'review_started_at',
        'submitted_at',
        'verified_at',
        'published_at',
        'period_year',
        'submission_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'category_data' => 'array',
        'reviewed_by' => 'integer',
        'review_started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
        'published_at' => 'datetime',
        'submission_type' => 'string',
        'period_year' => 'integer',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saving(function ($submission) {
            // Slug generation
            if (!$submission->slug || ($submission->isDirty('name') && !$submission->slug)) {
                $submission->slug = static::generateUniqueSlug($submission->name);
            }

            // Status Timestamps
            if ($submission->isDirty('status')) {
                if ($submission->status === static::STATUS_SUBMITTED && !$submission->submitted_at) {
                    $submission->submitted_at = now();
                }
                if ($submission->status === static::STATUS_VERIFIED && !$submission->verified_at) {
                    $submission->verified_at = now();
                }
                if ($submission->status === static::STATUS_PUBLISHED && !$submission->published_at) {
                    $submission->published_at = now();
                }
            }

            // Default period_year to current year
            if (empty($submission->period_year)) {
                $submission->period_year = date('Y');
            }
        });
    }

    /**
     * Get the user that owns the submission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the files for the submission.
     */
    public function files(): HasMany
    {
        return $this->hasMany(SubmissionFile::class);
    }

    /**
     * Get the validator who is currently reviewing the submission.
     */
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get the administrative reviews for the submission.
     */
    public function administrativeReviews(): HasMany
    {
        return $this->hasMany(AdministrativeReview::class, 'submission_id');
    }

    /**
     * Get the field verifications for the submission.
     */
    public function fieldVerifications(): HasMany
    {
        return $this->hasMany(FieldVerification::class, 'submission_id');
    }

    /**
     * Scope to filter by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get only published submissions.
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Scope to get submissions in review (submitted, admin review, field verification).
     */
    public function scopeInReview($query)
    {
        return $query->whereIn('status', [
            self::STATUS_SUBMITTED,
            self::STATUS_ADMINISTRATIVE_REVIEW,
            self::STATUS_FIELD_VERIFICATION,
        ]);
    }

    /**
     * Scope to get only authenticated user's submissions.
     */
    public function scopeOwnedBy($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if submission can be edited.
     */
    public function isEditable(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_REVISION]);
    }

    /**
     * Check if submission can be submitted.
     */
    public function canBeSubmitted(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_REVISION]);
    }

    /**
     * Check if the submission can be claimed for review.
     */
    public function canBeClaimed(): bool
    {
        return $this->status === self::STATUS_SUBMITTED && is_null($this->reviewed_by);
    }

    /**
     * Check if the submission can be unclaimed.
     */
    public function canBeUnclaimed(int $userId): bool
    {
        return $this->status === self::STATUS_ADMINISTRATIVE_REVIEW && $this->reviewed_by === $userId;
    }

    /**
     * Get human-readable status name.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SUBMITTED => 'Submitted',
            self::STATUS_ADMINISTRATIVE_REVIEW => 'Administrative Review',
            self::STATUS_FIELD_VERIFICATION => 'Field Verification',
            self::STATUS_VERIFIED => 'Verified',
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_REVISION => 'Needs Revision',
            default => 'Unknown',
        };
    }

    /**
     * Get status badge color class.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'gray',
            self::STATUS_REVISION => 'amber',
            self::STATUS_SUBMITTED => 'blue',
            self::STATUS_ADMINISTRATIVE_REVIEW, self::STATUS_FIELD_VERIFICATION => 'indigo',
            self::STATUS_VERIFIED => 'emerald',
            self::STATUS_PUBLISHED => 'green',
            self::STATUS_REJECTED => 'red',
            default => 'gray',
        };
    }

    /**
     * Generate unique slug for the submission.
     */
    public static function generateUniqueSlug(string $name): string
    {
        $slug = \Illuminate\Support\Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Check if this is an OPK submission
     */
    public function isOPK(): bool
    {
        return $this->submission_type === 'statistik';
    }

    /**
     * Check if this is an active culture report
     */
    public function isActiveCulture(): bool
    {
        return $this->submission_type === 'aktif';
    }

    /**
     * Get the OPK category from active culture report kategori_opk field
     */
    public function getOPKCategory(): ?string
    {
        if (!$this->isActiveCulture()) {
            return null;
        }

        return $this->category_data['kategori_opk'] ?? null;
    }

    /**
     * Scope to filter by submission type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('submission_type', $type);
    }
}
