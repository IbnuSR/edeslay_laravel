<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturController extends Controller
{
    public function index()
    {
        $struktur = StrukturDesa::orderBy('urutan', 'asc')->get();
        return view('admin.struktur.index', compact('struktur'));
    }

    public function create()
    {
        return view('admin.struktur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('struktur-desa', 'public');
        }

        StrukturDesa::create($validated);

        return redirect()->route('admin.struktur.index')
            ->with('success', 'Data perangkat desa berhasil ditambahkan');
    }

    public function edit(StrukturDesa $struktur)
    {
        return view('admin.struktur.edit', compact('struktur'));
    }

    public function update(Request $request, StrukturDesa $struktur)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($struktur->foto) {
                Storage::disk('public')->delete($struktur->foto);
            }
            $validated['foto'] = $request->file('foto')->store('struktur-desa', 'public');
        }

        $struktur->update($validated);

        return redirect()->route('admin.struktur.index')
            ->with('success', 'Data perangkat desa berhasil diperbarui');
    }

    public function confirmDelete(StrukturDesa $struktur)
    {
        return view('admin.struktur.delete', compact('struktur'));
    }

    public function destroy(StrukturDesa $struktur)
    {
        if ($struktur->foto) {
            Storage::disk('public')->delete($struktur->foto);
        }

        $struktur->delete();

        return redirect()->route('admin.struktur.index')
            ->with('success', 'Data perangkat desa berhasil dihapus');
    }
}