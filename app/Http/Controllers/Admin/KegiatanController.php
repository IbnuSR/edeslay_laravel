<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'judul' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'foto' => 'nullable|image|max:5120'
        ]);

        $foto = null;
        $type = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $foto = file_get_contents($file->getRealPath());
            $type = $file->getMimeType();
        }

        DB::table('kegiatan')->insert([
            'judul' => $request->judul,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'foto' => $foto,
            'foto_type' => $type,
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
            'id' => 'required',
            'judul' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'foto' => 'nullable|image|max:5120'
        ]);

        $data = [
            'judul' => $request->judul,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $data['foto'] = file_get_contents($file->getRealPath());
            $data['foto_type'] = $file->getMimeType();
        }

        DB::table('kegiatan')->where('id', $request->id)->update($data);

        return redirect()->route('admin.kegiatan.index', ['action' => 'list'])
            ->with('success', 'Kegiatan berhasil diupdate');
    }
}