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
     * Get category-specific fields definition
     */
    public static function getCategoryFields(string $category): array
    {
        return match($category) {
            self::CATEGORY_TRADISI_LISAN => [
                'jenis_tradisi' => ['label' => 'Jenis Tradisi', 'type' => 'select', 'options' => ['Pantun', 'Cerita Rakyat', 'Sejarah Lisan', 'Legenda', 'Mitos', 'Dongeng', 'Pepatah/Peribahasa', 'Lainnya'], 'placeholder' => 'Pilih jenis tradisi'],
                'bahasa_tutur' => ['label' => 'Bahasa Tutur', 'type' => 'text', 'placeholder' => 'Bahasa yang digunakan dalam penuturan'],
                'penutur_narasumber' => ['label' => 'Penutur / Narasumber', 'type' => 'text', 'placeholder' => 'Nama penutur atau narasumber'],
                'daerah_asal' => ['label' => 'Daerah Asal', 'type' => 'text', 'placeholder' => 'Daerah asal tradisi lisan ini'],
                'konten_tuturan' => ['label' => 'Konten Tuturan', 'type' => 'textarea', 'placeholder' => 'Isi atau ringkasan dari tuturan'],
            ],
            self::CATEGORY_MANUSKRIP => [
                'jenis_naskah' => ['label' => 'Jenis Naskah', 'type' => 'select', 'options' => ['Babad', 'Serat', 'Catatan Sejarah', 'Kitab', 'Prasasti', 'Lainnya'], 'placeholder' => 'Pilih jenis naskah'],
                'bahasa_naskah' => ['label' => 'Bahasa Naskah', 'type' => 'text', 'placeholder' => 'Bahasa yang digunakan dalam naskah'],
                'aksara' => ['label' => 'Jenis Aksara', 'type' => 'text', 'placeholder' => 'Jenis aksara (Jawa, Arab Melayu, dll.)'],
                'tahun_perkiraan' => ['label' => 'Tahun Perkiraan', 'type' => 'text', 'placeholder' => 'Perkiraan tahun penulisan'],
                'kondisi_fisik' => ['label' => 'Kondisi Fisik', 'type' => 'select', 'options' => ['Baik', 'Cukup Baik', 'Rusak Ringan', 'Rusak Berat', 'Fragmentaris'], 'placeholder' => 'Pilih kondisi fisik'],
                'pemilik_penyimpan' => ['label' => 'Pemilik / Penyimpan', 'type' => 'text', 'placeholder' => 'Individu atau lembaga penyimpan'],
            ],
            self::CATEGORY_ADAT_ISTIADAT => [
                'jenis_adat' => ['label' => 'Jenis Adat', 'type' => 'select', 'options' => ['Upacara Adat', 'Hukum Adat', 'Tata Kelola Lingkungan', 'Penyelesaian Sengketa', 'Adat Pernikahan', 'Adat Kematian', 'Lainnya'], 'placeholder' => 'Pilih jenis adat'],
                'komunitas_pelaksana' => ['label' => 'Komunitas Pelaksana', 'type' => 'text', 'placeholder' => 'Suku/komunitas yang melaksanakan'],
                'waktu_pelaksanaan' => ['label' => 'Waktu Pelaksanaan', 'type' => 'text', 'placeholder' => 'Kapan adat ini dilaksanakan'],
                'fungsi_sosial' => ['label' => 'Fungsi Sosial', 'type' => 'textarea', 'placeholder' => 'Fungsi dan peran adat dalam masyarakat'],
            ],
            self::CATEGORY_RITUS => [
                'nama_upacara' => ['label' => 'Nama Upacara', 'type' => 'text', 'placeholder' => 'Nama upacara atau ritual'],
                'agama_kepercayaan' => ['label' => 'Agama / Kepercayaan', 'type' => 'text', 'placeholder' => 'Agama atau sistem kepercayaan terkait'],
                'waktu_pelaksanaan' => ['label' => 'Waktu Pelaksanaan', 'type' => 'text', 'placeholder' => 'Waktu atau musim pelaksanaan ritual'],
                'peralatan' => ['label' => 'Peralatan yang Digunakan', 'type' => 'textarea', 'placeholder' => 'Daftar peralatan atau sesaji yang diperlukan'],
                'makna_filosofis' => ['label' => 'Makna Filosofis', 'type' => 'textarea', 'placeholder' => 'Makna dan filosofi di balik ritual ini'],
            ],
            self::CATEGORY_PENGETAHUAN_TRADISIONAL => [
                'jenis_pengetahuan' => ['label' => 'Jenis Pengetahuan', 'type' => 'select', 'options' => ['Obat Tradisional', 'Jamu', 'Makanan Lokal', 'Pertanian', 'Perikanan', 'Astronomi Tradisional', 'Lainnya'], 'placeholder' => 'Pilih jenis pengetahuan'],
                'bahan_material' => ['label' => 'Bahan / Material', 'type' => 'textarea', 'placeholder' => 'Bahan-bahan yang digunakan'],
                'kegunaan' => ['label' => 'Kegunaan', 'type' => 'textarea', 'placeholder' => 'Manfaat atau kegunaan pengetahuan ini'],
                'cara_pembuatan' => ['label' => 'Cara Pembuatan / Pengolahan', 'type' => 'textarea', 'placeholder' => 'Langkah-langkah pembuatan atau pengolahan'],
            ],
            self::CATEGORY_TEKNOLOGI_TRADISIONAL => [
                'jenis_teknologi' => ['label' => 'Jenis Teknologi', 'type' => 'select', 'options' => ['Alat Pertanian', 'Metode Irigasi', 'Rumah Adat', 'Alat Transportasi', 'Alat Kerajinan', 'Lainnya'], 'placeholder' => 'Pilih jenis teknologi'],
                'bahan_material' => ['label' => 'Bahan Material', 'type' => 'textarea', 'placeholder' => 'Material yang digunakan dalam pembuatan'],
                'fungsi' => ['label' => 'Fungsi', 'type' => 'textarea', 'placeholder' => 'Fungsi dan kegunaan teknologi ini'],
                'cara_penggunaan' => ['label' => 'Cara Penggunaan', 'type' => 'textarea', 'placeholder' => 'Cara menggunakan teknologi ini'],
            ],
            self::CATEGORY_SENI => [
                'jenis_seni' => ['label' => 'Jenis Seni', 'type' => 'select', 'options' => ['Seni Rupa', 'Seni Pertunjukan', 'Seni Sastra', 'Seni Film', 'Seni Musik', 'Seni Tari', 'Seni Media', 'Lainnya'], 'placeholder' => 'Pilih jenis seni'],
                'media_alat' => ['label' => 'Media / Alat', 'type' => 'text', 'placeholder' => 'Media atau alat yang digunakan'],
                'komunitas_seniman' => ['label' => 'Komunitas / Seniman', 'type' => 'text', 'placeholder' => 'Komunitas atau seniman yang terkait'],
                'sejarah_perkembangan' => ['label' => 'Sejarah Perkembangan', 'type' => 'textarea', 'placeholder' => 'Sejarah dan perkembangan seni ini'],
            ],
            self::CATEGORY_BAHASA => [
                'nama_bahasa' => ['label' => 'Nama Bahasa', 'type' => 'text', 'placeholder' => 'Nama bahasa daerah atau isyarat'],
                'jumlah_penutur' => ['label' => 'Jumlah Penutur', 'type' => 'text', 'placeholder' => 'Perkiraan jumlah penutur aktif'],
                'aksara_tulisan' => ['label' => 'Aksara / Tulisan', 'type' => 'text', 'placeholder' => 'Sistem aksara atau tulisan yang digunakan'],
                'klasifikasi_linguistik' => ['label' => 'Klasifikasi Linguistik', 'type' => 'text', 'placeholder' => 'Rumpun atau keluarga bahasa'],
                'status_bahasa' => ['label' => 'Status Bahasa', 'type' => 'select', 'options' => ['Aman', 'Rentan', 'Terancam', 'Sangat Terancam', 'Hampir Punah', 'Punah'], 'placeholder' => 'Pilih status bahasa'],
            ],
            self::CATEGORY_PERMAINAN_RAKYAT => [
                'jumlah_pemain' => ['label' => 'Jumlah Pemain', 'type' => 'text', 'placeholder' => 'Jumlah pemain yang dibutuhkan'],
                'peralatan' => ['label' => 'Peralatan', 'type' => 'textarea', 'placeholder' => 'Peralatan yang diperlukan'],
                'aturan_permainan' => ['label' => 'Aturan Permainan', 'type' => 'textarea', 'placeholder' => 'Aturan dan cara bermain'],
                'usia_pemain' => ['label' => 'Usia Pemain', 'type' => 'text', 'placeholder' => 'Rentang usia pemain (misal: 5-12 tahun)'],
            ],
            self::CATEGORY_OLAHRAGA_TRADISIONAL => [
                'jenis_olahraga' => ['label' => 'Jenis Olahraga', 'type' => 'select', 'options' => ['Bela Diri', 'Ketangkasan', 'Kekuatan', 'Kecepatan', 'Strategi', 'Lainnya'], 'placeholder' => 'Pilih jenis olahraga'],
                'peralatan' => ['label' => 'Peralatan', 'type' => 'textarea', 'placeholder' => 'Peralatan yang digunakan'],
                'aturan' => ['label' => 'Aturan', 'type' => 'textarea', 'placeholder' => 'Aturan dan tata cara olahraga'],
                'kejuaraan_event' => ['label' => 'Kejuaraan / Event', 'type' => 'text', 'placeholder' => 'Event atau kejuaraan yang terkait'],
            ],
            self::CATEGORY_CAGAR_BUDAYA => [
                'jenis_objek' => ['label' => 'Jenis Objek', 'type' => 'select', 'options' => ['Candi', 'Benteng', 'Istana/Keraton', 'Makam', 'Situs Arkeologi', 'Benda Bersejarah', 'Keris', 'Prasasti', 'Lainnya'], 'placeholder' => 'Pilih jenis objek'],
                'periode_sejarah' => ['label' => 'Periode Sejarah', 'type' => 'text', 'placeholder' => 'Periode atau era sejarah'],
                'kondisi' => ['label' => 'Kondisi', 'type' => 'select', 'options' => ['Baik', 'Cukup Baik', 'Rusak Ringan', 'Rusak Berat', 'Reruntuhan'], 'placeholder' => 'Pilih kondisi'],
                'dimensi_ukuran' => ['label' => 'Dimensi / Ukuran', 'type' => 'text', 'placeholder' => 'Ukuran atau dimensi objek'],
                'bahan_material' => ['label' => 'Bahan Material', 'type' => 'text', 'placeholder' => 'Material utama objek'],
            ],
            default => [],
        };
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
        'latitude',
        'longitude',
        'status',
        'reviewed_by',
        'review_started_at',
        'submitted_at',
        'verified_at',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'category_data' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'reviewed_by' => 'integer',
        'review_started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
        'published_at' => 'datetime',
    ];

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
}
