<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PelayananController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $action = $request->get('action', 'list');
        $id = $request->get('id');
        $search = $request->get('search', '');

        // Data profil
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));

        // ================= DELETE =================
        if ($action === 'delete' && $id) {
            $item = DB::table('panduan_surat')->where('id', $id)->first();
            if ($item && $item->foto_pendukung) {
                Storage::disk('public')->delete($item->foto_pendukung);
            }
            DB::table('panduan_surat')->where('id', $id)->delete();
            return redirect()->route('admin.pelayanan.index')->with('success', 'Berhasil dihapus');
        }

        // ================= STORE / UPDATE VIA ACTION =================
        if ($action === 'store') return $this->store($request);
        if ($action === 'update' && $id) return $this->update($request, $id);

        // Mapping action
        if ($action === 'tambah') $action = 'add_form';

        // ================= FETCH DATA =================
        $pelayananList = collect();
        $detail = null;
        $page_title = 'Daftar Pelayanan';

        if ($action === 'list') {
            $query = DB::table('panduan_surat');
            if ($search) $query->where('judul', 'like', "%{$search}%");
            $pelayananList = $query->orderBy('id', 'asc')->get();
        }
        
        if (($action === 'edit' || $action === 'view' || $action === 'add_form') && $id) {
            $detail = DB::table('panduan_surat')->where('id', $id)->first();
            if (!$detail && $action !== 'add_form') {
                return redirect()->route('admin.pelayanan.index')->with('error', 'Data tidak ditemukan');
            }
            $page_title = $action === 'edit' ? 'Edit Pelayanan' : ($action === 'view' ? 'Detail Pelayanan' : 'Tambah Pelayanan');
        }
        
        if ($action === 'add_form' && !$id) $page_title = 'Tambah Pelayanan';

        return view('admin.pelayanan', compact(
            'user', 'namaAdmin', 'roleAdmin', 'inisialAdmin',
            'action', 'pelayananList', 'detail', 'page_title', 'search'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string|max:500',
            'isi_panduan' => 'required|string',
            'foto_pendukung' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $fotoPath = null;
        $fotoType = null;

        if ($request->hasFile('foto_pendukung')) {
            $file = $request->file('foto_pendukung');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
            $fotoPath = $file->storeAs('pelayanan', $filename, 'public'); // ✅ Simpan ke storage/app/public/pelayanan
            $fotoType = $file->getMimeType();
        }

        DB::table('panduan_surat')->insert([
            'judul' => $request->judul,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'isi_panduan' => $request->isi_panduan,
            'foto_pendukung' => $fotoPath, // ✅ Simpan PATH relatif: 'pelayanan/filename.jpg'
            'foto_type' => $fotoType,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.pelayanan.index')->with('success', 'Berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string|max:500',
            'isi_panduan' => 'required|string',
            'foto_pendukung' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $updateData = [
            'judul' => $request->judul,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'isi_panduan' => $request->isi_panduan,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto_pendukung')) {
            $old = DB::table('panduan_surat')->where('id', $id)->first();
            if ($old && $old->foto_pendukung) {
                Storage::disk('public')->delete($old->foto_pendukung);
            }
            $file = $request->file('foto_pendukung');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
            $updateData['foto_pendukung'] = $file->storeAs('pelayanan', $filename, 'public');
            $updateData['foto_type'] = $file->getMimeType();
        }

        DB::table('panduan_surat')->where('id', $id)->update($updateData);
        return redirect()->route('admin.pelayanan.index')->with('success', 'Berhasil diupdate');
    }
}