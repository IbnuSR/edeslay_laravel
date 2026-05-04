<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SaranController extends Controller
{
    /**
     * Display a listing of saran (Admin panel).
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

        // Data profil untuk top-bar
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $roleAdmin = $user->role ?? 'admin';
        $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));

        // ================= DELETE =================
        if ($action === 'delete' && $id) {
            // Hapus foto jika ada
            $saran = DB::table('saran')->where('id', intval($id))->first();
            if ($saran && $saran->foto_sampul) {
                Storage::disk('public')->delete($saran->foto_sampul);
            }
            
            DB::table('saran')->where('id', intval($id))->delete();
            
            return redirect()->route('admin.saran.index')
                ->with('success', 'Saran berhasil dihapus');
        }

        // ================= FETCH DATA LIST =================
        $saranList = collect();
        $detail = null;

        if ($action === 'list') {
            $query = DB::table('saran');
            if ($search) {
                $query->where('judul', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            }
            $saranList = $query->orderBy('tanggal_dikirim', $orderDir)
                              ->orderBy('id', $orderDir)
                              ->get();
        }
        
        if ($action === 'view' && $id) {
            $detail = DB::table('saran')->where('id', intval($id))->first();
            if (!$detail) {
                return redirect()->route('admin.saran.index')
                    ->with('error', 'Data saran tidak ditemukan');
            }
        }

        return view('admin.saran', compact(
            'user', 'namaAdmin', 'roleAdmin', 'inisialAdmin',
            'action', 'saranList', 'detail', 'search', 'sort'
        ));
    }

    /**
     * ✅ STORE: Endpoint untuk mobile app (dengan upload foto opsional)
     */
public function store(Request $request)
{
    // Validasi
    $validator = Validator::make($request->all(), [
        'tanggal_pengisian' => 'required|date',  // ✅ Ganti email dengan tanggal
        'judul' => 'required|string|max:255',
        'isi_saran' => 'required|string|max:1000',
        'foto_sampul' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ], [
        'tanggal_pengisian.required' => 'Tanggal pengisian wajib diisi',
        'tanggal_pengisian.date' => 'Format tanggal tidak valid',
        'judul.required' => 'Judul wajib diisi',
        'isi_saran.required' => 'Isi saran wajib diisi',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()
        ], 422);
    }

    // Handle upload foto
    $fotoPath = null;
    $fotoType = null;
    
    if ($request->hasFile('foto_sampul')) {
        $file = $request->file('foto_sampul');
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
        $fotoPath = $file->storeAs('saran', $filename, 'public');
        $fotoType = $file->getMimeType();
    }

    // Simpan ke database
    $id = DB::table('saran')->insertGetId([
        'tanggal_pengisian' => $request->tanggal_pengisian,  // ✅ Gunakan tanggal_pengisian
        'judul' => $request->judul,
        'isi_saran' => $request->isi_saran,
        'foto_sampul' => $fotoPath,
        'foto_type' => $fotoType,
        'tanggal_dikirim' => now(),  // Tetap auto-timestamp
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Terima kasih! Saran Anda telah kami terima.',
        'data' => ['id' => $id]
    ], 201);
}}