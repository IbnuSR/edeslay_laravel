@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <!-- ================= HEADER ================= -->
    <div class="dashboard-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <!-- LEFT -->
            <div>

                <h2 class="fw-bold mb-1 text-dark">
                    Pengajuan Surat Online
                </h2>

                <div class="text-muted small">
                    Dashboard /
                    Pengajuan Surat /
                    {{ ucfirst(request('jenis', 'domisili')) }}
                </div>

            </div>

            <!-- RIGHT -->
            <div class="d-flex align-items-center gap-3 flex-wrap">

                <!-- CETAK -->
                <a href="{{ route('admin.surat.print', ['jenis' => request('jenis', 'domisili')]) }}"
                   target="_blank"
                   class="btn btn-primary rounded-pill px-4 shadow-sm">

                    <i class="fas fa-print me-2"></i>
                    Cetak Laporan

                </a>

                <!-- SEARCH -->
                <div class="search-modern">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        id="searchJenisSurat"
                        placeholder="Cari jenis surat..."
                    >

                </div>

                <!-- PROFILE -->
               {{-- Profile --}}
<div class="profile-wrapper">
    <div class="profile-info">
        <div class="name">{{ $namaAdmin ?? 'Administrator' }}</div>
        <div class="role">{{ $roleAdmin ?? 'admin' }}</div>
    </div>
    <a href="{{ route('admin.profile') }}" class="profile-avatar">
        @if(isset($fotoProfilSrc) && $fotoProfilSrc)
            <img src="{{ $fotoProfilSrc }}" alt="Foto">
        @else
            {{ $inisialAdmin ?? 'A' }}
        @endif
    </a>
