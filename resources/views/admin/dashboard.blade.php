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
        background: #bdddff;
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
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        position: relative;
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

    /* Search Results Dropdown */
    #searchResults {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        margin-top: 8px;
    }
    .search-result-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none;
        color: inherit;
        transition: background 0.2s;
    }
    .search-result-item:hover {
        background: #f8fafc;
    }
    .result-icon {
        width: 40px;
        height: 40px;
        background: #e3f2fd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1976d2;
        flex-shrink: 0;
    }
    .result-content {
        flex: 1;
        min-width: 0;
    }
    .result-title {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }
    .result-desc {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 6px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .search-result-footer {
        padding: 12px 16px;
        text-align: center;
        border-top: 2px solid #f1f5f9;
        background: #f8fafc;
    }
    .search-result-footer a {
        color: #1976d2;
        font-weight: 600;
        text-decoration: none;
    }
    .search-result-footer a:hover {
        text-decoration: underline;
    }

    .profile-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 16px;
        background: white;
        border-radius: 999px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
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
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-info {
        text-align: right;
    }
    .profile-info .name {
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
    }
    .profile-info .role {
        font-size: 12px;
        color: #94a3b8;
    }

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
    box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    border: 2px solid transparent;
}

/* Efek Hover Modern */
.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(25, 118, 210, 0.15);
    border-color: rgba(25, 118, 210, 0.2);
}

/* Gradient overlay saat hover */
.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.03) 0%, rgba(59, 130, 246, 0.03) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.stat-card:hover::before {
    opacity: 1;
}

/* Icon Animation */
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
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 1;
}

.stat-card:hover .stat-icon-box {
    transform: scale(1.15) rotate(-5deg);
    background: linear-gradient(135deg, #1976d2 0%, #3b82f6 100%);
    color: white;
    box-shadow: 0 8px 20px rgba(25, 118, 210, 0.4);
}

/* Angka & Label Animation */
.stat-card .stat-label,
.stat-card .stat-value {
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.stat-card:hover .stat-label {
    color: #1976d2;
    transform: translateX(5px);
}

.stat-card:hover .stat-value {
    color: #1e40af;
    transform: scale(1.05);
}

/* Ripple Effect */
.stat-card::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: radial-gradient(circle, rgba(25, 118, 210, 0.1) 0%, transparent 70%);
    transform: scale(0);
    transition: transform 0.5s ease;
    pointer-events: none;
}

.stat-card:hover::after {
    transform: scale(1.5);
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
    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }
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
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        margin-bottom: 30px;
    }
    .chart-box h4 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #1e293b;
    }

    .saran-box {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
    }
    .saran-box h4 {
        margin-top: 0;
        margin-bottom: 16px;
        color: #1e293b;
    }

    .saran-item {
        display: flex;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .saran-item:last-child {
        border-bottom: none;
    }
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

/* ===== BACKGROUND PATTERN HALUS ===== */
body {
    background-color: #f0f4ff !important;
    background-image: 
        radial-gradient(circle at 20% 30%, rgba(25, 118, 210, 0.04) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(59, 130, 246, 0.04) 0%, transparent 50%),
        radial-gradient(circle at 50% 50%, rgba(147, 51, 234, 0.03) 0%, transparent 50%);
    background-attachment: fixed;
}

body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: radial-gradient(circle, rgba(25, 118, 210, 0.06) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
    z-index: -1; /* Agar di belakang semua konten */
    opacity: 0.5;
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
            <!-- ✅ Search Box: Cari Saran/Kritik (Autocomplete) -->
            <div class="search-box">
                <i class="fas fa-search" style="color: #94a3b8;"></i>
                <input type="text" id="dashboardSearch" placeholder="Cari Saran/Kritik..." autocomplete="off">
                
                {{-- Search Results Dropdown --}}
                <div id="searchResults"></div>
            </div>

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
    <div class="stat-icon-box"><i class="fa-solid fa-folder-open"></i></div>
    <div>
        <div class="stat-label">Pelayanan</div>
        <div class="stat-value">{{ $total_panduan_surat ?? 0 }}</div>
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

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('saranChart').getContext('2d');
    
    // ✅ AMBIL DATA DINAMIS DARI CONTROLLER
    const chartLabels = @json($labels ?? []);
    const chartData = @json($data ?? []);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Saran',
                data: chartData,
                borderColor: '#2f80ed',
                backgroundColor: 'rgba(47, 128, 237, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>

{{-- ✅ SEARCH AUTOCOMPLETE SCRIPT --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('dashboardSearch');
    const resultsContainer = document.getElementById('searchResults');
    let debounceTimer;

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            clearTimeout(debounceTimer);
            
            if (query.length < 2) {
                resultsContainer.style.display = 'none';
                return;
            }
            
            debounceTimer = setTimeout(() => {
                fetchSearchResults(query);
            }, 300);
        });

        // Close results when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-box')) {
                resultsContainer.style.display = 'none';
            }
        });
    }

    function fetchSearchResults(query) {
        fetch(`{{ route('admin.dashboard.search') }}?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                displaySearchResults(data);
            })
            .catch(err => {
                console.error('Search error:', err);
                resultsContainer.innerHTML = `
                    <div style="padding: 16px; color: #ef4444; text-align: center;">
                        <i class="fas fa-exclamation-circle"></i> Gagal memuat hasil
                    </div>
                `;
                resultsContainer.style.display = 'block';
            });
    }

    function displaySearchResults(data) {
        resultsContainer.innerHTML = '';
        
        if (data.saran.length === 0) {
            resultsContainer.innerHTML = `
                <div style="padding: 16px; color: #64748b; text-align: center;">
                    <i class="fas fa-search" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                    Tidak ada hasil ditemukan untuk "${data.query}"
                </div>
            `;
            resultsContainer.style.display = 'block';
            return;
        }

        // Tampilkan hasil saran
        data.saran.forEach(saran => {
            const tanggal = new Date(saran.tanggal_dikirim).toLocaleDateString('id-ID', {
                day: 'numeric', month: 'short', year: 'numeric'
            });
            
            const isiPreview = saran.isi_saran.length > 80 
                ? saran.isi_saran.substring(0, 80) + '...' 
                : saran.isi_saran;

            resultsContainer.innerHTML += `
                <a href="{{ route('admin.saran.index') }}" class="search-result-item">
                    <div class="result-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="result-content">
                        <div class="result-title">${saran.judul}</div>
                        <div class="result-desc">${isiPreview}</div>
                        <small style="color: #94a3b8;">
                            <i class="fas fa-user"></i> ${saran.email} | 
                            <i class="fas fa-calendar"></i> ${tanggal}
                        </small>
                    </div>
                </a>
            `;
        });

        // Tambahkan footer "Lihat Semua"
        resultsContainer.innerHTML += `
            <div class="search-result-footer">
                <a href="{{ route('admin.saran.index') }}">
                    Lihat Semua Hasil (${data.saran.length}) <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        `;

        resultsContainer.style.display = 'block';
    }
});
</script>
@endpush

@endsection