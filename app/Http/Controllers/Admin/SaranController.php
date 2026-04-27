<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaranController extends Controller
{
    /**
     * Display a listing of saran (with search, sort, view, delete actions).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $action = $request->get('action', 'list');
        $id = $request->get('id');
        $search = trim($request->get('search', ''));
        $sort = $request->get('sort', 'desc');
        $orderDir = ($sort === 'asc') ? 'ASC' : 'DESC';
        $nextSort = ($sort === 'asc') ? 'desc' : 'asc';

        // Data profil untuk top-bar
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));
        $fotoProfilSrc = null;
        if (!empty($user->foto)) {
            $fotoProfilSrc = 'image/jpeg;base64,' . base64_encode($user->foto);
        }

        // Handle DELETE
        if ($action === 'delete' && $id) {
            DB::table('saran')->where('id', intval($id))->delete();
            return redirect()->route('admin.saran')->with('success', 'Saran berhasil dihapus');
        }

        // Fetch data based on action
        $saranList = [];
        $detail = null;
        $message = $request->session()->get('message');

        if ($action === 'list') {
            $query = DB::table('saran');
            if ($search) {
                // HANYA cari di judul, tidak di isi_saran (sesuai native code)
                $query->where('judul', 'like', "%{$search}%");
            }
            $saranList = $query->orderBy('tanggal_dikirim', $orderDir)
                              ->orderBy('id', $orderDir)
                              ->get();
        }
        
        if ($action === 'view' && $id) {
            $detail = DB::table('saran')->where('id', intval($id))->first();
            if (!$detail) {
                return redirect()->route('admin.saran')->with('error', 'Data saran tidak ditemukan');
            }
        }

        return view('admin.saran', compact(
            'user', 'namaAdmin', 'roleAdmin', 'inisialAdmin', 'fotoProfilSrc',
            'action', 'saranList', 'detail', 'search', 'sort', 'nextSort', 'message'
        ));
    }
}