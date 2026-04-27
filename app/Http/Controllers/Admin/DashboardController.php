<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index()
    {
        // 1. Cek user login
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // 2. Data Profil Admin
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));
        
        // Handle foto profil (BLOB atau path)
        $fotoProfilSrc = null;
        if (!empty($user->foto)) {
            if (filter_var($user->foto, FILTER_VALIDATE_URL) || str_starts_with($user->foto, 'image')) {
                $fotoProfilSrc = $user->foto;
            } else {
                $fotoProfilSrc = asset('storage/' . $user->foto);
            }
        }

        // 3. Statistik Cards
        $total_prestasi = DB::table('prestasi')->count();
        $total_kegiatan = DB::table('kegiatan')->count();
        $total_saran    = DB::table('saran')->count();
        $total_panduan_surat = DB::table('panduan_surat')->count();

        // 4. Data Grafik (6 Bulan Terakhir)
        $labels = [];
        $data = [];
        
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
        $saran_list = DB::table('saran')
            ->select('id', 'judul', 'email', 'isi_saran', 'tanggal_dikirim', 'foto_sampul', 'foto_type')
            ->orderBy('tanggal_dikirim', 'desc')
            ->limit(3)
            ->get();

        // 6. Kirim semua data ke View
        return view('admin.dashboard', compact(
            'namaAdmin',
            'roleAdmin',
            'inisialAdmin',
            'fotoProfilSrc',
            'total_prestasi',
            'total_kegiatan',
            'total_saran',
            'total_panduan_surat',
            'labels',
            'data',
            'saran_list'
        ));
    }
}