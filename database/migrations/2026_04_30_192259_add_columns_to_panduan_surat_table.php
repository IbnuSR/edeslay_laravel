<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('panduan_surat', function (Blueprint $table) {
            // Tambah kolom jika belum ada
            if (!Schema::hasColumn('panduan_surat', 'deskripsi_singkat')) {
                $table->string('deskripsi_singkat', 500)->nullable()->after('judul');
            }
            if (!Schema::hasColumn('panduan_surat', 'isi_panduan')) {
                $table->text('isi_panduan')->nullable()->after('deskripsi_singkat');
            }
            if (!Schema::hasColumn('panduan_surat', 'foto_pendukung')) {
                $table->string('foto_pendukung')->nullable()->after('isi_panduan');
            }
            if (!Schema::hasColumn('panduan_surat', 'foto_type')) {
                $table->string('foto_type')->nullable()->after('foto_pendukung');
            }
        });
    }

    public function down(): void
    {
        Schema::table('panduan_surat', function (Blueprint $table) {
            $table->dropColumn(['deskripsi_singkat', 'isi_panduan', 'foto_pendukung', 'foto_type']);
        });
    }
};