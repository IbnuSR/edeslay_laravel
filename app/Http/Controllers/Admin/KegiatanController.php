<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    /**
     * Handle all kegiatan actions (list, view, add, edit, delete, save).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $action = $request->get('action', 'list');
        $id = $request->get('id');
        $search = $request->get('search', '');

        // Data profil untuk top-bar
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));
        $fotoProfilSrc = null;
        if (!empty($user->foto)) {
            $fotoProfilSrc = 'image/jpeg;base64,' . base64_encode($user->foto);
        }

        // Handle DELETE
        if ($request->get('del')) {
            DB::table('kegiatan')->where('id', intval($request->get('del')))->delete();
            return redirect()->route('admin.kegiatan')->with('success', 'Kegiatan berhasil dihapus');
        }

        // Handle SAVE (Tambah/Edit)
        if ($request->isMethod('post') && $request->has('save_kegiatan')) {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'tanggal' => 'required|date',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            ]);

            $foto = null;
            $foto_type = null;
            
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $file = $request->file('foto');
                $foto = file_get_contents($file->getRealPath());
                $foto_type = $file->getMimeType();
            }

            if (!empty($request->input('id'))) {
                // UPDATE
                $updateData = [
                    'judul' => $validated['judul'],
                    'lokasi' => $validated['lokasi'],
                    'deskripsi' => $validated['deskripsi'],
                    'tanggal' => $validated['tanggal'],
                    'updated_at' => now(),
                ];
                if ($foto !== null) {
                    $updateData['foto'] = $foto;
                    $updateData['foto_type'] = $foto_type;
                }
                DB::table('kegiatan')->where('id', intval($request->input('id')))->update($updateData);
            } else {
                // INSERT
                DB::table('kegiatan')->insert([
                    'judul' => $validated['judul'],
                    'lokasi' => $validated['lokasi'],
                    'deskripsi' => $validated['deskripsi'],
                    'tanggal' => $validated['tanggal'],
                    'foto' => $foto,
                    'foto_type' => $foto_type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return redirect()->route('admin.kegiatan')->with('success', 'Data kegiatan berhasil disimpan');
        }

        // Fetch data based on action
        $kegiatanList = [];
        $edit = null;
        $detail = null;
        $page_title = 'Daftar Kegiatan Desa';

        if ($action === 'list') {
            $query = DB::table('kegiatan');
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('lokasi', 'like', "%{$search}%");
                });
            }
            $kegiatanList = $query->orderBy('tanggal', 'desc')->orderBy('id', 'desc')->get();
            $page_title = 'Daftar Kegiatan Desa';
        }
        
        if ($action === 'edit' && $id) {
            $edit = DB::table('kegiatan')->where('id', intval($id))->first();
            if (!$edit) return redirect()->route('admin.kegiatan')->with('error', 'Data tidak ditemukan');
            $page_title = 'Edit Kegiatan Desa';
        }
        
        if ($action === 'view' && $id) {
            $detail = DB::table('kegiatan')->where('id', intval($id))->first();
            if (!$detail) {
                $detail = null;
                $action = 'list';
            }
            $page_title = 'Detail Kegiatan Desa';
        }
        
        if ($action === 'tambah') {
            $page_title = 'Tambah Kegiatan Desa';
        }

        return view('admin.kegiatan', compact(
            'user', 'namaAdmin', 'roleAdmin', 'inisialAdmin', 'fotoProfilSrc',
            'action', 'kegiatanList', 'edit', 'detail', 'page_title', 'search'
        ));
    }
}