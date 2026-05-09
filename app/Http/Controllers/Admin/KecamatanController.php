<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::withCount('villages')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.kecamatans.index', compact('kecamatans'));
    }

    public function create()
    {
        return view('admin.kecamatans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kecamatans,name',
        ]);

        $kecamatan = Kecamatan::create([
            'name' => $request->name,
        ]);

        // Audit Log
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'created_kecamatan',
            'model_type' => get_class($kecamatan),
            'model_id' => $kecamatan->id,
            'details' => "Created new kecamatan '{$request->name}' (Admin)"
        ]);

        return redirect()->route('admin.kecamatans.index')
            ->with('success', 'Kecamatan baru berhasil ditambahkan.');
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('admin.kecamatans.edit', compact('kecamatan'));
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kecamatans,name,' . $kecamatan->id,
        ]);

        $oldName = $kecamatan->name;
        $kecamatan->update(['name' => $request->name]);

        // Audit Log
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated_kecamatan_name',
            'model_type' => get_class($kecamatan),
            'model_id' => $kecamatan->id,
            'details' => "Updated kecamatan name from '$oldName' to '{$request->name}' (Admin)"
        ]);

        return redirect()->route('admin.kecamatans.index')
            ->with('success', 'Nama kecamatan berhasil diperbarui.');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        $name = $kecamatan->name;
        $kecamatan->delete();

        // Audit Log
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_kecamatan',
            'model_type' => get_class($kecamatan),
            'model_id' => $kecamatan->id,
            'details' => "Deleted kecamatan '$name' (Admin)"
        ]);

        return redirect()->route('admin.kecamatans.index')
            ->with('success', 'Kecamatan berhasil dihapus.');
    }
}
