@extends('layouts.app')

@section('content')

{{-- CSS Khusus Pelayanan Admin --}}
<style>
    /* ===== RESET & GLOBAL ===== */
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Poppins',system-ui,-apple-system,BlinkMacSystemFont,sans-serif;background:#f4f5fb;color:#333}
    a{text-decoration:none;color:inherit}
    .app{display:flex;min-height:100vh}
    
    /* ===== SIDEBAR - FIX TOTAL ===== */
    .sidebar{
        position:fixed;
        left:20px;
        top:90px;
        width:260px;
        /* FIX: Tinggi pas dari top 90px sampai bawah */
        height:calc(100vh - 110px) !important;
        background:linear-gradient(180deg,#1c3f9fff,#3B82F6);
        /* FIX: Padding bawah besar untuk ruang tombol logout */
        padding:24px 20px 90px 20px !important;
        color:white;
        border-radius:20px;
        /* FIX: Flexbox untuk layout stabil */
        display:flex;
        flex-direction:column;
        z-index:50;
    }
    
    .sidebar-header{
        position:fixed;
        top:20px;
        left:20px;
        width:220px;
        background:transparent;
        padding:10px;
        display:flex;
        align-items:center;
        gap:12px;
        z-index:51;
    }
    .sidebar-header div{color:#000000ff;font-weight:600;font-size:15px}
    .sidebar-header img{height:48px;width:auto;display:block;object-fit:contain}
    
    /* ===== MENU ===== */
    .menu{
        margin-top:16px;
        display:flex;
        flex-direction:column;
        gap:6px;
        /* FIX: Menu mengisi ruang yang tersedia */
        flex:1;
        /* FIX: Scroll jika menu kepanjangan */
        overflow-y:auto;
        padding-right:4px;
    }
    .menu-item{
        display:flex;
        align-items:center;
        gap:10px;
        padding:10px 12px;
        border-radius:999px;
        font-size:13px;
        opacity:.9;
        color:#e5e7ff;
        text-decoration:none;
    }
    .menu-item:hover{background:rgba(255,255,255,.15);cursor:pointer}
    .menu-item.active{background:#38BDF8;opacity:1;font-weight:600;color:#fff}
    .menu-item img{width:22px}
    
    /* ===== SIDEBAR FOOTER (LOGOUT) ===== */
    .sidebar-footer{
        position:absolute;
        bottom:20px;
        left:20px;
        right:20px;
        z-index:51;
    }
    .sidebar-footer .logout{
        display:flex;
        align-items:center;
        gap:10px;
        width:100%;
        padding:12px 18px;
        text-decoration:none;
        font-size:14px;
        font-weight:500;
        cursor:pointer;
        color:white;
        border-radius:10px;
        transition:background 0.3s;
    }
    .sidebar-footer .logout:hover{background:rgba(255,255,255,0.15)}
    .sidebar-footer .logout img{width:20px;height:20px}
    
    /* ===== MAIN CONTENT ===== */
    .main{
        margin-top:-3px;
        margin-left:260px;
        padding:30px 40px;
        display:flex;
        flex-direction:column;
        flex:1;
        min-width:0;
    }
    .top-bar{
        display:flex;
        align-items:center;
        justify-content:flex-end;
        margin-bottom:14px;
    }
    .search-input-wrapper{
        background:#ffffff;
        border-radius:999px;
        padding:10px 22px;
        display:flex;
        align-items:center;
        width:55%;
        max-width:580px;
        box-shadow:0 6px 16px rgba(15,23,42,.08);
        margin-left:auto;
        margin-right:20px;
    }
    .search-icon{font-size:18px;opacity:0.55;margin-right:10px;display:flex;align-items:center}
    .search-input-wrapper input{border:none;outline:none;background:transparent;flex:1;font-size:13px}
    .profile-wrapper{display:flex;align-items:center;gap:10px;margin-left:20px}
    .profile-text{text-align:right;font-size:12px}
    .profile-text .name{font-weight:600}
    .profile-text .role{font-size:11px;color:#9ca3af}
    .profile-avatar{
        width:38px;height:38px;border-radius:999px;background:#f97316;
        display:flex;align-items:center;justify-content:center;
        font-weight:600;font-size:16px;color:#fff;overflow:hidden;
        text-decoration:none;cursor:pointer;
    }
    .profile-avatar img{width:100%;height:100%;object-fit:cover;border-radius:999px}
    
    /* ===== CONTENT CARD ===== */
    .header-row{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:6px}
    .btn-primary{
        background:linear-gradient(200deg,#1c3f9f,#3B82F6);
        color:#fff;
        border-radius:8px;
        padding:10px 20px;
        font-size:13px;
        border:none;
        cursor:pointer;
        font-weight:500;
    }
    .btn-primary:hover{filter:brightness(1.05);box-shadow:0 6px 14px rgba(37,99,235,0.35)}
    .content-card{
        background:#fff;
        border-radius:18px;
        padding:24px 28px;
        box-shadow:0 8px 20px rgba(15,23,42,.06);
        width:100%;
        max-width:none;
        margin:0;
        flex:1;
        box-sizing:border-box;
    }
    .content-card-form{margin-top:63px}
    .breadcrumb{font-size:11px;color:#9ca3af;margin-top:2px;margin-bottom:4px}
    h2.page-title{font-size:20px;margin-bottom:4px}
    
    /* ===== TABLE ===== */
    table{width:100%;border-collapse:collapse;margin-top:20px;font-size:13px}
    th,td{padding:8px 6px;text-align:left;vertical-align:top}
    thead{border-bottom:1px solid #e5e7eb}
    th{color:#6b7280;font-weight:500}
    tbody tr:hover{background:#f9fafb}
    .aksi-col{text-align:center;width:80px}
    .icon-btn{border:none;background:transparent;cursor:pointer;font-size:18px;margin:0 2px}
    .icon-btn.edit{color:#f97316}
    .icon-btn.delete{color:#ef4444}
    .thumb-col{width:90px}
    .thumb-img{width:60px;height:60px;border-radius:16px;object-fit:cover;background:#e5e7eb}
    .link-judul{color:#1d4ed8;font-weight:500}
    .link-judul:hover{text-decoration:underline}
    
    /* ===== FORM ===== */
    .form-wrapper{margin-top:20px;max-width:900px}
    .form-grid{display:grid;grid-template-columns:2fr 1fr;gap:24px}
    .card-form{border-radius:18px;border:1px solid #e5e7eb;padding:18px}
    .form-group{margin-bottom:14px}
    .form-group label{display:block;font-size:13px;margin-bottom:4px;font-weight:500}
    .form-group input[type=text],.form-group textarea{
        width:100%;
        padding:8px 10px;
        border-radius:10px;
        border:1px solid #d1d5db;
        font-size:13px;
        outline:none;
        resize:vertical;
    }
    .form-group textarea{min-height:90px}
    .form-group input:focus,.form-group textarea:focus{
        border-color:#5E63BB;
        box-shadow:0 0 0 1px rgba(79,70,229,.1);
    }
    
    /* ===== UPLOAD BOX ===== */
    .upload-box{
        width:100%;
        min-height:200px;
        border:2px dashed #d1d5db;
        border-radius:16px;
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        color:#6b7280;
        font-size:14px;
        position:relative;
        overflow:hidden;
        background:#fff;
    }
    .upload-box:hover{background:#f9fafb}
    .preview-img{
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        object-fit:cover;
        border-radius:16px;
        z-index:1;
    }
    .upload-overlay{
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        z-index:2;
        text-align:center;
        padding:20px;
        box-sizing:border-box;
    }
    .upload-overlay i{font-size:36px;color:#5E63BB;margin-bottom:10px}
    .upload-overlay span{font-size:16px;color:#000000ff;font-weight:500}
    .upload-trigger{
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        cursor:pointer;
        opacity:0;
        z-index:3;
    }
    .form-actions{margin-top:16px;display:flex;gap:10px}
    .btn-secondary{
        border-radius:10px;
        padding:9px 18px;
        background:#e5e7eb;
        border:none;
        font-size:13px;
        cursor:pointer;
    }
    
    /* ===== ALERT ===== */
    .alert{margin-top:10px;padding:8px 12px;border-radius:8px;font-size:12px}
    .alert-success{background:#bbf7d0;color:#166534}
    .alert-error{background:#fee2e2;color:#991b1b}
    pre{white-space:pre-wrap;font-family:inherit;font-size:13px}
    
    /* ===== DETAIL VIEW ===== */
    .detail-wrapper{margin-top:20px;display:flex;flex-direction:column;align-items:center}
    .detail-inner{max-width:700px;width:100%}
    .detail-img{max-width:100%;border-radius:18px;display:block;margin:0 auto 16px auto}
    .detail-title{font-size:18px;font-weight:600;margin-bottom:8px}
    .detail-label{font-size:13px;color:#6b7280;margin-top:10px;margin-bottom:4px}
    .detail-text{font-size:13px}
    
    /* ===== MODAL ===== */
    .modal-backdrop{
        position:fixed;
        inset:0;
        background:rgba(15,23,42,0.35);
        display:none;
        align-items:center;
        justify-content:center;
        z-index:999;
    }
    .modal-card{
        background:#ffffff;
        border-radius:18px;
        padding:32px 40px;
        width:420px;
        max-width:90%;
        box-shadow:0 20px 40px rgba(15,23,42,0.25);
        text-align:center;
        animation:modalIn .18s ease-out;
    }
    .modal-icon{
        width:72px;
        height:72px;
        border-radius:999px;
        border:3px solid #fdba74;
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0 auto 18px auto;
        color:#f97316;
        font-size:36px;
        font-weight:600;
    }
    .modal-title{font-size:22px;font-weight:600;margin-bottom:8px;color:#374151}
    .modal-text{font-size:14px;color:#4b5563;margin-bottom:22px;line-height:1.5}
    .modal-actions{display:flex;justify-content:center;gap:12px}
    .btn-danger{
        background:#e11d48;
        color:#ffffff;
        border:none;
        border-radius:10px;
        padding:10px 22px;
        font-size:14px;
        cursor:pointer;
        font-weight:600;
    }
    .btn-outline{
        background:#4b5563;
        color:#ffffff;
        border:none;
        border-radius:10px;
        padding:10px 22px;
        font-size:14px;
        cursor:pointer;
        font-weight:600;
    }
    @keyframes modalIn{
        from{opacity:0;transform:translateY(10px) scale(.97)}
        to{opacity:1;transform:translateY(0) scale(1)}
    }
    
    /* ===== SWEETALERT & UTILS ===== */
    .swal2-rounded{border-radius:20px !important}
    .btn-red{
        background:linear-gradient(180deg,#1c3f9fff,#3B82F6) !important;
        color:white !important;
        padding:8px 20px !important;
        border-radius:10px !important;
        margin-right:10px;
        border:none !important;
    }
    .btn-gray{
        background-color:#4a5568 !important;
        color:white !important;
        padding:8px 20px !important;
        border-radius:10px !important;
        border:none !important;
        outline:none !important;
    }
    .btn-red:hover,.btn-gray:hover{opacity:.9}
    .swal2-popup{
        position:relative !important;
        overflow:visible !important;
        border-radius:20px !important;
        box-shadow:0 0 25px rgba(0,234,255,0.6) !important;
        border:2px solid #00eaff !important;
    }
    .swal-dot{
        position:absolute;
        width:12px;
        height:12px;
        background:#00eaff;
        border-radius:50%;
        box-shadow:0 0 10px #00eaff;
        animation:walkBorder 4s linear infinite;
        z-index:9999;
    }
    @keyframes walkBorder{
        0%{top:-6px;left:-6px}
        25%{top:-6px;left:calc(100% - 6px)}
        50%{top:calc(100% - 6px);left:calc(100% - 6px)}
        75%{top:calc(100% - 6px);left:-6px}
        100%{top:-6px;left:-6px}
    }
</style>

<div class="app">
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo Nganjuk">
            <div>Desa Banjardowo</div>
        </div>
        <div class="menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item">
                <img src="{{ asset('assets/icons/dashboard1.png') }}" alt="">Dashboard
            </a>
            <a href="{{ route('admin.kegiatan') }}" class="menu-item">
                <img src="{{ asset('assets/icons/kegiatandesa.png') }}" alt="">Kegiatan Desa
            </a>
            <a href="{{ route('admin.prestasi') }}" class="menu-item">
                <img src="{{ asset('assets/icons/prestasi.png') }}" alt="">Prestasi
            </a>
            <a href="{{ route('admin.saran') }}" class="menu-item">
                <img src="{{ asset('assets/icons/kotaksaran1.png') }}" alt="">Kotak Saran
            </a>
            <a href="{{ route('admin.pelayanan') }}" class="menu-item active">
                <img src="{{ asset('assets/icons/pelayanan1.png') }}" alt="">Pelayanan
            </a>
        </div>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: inline;">
                @csrf
                <a href="#" class="logout" onclick="event.preventDefault(); confirmLogout();">
                    <img src="{{ asset('assets/icons/logout1.png') }}" alt="">
                    <span>Keluar</span>
                </a>
            </form>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main">

        {{-- TOP BAR HANYA UNTUK LIST --}}
        @if($action === 'list')
        <div class="top-bar">
            <form method="get" action="{{ route('admin.pelayanan') }}" class="search-input-wrapper">
                <input type="hidden" name="action" value="list">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" placeholder="Search Pelayanan" value="{{ old('search', $search ?? '') }}">
            </form>

            <div class="profile-wrapper">
                <div class="profile-text">
                    <div class="name">{{ $namaAdmin }}</div>
                    <div class="role">{{ $roleAdmin }}</div>
                </div>
                <a href="{{ route('admin.profile') }}" class="profile-avatar">
                    @if($fotoProfilSrc)
                        <img src="{{ $fotoProfilSrc }}" alt="Foto Profil">
                    @else
                        {{ $inisialAdmin }}
                    @endif
                </a>
            </div>
        </div>
        @endif

        <div class="content-card {{ $action !== 'list' ? 'content-card-form' : '' }}">

            {{-- TITLE + BREADCRUMB + TOMBOL TAMBAH --}}
            <div class="header-row">
                <div>
                    <h2 class="page-title">
                        @if($action === 'list') Daftar Pelayanan
                        @elseif($action === 'add_form') Tambah Pelayanan
                        @elseif($action === 'edit_form') Edit Pelayanan
                        @elseif($action === 'view') Detail Pelayanan
                        @endif
                    </h2>
                    <div class="breadcrumb">
                        Pelayanan /
                        @if($action === 'list') Daftar Pelayanan
                        @elseif($action === 'add_form') Tambah Pelayanan
                        @elseif($action === 'edit_form') Edit Pelayanan
                        @elseif($action === 'view') Detail Pelayanan
                        @endif
                    </div>
                </div>
                @if($action === 'list')
                    <button class="btn-primary" onclick="window.location.href='{{ route('admin.pelayanan', ['action' => 'add_form']) }}'">+ Tambah</button>
                @endif
            </div>

            {{-- NOTIF SUCCESS/ERROR --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if($message)
                <div class="alert {{ Str::contains($message, ['wajib', 'tidak', 'gagal']) ? 'alert-error' : 'alert-success' }}">
                    {{ $message }}
                </div>
            @endif

            {{-- ========== LIST PELAYANAN ========== --}}
            @if($action === 'list')
                <table>
                    <thead>
                        <tr>
                            <th class="thumb-col"></th>
                            <th style="width:60px;">No</th>
                            <th style="width:18%;">Judul</th>
                            <th style="width:27%;">Deskripsi Singkat</th>
                            <th>Isi Panduan</th>
                            <th class="aksi-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($pelayananList->isEmpty())
                        <tr><td colspan="6" style="text-align:center;padding:20px;color:#9ca3af;">Belum ada data pelayanan.</td></tr>
                    @else
                        @foreach($pelayananList as $i => $row)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.pelayanan', ['action' => 'view', 'id' => $row->id]) }}">
                                        @php
                                            $src = '';
                                            if (!empty($row->foto_pendukung)) {
                                                if (filter_var($row->foto_pendukung, FILTER_VALIDATE_URL)) {
                                                    $src = $row->foto_pendukung;
                                                } else {
                                                    $mime = $row->foto_type ?? 'image/jpeg';
                                                    $src = 'data:' . $mime . ';base64,' . base64_encode($row->foto_pendukung);
                                                }
                                            }
                                        @endphp
                                        @if(!empty($src))
                                            <img src="{{ $src }}" class="thumb-img" alt="Gambar">
                                        @else
                                            <div class="thumb-img"></div>
                                        @endif
                                    </a>
                                </td>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <a href="{{ route('admin.pelayanan', ['action' => 'view', 'id' => $row->id]) }}" class="link-judul">
                                        {{ $row->judul }}
                                    </a>
                                </td>
                                <td>{!! nl2br(e($row->deskripsi_singkat)) !!}</td>
                                <td>
                                    @php
                                        $desc = $row->isi_panduan;
                                        $desc = str_replace(['\\r\\n', '\\n', '\\r'], ["\r\n", "\n", "\r"], $desc);
                                        $maxLength = 250;
                                        echo strlen($desc) > $maxLength 
                                            ? nl2br(e(Str::limit($desc, $maxLength))) . '...' 
                                            : nl2br(e($desc));
                                    @endphp
                                </td>
                                <td class="aksi-col">
                                    <button class="icon-btn edit" title="Edit" onclick="window.location.href='{{ route('admin.pelayanan', ['action' => 'edit_form', 'id' => $row->id]) }}'">✏️</button>
                                    <button class="icon-btn delete" title="Hapus" onclick="openDeleteModal({{ $row->id }})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

            {{-- ========== ADD / EDIT FORM ========== --}}
            @elseif($action === 'add_form' || ($action === 'edit_form' && $detail))
                <div class="form-wrapper">
                    <div class="form-grid">
                        <div class="card-form">
                            <div class="form-group">
                                <label>No</label>
                                <input type="text" disabled
                                       value="{{ ($action === 'edit_form' && $detail) ? $detail->id : '' }}">
                                <small style="font-size:11px;color:#9ca3af;">No akan mengikuti ID data atau urutan.</small>
                            </div>
                        </div>
                    </div>

                    <form method="post"
                          action="{{ route('admin.pelayanan', ['action' => $action === 'add_form' ? 'add' : 'edit']) }}"
                          enctype="multipart/form-data">
                        @csrf
                        
                        @if($action === 'edit_form' && $detail)
                            <input type="hidden" name="id" value="{{ $detail->id }}">
                        @endif

                        <div class="form-grid">
                            <div class="card-form">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" name="judul" required
                                           value="{{ old('judul', $detail->judul ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Singkat</label>
                                    <input type="text" name="deskripsi_singkat" required
                                           value="{{ old('deskripsi_singkat', $detail->deskripsi_singkat ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Isi Panduan</label>
                                    <textarea name="isi_panduan" required>{{ old('isi_panduan', $detail->isi_panduan ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="card-form">
                                <div class="form-group">
                                    <label>Upload Image</label>
                                    <div class="upload-box" id="uploadBox">
                                        @php
                                            $srcForm = '';
                                            if ($action === 'edit_form' && $detail && !empty($detail->foto_pendukung)) {
                                                if (filter_var($detail->foto_pendukung, FILTER_VALIDATE_URL)) {
                                                    $srcForm = $detail->foto_pendukung;
                                                } else {
                                                    $mime = $detail->foto_type ?? 'image/jpeg';
                                                    $srcForm = 'data:' . $mime . ';base64,' . base64_encode($detail->foto_pendukung);
                                                }
                                            }
                                        @endphp
                                        <img id="previewImg" class="preview-img"
                                             src="{{ $srcForm }}"
                                             style="{{ !empty($srcForm) ? 'display:block;' : 'display:none;' }}"
                                             alt="Preview">
                                        <div class="upload-overlay">
                                            @if(!empty($srcForm))
                                                <span>Klik untuk Ganti Gambar</span>
                                            @else
                                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Pilih Image</span>
                                            @endif
                                        </div>
                                        <input type="file" id="uploadFoto" name="foto_pendukung"
                                               class="upload-trigger" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-secondary"
                                    onclick="window.location.href='{{ route('admin.pelayanan') }}'">← Kembali</button>
                            <button type="submit" class="btn-primary">
                                {{ $action === 'add_form' ? 'Simpan Data' : 'Update Data' }}
                            </button>
                        </div>
                    </form>
                </div>

            {{-- ========== DETAIL PELAYANAN ========== --}}
            @elseif($action === 'view' && $detail)
                <div class="detail-wrapper">
                    <div class="detail-inner">
                        @php
                            $srcDetail = '';
                            if (!empty($detail->foto_pendukung)) {
                                if (filter_var($detail->foto_pendukung, FILTER_VALIDATE_URL)) {
                                    $srcDetail = $detail->foto_pendukung;
                                } else {
                                    $mime = $detail->foto_type ?? 'image/jpeg';
                                    $srcDetail = 'data:' . $mime . ';base64,' . base64_encode($detail->foto_pendukung);
                                }
                            }
                        @endphp
                        @if(!empty($srcDetail))
                            <img src="{{ $srcDetail }}" class="detail-img" alt="Gambar Pelayanan">
                        @endif

                        <div class="detail-title">{{ $detail->judul }}</div>

                        <div class="detail-label">Deskripsi Singkat</div>
                        <div class="detail-text">{!! nl2br(e($detail->deskripsi_singkat)) !!}</div>

                        <div class="detail-label">Isi Panduan</div>
                        <div class="detail-text">
                            @php
                                $desc = $detail->isi_panduan;
                                $desc = str_replace(['\\r\\n', '\\n', '\\r'], ["\r\n", "\n", "\r"], $desc);
                                echo nl2br(e($desc));
                            @endphp
                        </div>

                        <div class="form-actions" style="margin-top:18px;">
                            <button type="button" class="btn-secondary"
                                    onclick="window.location.href='{{ route('admin.pelayanan') }}'">← Kembali</button>
                            <button type="button" class="btn-primary"
                                    onclick="window.location.href='{{ route('admin.pelayanan', ['action' => 'edit_form', 'id' => $detail->id]) }}'">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="deleteModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-icon">!</div>
        <div class="modal-title">Hapus Pelayanan?</div>
        <div class="modal-text">Data yang sudah dihapus tidak bisa dikembalikan.</div>
        <div class="modal-actions">
            <button class="btn-danger" type="button" onclick="confirmDelete()">Ya, hapus</button>
            <button class="btn-outline" type="button" onclick="closeDeleteModal()">Batal</button>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let deleteId = null;
    function openDeleteModal(id){ deleteId = id; document.getElementById('deleteModal').style.display = 'flex'; }
    function closeDeleteModal(){ deleteId = null; document.getElementById('deleteModal').style.display = 'none'; }
    function confirmDelete(){ if(deleteId) window.location.href = '{{ route("admin.pelayanan", ["action" => "delete"]) }}&id=' + deleteId; }

    // Preview gambar upload
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('uploadFoto');
        const previewImg = document.getElementById('previewImg');
        if (!fileInput || !previewImg) return;
        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) { previewImg.src = e.target.result; previewImg.style.display = 'block'; };
            reader.readAsDataURL(file);
        });
    });

    function confirmLogout() {
        Swal.fire({
            title: "Logout?", text: "Anda yakin ingin keluar dari dashboard admin?", icon: "warning",
            showCancelButton: true, confirmButtonText: "Ya, logout", cancelButtonText: "Batal",
            buttonsStyling: false, customClass: { popup: 'swal2-rounded', confirmButton: 'btn-red', cancelButton: 'btn-gray' }
        }).then((result) => { if (result.isConfirmed) document.getElementById('logout-form').submit(); });
    }

    // Animasi SweetAlert dot
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new MutationObserver(() => {
            const popup = document.querySelector('.swal2-popup');
            if (popup && !document.querySelector('.swal-dot')) {
                const dot = document.createElement('div'); dot.classList.add('swal-dot'); popup.appendChild(dot);
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    });
</script>

@endsection