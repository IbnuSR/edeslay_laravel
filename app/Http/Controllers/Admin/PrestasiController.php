<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrestasiController extends Controller
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
        $fotoProfilSrc = !empty($user->foto) ? 'image/jpeg;base64,' . base64_encode($user->foto) : null;

        // Handle DELETE
        if ($action === 'delete' && $id) {
            DB::table('prestasi')->where('id', intval($id))->delete();
            return redirect()->route('admin.prestasi')->with('success', 'Prestasi berhasil dihapus');
        }

        // Handle SAVE (Tambah/Edit)
        if ($request->isMethod('post') && $request->has('save_prestasi')) {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'tanggal' => 'required|date',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            ]);

            $foto = null; $foto_type = null;
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $file = $request->file('foto');
                $foto = file_get_contents($file->getRealPath());
                $foto_type = $file->getMimeType();
            }

            if (!empty($request->input('id'))) {
                // UPDATE
                $updateData = [
                    'judul' => $validated['judul'],
                    'deskripsi' => $validated['deskripsi'],
                    'tanggal' => $validated['tanggal'],
                    'updated_at' => now(),
                ];
                if ($foto !== null) { $updateData['foto'] = $foto; $updateData['foto_type'] = $foto_type; }
                DB::table('prestasi')->where('id', intval($request->input('id')))->update($updateData);
            } else {
                // INSERT
                DB::table('prestasi')->insert([
                    'judul' => $validated['judul'],
                    'deskripsi' => $validated['deskripsi'],
                    'tanggal' => $validated['tanggal'],
                    'foto' => $foto, 'foto_type' => $foto_type,
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
            return redirect()->route('admin.prestasi')->with('success', 'Data prestasi berhasil disimpan');
        }

        // Fetch data
        $prestasiList = []; $edit = null; $detail = null; $page_title = 'Daftar Prestasi';

        if ($action === 'list') {
            $query = DB::table('prestasi');
            if ($search) $query->where('judul', 'like', "%{$search}%");
            $prestasiList = $query->orderBy('tanggal', 'desc')->get();
        }
        if (($action === 'edit_form' || $action === 'view') && $id) {
            $detail = DB::table('prestasi')->where('id', intval($id))->first();
            if (!$detail) return redirect()->route('admin.prestasi')->with('error', 'Data tidak ditemukan');
            $page_title = $action === 'edit_form' ? 'Edit Prestasi' : 'Detail Prestasi';
        }
        if ($action === 'add_form') $page_title = 'Tambah Prestasi';

        return view('admin.prestasi', compact(
            'user', 'namaAdmin', 'roleAdmin', 'inisialAdmin', 'fotoProfilSrc',
            'action', 'prestasiList', 'edit', 'detail', 'page_title', 'search'
        ));
    }
}