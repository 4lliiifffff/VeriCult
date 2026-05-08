<?php

namespace App\Http\Controllers\SuperAdmin;

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

        return view('super-admin.kecamatans.index', compact('kecamatans'));
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('super-admin.kecamatans.edit', compact('kecamatan'));
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
            'details' => "Updated kecamatan name from '$oldName' to '{$request->name}'"
        ]);

        return redirect()->route('super-admin.kecamatans.index')
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
            'details' => "Deleted kecamatan '$name'"
        ]);

        return redirect()->route('super-admin.kecamatans.index')
            ->with('success', 'Kecamatan berhasil dihapus.');
    }
}
