@extends('layouts.app')

@section('content')

{{-- CSS Khusus Dashboard - PASTE CSS ASLI KAMU DI BAWAH INI --}}
<style>
    /* ===== RESET & GLOBAL ===== */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        background: #f4f5fb;
        color: #333;
    }
    a { text-decoration: none; color: inherit; }
    .app { display: flex; min-height: 100vh; }

    /* ===== SIDEBAR ===== */
    .sidebar {
        position: fixed;
        left: 20px;
        top: 90px;
        width: 260px;
        height: calc(100vh - 104px);
        background: linear-gradient(180deg, #1c3f9fff, #3B82F6);
        padding: 24px 20px;
        color: white;
        border-radius: 20px;
        z-index: 40;
    }
    .sidebar-header {
        position: fixed;
        top: 20px;
        left: 20px;
        width: 220px;
        background: transparent;
        padding: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .sidebar-header div {
        color: #000000ff;
        font-weight: 600;
        font-size: 15px;
    }
    .sidebar-header img {
        height: 48px;
        width: auto;
        display: block;
        object-fit: contain;
    }
    .menu {
        margin-top: 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .menu-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 999px;
        font-size: 13px;
        opacity: .9;
        color: #e5e7ff;
    }
    .menu-item:hover {
        background: rgba(255,255,255,.15);
        cursor: pointer;
    }
    .menu-item.active {
        background: #38BDF8;
        opacity: 1;
        font-weight: 600;
        color: #fff;
    }
    .menu-item img { width: 22px; }
    .sidebar-footer {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
    }
    .sidebar-footer .logout {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 12px 18px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
    }
    .sidebar-footer .logout img { width: 20px; height: 20px; }

    /* ===== MAIN ===== */
    .main {
        margin-top: -3px;
        margin-left: 260px;
        padding: 30px 40px;
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 0;
    }

    /* ===== TOP BAR ===== */
    .top-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        margin-bottom: 24px;
    }
    .profile-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .profile-text {
        text-align: right;
        font-size: 12px;
    }
    .profile-text .name{font-weight:600}
    .profile-text .role{font-size:11px;color:#9ca3af}
    .profile-avatar{
        width:38px;
        height:38px;
        border-radius:999px;
        background:#f97316;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:600;
        font-size:16px;
        color:#fff;
        overflow:hidden;
    }
    .profile-avatar img{
        width:100%;
        height:100%;
        object-fit:cover;
        border-radius:999px;
    }

    /* ===== KONTEN ===== */
    .page-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 24px;
    }
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
    }
    .stat-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #f0f4ff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4c52ceff;
        font-size: 24px;
    }
    .stat-label { font-size: 13px; color: #6b7280; }
    .stat-value { font-size: 26px; font-weight: 700; margin-top: 4px; color: #1c3f9f; }

    /* Chart */
    .chart-box {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 8px 20px rgba(15,23,42,0.06);
        height: 300px;
        margin-bottom: 30px;
    }
    .chart-box h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #333;
    }

    /* Saran */
    .saran-box {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 8px 20px rgba(15,23,42,0.06);
    }
    .saran-box h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #333;
    }
    .saran-item {
        display: flex;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }
    .saran-item:last-child { border-bottom: none; }
    .saran-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        color: #6b7280;
        overflow: hidden;
    }
    .saran-content h5 {
        margin: 0 0 6px;
        font-size: 15px;
        font-weight: 600;
        color: #1c3f9f;
    }
    .saran-date {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 6px;
    }
    .saran-desc {
        font-size: 13px;
        line-height: 1.5;
        color: #555;
    }

    /* Canvas Chart */
    #saranChart {
        width: 100% !important;
        height: 220px !important;
    }
    .swal2-rounded { border-radius: 20px !important; }
    
    .btn-red {
        background: linear-gradient(180deg, #1c3f9fff, #3B82F6) !important;
        color: white !important;
        padding: 8px 20px !important;
        border-radius: 10px !important;
        margin-right: 10px;
        border: none !important;
        cursor: pointer;
    }
    .btn-gray {
        background-color: #4a5568 !important;
        color: white !important;
        padding: 8px 20px !important;
        border-radius: 10px !important;
        border: none !important;
        outline: none !important;
        cursor: pointer;
    }
    .btn-red:hover, .btn-gray:hover { opacity: .9; }
    
    .box {
      width: 200px;
      height: 200px;
      position: relative;
      border: 3px solid #00eaff;
      box-shadow: 0 0 15px #00eaff;
      border-radius: 10px;
    }
    .dot {
      position: absolute;
      width: 12px;
      height: 12px;
      background: #00eaff;
      border-radius: 50%;
      box-shadow: 0 0 10px #00eaff;
      animation: walk 4s linear infinite;
    }
    @keyframes walk {
      0%   { top: -6px; left: -6px; }
      25%  { top: -6px; left: calc(100% - 6px); }
      50%  { top: calc(100% - 6px); left: calc(100% - 6px); }
      75%  { top: calc(100% - 6px); left: -6px; }
      100% { top: -6px; left: -6px; }
    }
    .swal2-popup {
        position: relative !important;
        overflow: visible !important;
        border-radius: 20px !important;
        box-shadow: 0 0 25px rgba(0, 234, 255, 0.6) !important;
        border: 2px solid #00eaff !important;
    }
    .swal-dot {
        position: absolute;
        width: 12px;
        height: 12px;
        background: #00eaff;
        border-radius: 50%;
        box-shadow: 0 0 10px #00eaff;
        animation: walkBorder 4s linear infinite;
        z-index: 9999;
    }
    @keyframes walkBorder {
        0%   { top: -6px; left: -6px; }                          
        25%  { top: -6px; left: calc(100% - 6px); }              
        50%  { top: calc(100% - 6px); left: calc(100% - 6px); }  
        75%  { top: calc(100% - 6px); left: -6px; }              
        100% { top: -6px; left: -6px; }                          
    }
    
    /* Smooth Scroll */
    html { scroll-behavior: smooth; }
</style>

<div class="app">
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo Nganjuk">
            <div>Desa Banjardowo</div>
        </div>

        <div class="menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item active">
                <img src="{{ asset('assets/icons/dashboard1.png') }}" alt=""> Dashboard
            </a>
            <a href="{{ route('admin.kegiatan') }}" class="menu-item">
                <img src="{{ asset('assets/icons/kegiatandesa.png') }}" alt=""> Kegiatan Desa
            </a>
            <a href="{{ route('admin.prestasi') }}" class="menu-item">
                <img src="{{ asset('assets/icons/prestasi.png') }}" alt=""> Prestasi
            </a>
            <a href="{{ route('admin.saran') }}" class="menu-item">
                <img src="{{ asset('assets/icons/kotaksaran1.png') }}" alt=""> Kotak Saran
            </a>
            <a href="{{ route('admin.pelayanan') }}" class="menu-item">
                <img src="{{ asset('assets/icons/pelayanan1.png') }}" alt=""> Pelayanan
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
        <!-- TOP BAR -->
        <div class="top-bar">
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

        <h1 class="page-title">Dashboard</h1>

        <!-- STATISTIK -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon-box"><i class="fa-solid fa-trophy"></i></div>
                <div class="stat-text">
                    <div class="stat-label">Jumlah Prestasi</div>
                    <div class="stat-value">{{ $total_prestasi ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-box"><i class="fa-solid fa-bullhorn"></i></div>
                <div class="stat-text">
                    <div class="stat-label">Kegiatan Desa</div>
                    <div class="stat-value">{{ $total_kegiatan ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-box"><i class="fa-solid fa-envelope"></i></div>
                <div class="stat-text">
                    <div class="stat-label">Kotak Saran Masuk</div>
                    <div class="stat-value">{{ $total_saran ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-box"><i class="fa-solid fa-users"></i></div>
                <div class="stat-text">
                    <div class="stat-label">Pelayanan Aktif</div>
                    <div class="stat-value">{{ $total_panduan_surat ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- GRAFIK -->
        <div class="chart-box">
            <h4>Grafik Kotak Saran Masuk (6 Bulan Terakhir)</h4>
            <canvas id="saranChart"></canvas>
        </div>

        <!-- SARAN TERBARU -->
        <div class="saran-box">
            <h4>Daftar Saran Terbaru</h4>
            
            @if(!isset($saran_list) || $saran_list->isEmpty())
                <p style="text-align:center; color:#9ca3af; margin-top:20px;">Belum ada saran masuk.</p>
            @else
                @foreach($saran_list as $saran)
                    <a href="{{ route('admin.saran') }}" class="saran-item-link">
                    <div class="saran-item">
                        <div class="saran-avatar">
                            @if(!empty($saran->foto_sampul))
                                @php
                                    $mime = $saran->foto_type ?? 'image/jpeg';
                                    $raw = $saran->foto_sampul;
                                    $isBase64 = preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $raw);
                                    $src = $isBase64 ? 'data:' . $mime . ';base64,' . $raw : 'data:' . $mime . ';base64,' . base64_encode($raw);
                                @endphp
                                <img src="{{ $src }}" alt="Foto Saran" style="width:42px;height:42px;border-radius:50%;object-fit:cover;display:block;">
                            @else
                                {{ strtoupper(substr($saran->email ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                        <div class="saran-content">
                            <h5>{{ $saran->judul }}</h5>
                            <div class="saran-date">
                                dari {{ $saran->email }} • 
                                {{ \Carbon\Carbon::parse($saran->tanggal_dikirim)->isoFormat('D MMMM Y') }}
                            </div>
                            <div class="saran-desc">
                                {!! nl2br(e(Str::limit($saran->isi_saran, 100))) !!}...
                            </div>
                        </div>
                    </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Ambil data dari controller (pastikan ada ?? [] agar tidak error jika kosong)
    const chartLabels = @json($labels ?? []);
    const chartData = @json($data ?? []);

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('saranChart');
        
        // Cek apakah elemen chart ada di halaman
        if (ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Jumlah Saran',
                        data: chartData,
                        backgroundColor: '#5E63BB',
                        borderColor: '#4a4ebf',
                        borderWidth: 1,
                        borderRadius: 6,
                        barPercentage: 0.7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => `Saran: ${ctx.parsed.y}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f0f0f0' },
                            ticks: { stepSize: 1 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    });

    // Fungsi Logout
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
// Animasi SweetAlert dot
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