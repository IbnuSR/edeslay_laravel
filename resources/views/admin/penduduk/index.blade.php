@extends('layouts.app')

@section('content')

<style>
    /* ===== RESET LINK DEFAULT ===== */
    a { text-decoration: none !important; color: inherit; }
    
    /* ===== MAIN CONTENT ===== */
    .main-container { 
        padding: 20px 30px; width: 100%; max-width: 100%;
        background: #f5f9ff; box-sizing: border-box;
    }
    
    /* ===== TOP BAR ===== */
    .top-bar { 
        display: flex; align-items: center; justify-content: space-between; 
        margin-bottom: 30px; background: #bdddff; padding: 20px 30px;
        border-radius: 16px; flex-wrap: wrap; gap: 20px;
    }
    .page-header h1 { font-size: 26px; font-weight: 700; color: #1e293b; margin-bottom: 4px; margin-top: 0; }
    .breadcrumb { font-size: 13px; color: #94a3b8; }
    .search-wrapper { display: flex; align-items: center; gap: 20px; flex: 1; justify-content: flex-end; }
    .search-box { 
        background: white; border-radius: 999px; padding: 12px 24px; 
        display: flex; align-items: center; gap: 12px; width: 270px;
        max-width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .search-box input { 
        border: none; outline: none; background: transparent; flex: 1; 
        font-size: 14px; color: #334155; min-width: 0;
    }
    .search-box input::placeholder { color: #94a3b8; }
    .profile-wrapper { 
        display: flex; align-items: center; gap: 12px; padding: 8px 16px;
        background: white; border-radius: 999px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); white-space: nowrap;
    }
    .profile-avatar { 
        width: 40px; height: 40px; border-radius: 999px; 
        background: linear-gradient(135deg, #f97316, #fb923c);
        display: flex; align-items: center; justify-content: center; 
        font-weight: 600; font-size: 16px; color: white;
        overflow: hidden; flex-shrink: 0; text-decoration: none !important;
    }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-info { text-align: right; }
    .profile-info .name { font-weight: 600; font-size: 14px; color: #1e293b; }
    .profile-info .role { font-size: 12px; color: #94a3b8; }
    
    /* ===== STATS CARDS ===== */
    .stats-row { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); 
        gap: 20px; 
        margin-bottom: 30px; 
    }
    .stat-card { 
        background: white; 
        border-radius: 14px; 
        padding: 20px; 
        box-shadow: 0 6px 16px rgba(15,23,42,0.06); 
        display: flex; 
        align-items: center; 
        gap: 16px; 
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); }
    .stat-icon-box { 
        width: 52px; height: 52px; border-radius: 14px; 
        background: #f0f4ff; display: flex; align-items: center; justify-content: center; 
        color: #1976d2; font-size: 22px; 
    }
    .stat-label { font-size: 13px; color: #6b7280; font-weight: 500;}
    .stat-value { font-size: 26px; font-weight: 700; margin-top: 4px; color: #1e293b; }
    
    /* ===== CONTENT CARD ===== */
    .content-card { 
        background: white; border-radius: 20px; padding: 30px; 
        box-shadow: 0 2px 12px rgba(0,0,0,0.04); width: 100%; box-sizing: border-box;
    }
    .card-header { 
        display: flex; justify-content: space-between; align-items: center; 
        margin-bottom: 24px; flex-wrap: wrap; gap: 16px;
    }
    .card-header h2 { margin: 0; font-size: 20px; font-weight: 700; color: #1e293b; }
    
    /* ===== FILTER BOX ===== */
    .filter-box {
        background: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 24px;
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 12px;
        align-items: end;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #2f80ed;
        box-shadow: 0 0 0 3px rgba(47, 128, 237, 0.1);
    }
    .btn-filter {
        background: #2b6cb0;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-filter:hover { background: #2563eb; }
    
    /* ===== TABLE ===== */
    .table-container { overflow-x: auto; width: 100%; }
    table { width: 100%; border-collapse: collapse; min-width: 1000px; }
    th { 
        padding: 16px; text-align: left; font-weight: 600; color: #64748b;
        font-size: 13px; border-bottom: 2px solid #e3f2fd; white-space: nowrap;
    }
    td { 
        padding: 20px 16px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;
        font-size: 14px; color: #334155;
    }
    tbody tr:hover { background: #f8fafc; }
    
    .aksi-col { width: 120px; text-align: center; }
    .aksi-buttons { display: flex; gap: 8px; justify-content: center; align-items: center; }
    .btn-icon { 
        width: 36px; height: 36px; border-radius: 8px; border: none !important; 
        cursor: pointer; display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.3s; background: transparent; text-decoration: none;
    }
    .btn-edit { color: #2563eb; background: #dbeafe; }
    .btn-edit:hover { background: #2563eb; color: white; transform: scale(1.1); }
    .btn-delete { color: #ef4444; background: #fee2e2; }
    .btn-delete:hover { background: #ef4444; color: white; transform: scale(1.1); }
    
    /* ===== PAGINATION ===== */
    .pagination {
        padding: 20px 0 0 0;
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .pagination a,
    .pagination span {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        text-decoration: none;
        color: #475569;
        transition: all 0.2s;
    }
    .pagination a:hover {
        background: #2b6cb0;
        color: white;
        border-color: #2b6cb0;
    }
    .pagination .active {
        background: #2b6cb0;
        color: white;
        border-color: #2b6cb0;
    }
    
    /* ===== ALERT ===== */
    .alert { 
        margin-bottom: 20px; padding: 14px 20px; border-radius: 12px; 
        font-size: 14px; font-weight: 500;
    }
    .alert-success { background: #dcfce7; color: #166534; border: 2px solid #86efac; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 2px solid #fca5a5; }
    
    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 1024px) {
        .main-container { padding: 15px 20px; }
        .top-bar { flex-direction: column; align-items: stretch; padding: 15px 20px; }
        .search-wrapper { flex-direction: column; width: 100%; }
        .search-box { width: 100%; }
        .profile-wrapper { justify-content: center; width: 100%; }
        .filter-grid { grid-template-columns: 1fr; }
        .stats-row { grid-template-columns: repeat(2, 1fr); }
    }
    
    @media (max-width: 768px) {
        .main-container { padding: 10px 15px; }
        .content-card { padding: 20px 15px; }
        .stats-row { grid-template-columns: 1fr; }
        .page-header h1 { font-size: 22px; }
        table { font-size: 12px; }
        th, td { padding: 12px 8px; }
    }
    
    @media (max-width: 480px) {
        .stat-value { font-size: 20px; }
        .stat-icon-box { width: 40px; height: 40px; font-size: 18px; }
    }
</style>

<div class="main-container">
    {{-- TOP BAR --}}
    <div class="top-bar">
        <div class="page-header">
            <h1>Data Penduduk</h1>
            <div class="breadcrumb">Dashboard / Data Penduduk</div>
        </div>
        
        <div class="search-wrapper">
            {{-- Search Box --}}
            <form method="get" action="{{ route('admin.penduduk.index') }}" class="search-box">
                <i class="fas fa-search" style="color: #94a3b8;"></i>
                <input type="text" name="search" placeholder="Cari NIK / Nama" value="{{ old('search', $search ?? '') }}">
            </form>
            
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

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">⚠️ {{ session('error') }}</div>
    @endif

    {{-- STATS CARDS --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon-box">👥</div>
            <div>
                <div class="stat-label">Total Penduduk</div>
                <div class="stat-value">{{ number_format($stats['total']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-box" style="background: #dcfce7; color: #16a34a;">👨</div>
            <div>
                <div class="stat-label">Laki-laki</div>
                <div class="stat-value">{{ number_format($stats['laki']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-box" style="background: #fce7f3; color: #db2777;">👩</div>
            <div>
                <div class="stat-label">Perempuan</div>
                <div class="stat-value">{{ number_format($stats['perempuan']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-box" style="background: #e9d5ff; color: #9333ea;">🏘️</div>
            <div>
                <div class="stat-label">Jumlah Dusun</div>
                <div class="stat-value">{{ number_format($stats['dusun_count']) }}</div>
            </div>
        </div>
    </div>

    {{-- CONTENT CARD --}}
    <div class="content-card">
        {{-- CARD HEADER (SUDAH DIGABUNG - TANPA DUPLIKAT) --}}
        <div class="card-header">
            <h2>Daftar Data Penduduk</h2>
            <div style="display: flex; gap: 12px;">
                {{-- Tombol Import --}}
                <a href="{{ route('admin.penduduk.import') }}" 
                   style="background: #10b981; color: white; padding: 12px 24px; border-radius: 10px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    📥 Import Excel
                </a>
                {{-- Tombol Tambah Data --}}
                <a href="{{ route('admin.penduduk.create') }}" 
                   style="background: linear-gradient(135deg, #2b6cb0, #2f80ed); color: white; padding: 12px 24px; border-radius: 10px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    ➕ Tambah Data
                </a>
            </div>
        </div>

        {{-- FILTER BOX --}}
        <form method="GET" class="filter-box">
            <div class="filter-grid">
                <div class="form-group">
                    <label>Cari NIK / Nama / Pekerjaan</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Masukkan kata kunci..." value="{{ $search }}">
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control">
                        <option value="">Semua</option>
                        <option value="L" {{ $filter_jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $filter_jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pendidikan</label>
                    <select name="pendidikan" class="form-control">
                        <option value="">Semua</option>
                        <option value="SD" {{ $filter_pendidikan == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ $filter_pendidikan == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ $filter_pendidikan == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="S1" {{ $filter_pendidikan == 'S1' ? 'selected' : '' }}>S1</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Dusun</label>
                    <input type="text" name="dusun" class="form-control" 
                           placeholder="Nama dusun" value="{{ $filter_dusun }}">
                </div>
                <button type="submit" class="btn-filter">🔍 Filter</button>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>L/P</th>
                        <th>Tanggal Lahir</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                        <th>Dusun</th>
                        <th class="aksi-col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendudukList as $p)
                    <tr>
                        <td style="text-align: center; font-weight: 600; color: #64748b;">{{ $loop->iteration }}</td>
                        <td><strong>{{ $p->nik }}</strong></td>
                        <td>
                            <div style="font-weight: 600;">{{ $p->nama }}</div>
                            <div style="font-size: 12px; color: #94a3b8;">{{ $p->status_keluarga ?? '-' }}</div>
                        </td>
                        <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td style="font-size: 13px; color: #94a3b8;">
                            {{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('d/m/Y') : '-' }}
                        </td>
                        <td>{{ $p->pendidikan }}</td>
                        <td>{{ $p->pekerjaan ?? '-' }}</td>
                        <td>{{ $p->dusun ?? '-' }}</td>
                        <td class="aksi-col">
                            <div class="aksi-buttons">
                                <a href="{{ route('admin.penduduk.edit', $p) }}" class="btn-icon btn-edit" title="Edit">
                                    ✏️
                                </a>
                                <a href="{{ route('admin.penduduk.delete', $p) }}" class="btn-icon btn-delete" title="Hapus" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data penduduk {{ $p->nama }} (NIK: {{ $p->nik }})?')">
                                    🗑️
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px; color: #94a3b8;">
                            <div style="font-size: 48px; margin-bottom: 12px;">📭</div>
                            <div>Belum ada data penduduk</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($pendudukList->hasPages())
            <div class="pagination">
                {{ $pendudukList->links('pagination::simple-tailwind') }}
            </div>
        @endif
    </div>
</div>

@endsection