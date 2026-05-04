<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saran', function (Blueprint $table) {
            // Hapus kolom email (optional)
            // $table->dropColumn('email');
            
            // Tambah kolom tanggal_pengisian
            $table->date('tanggal_pengisian')->nullable()->after('judul');
        });
    }

    public function down(): void
    {
        Schema::table('saran', function (Blueprint $table) {
            // $table->string('email')->nullable();
            $table->dropColumn('tanggal_pengisian');
        });
    }
};