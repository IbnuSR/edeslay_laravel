<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            // Tambah kolom status keluarga (untuk hitung Kepala Keluarga)
            if (!Schema::hasColumn('penduduk', 'status_keluarga')) {
                $table->enum('status_keluarga', ['Kepala Keluarga', 'Anggota'])->default('Anggota')->after('jenis_kelamin');
            }
            
            // Sesuaikan perkawinan & kawin tercatat
            if (!Schema::hasColumn('penduduk', 'status_kawin')) {
                $table->enum('status_kawin', ['Tercatat', 'Tidak Tercatat'])->nullable()->after('status_perkawinan');
            }
            
            // Pastikan kolom pendidikan & pekerjaan cukup panjang untuk label infografis
            $table->string('pendidikan', 100)->change();
            $table->string('pekerjaan', 100)->nullable()->change();
            
            // Tambah kolom usia (opsional, tapi mempercepat query)
            if (!Schema::hasColumn('penduduk', 'usia')) {
                $table->integer('usia')->nullable()->after('tanggal_lahir');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn(['status_keluarga', 'status_kawin', 'usia']);
        });
    }
};