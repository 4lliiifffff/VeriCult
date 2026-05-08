<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KecamatanController extends Controller
{
    /**
     * Tampilkan daftar semua kecamatan.
     */
    public function index(): View
    {
        $kecamatans = Kecamatan::withCount('villages')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.kecamatans.index', compact('kecamatans'));
    }

    /**
     * Hapus kecamatan yang tidak valid.
     * Villages yang terdampak akan memiliki kecamatan_id = NULL (cascade onDelete).
     */
    public function destroy(Kecamatan $kecamatan): RedirectResponse
    {
        $villageName = $kecamatan->name;
        $villageCount = $kecamatan->villages()->count();

        $kecamatan->delete();

        $message = "Kecamatan \"{$villageName}\" berhasil dihapus.";
        if ($villageCount > 0) {
            $message .= " {$villageCount} desa yang terdampak telah dilepas dari kecamatan.";
        }

        return redirect()->route('admin.kecamatans.index')
            ->with('success', $message);
    }
}
