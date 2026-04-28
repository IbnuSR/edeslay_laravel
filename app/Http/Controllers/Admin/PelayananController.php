<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PelayananController extends Controller
{
    /**
     * Display a listing of pelayanan (with search, add, edit, view, delete actions).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $action = $request->get('action', 'list');
        $id = $request->get('id');
        $search = $request->get('search', '');
        $message = $request->session()->get('message');

        // Data profil untuk top-bar
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));
        $fotoProfilSrc = null;
        if (!empty($user->foto)) {
            $fotoProfilSrc = 'image/jpeg;base64,' . base64_encode($user->foto);
        }

        // Handle DELETE
        if ($action === 'delete' && $id) {
            DB::table('panduan_surat')->where('id', intval($id))->delete();
            return redirect()->route('admin.pelayanan.index')->with('success', 'Panduan surat berhasil dihapus');
        }

        // Handle ADD
        if ($action === 'add' && $request->isMethod('post')) {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi_singkat' => 'required|string|max:500',
                'isi_panduan' => 'required|string',
                'foto_pendukung' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            ], [
                'judul.required' => 'Judul wajib diisi.',
                'deskripsi_singkat.required' => 'Deskripsi singkat wajib diisi.',
                'isi_panduan.required' => 'Isi panduan wajib diisi.',
            ]);

            $fotoData = null;
            $fotoType = 'image/jpeg';
            
            if ($request->hasFile('foto_pendukung') && $request->file('foto_pendukung')->isValid()) {
                $file = $request->file('foto_pendukung');
                $fotoData = file_get_contents($file->getRealPath());
                $fotoType = $file->getMimeType();
            }

            DB::table('panduan_surat')->insert([
                'judul' => $validated['judul'],
                'deskripsi_singkat' => $validated['deskripsi_singkat'],
                'isi_panduan' => $validated['isi_panduan'],
                'foto_pendukung' => $fotoData,
                'foto_type' => $fotoType,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.pelayanan.index')->with('success', 'Panduan surat berhasil ditambahkan');
        }

        // Handle EDIT
        if ($action === 'edit' && $request->isMethod('post')) {
            $validated = $request->validate([
                'id' => 'required|integer|exists:panduan_surat,id',
                'judul' => 'required|string|max:255',
                'deskripsi_singkat' => 'required|string|max:500',
                'isi_panduan' => 'required|string',
                'foto_pendukung' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            ]);

            $updateData = [
                'judul' => $validated['judul'],
                'deskripsi_singkat' => $validated['deskripsi_singkat'],
                'isi_panduan' => $validated['isi_panduan'],
                'updated_at' => now(),
            ];

            if ($request->hasFile('foto_pendukung') && $request->file('foto_pendukung')->isValid()) {
                $file = $request->file('foto_pendukung');
                $updateData['foto_pendukung'] = file_get_contents($file->getRealPath());
                $updateData['foto_type'] = $file->getMimeType();
            }

            DB::table('panduan_surat')->where('id', intval($validated['id']))->update($updateData);

            return redirect()->route('admin.pelayanan.index')->with('success', 'Panduan surat berhasil diupdate');
        }

        // Fetch data based on action
        $pelayananList = [];
        $detail = null;
        $page_title = 'Daftar Pelayanan';

        if ($action === 'list') {
            $query = DB::table('panduan_surat');
            if ($search) {
                $query->where('judul', 'like', "%{$search}%");
            }
            $pelayananList = $query->orderBy('id', 'asc')->get();
            $page_title = 'Daftar Pelayanan';
        }
        
        if (($action === 'edit_form' || $action === 'view') && $id) {
            $detail = DB::table('panduan_surat')->where('id', intval($id))->first();
            if (!$detail) {
                return redirect()->route('admin.pelayanan.index')->with('error', 'Data tidak ditemukan');
            }
            $page_title = $action === 'edit_form' ? 'Edit Pelayanan' : 'Detail Pelayanan';
        }
        
        if ($action === 'add_form') {
            $page_title = 'Tambah Pelayanan';
        }

        return view('admin.pelayanan', compact(
            'user', 'namaAdmin', 'roleAdmin', 'inisialAdmin', 'fotoProfilSrc',
            'action', 'pelayananList', 'detail', 'page_title', 'search', 'message'
        ));
    }

    /**
     * Helper: Convert BLOB to base64 image URL.
     */
    private function getFotoSrc($foto_pendukung, $foto_type)
    {
        if (empty($foto_pendukung)) return '';
        if (filter_var($foto_pendukung, FILTER_VALIDATE_URL)) return $foto_pendukung;
        $mime = !empty($foto_type) ? $foto_type : 'image/jpeg';
        return 'data:' . $mime . ';base64,' . base64_encode($foto_pendukung);
    }
}