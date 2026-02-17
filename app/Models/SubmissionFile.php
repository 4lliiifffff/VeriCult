<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class SubmissionFile extends Model
{
    /**
     * File type constants
     */
    const TYPE_DOCUMENT = 'document';
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cultural_submission_id',
        'original_name',
        'stored_name',
        'file_type',
        'mime_type',
        'file_size',
        'path',
    ];

    /**
     * Get the submission that owns the file.
     */
    public function culturalSubmission(): BelongsTo
    {
        return $this->belongsTo(CulturalSubmission::class);
    }

    /**
     * Get human-readable file size.
     */
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' bytes';
    }

    /**
     * Get file type icon.
     */
    public function getFileIconAttribute(): string
    {
        return match($this->file_type) {
            self::TYPE_DOCUMENT => 'document',
            self::TYPE_IMAGE => 'image',
            self::TYPE_VIDEO => 'video',
            default => 'paper-clip',
        };
    }

    /**
     * Get file type color for badges.
     */
    public function getFileColorAttribute(): string
    {
        return match($this->file_type) {
            self::TYPE_DOCUMENT => 'blue',
            self::TYPE_IMAGE => 'green',
            self::TYPE_VIDEO => 'purple',
            default => 'gray',
        };
    }

    /**
     * Get public URL for file.
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }

    /**
     * Scope to filter by file type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('file_type', $type);
    }

    /**
     * Delete file from storage when model is deleted.
     */
    protected static function booted()
    {
        static::deleting(function ($file) {
            if (Storage::exists($file->path)) {
                Storage::delete($file->path);
            }
        });
    }
}
