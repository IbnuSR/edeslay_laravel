<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LayananController extends Controller
{
    /**
     * Display admin layanan page (panduan surat, pengajuan, dll).
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        // Data profil untuk top-bar
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));
        $fotoProfilSrc = null;
        if (!empty($user->foto)) {
            $fotoProfilSrc = 'image/jpeg;base64,' . base64_encode($user->foto);
        }

        // Ambil data panduan surat (contoh)
        $panduanList = DB::table('panduan_surat')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil statistik pengajuan
        $stats = [
            'total_pengajuan' => DB::table('pengajuan_surat')->count(),
            'pending' => DB::table('pengajuan_surat')->where('status', 'pending')->count(),
            'approved' => DB::table('pengajuan_surat')->where('status', 'approved')->count(),
            'rejected' => DB::table('pengajuan_surat')->where('status', 'rejected')->count(),
        ];

        return view('admin.layanan', compact(
            'namaAdmin', 'roleAdmin', 'inisialAdmin', 'fotoProfilSrc',
            'panduanList', 'stats'
        ));
    }

    /**
     * Store new panduan surat.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|in:ktp,domisili,usaha,kelahiran,kematian',
        ]);

        DB::table('panduan_surat')->insert([
            'judul' => $validated['judul'],
            'konten' => $validated['konten'],
            'kategori' => $validated['kategori'],
            'created_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Panduan berhasil ditambahkan');
    }

    /**
     * Delete panduan surat.
     */
    public function destroy($id)
    {
        DB::table('panduan_surat')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Panduan berhasil dihapus');
    }
}