<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SiteContent;
use Illuminate\Support\Facades\Cache;

class SiteContentController extends Controller
{
    /**
     * Display a listing of maintainable pages.
     */
    public function index()
    {
        $pages = [
            'beranda' => 'Beranda',
            'tentang' => 'Tentang Kami',
            'fitur' => 'Fitur Unggulan',
            'global' => 'Kontak & Footer',
            'seo' => 'SEO & Metadata',
        ];

        return view('super-admin.site-content.index', compact('pages'));
    }

    /**
     * Show the form for editing the specified page content.
     */
    public function edit($page)
    {
        $contents = SiteContent::where('page', $page)
            ->orderBy('sort_order')
            ->get();

        $pageLabels = [
            'beranda' => 'Beranda',
            'tentang' => 'Tentang Kami',
            'fitur' => 'Fitur Unggulan',
            'global' => 'Kontak & Footer',
            'seo' => 'SEO & Metadata',
        ];

        $pageLabel = $pageLabels[$page] ?? ucfirst($page);

        return view('super-admin.site-content.edit', compact('page', 'contents', 'pageLabel'));
    }

    /**
     * Update the specified page content in storage.
     */
    public function update(Request $request, $page)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $section => $value) {
            SiteContent::where('page', $page)
                ->where('section', $section)
                ->update(['value' => $value]);
        }

        // Flush cache for this page
        Cache::forget("site_content_{$page}");
        
        // Also flush global if global changed
        if ($page === 'global') {
            Cache::forget('site_content_global');
        }

        return redirect()->route('super-admin.site-content.index')
            ->with('success', "Konten halaman {$page} berhasil diperbarui.");
    }
}
