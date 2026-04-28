<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index()
    {
        // 1. Pastikan user login
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login'); // kalau belum login, balik ke login admin
        }

        // 2. Data Profil Admin
        $namaAdmin     = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin     = $user->role ?? 'admin';
        $inisialAdmin  = strtoupper(substr($namaAdmin, 0, 1));

        // Foto profil (URL atau path storage)
        $fotoProfilSrc = null;
        if (!empty($user->foto)) {
            if (filter_var($user->foto, FILTER_VALIDATE_URL)) {
                $fotoProfilSrc = $user->foto;
            } else {
                $fotoProfilSrc = asset('storage/' . $user->foto);
            }
        }

        // 3. Statistik Cards
        $totalPrestasi      = DB::table('prestasi')->count();
        $totalKegiatan      = DB::table('kegiatan')->count();
        $totalSaran         = DB::table('saran')->count();
        $totalPanduanSurat  = DB::table('panduan_surat')->count();

        // 4. Data Grafik (6 Bulan Terakhir)
        $labels = [];
        $data   = [];
        for ($i = 5; $i >= 0; $i--) {
            $time = strtotime("-$i months");
            $labels[] = date('M Y', $time);

            $count = DB::table('saran')
                ->whereYear('tanggal_dikirim', date('Y', $time))
                ->whereMonth('tanggal_dikirim', date('m', $time))
                ->count();
            $data[] = $count;
        }

        // 5. Daftar Saran Terbaru (Limit 3)
        $saranList = DB::table('saran')
            ->select('id', 'judul', 'email', 'isi_saran', 'tanggal_dikirim', 'foto_sampul', 'foto_type')
            ->orderBy('tanggal_dikirim', 'desc')
            ->limit(3)
            ->get();

        // 6. Kirim semua data ke View admin.dashboard
        return view('admin.dashboard', compact(
            'namaAdmin',
            'roleAdmin',
            'inisialAdmin',
            'fotoProfilSrc',
            'totalPrestasi',
            'totalKegiatan',
            'totalSaran',
            'totalPanduanSurat',
            'labels',
            'data',
            'saranList'
        ));
    }
}
