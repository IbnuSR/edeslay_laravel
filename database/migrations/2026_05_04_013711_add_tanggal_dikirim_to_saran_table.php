<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saran', function (Blueprint $table) {
            if (!Schema::hasColumn('saran', 'tanggal_dikirim')) {
                $table->dateTime('tanggal_dikirim')->nullable()->after('isi_saran');
            }
        });
    }

    public function down(): void
    {
        Schema::table('saran', function (Blueprint $table) {
            $table->dropColumn('tanggal_dikirim');
        });
    }
};