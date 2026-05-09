<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function index(Request $request)
    {
        $query = Village::with('kecamatan')->orderBy('name');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        $villages = $query->paginate(20);
        $kecamatans = Kecamatan::orderBy('name')->get();

        return view('admin.villages.index', compact('villages', 'kecamatans'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::orderBy('name')->get();
        return view('admin.villages.create', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kecamatan_id' => 'nullable|exists:kecamatans,id',
            'kecamatan_name' => 'nullable|string|max:255',
        ]);

        if ($request->kecamatan_id) {
            $kecamatanId = $request->kecamatan_id;
        } elseif ($request->kecamatan_name) {
            $kecamatan = Kecamatan::firstOrCreate(['name' => $request->kecamatan_name]);
            $kecamatanId = $kecamatan->id;
        } else {
            return back()->withErrors(['kecamatan_id' => 'Silakan pilih atau masukkan nama kecamatan.'])->withInput();
        }

        $village = Village::create([
            'name' => $request->name,
            'kecamatan_id' => $kecamatanId,
        ]);

        // Audit Log
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'created_village',
            'model_type' => get_class($village),
            'model_id' => $village->id,
            'details' => "Created new village '{$request->name}' in kecamatan ID '{$kecamatanId}' (Admin)"
        ]);

        return redirect()->route('admin.villages.index')
            ->with('success', 'Desa baru berhasil ditambahkan.');
    }

    public function edit(Village $village)
    {
        $kecamatans = Kecamatan::orderBy('name')->get();
        return view('admin.villages.edit', compact('village', 'kecamatans'));
    }

    public function update(Request $request, Village $village)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kecamatan_name' => 'required|string|max:255',
        ]);

        $oldName = $village->name;
        
        // Find or create kecamatan
        $kecamatan = Kecamatan::firstOrCreate(['name' => $request->kecamatan_name]);

        $village->update([
            'name' => $request->name,
            'kecamatan_id' => $kecamatan->id,
        ]);

        // Audit Log
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated_village',
            'model_type' => get_class($village),
            'model_id' => $village->id,
            'details' => "Updated village name from '$oldName' to '{$request->name}' (Admin)"
        ]);

        return redirect()->route('admin.villages.index')
            ->with('success', 'Data desa berhasil diperbarui.');
    }

    public function destroy(Village $village)
    {
        $name = $village->name;
        $village->delete();

        // Audit Log
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_village',
            'model_type' => get_class($village),
            'model_id' => $village->id,
            'details' => "Deleted village '$name' (Admin)"
        ]);

        return redirect()->route('admin.villages.index')
            ->with('success', 'Desa berhasil dihapus.');
    }
}
