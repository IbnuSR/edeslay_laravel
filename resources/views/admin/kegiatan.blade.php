@extends('layouts.app')

@section('content')
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, sans-serif; background: #f4f5fb; color: #333; }
    a { text-decoration: none; color: inherit; }
    .app { display: flex; min-height: 100vh; }
    .sidebar { position: fixed; left: 20px; top: 90px; width: 260px; height: calc(100vh - 104px); background: linear-gradient(180deg, #1c3f9fff, #3B82F6); padding: 24px 20px; color: white; border-radius: 20px; }
    .sidebar-header { position: fixed; top: 20px; left: 20px; width: 220px; background: transparent; padding: 10px; display: flex; align-items: center; gap: 12px; }
    .sidebar-header div { color: #000000ff; font-weight: 600; font-size: 15px; }
    .sidebar-header img { height: 48px; width: auto; display: block; object-fit: contain; }
    .menu { margin-top: 16px; display: flex; flex-direction: column; gap: 6px; }
    .menu-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 999px; font-size: 13px; opacity: .9; color: #e5e7ff; }
    .menu-item:hover { background: rgba(255,255,255,.15); cursor: pointer; }
    .menu-item.active { background: #38BDF8; opacity: 1; font-weight: 600; color: #fff; }
    .menu-item img { width: 22px; }
    .sidebar-footer { position: absolute; bottom: 20px; left: 20px; right: 20px; }
    .sidebar-footer .logout { display: flex; align-items: center; gap: 10px; width: 100%; padding: 12px 18px; text-decoration: none; font-size: 14px; font-weight: 500; }
    .sidebar-footer .logout img { width: 20px; height: 20px; }
    .main { margin-top: -3px; margin-left: 260px; padding: 30px 40px; display: flex; flex-direction: column; flex: 1; min-width: 0; }
    .top-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
    .search-input-wrapper { background: #ffffff; border-radius: 999px; padding: 10px 22px; display: flex; align-items: center; width: 55%; max-width: 580px; box-shadow: 0 6px 16px rgba(15,23,42,.08); margin-left: auto; margin-right: 20px; }
    .search-icon { font-size: 18px; opacity: 0.55; margin-right: 10px; display: flex; align-items: center; }
    .search-input-wrapper input { border: none; outline: none; background: transparent; flex: 1; font-size: 13px; }
    .profile-wrapper { display: flex; align-items: center; gap: 10px; margin-left: 20px; }
    .profile-text { text-align: right; font-size: 12px; }
    .profile-text .name{font-weight:600}
    .profile-text .role{font-size:11px;color:#9ca3af}
    .profile-avatar{width:38px;height:38px;border-radius:999px;background:#f97316;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:16px;color:#fff;overflow:hidden;}
    .profile-avatar img{width:100%;height:100%;object-fit:cover;border-radius:999px;}
    .content-card { background: #fff; border-radius: 18px; padding: 24px 28px; box-shadow: 0 8px 20px rgba(15,23,42,.06); width: 100%; max-width: none; margin: 0; box-sizing: border-box; flex: 1; }
    .content-card-form{ margin-top: 63px; }
    .header-row { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 6px; }
    .breadcrumb { font-size: 11px; color: #9ca3af; margin-top: 2px; margin-bottom: 4px; }
    h2.page-title { font-size: 20px; margin-bottom: 4px; }
    .btn-tambah { background: linear-gradient(200deg, #1c3f9f, #3B82F6); color: #fff; border-radius: 8px; padding: 10px 20px; font-size: 13px; border: none; cursor: pointer; font-weight: 500; display: flex; align-items: center; gap: 8px;}
    .btn-tambah:hover { filter: brightness(1.05); box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35);}
    table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 13px; }
    th, td { padding: 8px 6px; text-align: left; vertical-align: top; }
    thead { border-bottom: 1px solid #e5e7eb; }
    th { color: #6b7280; font-weight: 500; }
    tbody tr:hover { background: #f9fafb; }
    .aksi-col { width: 70px; text-align: center; }
    .icon-btn { border: none; background: transparent; cursor: pointer; font-size: 18px; margin: 0 2px; }
    .icon-btn.delete { color: #ef4444; }
    .alert { margin-top: 10px; padding: 8px 12px; border-radius: 8px; font-size: 12px; }
    .alert-info { background: #e0f2fe; color: #1d4ed8; }
    .text-judul { font-weight: 500; }
    .text-tanggal { font-size: 12px; color: #6b7280; }
    .foto-bulat { width: 60px; height: 60px; border-radius: 16px; object-fit: cover; background: #e5e7eb; display: block;}
    .form-container { display: flex; gap: 30px; margin-top: 20px; align-items: flex-start; }
    .form-left { width: 55%; background: white; padding: 28px; border-radius: 14px; border: 1px solid #e2e2e2; }
    .form-left input, .form-left textarea { width: 100%; padding: 13px 14px; margin-top: 14px; border-radius: 10px; border: 1px solid #c8c8c8; font-size: 14px; }
    .back-btn { margin-top: 10px; display: inline-block; color: #444; text-decoration: none; font-size: 14px; }
    .btn-simpan { margin-top: 18px; background: #48C774; padding: 12px 22px; border-radius: 10px; border: none; color: white; font-size: 15px; cursor: pointer; display: flex; align-items: center; gap: 6px; }
    .form-right { width: 40%; padding-top: 10px; position: relative; }
    .upload-box { width: 100%; height: 230px; border: 2px dashed #bfbfbf; border-radius: 16px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #777; font-size: 15px; position: relative; overflow: hidden; background: #fff; }
    .upload-box:hover { background: #f5f6ff; }
    .preview-img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 16px; z-index: 1; }
    .upload-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 2; text-align: center; padding: 20px; box-sizing: border-box; }
    .upload-overlay i { font-size: 36px; color: #5E63BB; margin-bottom: 10px; }
    .upload-overlay span { font-size: 16px; color: #000000ff; font-weight: 500; }
    .upload-trigger { position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; opacity: 0; z-index: 3; }
    .modal-backdrop { position:fixed; inset:0; background:rgba(15,23,42,0.35); display:none; align-items:center; justify-content:center; z-index:999; }
    .modal-card { background:#ffffff; border-radius:18px; padding:32px 40px; width:420px; max-width:90%; box-shadow:0 20px 40px rgba(15,23,42,0.25); text-align:center; animation:modalIn .18s ease-out; }
    .modal-icon { width:72px; height:72px; border-radius:999px; border:3px solid #fdba74; display:flex; align-items:center;justify-content:center; margin:0 auto 18px auto; color:#f97316; font-size:36px; font-weight:600; }
    .modal-title { font-size:22px; font-weight:600; margin-bottom:8px; color:#374151; }
    .modal-text { font-size:14px; color:#4b5563; margin-bottom:22px; line-height:1.5; }
    .modal-actions { display:flex; justify-content:center; gap:12px; }
    .btn-danger { background:#e11d48; color:#ffffff; border:none; border-radius:10px; padding:10px 22px; font-size:14px; cursor:pointer; font-weight:600; }
    .btn-outline{ background:#4b5563; color:#ffffff; border:none; border-radius:10px; padding:10px 22px; font-size:14px; cursor:pointer; font-weight:600; }
    @keyframes modalIn { from{opacity:0;transform:translateY(10px) scale(.97);} to{opacity:1;transform:translateY(0) scale(1);} }
    .fa-trash { color: #ef4444 !important; }
    body, html, .main, .content-card { overflow-x: hidden !important; }
    .detail-page { padding: 30px 0; background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); max-width: 700px; margin: 0 auto; }
    .detail-image { width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; background: #f1f5f9; }
    .detail-date { font-size: 14px; color: #6b7280; margin-bottom: 8px; }
    .detail-title { font-size: 22px; font-weight: 600; color: #1e293b; margin-bottom: 16px; }
    .detail-text { font-size: 14px; line-height: 1.6; color: #334155; margin-bottom: 20px; }
    .detail-text strong { font-weight: 600; }
    .detail-actions { display: flex; gap: 10px; margin-top: 20px; }
    .detail-actions button, .detail-actions a { padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; }
    .detail-actions .btn-edit { background: #3b82f6; color: white; }
    .detail-actions .btn-delete { background: #ef4444; color: white; }
    .detail-back { display: inline-block; color: #6b7280; font-size: 14px; margin-bottom: 20px; cursor: pointer; text-decoration: underline; }
    .detail-back:hover { color: #3b82f6; }
    @media (max-width: 768px) { .main { margin-left: 20px; padding: 20px 15px; } .detail-page { padding: 20px 10px; } .detail-image { max-height: 300px; } }
    .swal2-rounded { border-radius: 20px !important; }
    .btn-red { background: linear-gradient(180deg, #1c3f9fff, #3B82F6) !important; color: white !important; padding: 8px 20px !important; border-radius: 10px !important; margin-right: 10px; border: none !important; }
    .btn-gray { background-color: #4a5568 !important; color: white !important; padding: 8px 20px !important; border-radius: 10px !important; border: none !important; outline: none !important; }
    .btn-red:hover, .btn-gray:hover { opacity: .9; }
    .swal2-popup { position: relative !important; overflow: visible !important; border-radius: 20px !important; box-shadow: 0 0 25px rgba(0, 234, 255, 0.6) !important; border: 2px solid #00eaff !important; }
    .swal-dot { position: absolute; width: 12px; height: 12px; background: #00eaff; border-radius: 50%; box-shadow: 0 0 10px #00eaff; animation: walkBorder 4s linear infinite; z-index: 9999; }
    @keyframes walkBorder { 0% { top: -6px; left: -6px; } 25% { top: -6px; left: calc(100% - 6px); } 50% { top: calc(100% - 6px); left: calc(100% - 6px); } 75% { top: calc(100% - 6px); left: -6px; } 100% { top: -6px; left: -6px; } }
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
            <a href="{{ route('admin.kegiatan') }}" class="menu-item active">
                <img src="{{ asset('assets/icons/kegiatandesa.png') }}" alt="">Kegiatan Desa
            </a>
            <a href="{{ route('admin.prestasi') }}" class="menu-item">
                <img src="{{ asset('assets/icons/prestasi.png') }}" alt="">Prestasi
            </a>
            <a href="{{ route('admin.saran') }}" class="menu-item">
                <img src="{{ asset('assets/icons/kotaksaran1.png') }}" alt="">Kotak Saran
            </a>
            <a href="{{ route('admin.pelayanan') }}" class="menu-item">
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
        @if($action === 'list')
        <div class="top-bar">
            <form method="get" action="{{ route('admin.kegiatan') }}" class="search-input-wrapper">
                <input type="hidden" name="action" value="list">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" placeholder="Search Kegiatan" value="{{ old('search', $search ?? '') }}">
            </form>
            <div class="profile-wrapper">
                <div class="profile-text">
                    <div class="name">{{ $namaAdmin ?? 'Administrator' }}</div>
                    <div class="role">{{ $roleAdmin ?? 'admin' }}</div>
                </div>
                <a href="{{ route('admin.profile') }}" class="profile-avatar">
                    @if(isset($fotoProfilSrc) && $fotoProfilSrc)
                        <img src="{{ $fotoProfilSrc }}" alt="Foto Profil">
                    @else
                        {{ $inisialAdmin ?? 'A' }}
                    @endif
                </a>
            </div>
        </div>
        @endif

        @if($message)
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: '{{ $message }}',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });
                });
            </script>
        @endif

        @if($action === 'list')
            <div class="content-card">
                <div class="header-row">
                    <div>
                        <h2 class="page-title">{{ $page_title ?? 'Daftar Kegiatan Desa' }}</h2>
                        <div class="breadcrumb">Dashboard / Kegiatan Desa / Daftar Kegiatan</div>
                    </div>
                    <a href="{{ route('admin.kegiatan', ['action' => 'tambah']) }}">
                        <button class="btn-tambah">
                            <span style="font-size:16px; margin-bottom:1px;">+</span> Tambah
                        </button>
                    </a>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th style="width:10%"></th>
                        <th style="width:6%">No</th>
                        <th style="width:25%">Nama Kegiatan Desa</th>
                        <th style="width:20%">Lokasi</th>
                        <th style="width:25%">Deskripsi</th>
                        <th style="width:14%">Tanggal Perolehan</th>
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
                            <td>
                                @if(!empty($fotoSrc))
                                    <img src="{{ $fotoSrc }}" alt="Foto" class="foto-bulat">
                                @else
                                    <span class="foto-bulat"></span>
                                @endif
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-judul">
                                <a href="{{ route('admin.kegiatan', ['action' => 'view', 'id' => $row->id]) }}">
                                    {{ $row->judul }}
                                </a>
                            </td>
                            <td>{{ $row->lokasi }}</td>
                            <td>{!! nl2br(e($shortDesc)) !!}</td>
                            <td class="text-tanggal">
                                {{ \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y') }}
                            </td>
                            <td class="aksi-col" style="display:flex; justify-content:center; align-items:center; gap:6px;">
                                <a href="{{ route('admin.kegiatan', ['action' => 'edit', 'id' => $row->id]) }}" title="Edit">
                                    <button class="icon-btn">✏️</button>
                                </a>
                                <button class="icon-btn delete" title="Hapus" onclick="openDeleteModal({{ $row->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:20px;color:#9ca3af;">
                                Belum ada data kegiatan.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        @if($action === 'view')
            <div class="content-card content-card-form">
                <div class="header-row">
                    <div>
                        <h2 class="page-title">Detail Kegiatan</h2>
                        <div class="breadcrumb">Dashboard / Kegiatan Desa / Detail Kegiatan</div>
                    </div>
                    <a href="{{ route('admin.kegiatan') }}" class="btn-tambah" style="padding:8px 16px; font-size:12px;">
                        <span style="font-size:14px;">←</span> Kembali
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

                    <div class="detail-page">
                        @if(!empty($fotoSrc))
                            <img src="{{ $fotoSrc }}" alt="Foto Kegiatan" class="detail-image">
                        @else
                            <div class="detail-image" style="display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:24px;">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif

                        <div class="detail-date">{{ \Carbon\Carbon::parse($detail->tanggal)->isoFormat('D MMMM Y') }}</div>
                        <div class="detail-title">{{ $detail->judul }}</div>
                        <div class="detail-text">
                            <p><strong>Lokasi:</strong> {{ $detail->lokasi }}</p>
                            <p><strong>Deskripsi:</strong><br>{!! nl2br(e($detail->deskripsi)) !!}</p>
                        </div>
                        <div class="detail-actions">
                            <a href="{{ route('admin.kegiatan', ['action' => 'edit', 'id' => $detail->id]) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button class="btn-delete" onclick="openDeleteModal({{ $detail->id }})">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                @else
                    <div class="detail-page" style="text-align:center; padding:40px 20px; background:#f9fafb; border-radius:12px;">
                        <i class="fa-solid fa-exclamation-circle" style="font-size:48px; color:#f59e0b; margin-bottom:16px;"></i>
                        <h3 style="font-size:18px; color:#1e293b; margin-bottom:8px;">Data Tidak Ditemukan</h3>
                        <p style="color:#64748b; margin-bottom:20px;">Kegiatan dengan ID ini tidak ada atau telah dihapus.</p>
                        <a href="{{ route('admin.kegiatan') }}" style="background:#3b82f6; color:white; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:500;">
                            ← Kembali ke Daftar
                        </a>
                    </div>
                @endif
            </div>
        @endif

        @if($action === 'tambah' || $action === 'edit')
            <div class="content-card content-card-form">
                <div class="header-row">
                    <div>
                        <h2 class="page-title">{{ $page_title ?? ($action === 'tambah' ? 'Tambah Kegiatan Desa' : 'Edit Kegiatan Desa') }}</h2>
                        <div class="breadcrumb">
                            Dashboard / Kegiatan Desa / 
                            {{ $action === 'tambah' ? 'Tambah' : 'Edit' }} Kegiatan
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.kegiatan') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="action" value="{{ $action }}">
                    @if(isset($edit) && $edit)
                        <input type="hidden" name="id" value="{{ $edit->id ?? '' }}">
                    @endif
                    
                    <div class="form-container">
                        <div class="form-left">
                            <label>Nama Kegiatan</label>
                            <input type="text" name="judul" required value="{{ old('judul', $edit->judul ?? '') }}">
                            <label>Lokasi</label>
                            <input type="text" name="lokasi" required value="{{ old('lokasi', $edit->lokasi ?? '') }}">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" rows="5" required>{{ old('deskripsi', $edit->deskripsi ?? '') }}</textarea>
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" required value="{{ old('tanggal', $edit->tanggal ?? '') }}">
                        </div>
                        <div class="form-right">
                            <div class="upload-box" id="uploadBox">
                                @php
                                    $previewSrc = '';
                                    if (isset($edit) && !empty($edit->foto)) {
                                        $mime = $edit->foto_type ?? 'image/jpeg';
                                        $raw = $edit->foto;
                                        $isBase64 = preg_match('/^[A-Za-z0-9+\/=]+$/', $raw);
                                        $previewSrc = $mime . ';base64,' . ($isBase64 ? $raw : base64_encode($raw));
                                    }
                                @endphp
                                <img id="previewImg" class="preview-img"
                                     src="{{ $previewSrc }}"
                                     style="{{ $previewSrc ? 'display:block;' : 'display:none;' }}"
                                     alt="Preview">
                                <div class="upload-overlay">
                                    @if($previewSrc)
                                        <span>Klik untuk Ganti Gambar</span>
                                    @else
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <span>Pilih Image</span>
                                    @endif
                                </div>
                                <input type="file" id="uploadFoto" name="foto" class="upload-trigger" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="save_kegiatan" class="btn-simpan">
                        <i class="fas fa-save"></i>
                        {{ $action === 'edit' ? 'Update Data' : 'Simpan Data' }}
                    </button>
                    <a href="{{ route('admin.kegiatan') }}" class="back-btn">&larr; Kembali ke Daftar</a>
                </form>
            </div>
        @endif
    </div>
</div>

<div id="deleteModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-icon">!</div>
        <div class="modal-title">Hapus data kegiatan?</div>
        <div class="modal-text">
            Data yang sudah dihapus tidak dapat dikembalikan.<br>
            Apakah Anda yakin ingin melanjutkan?
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-outline" onclick="closeDeleteModal()">Batal</button>
            <button type="button" class="btn-danger" onclick="confirmDelete()">Ya, hapus</button>
        </div>
    </div>
</div>

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
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput  = document.getElementById('uploadFoto');
        const previewImg = document.getElementById('previewImg');
        if (!fileInput || !previewImg) return;
        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const observer = new MutationObserver(() => {
        const popup = document.querySelector('.swal2-popup');
        if (popup && !document.querySelector('.swal-dot')) {
            const dot = document.createElement('div');
            dot.classList.add('swal-dot');
            popup.appendChild(dot);
        }
    });
    observer.observe(document.body, { childList: true, subtree: true });
});
</script>
@endsection