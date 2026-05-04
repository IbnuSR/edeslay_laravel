<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    // ================= MAIN HANDLER =================
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $action = $request->action ?? 'list';
        $id = $request->id;

        $data = [
            'action' => $action,
            'namaAdmin' => $user->nama_lengkap,
            'roleAdmin' => $user->role,
            'inisialAdmin' => strtoupper(substr($user->nama_lengkap, 0, 1)),
        ];

        // ================= LIST =================
        if ($action == 'list') {
            $search = $request->search;

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

        // ================= TAMBAH =================
        if ($action == 'tambah') {
            $data['page_title'] = 'Tambah Kegiatan';
            return view('admin.kegiatan', $data);
        }

        // ================= VIEW =================
        if ($action == 'view') {
            $data['detail'] = DB::table('kegiatan')->where('id', $id)->first();
            return view('admin.kegiatan', $data);
        }

        // ================= EDIT =================
        if ($action == 'edit') {
            $data['edit'] = DB::table('kegiatan')->where('id', $id)->first();
            return view('admin.kegiatan', $data);
        }

        // ================= DELETE (GET) =================
        if ($action == 'delete') {
            // Hapus file foto jika ada
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

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $fotoPath = null;
        $fotoType = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            
            // Generate unique filename
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
            
            // Simpan ke storage/app/public/kegiatan
            $fotoPath = $file->storeAs('kegiatan', $filename, 'public');
            $fotoType = $file->getMimeType();
        }

        DB::table('kegiatan')->insert([
            'judul' => $request->judul,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'foto' => $fotoPath,  // Simpan PATH saja
            'foto_type' => $fotoType,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.kegiatan.index', ['action' => 'list'])
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    // ================= UPDATE =================
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:kegiatan,id',
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $data = [
            'judul' => $request->judul,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            // Ambil data lama untuk hapus file lama
            $old = DB::table('kegiatan')->where('id', $request->id)->first();
            if ($old && $old->foto) {
                Storage::disk('public')->delete($old->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
            
            $data['foto'] = $file->storeAs('kegiatan', $filename, 'public');
            $data['foto_type'] = $file->getMimeType();
        }

        DB::table('kegiatan')->where('id', $request->id)->update($data);

        return redirect()->route('admin.kegiatan.index', ['action' => 'list'])
            ->with('success', 'Kegiatan berhasil diupdate');
    }
}