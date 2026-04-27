<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StrukturController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $action = $request->get('action', 'list');
        $id = $request->get('id');

        // Data profil
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));
        $fotoProfilSrc = !empty($user->foto) ? 'image/jpeg;base64,' . base64_encode($user->foto) : null;

        // Handle DELETE
        if ($action === 'delete' && $id) {
            DB::table('struktur_desa')->where('id', intval($id))->delete();
            return redirect()->route('admin.struktur')->with('success', 'Data struktur berhasil dihapus');
        }

        // Handle SAVE (Tambah/Edit)
        if ($request->isMethod('post') && $request->has('save_struktur')) {
            $validated = $request->validate([
                'jabatan' => 'required|string|max:255',
                'nama' => 'required|string|max:255',
            ]);

            if (!empty($request->input('id'))) {
                // UPDATE
                DB::table('struktur_desa')->where('id', intval($request->input('id')))->update([
                    'jabatan' => $validated['jabatan'],
                    'nama' => $validated['nama'],
                    'updated_at' => now(),
                ]);
            } else {
                // INSERT
                DB::table('struktur_desa')->insert([
                    'jabatan' => $validated['jabatan'],
                    'nama' => $validated['nama'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return redirect()->route('admin.struktur')->with('success', 'Data struktur berhasil disimpan');
        }

        // Fetch data
        $strukturList = DB::table('struktur_desa')->orderBy('id', 'asc')->get();
        $edit = $id ? DB::table('struktur_desa')->where('id', intval($id))->first() : null;

        return view('admin.struktur', compact(
            'user', 'namaAdmin', 'roleAdmin', 'inisialAdmin', 'fotoProfilSrc',
            'action', 'strukturList', 'edit'
        ));
    }
}