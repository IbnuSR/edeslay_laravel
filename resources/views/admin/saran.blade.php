@extends('layouts.app')

@section('content')

{{-- CSS Khusus Saran Admin --}}
<style>
    /* ===== PASTE SEMUA CSS ASLI KAMU DI SINI ===== */
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Poppins',system-ui,-apple-system,BlinkMacSystemFont,sans-serif;background:#f4f5fb;color:#333}
    a{text-decoration:none;color:inherit}
    .app{display:flex;min-height:100vh}
    .sidebar{position:fixed;left:20px;top:90px;width:260px;height:calc(100vh-104px);background:linear-gradient(180deg,#1c3f9fff,#3B82F6);padding:24px 20px;color:white;border-radius:20px}
    .sidebar-header{position:fixed;top:20px;left:20px;width:220px;background:transparent;padding:10px;display:flex;align-items:center;gap:12px}
    .sidebar-header div{color:#000000ff;font-weight:600;font-size:15px}
    .sidebar-header img{height:48px;width:auto;display:block;object-fit:contain}
    .menu{margin-top:16px;display:flex;flex-direction:column;gap:6px}
    .menu-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:999px;font-size:13px;opacity:.9;color:#e5e7ff}
    .menu-item:hover{background:rgba(255,255,255,.15);cursor:pointer}
    .menu-item.active{background:#38BDF8;opacity:1;font-weight:600;color:#fff}
    .menu-item img{width:22px}
    .sidebar-footer{position:absolute;bottom:20px;left:20px;right:20px}
    .sidebar-footer .logout{display:flex;align-items:center;gap:10px;width:100%;padding:12px 18px;text-decoration:none;font-size:14px;font-weight:500;cursor:pointer}
    .sidebar-footer .logout img{width:20px;height:20px}
    .main{margin-top:-3px;margin-left:260px;padding:30px 40px;display:flex;flex-direction:column;flex:1;min-width:0}
    .top-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
    .search-input-wrapper{background:#ffffff;border-radius:999px;padding:10px 22px;display:flex;align-items:center;width:55%;max-width:580px;box-shadow:0 6px 16px rgba(15,23,42,.08);margin-left:auto;margin-right:20px}
    .search-icon{font-size:18px;opacity:0.55;margin-right:10px;display:flex;align-items:center}
    .search-input-wrapper input{border:none;outline:none;background:transparent;flex:1;font-size:13px}
    .profile-wrapper{display:flex;align-items:center;gap:10px;margin-left:20px}
    .profile-text{text-align:right;font-size:12px}
    .profile-text .name{font-weight:600}
    .profile-text .role{font-size:11px;color:#9ca3af}
    .profile-avatar{width:38px;height:38px;border-radius:999px;background:#f97316;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:16px;color:#fff;overflow:hidden;text-decoration:none;cursor:pointer}
    .profile-avatar img{width:100%;height:100%;object-fit:cover;border-radius:999px;display:block}
    .content-card{background:#fff;border-radius:18px;padding:24px 28px;box-shadow:0 8px 20px rgba(15,23,42,.06);width:100%;max-width:none;margin:0;flex:1;box-sizing:border-box}
    .content-card-form{margin-top:63px}
    .header-row{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:6px}
    .breadcrumb{font-size:11px;color:#9ca3af;margin-top:2px;margin-bottom:4px}
    h2.page-title{font-size:20px;margin-bottom:4px}
    table{width:100%;border-collapse:collapse;margin-top:20px;font-size:13px}
    th,td{padding:8px 6px;text-align:left;vertical-align:top}
    thead{border-bottom:1px solid #e5e7eb}
    th{color:#6b7280;font-weight:500}
    tbody tr:hover{background:#f9fafb}
    .aksi-col{width:70px;text-align:center}
    .icon-btn{border:none;background:transparent;cursor:pointer;font-size:18px;margin:0 2px}
    .icon-btn.delete{color:#ef4444}
    .alert{margin-top:10px;padding:8px 12px;border-radius:8px;font-size:12px}
    .alert-success{background:#bbf7d0;color:#166534}
    .alert-error{background:#fee2e2;color:#991b1b}
    .text-judul{font-weight:500}
    .text-tanggal{font-size:12px;color:#6b7280}
    .foto-bulat{width:60px;height:60px;border-radius:16px;object-fit:cover;background:#e5e7eb;display:block}
    td.isi-saran{word-wrap:break-word;overflow-wrap:break-word;max-width:500px}
    .detail-container{background:#fff;border-radius:18px;padding:30px 40px;box-shadow:0 8px 20px rgba(15,23,42,.06);display:flex;flex-direction:column;align-items:center}
    .detail-inner{max-width:700px;width:100%}
    .detail-back{font-size:24px;cursor:pointer;margin-bottom:10px}
    .detail-image{width:100%;max-height:420px;object-fit:cover;border-radius:18px;margin-bottom:18px;background:#e5e7eb}
    .detail-date{font-size:11px;color:#6b7280;margin-bottom:4px}
    .detail-title{font-size:16px;font-weight:600;margin-bottom:12px}
    .detail-text{font-size:13px;line-height:1.6;word-wrap:break-word;overflow-wrap:break-word}
    .detail-page{margin-top:63px}
    .modal-backdrop{position:fixed;inset:0;background:rgba(15,23,42,0.35);display:none;align-items:center;justify-content:center;z-index:999}
    .modal-card{background:#ffffff;border-radius:22px;padding:32px 40px;width:420px;max-width:90%;box-shadow:0 20px 40px rgba(15,23,42,0.25);text-align:center;animation:modalIn .18s ease-out}
    .modal-icon{width:72px;height:72px;border-radius:999px;border:3px solid #fdba74;display:flex;align-items:center;justify-content:center;margin:0 auto 18px auto;color:#f97316;font-size:36px;font-weight:600}
    .modal-title{font-size:22px;font-weight:600;margin-bottom:8px;color:#374151}
    .modal-text{font-size:14px;color:#4b5563;margin-bottom:22px;line-height:1.5}
    .modal-actions{display:flex;justify-content:center;gap:12px}
    .btn-danger{background:#e11d48;color:#fff;border:none;border-radius:10px;padding:10px 22px;font-size:14px;cursor:pointer;font-weight:600}
    .btn-outline{background:#4b5563;color:#fff;border:none;border-radius:10px;padding:10px 22px;font-size:14px;cursor:pointer;font-weight:600}
    @keyframes modalIn{from{opacity:0;transform:translateY(10px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
    .fa-trash{color:#ef4444 !important}
    .swal2-rounded{border-radius:20px !important}
    .btn-red{background:linear-gradient(180deg,#1c3f9fff,#3B82F6) !important;color:white !important;padding:8px 20px !important;border-radius:10px !important;margin-right:10px;border:none !important}
    .btn-gray{background-color:#4a5568 !important;color:white !important;padding:8px 20px !important;border-radius:10px !important;border:none !important;outline:none !important}
    .btn-red:hover,.btn-gray:hover{opacity:.9}
    .swal2-popup{position:relative !important;overflow:visible !important;border-radius:20px !important;box-shadow:0 0 25px rgba(0,234,255,0.6) !important;border:2px solid #00eaff !important}
    .swal-dot{position:absolute;width:12px;height:12px;background:#00eaff;border-radius:50%;box-shadow:0 0 10px #00eaff;animation:walkBorder 4s linear infinite;z-index:9999}
    @keyframes walkBorder{0%{top:-6px;left:-6px}25%{top:-6px;left:calc(100% - 6px)}50%{top:calc(100% - 6px);left:calc(100% - 6px)}75%{top:calc(100% - 6px);left:-6px}100%{top:-6px;left:-6px}}
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
            <!-- Halaman ini -->
            <a href="{{ route('admin.saran') }}" class="menu-item active">
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

        {{-- BAR ATAS – HANYA MUNCUL DI LIST --}}
        @if($action === 'list')
        <div class="top-bar">
            <form method="get" action="{{ route('admin.saran') }}" class="search-input-wrapper">
                <input type="hidden" name="action" value="list">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" placeholder="Search Saran" value="{{ old('search', $search) }}">
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

        {{-- NOTIF SUCCESS/ERROR --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if($message)
            <div class="alert alert-info">{{ $message }}</div>
        @endif

        {{-- ========== LIST SARAN ========== --}}
        @if($action === 'list')
            <div class="content-card">
                <div class="header-row">
                    <div>
                        <h2 class="page-title">Daftar Saran</h2>
                        <div class="breadcrumb">Dashboard / Kotak Saran / Daftar Saran</div>
                    </div>
                </div>

                <table>
                    <thead>
                    <tr>
                        <th style="width:10%;"></th>
                        <th style="width:6%;">No</th>
                        <th style="width:22%;">Judul</th>
                        <th style="width:18%;">
                            Tanggal Dikirim
                            <a href="{{ route('admin.saran', ['action' => 'list', 'search' => $search, 'sort' => $nextSort]) }}">
                                <img src="{{ asset('assets/icons/sort.png') }}" alt="Urutkan"
                                     style="width:14px;margin-left:4px;vertical-align:middle;{{ $sort === 'asc' ? 'transform:rotate(180deg);' : '' }}">
                            </a>
                        </th>
                        <th>Saran atau Kritik</th>
                        <th class="aksi-col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($saranList->isEmpty())
                        <tr><td colspan="6" style="text-align:center;padding:20px;color:#9ca3af;">Belum ada data saran.</td></tr>
                    @else
                        @php($no = 1)
                        @foreach($saranList as $row)
                            <tr>
                                {{-- FOTO --}}
                                <td>
                                    @if(!empty($row->foto_sampul))
                                        @php
                                            $mime = $row->foto_type ?? 'image/jpeg';
                                            $raw = $row->foto_sampul;
                                            $isBase64 = preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $raw);
                                            $base64 = $isBase64 ? $raw : base64_encode($raw);
                                            $src = 'data:' . $mime . ';base64,' . $base64;
                                        @endphp
                                        <img src="{{ $src }}" alt="Foto" class="foto-bulat">
                                    @else
                                        <span class="foto-bulat"></span>
                                    @endif
                                </td>

                                {{-- NO --}}
                                <td>{{ $no++ }}</td>

                                {{-- JUDUL (klik ke detail) --}}
                                <td class="text-judul">
                                    <a href="{{ route('admin.saran', ['action' => 'view', 'id' => $row->id]) }}">
                                        {{ $row->judul }}
                                    </a>
                                </td>

                                {{-- TANGGAL --}}
                                <td class="text-tanggal">
                                    {{ \Carbon\Carbon::parse($row->tanggal_dikirim)->isoFormat('D MMMM Y') }}
                                </td>

                                {{-- ISI SARAN (singkat) --}}
                                <td class="isi-saran">
                                    @php
                                        $maxLength = 180;
                                        $isiFull = $row->isi_saran;
                                        $isiShort = mb_strlen($isiFull, 'UTF-8') > $maxLength 
                                            ? mb_substr($isiFull, 0, $maxLength, 'UTF-8') . '...' 
                                            : $isiFull;
                                    @endphp
                                    {!! nl2br(e($isiShort)) !!}
                                </td>

                                {{-- AKSI HAPUS --}}
                                <td class="aksi-col">
                                    <button class="icon-btn delete" title="Hapus" onclick="openDeleteModal({{ $row->id }})">
                                        <i class="fa-solid fa-trash" style="color: #ef4444; font-size: 20px; cursor: pointer;"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

        {{-- ========== DETAIL SARAN ========== --}}
        @elseif($action === 'view' && $detail)
            <div class="detail-container detail-page">
                <div class="detail-inner">
                    <div class="detail-back" onclick="window.location.href='{{ route('admin.saran') }}'">⟵</div>

                    @if(!empty($detail->foto_sampul))
                        @php
                            $mime = $detail->foto_type ?? 'image/jpeg';
                            $raw = $detail->foto_sampul;
                            $isBase64 = preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $raw);
                            $base64 = $isBase64 ? $raw : base64_encode($raw);
                            $src = 'data:' . $mime . ';base64,' . $base64;
                        @endphp
                        <img src="{{ $src }}" alt="Foto Saran" class="detail-image">
                    @else
                        <div class="detail-image"></div>
                    @endif
                    
                    <div class="detail-date">
                        {{ \Carbon\Carbon::parse($detail->tanggal_dikirim)->isoFormat('D MMMM Y') }}
                    </div>

                    <div class="detail-title">{{ $detail->judul }}</div>

                    <div class="detail-text">
                        {!! nl2br(e($detail->isi_saran)) !!}
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="deleteModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-icon">!</div>
        <div class="modal-title">Hapus Saran?</div>
        <div class="modal-text">Data yang sudah dihapus tidak bisa dikembalikan.</div>
        <div class="modal-actions">
            <button type="button" class="btn-danger" onclick="confirmDelete()">Ya, hapus</button>
            <button type="button" class="btn-outline" onclick="closeDeleteModal()">Batal</button>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
    let deleteId = null;
    function openDeleteModal(id){ deleteId = id; document.getElementById('deleteModal').style.display = 'flex'; }
    function closeDeleteModal(){ deleteId = null; document.getElementById('deleteModal').style.display = 'none'; }
    function confirmDelete(){ if(deleteId) window.location.href = '{{ route("admin.saran", ["action" => "delete"]) }}&id=' + deleteId; }

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