</div>

            </div>

        </div>

    </div>

    <!-- ================= MENU JENIS SURAT ================= -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            @php

                $jenisSurat = [

                    'domisili' => [
                        'icon' => 'fa-home',
                        'label' => 'Surat Domisili'
                    ],

                    'sktm' => [
                        'icon' => 'fa-hand-holding-heart',
                        'label' => 'SKTM'
                    ],

                    'penghasilan' => [
                        'icon' => 'fa-money-bill-wave',
                        'label' => 'Surat Penghasilan'
                    ],

                    'kelahiran' => [
                        'icon' => 'fa-baby',
                        'label' => 'Surat Kelahiran'
                    ],

                    'ktp' => [
                        'icon' => 'fa-id-card',
                        'label' => 'Surat KTP'
                    ],

                    'kematian' => [
                        'icon' => 'fa-pray',
                        'label' => 'Surat Kematian'
                    ],

                    'izin' => [
                        'icon' => 'fa-file-contract',
                        'label' => 'Izin Kegiatan'
                    ],

                    'nikah' => [
                        'icon' => 'fa-ring',
                        'label' => 'Surat Nikah'
                    ],

                ];

            @endphp

            <div class="row g-3" id="jenisSuratGrid">

                @foreach($jenisSurat as $key => $item)

                    @php
                        $count = \DB::table('pengajuan_' . $key)->count();
                    @endphp

                    <div class="col-lg-3 col-md-6">

                        <a
                            href="{{ route('admin.surat.index', ['jenis' => $key]) }}"
                            class="jenis-card text-decoration-none
                            {{ request('jenis') == $key ? 'active-jenis' : '' }}"
                            data-jenis="{{ strtolower($item['label']) }}"
                        >

                            <div class="d-flex align-items-center justify-content-between">

                                <div class="d-flex align-items-center gap-3">

                                    <div class="jenis-icon">

                                        <i class="fas {{ $item['icon'] }}"></i>

                                    </div>

                                    <div class="jenis-title">

                                        {{ $item['label'] }}

                                    </div>

                                </div>

                                <span class="badge rounded-pill bg-primary">

                                    {{ $count }}

                                </span>

                            </div>

                        </a>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

    <!-- ================= FILTER ================= -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h5 class="fw-bold text-dark mb-1">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Rekap Pengajuan
                    </h5>

                    <small class="text-muted">
                        Filter data berdasarkan periode
                    </small>

                </div>

                <div class="d-flex flex-wrap gap-2">

                    <a href="{{ route('admin.surat.index', [
                        'jenis' => request('jenis'),
                        'filter' => 'hari_ini'
                    ]) }}"
                       class="btn-filter {{ request('filter') == 'hari_ini' ? 'active-filter' : '' }}">

                        Hari Ini

                    </a>

                    <a href="{{ route('admin.surat.index', [
                        'jenis' => request('jenis'),
                        'filter' => 'minggu'
                    ]) }}"
                       class="btn-filter {{ request('filter') == 'minggu' ? 'active-filter' : '' }}">

                        Minggu Ini

                    </a>

                    <a href="{{ route('admin.surat.index', [
                        'jenis' => request('jenis'),
                        'filter' => 'bulan'
                    ]) }}"
                       class="btn-filter {{ request('filter') == 'bulan' ? 'active-filter' : '' }}">

                        Bulan Ini

                    </a>

                    <a href="{{ route('admin.surat.index', [
                        'jenis' => request('jenis'),
                        'filter' => 'tahun'
                    ]) }}"
                       class="btn-filter {{ request('filter') == 'tahun' ? 'active-filter' : '' }}">

                        Tahun Ini

                    </a>

                    <a href="{{ route('admin.surat.index', [
                        'jenis' => request('jenis')
                    ]) }}"
                       class="btn-filter {{ request('filter') == null ? 'active-filter' : '' }}">

                        Semua

                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- ================= STATS ================= -->
    @php

        $jenis = request('jenis', 'domisili');

        $proses = \DB::table('pengajuan_' . $jenis)
            ->where('status', 'proses')
            ->count();

        $selesai = \DB::table('pengajuan_' . $jenis)
            ->where('status', 'selesai')
            ->count();

        $ditolak = \DB::table('pengajuan_' . $jenis)
            ->where('status', 'ditolak')
            ->count();

        $total = \DB::table('pengajuan_' . $jenis)
            ->count();

    @endphp

    <div class="row mb-4">

        <div class="col-xl-3 col-md-6 mb-3">

            <div class="stats-box stats-blue">

                <div>

                    <div class="stats-label">
                        Sedang Diproses
                    </div>

                    <div class="stats-number">
                        {{ $proses }}
                    </div>

                </div>

                <i class="fas fa-spinner"></i>

            </div>

        </div>

        <div class="col-xl-3 col-md-6 mb-3">

            <div class="stats-box stats-green">

                <div>

                    <div class="stats-label">
                        Selesai
                    </div>

                    <div class="stats-number">
                        {{ $selesai }}
                    </div>

                </div>

                <i class="fas fa-check-circle"></i>

            </div>

        </div>

        <div class="col-xl-3 col-md-6 mb-3">

            <div class="stats-box stats-red">

                <div>

                    <div class="stats-label">
                        Ditolak
                    </div>

                    <div class="stats-number">
                        {{ $ditolak }}
                    </div>

                </div>

                <i class="fas fa-times-circle"></i>

            </div>

        </div>

        <div class="col-xl-3 col-md-6 mb-3">

            <div class="stats-box stats-cyan">

                <div>

                    <div class="stats-label">
                        Total Pengajuan
                    </div>

                    <div class="stats-number">
                        {{ $total }}
                    </div>

                </div>

                <i class="fas fa-file-alt"></i>

            </div>

        </div>

    </div>

    <!-- ================= ALERT ================= -->
    @if(session('success'))

        <div class="alert alert-success border-0 shadow-sm">

            <i class="fas fa-check-circle me-2"></i>

            {{ session('success') }}

        </div>

    @endif

    <!-- ================= TABLE ================= -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <h5 class="fw-bold text-primary mb-0">

                    <i class="fas fa-list me-2"></i>

                    Daftar Pengajuan
                    {{ strtoupper(request('jenis', 'domisili')) }}

                </h5>

                <div class="search-modern small-search">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        id="searchTable"
                        placeholder="Cari nama / NIK..."
                    >

                </div>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle modern-table" id="dataTable">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Pemohon</th>
                            <th>NIK</th>
                            <th>Tanggal</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($data as $index => $row)

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>

                                    <div class="fw-bold">
                                        {{ $row->nama_lengkap ?? $row->nama_pelapor ?? '-' }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $row->no_hp ?? '-' }}
                                    </small>

                                </td>

                                <td>
                                    {{ $row->nik ?? $row->nik_pelapor ?? '-' }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($row->tanggal_pengajuan)->format('d M Y') }}
                                </td>

                                <td>

                                    @if($row->metode_pengambilan == 'cetak_online')

                                        <span class="badge bg-info">

                                            <i class="fas fa-download me-1"></i>
                                            Online

                                        </span>

                                    @else

                                        <span class="badge bg-purple">

                                            <i class="fas fa-store me-1"></i>
                                            Ambil Desa

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($row->status == 'proses')

                                        <span class="badge bg-warning text-dark">

                                            <i class="fas fa-spinner fa-spin me-1"></i>
                                            Proses

                                        </span>

                                    @elseif($row->status == 'selesai')

                                        <span class="badge bg-success">

                                            <i class="fas fa-check me-1"></i>
                                            Selesai

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            <i class="fas fa-times me-1"></i>
                                            Ditolak

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a href="{{ route('admin.surat.detail', [
                                        'jenis' => request('jenis'),
                                        'id' => $row->id
                                    ]) }}"
                                       class="btn btn-primary btn-sm rounded-pill px-3">

                                        <i class="fas fa-eye me-1"></i>
                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-5">

                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>

                                    <div class="text-muted">
                                        Belum ada pengajuan surat
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<style>

body {

    background: rgb(244, 247, 251);
}

/* ================= HEADER ================= */

.dashboard-header {

    background: #bdddff;

    border-radius: 18px;

    padding: 24px;

    box-shadow:
        0 4px 20px rgba(
            0,
            0,
            0,
            0.05
        );
}

