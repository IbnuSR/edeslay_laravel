@extends('layouts.app')

@section('content')
<!-- Header Section dengan Style Baru -->
<div class="modern-header">
    <div class="header-left">
        <h1 class="header-title">Pengajuan Surat Online</h1>
        <div class="breadcrumb">
            Dashboard / Pengajuan Surat / {{ ucfirst(request('jenis', 'domisili')) }}
        </div>
    </div>
    
    <div class="header-right">
        <!-- Tombol Cetak Laporan -->
        <a href="{{ route('admin.surat.print', ['jenis' => request('jenis', 'domisili')]) }}" 
           target="_blank" 
           class="btn-print-laporan">
            <i class="fas fa-print"></i>
            <span>Cetak Laporan</span>
        </a>
        
        <!-- Search Jenis Surat -->
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchJenisSurat" placeholder="Cari Jenis Surat...">
        </div>
        
        <!-- ✅ User Profile - PAKAI VARIABEL GLOBAL DARI AppServiceProvider -->
        <div class="user-profile">
            <div class="user-info">
                <div class="user-name">{{ $namaAdmin ?? 'Administrator Desa Banjardowo' }}</div>
                <div class="user-role">{{ $roleAdmin ?? 'admin' }}</div>
            </div>
            <a href="{{ route('admin.profile') }}" class="user-avatar">
                @if($fotoProfilSrc ?? false)
                    <img src="{{ $fotoProfilSrc }}" alt="Foto" onerror="this.parentElement.innerHTML='{{ $inisialAdmin ?? 'A' }}'">
                @else
                    {{ $inisialAdmin ?? 'A' }}
                @endif
            </a>
        </div>
    </div>
</div>

