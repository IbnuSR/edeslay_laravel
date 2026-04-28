@extends('layouts.app')

@section('content')

{{-- CSS Khusus Layanan Admin --}}
<style>
    /* ===== PASTE CSS DESAIN KAMU DI SINI ===== */
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
    .sidebar-footer .logout { display: flex; align-items: center; gap: 10px; width: 100%; padding: 12px 18px; text-decoration: none; font-size: 14px; font-weight: 500; cursor: pointer; }
    .sidebar-footer .logout img { width: 20px; height: 20px; }
    .main { margin-top: -3px; margin-left: 260px; padding: 30px 40px; display: flex; flex-direction: column; flex: 1; min-width: 0; }
    .top-bar { display: flex; align-items: center; justify-content: flex-end; margin-bottom: 24px; }
    .profile-wrapper { display: flex; align-items: center; gap: 10px; }
    .profile-text { text-align: right; font-size: 12px; }
    .profile-text .name{font-weight:600}
    .profile-text .role{font-size:11px;color:#9ca3af}
    .profile-avatar{width:38px;height:38px;border-radius:999px;background:#f97316;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:16px;color:#fff;overflow:hidden;}
    .profile-avatar img{width:100%;height:100%;object-fit:cover;border-radius:999px;}
    .page-title { font-size: 24px; font-weight: 700; margin-bottom: 24px; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 6px 16px rgba(15,23,42,0.06); text-align: center; }
    .stat-value { font-size: 28px; font-weight: 700; color: #1c3f9f; }
    .stat-label { font-size: 13px; color: #6b7280; margin-top: 4px; }
    .content-card { background: white; border-radius: 18px; padding: 24px; box-shadow: 0 8px 20px rgba(15,23,42,0.06); margin-bottom: 20px; }
    .table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    .table th { color: #6b7280; font-weight: 500; }
    .btn-primary { background: #3B82F6; color: white; padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; }
    .btn-danger { background: #ef4444; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; }
    .alert { padding: 12px; border-radius: 8px; margin-bottom: 16px; }
    .alert-success { background: #d4edda; color: #155724; }
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
                <img src="{{ asset('assets/icons/dashboard1.png') }}"> Dashboard
            </a>
            <a href="{{ route('admin.kegiatan.index') }}" class="menu-item">
                <img src="{{ asset('assets/icons/kegiatandesa.png') }}"> Kegiatan Desa
            </a>
            <a href="{{ route('admin.prestasi.index') }}" class="menu-item">
                <img src="{{ asset('assets/icons/prestasi.png') }}"> Prestasi
            </a>
            <a href="{{ route('admin.saran.index') }}" class="menu-item">
                <img src="{{ asset('assets/icons/kotaksaran1.png') }}"> Kotak Saran
            </a>
            <a href="{{ route('admin.pelayanan.index') }}" class="menu-item active">
                <img src="{{ asset('assets/icons/pelayanan1.png') }}"> Pelayanan
            </a>
        </div>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: inline;">
                @csrf
                <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="{{ asset('assets/icons/logout1.png') }}"> <span>Keluar</span>
                </a>
            </form>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main">
        <!-- TOP BAR -->
        <div class="top-bar">
            <div class="profile-wrapper">
                <div class="profile-text">
                    <div class="name">{{ $namaAdmin }}</div>
                    <div class="role">{{ $roleAdmin }}</div>
                </div>
                <a href="{{ route('admin.profile') }}" class="profile-avatar">
                    @if($fotoProfilSrc)
                        <img src="{{ $fotoProfilSrc }}" alt="Profil">
                    @else
                        {{ $inisialAdmin }}
                    @endif
                </a>
            </div>
        </div>

        <h1 class="page-title">Manajemen Pelayanan</h1>

        <!-- Statistik -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_pengajuan'] }}</div>
                <div class="stat-label">Total Pengajuan</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color:#f59e0b">{{ $stats['pending'] }}</div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color:#10b981">{{ $stats['approved'] }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color:#ef4444">{{ $stats['rejected'] }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>

        <!-- Panduan Surat -->
        <div class="content-card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                <h3 style="font-size:18px;font-weight:600;">Panduan Pengajuan Surat</h3>
                <button class="btn-primary" onclick="document.getElementById('formPanduan').style.display='block'">
                    + Tambah Panduan
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($panduanList as $panduan)
                    <tr>
                        <td>{{ $panduan->judul }}</td>
                        <td>
                            <span style="background:#e0f2fe;color:#0369a1;padding:4px 8px;border-radius:4px;font-size:12px;">
                                {{ ucfirst($panduan->kategori) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($panduan->created_at)->isoFormat('D MMM Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.pelayanan.index', $panduan->id) }}" style="display:inline;" onsubmit="return confirm('Hapus panduan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:#9ca3af;padding:20px;">Belum ada panduan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Form Tambah Panduan (Hidden by default) -->
        <div class="content-card" id="formPanduan" style="display:none;">
            <h3 style="margin-bottom:16px;">Tambah Panduan Baru</h3>
            <form method="POST" action="{{ route('admin.pelayanan.index') }}">
                @csrf
                <div style="margin-bottom:12px;">
                    <label style="display:block;margin-bottom:4px;font-weight:500;">Judul Panduan</label>
                    <input type="text" name="judul" required style="width:100%;padding:10px;border:1px solid #cbd5e1;border-radius:8px;">
                </div>
                <div style="margin-bottom:12px;">
                    <label style="display:block;margin-bottom:4px;font-weight:500;">Kategori</label>
                    <select name="kategori" required style="width:100%;padding:10px;border:1px solid #cbd5e1;border-radius:8px;">
                        <option value="ktp">Surat Pengantar KTP</option>
                        <option value="domisili">Surat Domisili</option>
                        <option value="usaha">Surat Usaha</option>
                        <option value="kelahiran">Surat Kelahiran</option>
                        <option value="kematian">Surat Kematian</option>
                    </select>
                </div>
                <div style="margin-bottom:12px;">
                    <label style="display:block;margin-bottom:4px;font-weight:500;">Konten Panduan</label>
                    <textarea name="konten" rows="5" required style="width:100%;padding:10px;border:1px solid #cbd5e1;border-radius:8px;"></textarea>
                </div>
                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn-primary">Simpan</button>
                    <button type="button" class="btn-danger" onclick="document.getElementById('formPanduan').style.display='none'" style="background:#6b7280;">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection