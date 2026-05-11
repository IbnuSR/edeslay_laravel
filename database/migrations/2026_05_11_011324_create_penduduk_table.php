<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            
            // Data Identitas
            $table->string('nik', 16)->unique(); // 16 digit
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            
            // Data Demografi
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->enum('pendidikan_terakhir', ['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3']);
            $table->string('pekerjaan')->nullable();
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            
            // Data Alamat
            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('dusun')->nullable();
            $table->string('desa')->default('Banjardowo');
            $table->string('kecamatan')->default('Lengkong');
            $table->string('kabupaten')->default('Nganjuk');
            
            // Data Kontak
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            
            // Status & Metadata
            $table->enum('status_penduduk', ['Tetap', 'Pindah', 'Meninggal'])->default('Tetap');
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            
            // Index untuk query cepat
            $table->index(['nik']);
            $table->index(['jenis_kelamin', 'agama', 'pendidikan_terakhir', 'pekerjaan', 'status_perkawinan']);
            $table->index(['rt', 'rw', 'dusun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};