<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'section',
        'type',
        'value',
        'label',
        'sort_order',
    ];

    /**
     * Get content value with fallback.
     */
    public static function getValue($page, $section, $default = null)
    {
        $content = self::where('page', $page)
            ->where('section', $section)
            ->first();

        return $content ? $content->value : $default;
    }

    /**
     * Get all content for a page as an associative array.
     */
    public static function getContentForPage($page)
    {
        return self::where('page', $page)
            ->orderBy('sort_order')
            ->get()
            ->pluck('value', 'section')
            ->toArray();
    }
}
