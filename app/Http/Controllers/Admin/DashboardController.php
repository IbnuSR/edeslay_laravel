<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Profil admin
        $namaAdmin    = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin    = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));

        $fotoProfilSrc = null;
        if (!empty($user->foto)) {
            $fotoProfilSrc = filter_var($user->foto, FILTER_VALIDATE_URL)
                ? $user->foto
                : asset('storage/' . $user->foto);
        }

        // STATISTIK
        $total_prestasi       = DB::table('prestasi')->count();
        $total_kegiatan       = DB::table('kegiatan')->count();
        $total_saran          = DB::table('saran')->count();
        $total_panduan_surat  = DB::table('panduan_surat')->count();

        // GRAFIK: Data saran 6 bulan terakhir
        $labels = [];
        $data   = [];

        for ($i = 5; $i >= 0; $i--) {
            $time = strtotime("-$i months");
            $labels[] = date('M Y', $time);

            $data[] = DB::table('saran')
                ->whereYear('tanggal_dikirim', date('Y', $time))
                ->whereMonth('tanggal_dikirim', date('m', $time))
                ->count();
        }

        // SARAN LIST: 3 terbaru untuk ditampilkan di dashboard
        $saran_list = DB::table('saran')
            ->select('id', 'judul', 'email', 'isi_saran', 'tanggal_dikirim', 'foto_sampul', 'foto_type')
            ->orderBy('tanggal_dikirim', 'desc')
            ->limit(3)
            ->get();

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

    /**
     * ✅ SEARCH API: Untuk autocomplete search saran di dashboard
     * Endpoint: GET /admin/dashboard/search?q=keyword
     */
    public function search(Request $request)
    {
        $search = trim($request->get('q', ''));
        
        $results = [
            'saran' => [],
            'query' => $search,
        ];

        if ($search && strlen($search) >= 2) {
            // Search di tabel saran: judul, isi_saran, atau email
            $results['saran'] = DB::table('saran')
                ->select('id', 'judul', 'email', 'isi_saran', 'tanggal_dikirim')
                ->where(function($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                          ->orWhere('isi_saran', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                })
                ->orderBy('tanggal_dikirim', 'desc')
                ->limit(10)
                ->get();
        }

        return response()->json($results);
    }
}