@extends('layouts.app')

@section('content')
<style>
    /* ===== RESET LINK DEFAULT ===== */
    a {
        text-decoration: none !important;
        color: inherit;
    }
    
    /* ===== MAIN CONTENT ===== */
    .main-container { 
        padding: 20px 30px; 
        width: 100%;
        max-width: 100%;
        background: #f5f9ff;
        box-sizing: border-box;
    }
    
    /* ===== TOP BAR ===== */
    .top-bar { 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        margin-bottom: 30px;
        background: #e3f2fd;
        padding: 20px 30px;
        border-radius: 16px;
        flex-wrap: wrap;
        gap: 20px;
    }
    .page-header h1 { 
        font-size: 26px; 
        font-weight: 700; 
        color: #1e293b;
        margin-bottom: 4px;
        margin-top: 0;
    }
    .breadcrumb { 
        font-size: 13px; 
        color: #94a3b8;
    }
    .search-wrapper { 
        display: flex; 
        align-items: center; 
        gap: 20px;
        flex: 1;
        justify-content: flex-end;
    }
    .search-box { 
        background: white; 
        border-radius: 999px; 
        padding: 12px 24px; 
        display: flex; 
        align-items: center; 
        gap: 12px;
        width: 270px;
        max-width: 100%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .search-box input { 
        border: none; 
        outline: none; 
        background: transparent; 
        flex: 1; 
        font-size: 14px;
        color: #334155;
        min-width: 0;
    }
    .search-box input::placeholder {
        color: #94a3b8;
    }
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
        flex-shrink: 0;
        text-decoration: none !important;
        border: none !important;
        outline: none !important;
    }
    .profile-avatar:hover {
        opacity: 0.9;
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
        width: 100%;
        box-sizing: border-box;
    }
    .card-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .card-header h2 {
        margin: 0;
    }
    .btn-tambah { 
        background: #1976d2; 
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
        box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
        white-space: nowrap;
        text-decoration: none !important;
    }
    .btn-tambah:hover { 
        background: #1565c0;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(25, 118, 210, 0.4);
    }
    
    /* ===== TABLE ===== */
    .table-container { 
        overflow-x: auto; 
        width: 100%;
    }
    table { 
        width: 100%; 
        border-collapse: collapse;
        min-width: 800px;
    }
    th { 
        padding: 16px; 
        text-align: left; 
        font-weight: 600; 
        color: #64748b;
        font-size: 13px;
        border-bottom: 2px solid #e3f2fd;
        white-space: nowrap;
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
    }
    .judul-link { 
        color: #1e293b; 
        font-weight: 600;
        transition: color 0.3s;
        text-decoration: none !important;
        border: none !important;
    }
    .judul-link:hover { 
        color: #1976d2;
        text-decoration: none !important;
    }
    .deskripsi-text { 
        color: #64748b; 
        font-size: 13px;
        line-height: 1.6;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .tanggal-text { 
        font-size: 13px; 
        color: #94a3b8;
        font-weight: 500;
        white-space: nowrap;
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
        border: none !important; 
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        background: transparent;
        text-decoration: none !important;
        outline: none !important;
        padding: 0;
        margin: 0;
    }
    .btn-icon:focus {
        outline: none !important;
    }
    .btn-edit { 
        color: #f59e0b;
        text-decoration: none !important;
    }
    .btn-edit:hover { 
        background: #fef3c7; 
        transform: scale(1.1);
        text-decoration: none !important;
    }
    .btn-delete { 
        color: #ef4444;
        text-decoration: none !important;
    }
    .btn-delete:hover { 
        background: #fee2e2; 
        transform: scale(1.1);
        text-decoration: none !important;
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
        box-sizing: border-box;
    }
    .form-group input:focus,
    .form-group textarea:focus { 
        border-color: #1976d2;
        outline: none;
        box-shadow: 0 0 0 4px rgba(25, 118, 210, 0.1);
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
        border-color: #1976d2; 
        background: #f0f7ff;
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
        color: #1976d2; 
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
        flex-wrap: wrap;
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
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-secondary:hover { 
        background: #cbd5e1;
        transform: translateY(-2px);
        text-decoration: none !important;
    }
    .btn-primary { 
        background: #10b981; 
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
        text-decoration: none !important;
    }
    .btn-primary:hover { 
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        text-decoration: none !important;
    }
    
    /* ===== DETAIL VIEW ===== */
    .detail-container { 
        background: white; 
        border-radius: 16px; 
        padding: 30px; 
        max-width: 100%;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .detail-image { 
        width: 100%; 
        max-height: 450px; 
        object-fit: cover; 
        border-radius: 16px; 
        margin-bottom: 24px;
        background: #f1f5f9;
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
        margin: 0;
    }
    .detail-content { 
        font-size: 15px; 
        line-height: 1.8; 
        color: #475569;
    }
    .detail-content strong { color: #1e293b; font-weight: 600; }
    .detail-content p { margin: 8px 0; }
    .detail-actions { 
        display: flex; 
        gap: 12px; 
        margin-top: 30px;
        padding-top: 24px;
        border-top: 2px solid #e2e8f0;
        flex-wrap: wrap;
    }
    .btn-detail-edit { 
        background: #1976d2; 
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
        text-decoration: none !important;
    }
    .btn-detail-edit:hover {
        transform: translateY(-2px);
        text-decoration: none !important;
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
        text-decoration: none !important;
    }
    .btn-detail-delete:hover {
        transform: translateY(-2px);
        text-decoration: none !important;
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
        margin-top: 0;
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
        flex-wrap: wrap;
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
        text-decoration: none !important;
    }
    .btn-modal-cancel:hover { 
        background: #cbd5e1;
        text-decoration: none !important;
    }
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
        text-decoration: none !important;
    }
    .btn-modal-delete:hover { 
        background: #dc2626;
        text-decoration: none !important;
    }
    
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
        .form-grid { grid-template-columns: 1fr; }
        .search-box { width: 250px; }
    }
    @media (max-width: 768px) {
        .top-bar { flex-direction: column; align-items: stretch; }
        .search-wrapper { flex-direction: column; width: 100%; }
        .search-box { width: 100%; }
        .profile-wrapper { justify-content: flex-end; }
        .profile-info { display: none; }
        .card-header { flex-direction: column; align-items: flex-start; }
        .btn-tambah { width: 100%; justify-content: center; }
    }
</style>

<div class="main-container">
    @if($action === 'list')
    <div class="top-bar">
        <div class="page-header">
            <h1>Prestasi Desa</h1>
            <div class="breadcrumb">Dashboard / Prestasi / Daftar Prestasi</div>
        </div>
        <div class="search-wrapper">
            <form method="get" action="{{ route('admin.prestasi.index') }}" class="search-box">
                <input type="hidden" name="action" value="list">
                <i class="fas fa-search" style="color: #94a3b8;"></i>
                <input type="text" name="search" placeholder="Cari Prestasi" value="{{ old('search', $search ?? '') }}">
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
                <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">Daftar Prestasi</h2>
                <a href="{{ route('admin.prestasi.index', ['action' => 'tambah']) }}">
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
                            <th>Nama Prestasi</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th class="aksi-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasiList as $row)
                            @php
                                // ✅ BARU: Gunakan Storage::url() untuk path file
                                $fotoSrc = !empty($row->foto) ? Storage::url($row->foto) : '';
                                
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
                                        <div class="foto-item" style="display: flex; align-items: center; justify-content: center; background: #e3f2fd;">
                                            <i class="fas fa-image" style="color: #94a3b8;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.prestasi.index', ['action' => 'view', 'id' => $row->id]) }}" class="judul-link">
                                        {{ $row->judul }}
                                    </a>
                                </td>
                                <td>
                                    <div class="tanggal-text">
                                        {{ \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="deskripsi-text">
                                        {!! nl2br(e($shortDesc)) !!}
                                    </div>
                                </td>
                                <td class="aksi-col">
                                    <div class="aksi-buttons">
                                        <a href="{{ route('admin.prestasi.index', ['action' => 'edit', 'id' => $row->id]) }}" title="Edit">
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
                                <td colspan="6" style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.5;"></i>
                                    Belum ada data prestasi.
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
                <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">Detail Prestasi</h2>
                <a href="{{ route('admin.prestasi.index') }}">
                    <button class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                </a>
            </div>

            @if(isset($detail) && $detail)
                @php
                    // ✅ BARU: Gunakan Storage::url() untuk path file
                    $fotoSrc = !empty($detail->foto) ? Storage::url($detail->foto) : '';
                @endphp

                <div class="detail-container">
                    @if(!empty($fotoSrc))
                        <img src="{{ $fotoSrc }}" alt="Foto Prestasi" class="detail-image">
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
                        <p><strong>Deskripsi:</strong></p>
                        <p>{!! nl2br(e($detail->deskripsi)) !!}</p>
                    </div>

                    <div class="detail-actions">
                        <a href="{{ route('admin.prestasi.index', ['action' => 'edit', 'id' => $detail->id]) }}" class="btn-detail-edit">
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
                    <h3 style="font-size: 20px; color: #1e293b; margin-bottom: 12px; margin-top: 0;">Data Tidak Ditemukan</h3>
                    <p style="color: #64748b; margin-bottom: 24px;">Prestasi dengan ID ini tidak ada atau telah dihapus.</p>
                    <a href="{{ route('admin.prestasi.index') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            @endif
        </div>
    @endif

    {{-- ✅ PERBAIKAN FORM: Action Dinamis --}}
    @if($action === 'tambah' || $action === 'edit')
        <div class="content-card">
            <div class="card-header">
                <div>
                    <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0;">
                        {{ $page_title ?? ($action === 'tambah' ? 'Tambah Prestasi' : 'Edit Prestasi') }}
                    </h2>
                    <div class="breadcrumb" style="margin: 0;">
                        Dashboard / Prestasi / {{ $action === 'tambah' ? 'Tambah' : 'Edit' }} Prestasi
                    </div>
                </div>
            </div>

            {{-- Form Action: Store untuk tambah, Update untuk edit --}}
            <form method="POST" 
                  action="{{ $action === 'edit' ? route('admin.prestasi.update', $edit->id) : route('admin.prestasi.store') }}" 
                  enctype="multipart/form-data">
                @csrf
                {{-- Method PUT hanya untuk update --}}
                @if($action === 'edit')
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $edit->id }}">
                @endif
                
                <div class="form-wrapper">
                    <div class="form-grid">
                        <div class="form-section">
                            <div class="form-group">
                                <label>Judul Prestasi</label>
                                <input type="text" name="judul" required value="{{ old('judul', $edit->judul ?? '') }}" placeholder="Masukkan judul prestasi">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" required placeholder="Masukkan deskripsi prestasi">{{ old('deskripsi', $edit->deskripsi ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" required value="{{ old('tanggal', $edit->tanggal ?? '') }}">
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-group">
                                <label>Upload Foto Prestasi</label>
                                <div class="upload-container" id="uploadBox">
                                    @php
                                        $previewSrc = '';
                                        if (isset($edit) && !empty($edit->foto)) {
                                            $previewSrc = Storage::url($edit->foto);
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
                        <a href="{{ route('admin.prestasi.index') }}" class="btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            {{ $action === 'edit' ? 'Update Data' : 'Simpan Data' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>

<!-- MODAL KONFIRMASI HAPUS -->
<div id="deleteModal" class="modal-backdrop">
    <div class="modal-content">
        <div class="modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 class="modal-title">Hapus Prestasi?</h3>
        <p class="modal-text">
            Apakah Anda yakin ingin menghapus prestasi ini?<br>
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
            window.location.href = '{{ route("admin.prestasi.index") }}?action=delete&id=' + deleteId;
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