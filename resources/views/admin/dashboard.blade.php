@extends('layouts.app')

@section('content')

<!-- STYLE -->
<style>

    /* ===== TOP BAR CSS ===== */

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

    

    /* Penambah agar search & profile sejajar ke kanan */

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

        width: 350px;

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

    }

    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .profile-info { text-align: right; }

    .profile-info .name { font-weight: 600; font-size: 14px; color: #1e293b; }

    .profile-info .role { font-size: 12px; color: #94a3b8; }



    /* ===== DASHBOARD CONTENT CSS ===== */

    .dashboard-content {

        /* Wrapper utama */

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

        transition: transform 0.2s;

    }

    .stat-card:hover {

        transform: translateY(-3px);

    }

    .stat-icon-box { 

        width: 52px; 

        height: 52px; 

        border-radius: 14px; 

        background: #f0f4ff; 

        display: flex; 

        align-items: center; 

        justify-content: center; 

        color: #1976d2; 

        font-size: 22px; 

    }

    .stat-label { font-size: 13px; color: #6b7280; font-weight: 500;}

    .stat-value { 

        font-size: 26px; 

        font-weight: 700; 

        margin-top: 4px; 

        color: #1e293b; 

    }

    

    .chart-box { 

        background: white; 

        border-radius: 18px; 

        padding: 24px; 

        box-shadow: 0 8px 20px rgba(15,23,42,0.06); 

        margin-bottom: 30px; 

    }

    .chart-box h4 { margin-top: 0; margin-bottom: 20px; color: #1e293b; }

    

    .saran-box { 

        background: white; 

        border-radius: 18px; 

        padding: 24px; 

        box-shadow: 0 8px 20px rgba(15,23,42,0.06); 

    }

    .saran-box h4 { margin-top: 0; margin-bottom: 16px; color: #1e293b; }

    

    .saran-item { 

        display: flex; 

        gap: 16px; 

        padding: 16px 0; 

        border-bottom: 1px solid #f1f5f9; 

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

        font-weight: bold; 

        color: #4b5563; 

        flex-shrink: 0;

    }

</style>



<div class="dashboard-content">

    

    <!-- 1. TOP BAR -->

    <div class="top-bar">

        <div class="page-header">

            <h1>Dashboard</h1>

            <div class="breadcrumb">Dashboard / Beranda</div>

        </div>

        

        <div class="search-wrapper">

            <!-- Search Box -->

            <form method="get" action="{{ route('admin.kegiatan.index') }}" class="search-box">

                <i class="fas fa-search" style="color: #94a3b8;"></i>

                <input type="text" name="search" placeholder="Cari Kegiatan" value="{{ old('search', $search ?? '') }}">

            </form>

            

            <!-- Profile -->

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



    <!-- 2. STATISTIK -->

    <div class="stats-row">

        <div class="stat-card">

            <div class="stat-icon-box"><i class="fa-solid fa-trophy"></i></div>

            <div>

                <div class="stat-label">Jumlah Prestasi</div>

                <div class="stat-value">{{ $total_prestasi ?? 0 }}</div>

            </div>

        </div>



        <div class="stat-card">

            <div class="stat-icon-box"><i class="fa-solid fa-bullhorn"></i></div>

            <div>

                <div class="stat-label">Kegiatan Desa</div>

                <div class="stat-value">{{ $total_kegiatan ?? 0 }}</div>

            </div>

        </div>



        <div class="stat-card">

            <div class="stat-icon-box"><i class="fa-solid fa-chart-pie"></i></div>

            <div>

                <div class="stat-label">Infografis</div>

                <div class="stat-value">{{ $total_infografis ?? 0 }}</div>

            </div>

        </div>



        <div class="stat-card">

            <div class="stat-icon-box"><i class="fa-solid fa-envelope"></i></div>

            <div>

                <div class="stat-label">Kotak Saran</div>

                <div class="stat-value">{{ $total_saran ?? 0 }}</div>

            </div>

        </div>

    </div>



    <!-- 3. GRAFIK -->

    <div class="chart-box">

        <h4>Grafik Kotak Saran Masuk (6 Bulan Terakhir)</h4>

        <canvas id="saranChart" height="100"></canvas>

    </div>



    <!-- 4. SARAN TERBARU -->

    <div class="saran-box">

        <h4>Daftar Saran Terbaru</h4>

        @if(!isset($saran_list) || $saran_list->isEmpty())

            <p style="text-align:center; color:#9ca3af; margin-top:20px;">Belum ada saran masuk.</p>

        @else

            @foreach($saran_list as $saran)

                <div class="saran-item">

                    <div class="saran-avatar">{{ strtoupper(substr($saran->email ?? 'U', 0, 1)) }}</div>

                    <div>

                        <h5 style="color: #1e293b; margin: 0 0 4px 0;">{{ $saran->judul }}</h5>

                        <small style="color: #94a3b8;">dari {{ $saran->email }}</small>

                        <p style="margin-top: 8px; font-size: 14px; color: #64748b;">

                            {{ Str::limit($saran->isi_saran, 100) }}

                        </p>

                    </div>

                </div>

            @endforeach

        @endif

    </div>



</div>



<!-- Script Chart.js (Pastikan ada CDN chart.js di layout utama atau di sini) -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const ctx = document.getElementById('saranChart').getContext('2d');

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],

            datasets: [{

                label: 'Jumlah Saran',

                data: [5, 10, 8, 15, 12, 20], // Data dummy

                borderColor: '#2f80ed',

                backgroundColor: 'rgba(47, 128, 237, 0.1)',

                tension: 0.4,

                fill: true

            }]

        },

        options: {

            responsive: true,

            plugins: { legend: { display: false } },

            scales: { y: { beginAtZero: true } }

        }

    });

</script>
@endsection