/* ================= SEARCH ================= */

.search-modern {

    background: #f1f5f9;

    border-radius: 50px;

    padding: 10px 16px;

    display: flex;

    align-items: center;

    gap: 10px;
}

.search-modern input {

    border: none;

    background: transparent;

    outline: none;

    width: 180px;
}

.small-search input {

    width: 160px;
}

/* ================= PROFILE (✅ UPDATED) ================= */

.profile-wrapper {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 8px 16px;

    background: white;

    border-radius: 999px;

    box-shadow: 0 2px 8px rgba(0,0,0,0.04);

    white-space: nowrap;
}

.profile-info {

    text-align: right;
}

.profile-info .name {

    font-weight: 600;

    font-size: 14px;

    color: #1e293b;
}

.profile-info .role {

    font-size: 12px;

    color: #94a3b8;
}

.profile-avatar {

    width: 40px;

    height: 40px;

    border-radius: 999px;

    background: linear-gradient(
        135deg,
        #f97316,
        #fb923c
    );

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: 600;

    font-size: 16px;

    color: white;

    overflow: hidden;

    flex-shrink: 0;

    text-decoration: none !important;
}

.profile-avatar img {

    width: 100%;

    height: 100%;

    object-fit: cover;
}

/* ================= JENIS CARD ================= */

.jenis-card {

    background: white;

    border: 1px solid #848484;

    border-radius: 16px;

    padding: 18px;

    display: block;

    transition: .3s;
}

.jenis-card:hover {

    transform: translateY(-3px);

    box-shadow:
        0 10px 25px rgba(
            0,
            0,
            0,
            0.08
        );
}

.active-jenis {

    background: linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );

    color: white !important;

    border: none;
}

.jenis-icon {

    width: 42px;

    height: 42px;

    border-radius: 12px;

    background: rgba(
        37,
        99,
        235,
        0.1
    );

    display: flex;

    align-items: center;

    justify-content: center;

    color: #2563eb;
}

.active-jenis .jenis-icon {

    background: rgba(
        255,
        255,
        255,
        0.2
    );

    color: white;
}

.jenis-title {

    font-weight: 600;
}

/* ================= FILTER ================= */

.btn-filter {

    background: #f1f5f9;

    padding: 10px 18px;

    border-radius: 12px;

    text-decoration: none;

    color: #334155;

    font-size: 13px;

    font-weight: 600;

    transition: .3s;
}

.btn-filter:hover {

    background: #2563eb;

    color: white;
}

.active-filter {

    background: linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    ) !important;

    color: white !important;
}

/* ================= STATS ================= */

.stats-box {

    border-radius: 20px;

    padding: 24px;

    color: white;

    display: flex;

    justify-content: space-between;

    align-items: center;

    box-shadow:
        0 10px 25px rgba(
            0,
            0,
            0,
            0.08
        );
}

.stats-box i {

    font-size: 42px;

    opacity: .25;
}

.stats-label {

    font-size: 14px;

    font-weight: 600;
}

.stats-number {

    font-size: 34px;

    font-weight: bold;
}

.stats-blue {

    background: linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );
}

.stats-green {

    background: linear-gradient(
        135deg,
        #10b981,
        #34d399
    );
}

.stats-red {

    background: linear-gradient(
        135deg,
        #ef4444,
        #f87171
    );
}

.stats-cyan {

    background: linear-gradient(
        135deg,
        #06b6d4,
        #22d3ee
    );
}

/* ================= TABLE ================= */

.modern-table thead {

    background: #f8fafc;
}

.modern-table thead th {

    border: none;

    padding: 18px;

    color: #334155;
}

.modern-table tbody td {

    padding: 18px;

    vertical-align: middle;
}

.modern-table tbody tr {

    transition: .2s;
}

.modern-table tbody tr:hover {

    background: #f8fbff;
}

.bg-purple {

    background: #7c3aed !important;
}

/* ================= RESPONSIVE ================= */

@media(max-width: 768px){

    .dashboard-header {

        padding: 18px;
    }

    .search-modern input {

        width: 100px;
    }

}

</style>

<script>

// ================= SEARCH JENIS =================

document
.getElementById('searchJenisSurat')
?.addEventListener('keyup', function(){

    let value = this.value.toLowerCase();

    document
    .querySelectorAll('.jenis-card')
    .forEach(function(item){

        let jenis = item.dataset.jenis;

        item.parentElement.style.display =
            jenis.includes(value)
            ? 'block'
            : 'none';

    });

});

// ================= SEARCH TABLE =================

document
.getElementById('searchTable')
?.addEventListener('keyup', function(){

    let value = this.value.toLowerCase();

    document
    .querySelectorAll('#dataTable tbody tr')
    .forEach(function(row){

        row.style.display =
            row.innerText.toLowerCase().includes(value)
            ? ''
            : 'none';

    });

});

</script>

@endsection