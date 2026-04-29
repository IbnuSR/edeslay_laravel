<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrestasiController extends Controller
{
    // ================= INDEX =================
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        // ================= ACTION HANDLER =================
        $action = $request->get('action', 'list');
        $id = $request->get('id');
        $search = $request->get('search');

        // mapping action dari URL
        if ($action == 'tambah') $action = 'add_form';

        // ================= DATA USER =================
        $namaAdmin = $user->nama_lengkap ?? 'Admin';
        $roleAdmin = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));

        // ================= DELETE =================
        if ($action == 'delete' && $id) {
            DB::table('prestasi')->where('id', $id)->delete();
            return redirect()->route('admin.prestasi.index')
                ->with('success', 'Prestasi berhasil dihapus');
        }

        // ================= FETCH DATA =================
        $query = DB::table('prestasi');

        if ($search) {
            $query->where('judul', 'like', "%{$search}%");
        }

        $prestasiList = $query->orderBy('tanggal', 'desc')->get();

        // ================= DETAIL / EDIT =================
        $detail = null;
        $edit = null;
        $page_title = 'Daftar Prestasi';

        if ($action == 'view' && $id) {
            $detail = DB::table('prestasi')->where('id', $id)->first();
            $page_title = 'Detail Prestasi';
        }

        if ($action == 'edit' && $id) {
            $edit = DB::table('prestasi')->where('id', $id)->first();
            $page_title = 'Edit Prestasi';
        }

        if ($action == 'add_form') {
            $page_title = 'Tambah Prestasi';
        }

        // ================= RETURN VIEW (FIX UTAMA) =================
        return view('admin.prestasi', [
            'action' => $action,
            'prestasiList' => $prestasiList,
            'search' => $search,

            'detail' => $detail,
            'edit' => $edit,
            'page_title' => $page_title,

            'namaAdmin' => $namaAdmin,
            'roleAdmin' => $roleAdmin,
            'inisialAdmin' => $inisialAdmin,
        ]);
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'foto' => 'nullable|image|max:5120',
        ]);

        $foto = null;
        $foto_type = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $foto = file_get_contents($file->getRealPath());
            $foto_type = $file->getMimeType();
        }

        DB::table('prestasi')->insert([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'foto' => $foto,
            'foto_type' => $foto_type,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan');
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'foto' => 'nullable|image|max:5120',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $data['foto'] = file_get_contents($file->getRealPath());
            $data['foto_type'] = $file->getMimeType();
        }

        DB::table('prestasi')->where('id', $id)->update($data);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil diupdate');
    }

    // ================= DESTROY =================
    public function destroy($id)
    {
        DB::table('prestasi')->where('id', $id)->delete();

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus');
    }
}