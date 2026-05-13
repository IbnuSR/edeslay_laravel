<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class PengajuanSuratController extends Controller
{
    // ================= MAPPING TABLE =================
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

    // ================= LIST DATA =================
    public function index(Request $request)
    {
        $jenis = $request->jenis ?? 'domisili';

        $table = 'pengajuan_' . $jenis;

        // ================= CEK TABLE =================
        if (!Schema::hasTable($table)) {

            abort(404, 'Jenis surat tidak ditemukan');

        }

        $query = DB::table($table);

        // ================= FILTER PERIODE =================
        if ($request->filter == 'hari_ini') {

            $query->whereDate(
                'tanggal_pengajuan',
                now()->toDateString()
            );

        } elseif ($request->filter == 'minggu') {

            $query->whereBetween(
                'tanggal_pengajuan',
                [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]
            );

        } elseif ($request->filter == 'bulan') {

            $query->whereMonth(
                'tanggal_pengajuan',
                now()->month
            )->whereYear(
                'tanggal_pengajuan',
                now()->year
            );

        } elseif ($request->filter == 'tahun') {

            $query->whereYear(
                'tanggal_pengajuan',
                now()->year
            );
        }

        // ================= DATA =================
        $data = $query
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'admin.surat.index',
            [
                'data' => $data,
                'jenis' => $jenis,
            ]
        );
    }

    // ================= DETAIL =================
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

    // ================= UPDATE STATUS =================
    public function updateStatus(
        Request $request,
        $jenis,
        $id
    ) {

        $table = $this->tables[$jenis] ?? abort(404);

        // =================================================
        // MULAI DIKERJAKAN
        // =================================================
        if ($request->action == 'start') {

            DB::table($table)
                ->where('id', $id)
                ->update([

                    // PENANDA SUDAH DIKERJAKAN
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

        // =================================================
        // STATUS SELESAI
        // =================================================
        if ($status == 'selesai') {

            $updateData['nomor_surat'] =
                $request->nomor_surat;

            // =============================================
            // CETAK ONLINE
            // =============================================
            if (
                $request->hasFile('file_surat')
            ) {

                $file =
                    $request->file(
                        'file_surat'
                    );

                $filename =
                    time() . '_' .
                    $file->getClientOriginalName();

                $path =
                    $file->storeAs(
                        'surat_jadi',
                        $filename,
                        'public'
                    );

                // FIX DATABASE COLUMN
                $updateData[
                    'file_surat_jadi'
                ] = $path;
            }

            // =============================================
            // KETERANGAN ADMIN
            // =============================================
            if (
                $request->keterangan_admin
            ) {

                $updateData[
                    'keterangan_admin'
                ] =
                    $request->keterangan_admin;
            }
        }

        // =================================================
        // STATUS DITOLAK
        // =================================================
        if ($status == 'ditolak') {

            $updateData[
                'alasan_tolak'
            ] =
                $request->alasan_tolak;
        }

        // =================================================
        // UPDATE DATABASE
        // =================================================
        DB::table($table)
            ->where('id', $id)
            ->update($updateData);

        return back()->with(
            'success',
            'Status berhasil diupdate'
        );
    }

    // ================= PRINT =================
    public function print($jenis)
    {
        $table =
            $this->tables[$jenis]
            ?? abort(404);

        $data = DB::table($table)
            ->latest()
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