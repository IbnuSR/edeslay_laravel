@extends('layouts.app')

@section('content')
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, sans-serif; background: #f0f7ff; color: #333; }
    a { text-decoration: none; color: inherit; }
    .app { display: flex; min-height: 100vh; }
    
    /* ===== SIDEBAR ===== */
    .sidebar { 
        width: 280px; 
        background: linear-gradient(180deg, #1c3f9fff, #3B82F6); 
        padding: 30px 20px; 
        color: white; 
        position: fixed;
        height: 100vh;
        overflow-y: auto;
    }
    .sidebar-header { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    .sidebar-header img { height: 48px; width: auto; }
    .sidebar-header div { font-weight: 600; font-size: 16px; color: white; }
    .menu { display: flex; flex-direction: column; gap: 8px; }
    .menu-item { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        padding: 12px 16px; 
        border-radius: 12px; 
        font-size: 14px; 
        font-weight: 500;
        transition: all 0.3s;
        color: rgba(255,255,255,0.85);
    }
    .menu-item:hover { background: rgba(255,255,255,0.15); color: white; }
    .menu-item.active { background: #0ea5e9; color: white; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3); }
    .menu-item img { width: 20px; height: 20px; }
    .sidebar-footer { 
        position: absolute; 
        bottom: 30px; 
        left: 20px; 
        right: 20px; 
    }
    .sidebar-footer .logout { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        padding: 12px 16px; 
        color: rgba(255,255,255,0.85);
        border-radius: 12px;
        transition: all 0.3s;
        cursor: pointer;
    }
    .sidebar-footer .logout:hover { background: rgba(255,255,255,0.15); color: white; }
    .sidebar-footer .logout img { width: 20px; height: 20px; }
    
    /* ===== MAIN CONTENT ===== */
    .main { 
        margin-left: 280px; 
        padding: 30px 40px; 
        flex: 1; 
        background: #f0f7ff;
        min-height: 100vh;
    }
    
    /* ===== TOP BAR ===== */
    .top-bar { 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        margin-bottom: 30px;
        background: white;
        padding: 20px 30px;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .page-header h1 { 
        font-size: 24px; 
        font-weight: 700; 
        color: #1e293b;
        margin-bottom: 4px;
    }
    .breadcrumb { 
        font-size: 13px; 
        color: #94a3b8;
    }
    .search-wrapper { 
        display: flex; 
        align-items: center; 
        gap: 20px;
    }
    .search-box { 
        background: #f8fafc; 
        border-radius: 999px; 
        padding: 12px 24px; 
        display: flex; 
        align-items: center; 
        gap: 12px;
        width: 350px;
        border: 2px solid transparent;
        transition: all 0.3s;
    }
    .search-box:focus-within { 
        border-color: #3B82F6; 
        background: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .search-box input { 
        border: none; 
        outline: none; 
        background: transparent; 
        flex: 1; 
        font-size: 14px;
        color: #334155;
    }
    .profile-wrapper { 
        display: flex; 
        align-items: center; 
        gap: 12px;
        padding: 8px 16px;
        background: #f8fafc;
        border-radius: 999px;
    }
    .profile-avatar { 
        width: 40px; 
        height: 40px; 
        border-radius: 999px; 
        background: linear-gradient(135deg, #f97316, #fb923c);
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-weight: 600; 
        font-size: 16px; 
        color: white;
        overflow: hidden;
    }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-info { text-align: right; }
    .profile-info .name { font-weight: 600; font-size: 14px; color: #1e293b; }
    .profile-info .role { font-size: 12px; color: #94a3b8; }
    
    /* ===== CONTENT CARD ===== */
    .content-card { 
        background: white; 
        border-radius: 20px; 
        padding: 30px; 
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .card-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 24px;
    }
    .btn-tambah { 
        background: linear-gradient(135deg, #0ea5e9, #3B82F6); 
        color: white; 
        border-radius: 12px; 
        padding: 12px 24px; 
        font-size: 14px; 
        border: none; 
        cursor: pointer; 
        font-weight: 600; 
        display: flex; 
        align-items: center; 
        gap: 8px;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
    }
    .btn-tambah:hover { 
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
    }
    
    /* ===== TABLE ===== */
    .table-container { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th { 
        padding: 16px; 
        text-align: left; 
        font-weight: 600; 
        color: #64748b;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }
    td { 
        padding: 20px 16px; 
        vertical-align: middle; 
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #334155;
    }
    tbody tr:hover { background: #f8fafc; }
    .no-col { width: 60px; text-align: center; font-weight: 600; color: #64748b; }
    .img-col { width: 80px; }
    .foto-item { 
        width: 60px; 
        height: 60px; 
        border-radius: 12px; 
        object-fit: cover; 
        background: #f1f5f9;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .judul-link { 
        color: #1e293b; 
        font-weight: 600;
        transition: color 0.3s;
    }
    .judul-link:hover { color: #3B82F6; }
    .deskripsi-text { 
        color: #64748b; 
        font-size: 13px;
        line-height: 1.6;
        max-width: 400px;
    }
    .tanggal-text { 
        font-size: 13px; 
        color: #94a3b8;
        font-weight: 500;
    }
    .aksi-col { 
        width: 100px; 
        text-align: center; 
    }
    .aksi-buttons { 
        display: flex; 
        gap: 8px; 
        justify-content: center;
        align-items: center;
    }
    .btn-icon { 
        width: 36px; 
        height: 36px; 
        border-radius: 8px; 
        border: none; 
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    .btn-edit { 
        background: #fef3c7; 
        color: #f59e0b;
    }
    .btn-edit:hover { 
        background: #fde68a; 
        transform: scale(1.1);
    }
    .btn-delete { 
        background: #fee2e2; 
        color: #ef4444;
    }
    .btn-delete:hover { 
        background: #fecaca; 
        transform: scale(1.1);
    }
    
    /* ===== FORM ===== */
    .form-wrapper { margin-top: 20px; }
    .form-grid { 
        display: grid; 
        grid-template-columns: 2fr 1fr; 
        gap: 30px; 
        margin-bottom: 24px;
    }
    .form-section { 
        background: #f8fafc; 
        padding: 28px; 
        border-radius: 16px; 
        border: 2px solid #e2e8f0;
    }
    .form-group { margin-bottom: 20px; }
    .form-group label { 
        display: block; 
        font-size: 14px; 
        font-weight: 600; 
        margin-bottom: 8px;
        color: #334155;
    }
    .form-group input[type="text"],
    .form-group textarea,
    .form-group input[type="date"] { 
        width: 100%; 
        padding: 12px 16px; 
        border-radius: 10px; 
        border: 2px solid #e2e8f0; 
        font-size: 14px;
        transition: all 0.3s;
        font-family: inherit;
    }
    .form-group input:focus,
    .form-group textarea:focus { 
        border-color: #3B82F6;
        outline: none;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .form-group textarea { min-height: 120px; resize: vertical; }
    
    /* ===== UPLOAD BOX ===== */
    .upload-container { 
        width: 100%; 
        min-height: 260px; 
        border: 2px dashed #cbd5e1; 
        border-radius: 16px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        cursor: pointer; 
        background: white;
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
    }
    .upload-container:hover { 
        border-color: #3B82F6; 
        background: #f8fafc;
    }
    .upload-preview { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        border-radius: 16px;
        z-index: 1;
    }
    .upload-placeholder { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        z-index: 2;
        color: #64748b;
    }
    .upload-placeholder i { 
        font-size: 48px; 
        color: #3B82F6; 
        margin-bottom: 12px;
    }
    .upload-placeholder span { 
        font-size: 15px; 
        font-weight: 600;
        color: #334155;
    }
    .upload-input { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        cursor: pointer; 
        opacity: 0;
        z-index: 3;
    }
    
    /* ===== BUTTONS ===== */
    .form-actions { 
        display: flex; 
        gap: 12px; 
        margin-top: 24px;
        padding-top: 24px;
        border-top: 2px solid #e2e8f0;
    }
    .btn-secondary { 
        border-radius: 10px; 
        padding: 12px 24px; 
        background: #e2e8f0; 
        border: none; 
        font-size: 14px; 
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        color: #475569;
    }
    .btn-secondary:hover { 
        background: #cbd5e1;
        transform: translateY(-2px);
    }
    .btn-primary { 
        background: linear-gradient(135deg, #10b981, #34d399); 
        color: white; 
        border-radius: 10px; 
        padding: 12px 24px; 
        border: none; 
        font-size: 14px; 
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    .btn-primary:hover { 
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    /* ===== DETAIL VIEW ===== */
    .detail-container { 
        background: white; 
        border-radius: 16px; 
        padding: 30px; 
        max-width: 800px;
        margin: 0 auto;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .detail-image { 
        width: 100%; 
        max-height: 450px; 
        object-fit: cover; 
        border-radius: 16px; 
        margin-bottom: 24px;
        background: #f1f5f9;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }
    .detail-header { margin-bottom: 24px; }
    .detail-date { 
        font-size: 14px; 
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .detail-title { 
        font-size: 26px; 
        font-weight: 700; 
        color: #1e293b;
        line-height: 1.3;
    }
    .detail-content { 
        font-size: 15px; 
        line-height: 1.8; 
        color: #475569;
    }
    .detail-content strong { color: #1e293b; font-weight: 600; }
    .detail-actions { 
        display: flex; 
        gap: 12px; 
        margin-top: 30px;
        padding-top: 24px;
        border-top: 2px solid #e2e8f0;
    }
    .btn-detail-edit { 
        background: linear-gradient(135deg, #0ea5e9, #3B82F6); 
        color: white;
        padding: 12px 24px; 
        border-radius: 10px; 
        border: none;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-detail-delete { 
        background: #fee2e2; 
        color: #ef4444;
        padding: 12px 24px; 
        border-radius: 10px; 
        border: none;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-detail-edit:hover, .btn-detail-delete:hover {
        transform: translateY(-2px);
    }
    
    /* ===== MODAL ===== */
    .modal-backdrop { 
        position: fixed; 
        inset: 0; 
        background: rgba(15, 23, 42, 0.5); 
        display: none; 
        align-items: center; 
        justify-content: center; 
        z-index: 9999;
        backdrop-filter: blur(4px);
    }
    .modal-content { 
        background: white; 
        border-radius: 20px; 
        padding: 40px; 
        width: 450px; 
        max-width: 90%; 
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        text-align: center;
        animation: modalSlide 0.3s ease;
    }
    @keyframes modalSlide {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .modal-icon { 
        width: 80px; 
        height: 80px; 
        border-radius: 999px; 
        background: #fee2e2;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        margin: 0 auto 20px;
        color: #ef4444;
        font-size: 40px;
    }
    .modal-title { 
        font-size: 24px; 
        font-weight: 700; 
        margin-bottom: 12px;
        color: #1e293b;
    }
    .modal-text { 
        font-size: 15px; 
        color: #64748b; 
        margin-bottom: 28px;
        line-height: 1.6;
    }
    .modal-actions { 
        display: flex; 
        justify-content: center; 
        gap: 12px;
    }
    .btn-modal-cancel { 
        background: #e2e8f0; 
        color: #475569;
        border: none; 
        border-radius: 10px; 
        padding: 12px 28px; 
        font-size: 14px; 
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-modal-cancel:hover { background: #cbd5e1; }
    .btn-modal-delete { 
        background: #ef4444; 
        color: white; 
        border: none; 
        border-radius: 10px; 
        padding: 12px 28px; 
        font-size: 14px; 
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-modal-delete:hover { background: #dc2626; }
    
    /* ===== ALERT ===== */
    .alert { 
        margin-bottom: 20px; 
        padding: 14px 20px; 
        border-radius: 12px; 
        font-size: 14px;
        font-weight: 500;
    }
    .alert-success { 
        background: #dcfce7; 
        color: #166534;
        border: 2px solid #86efac;
    }
    .alert-error { 
        background: #fee2e2; 
        color: #991b1b;
        border: 2px solid #fca5a5;
    }
    
    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .sidebar { width: 240px; padding: 20px 16px; }
        .main { margin-left: 240px; padding: 20px; }
        .form-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .sidebar { display: none; }
        .main { margin-left: 0; }
        .search-box { width: 200px; }
        .profile-info { display: none; }
    }
</style>

<div class="app">
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo">
            <div>Desa Banjardowo</div>
        </div>
        <div class="menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item">
                <i class="fas fa-th-large" style="font-size: 18px;"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.kegiatan') }}" class="menu-item active">
                <i class="fas fa-calendar-alt" style="font-size: 18px;"></i>
                Kegiatan Desa
            </a>
            <a href="{{ route('admin.prestasi') }}" class="menu-item">
                <i class="fas fa-trophy" style="font-size: 18px;"></i>
                Prestasi
            </a>
            <a href="{{ route('admin.saran') }}" class="menu-item">
                <i class="fas fa-envelope" style="font-size: 18px;"></i>
                Kotak Saran
            </a>
            <a href="{{ route('admin.pelayanan') }}" class="menu-item">
                <i class="fas fa-concierge-bell" style="font-size: 18px;"></i>
                Pelayanan
            </a>
        </div>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: inline;">
                @csrf
                <div class="logout" onclick="event.preventDefault(); confirmLogout();">
                    <i class="fas fa-sign-out-alt" style="font-size: 18px;"></i>
                    <span>Keluar</span>
                </div>
            </form>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main">
        @if($action === 'list')
        <div class="top-bar">
            <div class="page-header">
                <h1>Kegiatan Desa</h1>
                <div class="breadcrumb">Dashboard / Kegiatan Desa / Daftar Kegiatan</div>
            </div>
            <div class="search-wrapper">
                <form method="get" action="{{ route('admin.kegiatan') }}" class="search-box">
                    <input type="hidden" name="action" value="list">
                    <i class="fas fa-search" style="color: #94a3b8;"></i>
                    <input type="text" name="search" placeholder="Cari Kegiatan" value="{{ old('search', $search ?? '') }}">
                </form>
                <div class="profile-wrapper">
                    <div class="profile-info">
                        <div class="name">{{ $namaAdmin ?? 'Administrator' }}</div>
                        <div class="role">{{ $roleAdmin ?? 'admin' }}</div>
                    </div>
                    <a href="{{ route('admin.profile') }}" class="profile-avatar">
                        @if(isset($fotoProfilSrc) && $fotoProfilSrc)
                            <img src="{{ $fotoProfilSrc }}" alt="Foto">
                        @else
                            {{ substr($namaAdmin ?? 'A', 0, 1) }}
                        @endif
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($action === 'list')
            <div class="content-card">
                <div class="card-header">
                    <h2 style="font-size: 20px; font-weight: 700; color: #1e293b;">Daftar Kegiatan Desa</h2>
                    <a href="{{ route('admin.kegiatan', ['action' => 'tambah']) }}">
                        <button class="btn-tambah">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </a>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th class="no-col">No</th>
                                <th class="img-col">Foto</th>
                                <th>Nama Kegiatan Desa</th>
                                <th>Lokasi</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Perolehan</th>
                                <th class="aksi-col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kegiatanList as $row)
                                @php
                                    $fotoSrc = '';
                                    if (!empty($row->foto)) {
                                        $mime = $row->foto_type ?? 'image/jpeg';
                                        $raw = $row->foto;
                                        $isBase64 = preg_match('/^[A-Za-z0-9+\/=]+$/', $raw);
                                        $fotoSrc = $mime . ';base64,' . ($isBase64 ? $raw : base64_encode($raw));
                                    }
                                    
                                    $maxLength = 250;
                                    $desc = strip_tags($row->deskripsi);
                                    $shortDesc = strlen($desc) > $maxLength 
                                        ? substr($desc, 0, $maxLength) . '...' 
                                        : $desc;
                                @endphp
                                <tr>
                                    <td class="no-col">{{ $loop->iteration }}</td>
                                    <td>
                                        @if(!empty($fotoSrc))
                                            <img src="{{ $fotoSrc }}" alt="Foto" class="foto-item">
                                        @else
                                            <div class="foto-item" style="display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                                <i class="fas fa-image" style="font-size: 24px;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.kegiatan', ['action' => 'view', 'id' => $row->id]) }}" class="judul-link">
                                            {{ $row->judul }}
                                        </a>
                                    </td>
                                    <td>{{ $row->lokasi }}</td>
                                    <td>
                                        <div class="deskripsi-text">
                                            {!! nl2br(e($shortDesc)) !!}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tanggal-text">
                                            {{ \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y') }}
                                        </div>
                                    </td>
                                    <td class="aksi-col">
                                        <div class="aksi-buttons">
                                            <a href="{{ route('admin.kegiatan', ['action' => 'edit', 'id' => $row->id]) }}" title="Edit">
                                                <button class="btn-icon btn-edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            </a>
                                            <button class="btn-icon btn-delete" title="Hapus" onclick="openDeleteModal({{ $row->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.5;"></i>
                                        Belum ada data kegiatan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($action === 'view')
            <div class="content-card">
                <div class="card-header">
                    <h2 style="font-size: 20px; font-weight: 700; color: #1e293b;">Detail Kegiatan</h2>
                    <a href="{{ route('admin.kegiatan') }}">
                        <button class="btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                    </a>
                </div>

                @if(isset($detail) && $detail)
                    @php
                        $fotoSrc = '';
                        if (!empty($detail->foto)) {
                            $mime = $detail->foto_type ?? 'image/jpeg';
                            $raw = $detail->foto;
                            $isBase64 = preg_match('/^[A-Za-z0-9+\/=]+$/', $raw);
                            $fotoSrc = $mime . ';base64,' . ($isBase64 ? $raw : base64_encode($raw));
                        }
                    @endphp

                    <div class="detail-container">
                        @if(!empty($fotoSrc))
                            <img src="{{ $fotoSrc }}" alt="Foto Kegiatan" class="detail-image">
                        @else
                            <div class="detail-image" style="display: flex; align-items: center; justify-content: center; background: #f1f5f9; color: #94a3b8;">
                                <i class="fas fa-image" style="font-size: 80px; opacity: 0.3;"></i>
                            </div>
                        @endif

                        <div class="detail-header">
                            <div class="detail-date">
                                <i class="far fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($detail->tanggal)->isoFormat('D MMMM Y') }}
                            </div>
                            <h1 class="detail-title">{{ $detail->judul }}</h1>
                        </div>

                        <div class="detail-content">
                            <p><strong>Lokasi:</strong> {{ $detail->lokasi }}</p>
                            <p><strong>Deskripsi:</strong></p>
                            <p>{!! nl2br(e($detail->deskripsi)) !!}</p>
                        </div>

                        <div class="detail-actions">
                            <a href="{{ route('admin.kegiatan', ['action' => 'edit', 'id' => $detail->id]) }}" class="btn-detail-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button class="btn-detail-delete" onclick="openDeleteModal({{ $detail->id }})">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </div>
                    </div>
                @else
                    <div style="text-align: center; padding: 60px 20px; background: #f8fafc; border-radius: 16px;">
                        <i class="fas fa-exclamation-circle" style="font-size: 64px; color: #f59e0b; margin-bottom: 20px;"></i>
                        <h3 style="font-size: 20px; color: #1e293b; margin-bottom: 12px;">Data Tidak Ditemukan</h3>
                        <p style="color: #64748b; margin-bottom: 24px;">Kegiatan dengan ID ini tidak ada atau telah dihapus.</p>
                        <a href="{{ route('admin.kegiatan') }}" class="btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                @endif
            </div>
        @endif

        @if($action === 'tambah' || $action === 'edit')
            <div class="content-card">
                <div class="card-header">
                    <h2 style="font-size: 20px; font-weight: 700; color: #1e293b;">
                        {{ $page_title ?? ($action === 'tambah' ? 'Tambah Kegiatan Desa' : 'Edit Kegiatan Desa') }}
                    </h2>
                    <div class="breadcrumb">
                        Dashboard / Kegiatan Desa / {{ $action === 'tambah' ? 'Tambah' : 'Edit' }} Kegiatan
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.kegiatan') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="action" value="{{ $action }}">
                    @if(isset($edit) && $edit)
                        <input type="hidden" name="id" value="{{ $edit->id ?? '' }}">
                    @endif
                    
                    <div class="form-wrapper">
                        <div class="form-grid">
                            <div class="form-section">
                                <div class="form-group">
                                    <label>Nama Kegiatan</label>
                                    <input type="text" name="judul" required value="{{ old('judul', $edit->judul ?? '') }}" placeholder="Masukkan nama kegiatan">
                                </div>
                                <div class="form-group">
                                    <label>Lokasi</label>
                                    <input type="text" name="lokasi" required value="{{ old('lokasi', $edit->lokasi ?? '') }}" placeholder="Masukkan lokasi kegiatan">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" required placeholder="Masukkan deskripsi kegiatan">{{ old('deskripsi', $edit->deskripsi ?? '') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal" required value="{{ old('tanggal', $edit->tanggal ?? '') }}">
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="form-group">
                                    <label>Upload Foto Kegiatan</label>
                                    <div class="upload-container" id="uploadBox">
                                        @php
                                            $previewSrc = '';
                                            if (isset($edit) && !empty($edit->foto)) {
                                                $mime = $edit->foto_type ?? 'image/jpeg';
                                                $raw = $edit->foto;
                                                $isBase64 = preg_match('/^[A-Za-z0-9+\/=]+$/', $raw);
                                                $previewSrc = $mime . ';base64,' . ($isBase64 ? $raw : base64_encode($raw));
                                            }
                                        @endphp
                                        <img id="previewImg" class="upload-preview"
                                             src="{{ $previewSrc }}"
                                             style="{{ $previewSrc ? 'display:block;' : 'display:none;' }}"
                                             alt="Preview">
                                        <div class="upload-placeholder" id="uploadPlaceholder" style="{{ $previewSrc ? 'display:none;' : 'display:flex;' }}">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span>Klik untuk upload foto</span>
                                        </div>
                                        <input type="file" id="uploadFoto" name="foto" class="upload-input" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('admin.kegiatan') }}" class="btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" name="save_kegiatan" class="btn-primary">
                                <i class="fas fa-save"></i>
                                {{ $action === 'edit' ? 'Update Data' : 'Simpan Data' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

<!-- MODAL KONFIRMASI HAPUS -->
<div id="deleteModal" class="modal-backdrop">
    <div class="modal-content">
        <div class="modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 class="modal-title">Hapus Kegiatan?</h3>
        <p class="modal-text">
            Apakah Anda yakin ingin menghapus kegiatan ini?<br>
            Data yang sudah dihapus tidak dapat dikembalikan.
        </p>
        <div class="modal-actions">
            <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Batal</button>
            <button type="button" class="btn-modal-delete" onclick="confirmDelete()">Ya, Hapus</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let deleteId = null;
    function openDeleteModal(id){
        deleteId = id;
        const modal = document.getElementById('deleteModal');
        if (modal) modal.style.display = 'flex';
    }
    function closeDeleteModal(){
        deleteId = null;
        const modal = document.getElementById('deleteModal');
        if (modal) modal.style.display = 'none';
    }
    function confirmDelete(){
        if (deleteId) {
            window.location.href = '{{ route("admin.kegiatan") }}?action=delete&id=' + deleteId;
        }
    }
    
    // Preview gambar upload
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('uploadFoto');
        const previewImg = document.getElementById('previewImg');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        
        if (!fileInput || !previewImg) return;
        
        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                if (uploadPlaceholder) {
                    uploadPlaceholder.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        });
    });

    function confirmLogout() {
        Swal.fire({
            title: "Logout?",
            text: "Anda yakin ingin keluar dari dashboard admin?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, logout",
            cancelButtonText: "Batal",
            buttonsStyling: false,
            customClass: {
                popup: 'swal2-rounded',
                confirmButton: 'btn-red',
                cancelButton: 'btn-gray'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>

<style>
    .swal2-rounded { border-radius: 20px !important; }
    .btn-red { 
        background: linear-gradient(135deg, #ef4444, #dc2626) !important; 
        color: white !important; 
        padding: 12px 28px !important; 
        border-radius: 10px !important; 
        margin-right: 10px; 
        border: none !important;
        font-weight: 600 !important;
    }
    .btn-gray { 
        background: #e2e8f0 !important; 
        color: #475569 !important; 
        padding: 12px 28px !important; 
        border-radius: 10px !important; 
        border: none !important; 
        font-weight: 600 !important;
    }
    .btn-red:hover, .btn-gray:hover { opacity: 0.9; transform: translateY(-2px); }
</style>
@endsection