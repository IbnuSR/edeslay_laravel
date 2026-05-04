<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        if ($action == 'tambah') $action = 'tambah';

        // ================= DATA USER =================
        // ✅ FIX: Fallback ke 'Administrator' agar konsisten
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));

        // ================= DELETE =================
        if ($action == 'delete' && $id) {
            // ✅ FIX: Hapus file dari storage juga
            $prestasi = DB::table('prestasi')->where('id', $id)->first();
            if ($prestasi && $prestasi->foto) {
                Storage::disk('public')->delete($prestasi->foto);
            }
            
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

        // ================= RETURN VIEW =================
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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            // ✅ FIX: Validasi mime types spesifik + max size
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $fotoPath = null;
        $fotoType = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            
            // ✅ FIX: Generate unique filename
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
            
            // ✅ FIX: Simpan ke storage/app/public/prestasi (bukan base64)
            $fotoPath = $file->storeAs('prestasi', $filename, 'public');
            $fotoType = $file->getMimeType();
        }

        DB::table('prestasi')->insert([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            // ✅ FIX: Simpan PATH saja, bukan binary
            'foto' => $fotoPath,
            'foto_type' => $fotoType,
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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            // ✅ FIX: Hapus file lama dari storage
            $old = DB::table('prestasi')->where('id', $id)->first();
            if ($old && $old->foto) {
                Storage::disk('public')->delete($old->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
            
            $data['foto'] = $file->storeAs('prestasi', $filename, 'public');
            $data['foto_type'] = $file->getMimeType();
        }

        DB::table('prestasi')->where('id', $id)->update($data);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil diupdate');
    }

    // ================= DESTROY (Opsional - sudah ada di index) =================
    public function destroy($id)
    {
        $prestasi = DB::table('prestasi')->where('id', $id)->first();
        if ($prestasi && $prestasi->foto) {
            Storage::disk('public')->delete($prestasi->foto);
        }
        
        DB::table('prestasi')->where('id', $id)->delete();

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus');
    }
}