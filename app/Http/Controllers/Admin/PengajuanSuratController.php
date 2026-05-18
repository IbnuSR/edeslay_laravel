<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Services\FirebaseService;

class PengajuanSuratController extends Controller
{
    // =========================================================
    // MAPPING TABLE
    // =========================================================
    private $tables = [

        'domisili'    => 'pengajuan_domisili',
        'sktm'        => 'pengajuan_sktm',
        'penghasilan' => 'pengajuan_penghasilan',
        'kelahiran'   => 'pengajuan_kelahiran',
        'ktp'         => 'pengajuan_ktp',
        'kematian'    => 'pengajuan_kematian',
        'izin'        => 'pengajuan_izin',
        'nikah'       => 'pengajuan_nikah',
    ];

    // =========================================================
    // INDEX
    // =========================================================
    public function index(Request $request)
    {
        $jenis = $request->jenis ?? 'domisili';

        $table = $this->tables[$jenis] ?? null;

        if (!$table || !Schema::hasTable($table)) {
            abort(404, 'Jenis surat tidak ditemukan');
        }

        $query = DB::table($table);

        // =====================================================
        // FILTER PERIODE
        // =====================================================

        if ($request->filter == 'hari_ini') {

            $query->whereDate(
                'tanggal_pengajuan',
                now()->toDateString()
            );
        }

        elseif ($request->filter == 'minggu') {

            $query->whereBetween(
                'tanggal_pengajuan',
                [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]
            );
        }

        elseif ($request->filter == 'bulan') {

            $query->whereMonth(
                'tanggal_pengajuan',
                now()->month
            )->whereYear(
                'tanggal_pengajuan',
                now()->year
            );
        }

        elseif ($request->filter == 'tahun') {

            $query->whereYear(
                'tanggal_pengajuan',
                now()->year
            );
        }

        // =====================================================
        // SEARCH
        // =====================================================

        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'nama_lengkap',
                    'like',
                    '%' . $request->search . '%'
                )

                ->orWhere(
                    'nik',
                    'like',
                    '%' . $request->search . '%'
                );
            });
        }

        // =====================================================
        // DATA
        // =====================================================

        $data = $query
            ->orderBy(
                'tanggal_pengajuan',
                'desc'
            )
            ->get();

        // =====================================================
        // STATISTIK
        // =====================================================

        $proses = DB::table($table)
            ->where('status', 'proses')
            ->count();

        $selesai = DB::table($table)
            ->where('status', 'selesai')
            ->count();

        $ditolak = DB::table($table)
            ->where('status', 'ditolak')
            ->count();

        $total = DB::table($table)->count();

        return view(
            'admin.surat.index',
            compact(
                'data',
                'jenis',
                'proses',
                'selesai',
                'ditolak',
                'total'
            )
        );
    }

    // =========================================================
    // DETAIL
    // =========================================================
    public function show($jenis, $id)
    {
        $table = $this->tables[$jenis] ?? abort(404);

        $surat = DB::table($table)
            ->where('id', $id)
            ->first();

        if (!$surat) {
            abort(404);
        }

        return view(
            'admin.surat.detail',
            compact('surat', 'jenis')
        );
    }

    // =========================================================
    // UPDATE STATUS
    // =========================================================
    public function updateStatus(
        Request $request,
        $jenis,
        $id
    ) {

        $table = $this->tables[$jenis] ?? abort(404);

        // =====================================================
        // MULAI DIKERJAKAN
        // =====================================================

        if ($request->action == 'start') {

            DB::table($table)
                ->where('id', $id)
                ->update([

                    'nomor_surat' =>
                        'PROCESS-' . time(),

                    'updated_at' => now(),
                ]);

            return back()->with(
                'success',
                'Surat mulai dikerjakan'
            );
        }

        $status = $request->status;

        $updateData = [

            'status' => $status,

            'updated_at' => now(),
        ];

        // =====================================================
        // STATUS SELESAI
        // =====================================================

        if ($status == 'selesai') {

            $updateData['nomor_surat'] =
                $request->nomor_surat;

            // =================================================
            // UPLOAD PDF
            // =================================================

            if ($request->hasFile('file_surat')) {

                $file = $request->file('file_surat');

                $filename =
                    time() . '_' .
                    $file->getClientOriginalName();

                $path = $file->storeAs(
                    'surat_jadi',
                    $filename,
                    'public'
                );

                // FIX COLUMN DB
                $updateData['file_surat_jadi']
                    = $path;
            }

            // =================================================
            // KETERANGAN ADMIN
            // =================================================

            if ($request->keterangan_admin) {

                $updateData['keterangan_admin']
                    = $request->keterangan_admin;
            }
        }

        // =====================================================
        // STATUS DITOLAK
        // =====================================================

        if ($status == 'ditolak') {

            $updateData['alasan_tolak']
                = $request->alasan_tolak;
        }

        // =====================================================
        // UPDATE DATABASE
        // =====================================================

        DB::table($table)
            ->where('id', $id)
            ->update($updateData);

        // =====================================================
        // KIRIM NOTIFIKASI FIREBASE
        // =====================================================

        $dataUser = DB::table($table)
            ->where('id', $id)
            ->first();

        if ($dataUser) {

            $user = User::find(
                $dataUser->user_id
            );

            if ($user && $user->fcm_token) {

                $firebase =
                    app(FirebaseService::class);

                // ================= SELESAI =================
                if ($status == 'selesai') {

                    $firebase->sendNotification(

                        $user->fcm_token,

                        'Pengajuan Disetujui ✅',

                        'Surat ' .
                        strtoupper($jenis) .
                        ' sudah selesai'
                    );
                }

                // ================= DITOLAK =================
                if ($status == 'ditolak') {

                    $firebase->sendNotification(

                        $user->fcm_token,

                        'Pengajuan Ditolak ❌',

                        'Surat ' .
                        strtoupper($jenis) .
                        ' ditolak admin'
                    );
                }
            }
        }

        return back()->with(
            'success',
            'Status berhasil diupdate'
        );
    }

    // =========================================================
    // PRINT
    // =========================================================
    public function print($jenis)
    {
        $table =
            $this->tables[$jenis]
            ?? abort(404);

        $data = DB::table($table)
            ->orderBy(
                'tanggal_pengajuan',
                'desc'
            )
            ->get();

        $stats = [

            'total' =>
                DB::table($table)->count(),

            'proses' =>
                DB::table($table)
                    ->where(
                        'status',
                        'proses'
                    )->count(),

            'selesai' =>
                DB::table($table)
                    ->where(
                        'status',
                        'selesai'
                    )->count(),

            'ditolak' =>
                DB::table($table)
                    ->where(
                        'status',
                        'ditolak'
                    )->count(),
        ];

        return view(
            'admin.surat.print',
            [

                'data' => $data,

                'jenis' => $jenis,

                'total' =>
                    $stats['total'],

                'proses' =>
                    $stats['proses'],

                'selesai' =>
                    $stats['selesai'],

                'ditolak' =>
                    $stats['ditolak'],
            ]
        );
    }
}