<div class="container-fluid px-4 py-4">
    <!-- Tab Navigation -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body p-3">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;" id="jenisSuratGrid">
                @php
                    $jenisSurat = [
                        'domisili' => ['icon' => 'fa-home', 'label' => 'Surat Domisili'],
                        'sktm' => ['icon' => 'fa-hand-holding-heart', 'label' => 'SKTM'],
                        'penghasilan' => ['icon' => 'fa-money-bill-wave', 'label' => 'Surat Penghasilan'],
                        'kelahiran' => ['icon' => 'fa-baby', 'label' => 'Surat Kelahiran'],
                        'ktp' => ['icon' => 'fa-id-card', 'label' => 'Surat KTP'],
                        'kematian' => ['icon' => 'fa-pray', 'label' => 'Surat Kematian'],
                        'izin' => ['icon' => 'fa-file-contract', 'label' => 'Izin Kegiatan'],
                        'nikah' => ['icon' => 'fa-ring', 'label' => 'Surat Nikah']
                    ];
                @endphp

                @foreach($jenisSurat as $key => $item)
                <a href="{{ route('admin.surat.index', ['jenis' => $key]) }}" 
                   class="jenis-surat-item d-flex align-items-center justify-content-center p-3 rounded text-decoration-none transition-all
                          {{ request('jenis') == $key ? 'bg-primary text-white shadow' : 'bg-white text-gray-600 border hover-bg-light' }}"
                   data-jenis="{{ $item['label'] }}"
                   style="min-height: 60px; font-weight: 500;">
                    <i class="fas {{ $item['icon'] }} me-2"></i>
                    <span>{{ $item['label'] }}</span>
                    <span class="badge ms-2 {{ request('jenis') == $key ? 'bg-light text-primary' : 'bg-primary' }}">
                        @php 
                            $count = 0;
                            try {
                                $count = \DB::table('pengajuan_' . $key)->count();
                            } catch (\Exception $e) { $count = 0; }
                            echo $count;
                        @endphp
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sedang Diproses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php 
                                    $jenis = request('jenis', 'domisili'); 
                                    $proses = 0;
                                    try {
                                        $proses = \DB::table('pengajuan_' . $jenis)->where('status', 'proses')->count();
                                    } catch (\Exception $e) { $proses = 0; }
                                @endphp
                                {{ $proses }}
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-spinner fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php 
                                    $selesai = 0;
                                    try {
                                        $selesai = \DB::table('pengajuan_' . $jenis)->where('status', 'selesai')->count();
                                    } catch (\Exception $e) { $selesai = 0; }
                                @endphp
                                {{ $selesai }}
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php 
                                    $ditolak = 0;
                                    try {
                                        $ditolak = \DB::table('pengajuan_' . $jenis)->where('status', 'ditolak')->count();
                                    } catch (\Exception $e) { $ditolak = 0; }
                                @endphp
                                {{ $ditolak }}
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pengajuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php 
                                    $total = 0;
                                    try {
                                        $total = \DB::table('pengajuan_' . $jenis)->count();
                                    } catch (\Exception $e) { $total = 0; }
                                @endphp
                                {{ $total }}
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Table Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Pengajuan {{ ucfirst(request('jenis', 'domisili')) }}
            </h6>
            <div>
                <input type="text" id="searchTable" class="form-control form-control-sm" placeholder="Cari Nama/NIK..." style="width: 200px;">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Pemohon</th>
                            <th width="15%">NIK</th>
                            <th width="12%">No. HP</th>
                            <th width="12%">Tanggal</th>
                            <th width="12%">Metode</th>
                            <th width="12%">Status</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- ✅ PAKAI $data ?? [] AGAR TIDAK ERROR JIKA NULL --}}
                        @forelse($data ?? [] as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $row->nama_lengkap ?? $row->nama_pelapor ?? '-' }}</div>
                                <small class="text-muted">{{ $row->no_hp ?? '-' }}</small>
                            </td>
                            <td>{{ $row->nik ?? $row->nik_pelapor ?? '-' }}</td>
                            <td>{{ $row->no_hp ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->tanggal_pengajuan ?? now())->format('d/m/Y') }}</td>
                            <td>
                                @if(($row->metode_pengambilan ?? '') == 'cetak_online')
                                    <span class="badge bg-info"><i class="fas fa-download me-1"></i>Online</span>
                                @else
                                    <span class="badge bg-purple"><i class="fas fa-store me-1"></i>Ambil Desa</span>
                                @endif
                            </td>
                            <td>
                                @if(($row->status ?? '') == 'proses')
                                    <span class="badge bg-warning text-dark"><i class="fas fa-spinner fa-spin me-1"></i>Proses</span>
                                @elseif(($row->status ?? '') == 'selesai')
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Selesai</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.surat.detail', ['jenis' => request('jenis'), 'id' => $row->id ?? 0]) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted">Belum ada pengajuan surat {{ ucfirst(request('jenis', 'domisili')) }}</p>
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
    /* Modern Header Style */
    .modern-header {
        background: linear-gradient(135deg, #e3f2fd 0%, #f5f9ff 100%);
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .header-left { flex: 1; }
    .header-title { font-size: 28px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0; }
    .breadcrumb { font-size: 14px; color: #64748b; font-weight: 500; }
    .breadcrumb span { color: #94a3b8; }
    .header-right { display: flex; align-items: center; gap: 16px; }
    
    /* Tombol Cetak Laporan */
    .btn-print-laporan {
        background: linear-gradient(135deg, #4e73df, #2f80ed);
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(78, 115, 223, 0.3);
        transition: all 0.3s ease;
    }
    .btn-print-laporan:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.4);
    }
    .btn-print-laporan i { font-size: 16px; }
    
    .search-box {
        background: white;
        border-radius: 50px;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        min-width: 280px;
    }
    .search-box i { color: #94a3b8; font-size: 16px; }
    .search-box input {
        border: none; outline: none; font-size: 14px; width: 100%; color: #64748b;
    }
    .search-box input::placeholder { color: #94a3b8; }
    
    /* ✅ User Profile Style */
    .user-profile {
        background: white;
        border-radius: 50px;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        text-decoration: none !important;
    }
    .user-info { text-align: right; }
    .user-name { font-size: 14px; font-weight: 600; color: #1e293b; }
    .user-role { font-size: 12px; color: #94a3b8; }
    .user-avatar {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #f97316, #fb923c);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: 16px;
        overflow: hidden; flex-shrink: 0; text-decoration: none !important;
    }
    .user-avatar img { width: 100%; height: 100%; object-fit: cover; }
    
    /* Existing Styles */
    .border-left-primary { border-left: 4px solid #4e73df !important; }
    .border-left-success { border-left: 4px solid #1cc88a !important; }
    .border-left-danger { border-left: 4px solid #e74a3b !important; }
    .border-left-info { border-left: 4px solid #36b9cc !important; }
    .bg-purple { background-color: #6f42c1 !important; }
    .transition-all { transition: all 0.3s ease; }
    .hover-bg-light:hover { background-color: #f8f9fa !important; transform: translateY(-2px); }
</style>

<script>
// 1. Search Jenis Surat (Header) - Auto Redirect
document.getElementById('searchJenisSurat')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        var search = this.value.toLowerCase().trim();
        var mapping = {
            'domisili': 'domisili', 'sktm': 'sktm', 'penghasilan': 'penghasilan',
            'kelahiran': 'kelahiran', 'ktp': 'ktp', 'kematian': 'kematian',
            'izin': 'izin', 'nikah': 'nikah'
        };
        for (var key in mapping) {
            if (key.includes(search) || search.includes(key)) {
                window.location.href = '{{ route('admin.surat.index') }}?jenis=' + mapping[key];
                return;
            }
        }
        alert('Jenis surat tidak ditemukan. Coba: domisili, sktm, ktp, kelahiran, kematian, izin, nikah, penghasilan');
    }
});

// 2. Search Tabel - Filter Nama/NIK
document.getElementById('searchTable')?.addEventListener('keyup', function() {
    var search = this.value.toLowerCase();
    var rows = document.querySelectorAll('#dataTable tbody tr');
    rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
});
</script>
@endsection