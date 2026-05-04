<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kegiatan', function (Blueprint $table) {
            // Ubah kolom 'foto' ke LONGTEXT agar bisa menampung base64 image
            $table->longText('foto')->change()->nullable();
            
            // Tambah kolom foto_type (jika belum ada)
            if (!Schema::hasColumn('kegiatan', 'foto_type')) {
                $table->string('foto_type')->nullable()->after('foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->string('foto')->change(); // Kembalikan ke string (opsional)
            $table->dropColumn('foto_type');
        });
    }
};