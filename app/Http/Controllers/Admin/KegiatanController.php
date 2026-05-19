<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    // ================= MAIN HANDLER (SEMUA AKSI DI SINI) =================
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $action = $request->input('action', 'list');
        $id = $request->input('id');

        // 🔥 HANDLE POST REQUEST - INI KUNCINYA!
        if ($request->isMethod('post')) {
            
            // CASE 1: Simpan data baru
            if ($action === 'store' || $action === 'tambah') {
                return $this->store($request);
            }
            
            // CASE 2: Update data existing
            if (($action === 'update' || $action === 'edit') && $id) {
                return $this->update($request, $id);
            }
        }

        // ================= HANDLE GET REQUEST (TAMPILAN) =================
        $data = [
            'action' => $action,
            'namaAdmin' => $user->nama_lengkap ?? 'Administrator',
            'roleAdmin' => $user->role ?? 'admin',
            'inisialAdmin' => strtoupper(substr($user->nama_lengkap ?? 'A', 0, 1)),
        ];

        // LIST
        if ($action == 'list') {
            $search = $request->input('search');
            $query = DB::table('kegiatan');
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%$search%")
                      ->orWhere('lokasi', 'like', "%$search%");
                });
            }
            $data['kegiatanList'] = $query->orderBy('id', 'desc')->get();
            $data['search'] = $search;
            return view('admin.kegiatan', $data);
        }

        // TAMBAH FORM
        if ($action == 'tambah') {
            $data['page_title'] = 'Tambah Kegiatan';
            return view('admin.kegiatan', $data);
        }

        // VIEW DETAIL
        if ($action == 'view') {
            $data['detail'] = DB::table('kegiatan')->where('id', $id)->first();
            return view('admin.kegiatan', $data);
        }

        // EDIT FORM
        if ($action == 'edit') {
            $data['edit'] = DB::table('kegiatan')->where('id', $id)->first();
            return view('admin.kegiatan', $data);
        }

        // DELETE
        if ($action == 'delete' && $id) {
            $kegiatan = DB::table('kegiatan')->where('id', $id)->first();
            if ($kegiatan && $kegiatan->foto) {
                Storage::disk('public')->delete($kegiatan->foto);
            }
            DB::table('kegiatan')->where('id', $id)->delete();
            return redirect()->route('admin.kegiatan.index')
                ->with('success', 'Kegiatan berhasil dihapus');
        }

        return redirect()->route('admin.kegiatan.index', ['action' => 'list']);
    }

    // ================= STORE (CREATE NEW) =================
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480'
        ], [
            'foto.max' => 'Ukuran foto maksimal 20MB.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar tidak didukung.',
        ]);

        $fotoPath = null;
        $fotoType = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
            $fotoPath = $file->storeAs('kegiatan', $filename, 'public');
            $fotoType = $file->getMimeType();
        }

        DB::table('kegiatan')->insert([
            'judul' => $request->judul,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'foto' => $fotoPath,
            'foto_type' => $fotoType,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.kegiatan.index', ['action' => 'list'])
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    // ================= UPDATE (EDIT EXISTING) =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|integer|exists:kegiatan,id',
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480'
        ], [
            'id.exists' => 'Data kegiatan tidak ditemukan.',
            'foto.max' => 'Ukuran foto maksimal 20MB.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar tidak didukung.',
        ]);

        // Pastikan ID request cocok dengan parameter
        if ($request->id != $id) {
            return redirect()->back()->with('error', 'ID mismatch: Tidak bisa mengupdate data.');
        }

        $data = [
            'judul' => $request->judul,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            $old = DB::table('kegiatan')->where('id', $id)->first();
            if ($old && $old->foto && file_exists(storage_path('app/public/' . $old->foto))) {
                Storage::disk('public')->delete($old->foto);
            }
            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
            $data['foto'] = $file->storeAs('kegiatan', $filename, 'public');
            $data['foto_type'] = $file->getMimeType();
        }

        $updated = DB::table('kegiatan')->where('id', $id)->update($data);

        if ($updated) {
            return redirect()->route('admin.kegiatan.index', ['action' => 'list'])
                ->with('success', 'Kegiatan berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Gagal mengupdate data.');
    }

    // ================= SHOW (PREVIEW DETAIL) =================
    public function show($id)
    {
        $detail = DB::table('kegiatan')->where('id', $id)->first();
        return view('admin.kegiatan', [
            'action' => 'view',
            'detail' => $detail,
            'namaAdmin' => Auth::user()->nama_lengkap ?? 'Administrator',
            'roleAdmin' => Auth::user()->role ?? 'admin',
            'inisialAdmin' => strtoupper(substr(Auth::user()->nama_lengkap ?? 'A', 0, 1)),
        ]);
    }
}