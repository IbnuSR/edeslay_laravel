@extends('layouts.app')

@section('content')

{{-- CSS Khusus Dashboard --}}
<style>
    /* ===== PASTE SEMUA CSS ASLI KAMU DI SINI ===== */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        background: #f4f5fb;
        color: #333;
    }
    a { text-decoration: none; color: inherit; }
    .app { display: flex; min-height: 100vh; }
    /* ... (semua CSS sidebar, main, chart, dll tetap sama) ... */
    
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
    // Data dari controller via @json (aman)
    const chartLabels = @json($labels ?? []);
    const chartData = @json($data ?? []);

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('saranChart');
        if (ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                 {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Jumlah Saran',
                         chartData,
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
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f0f0f0' }, ticks: { stepSize: 1 } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
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