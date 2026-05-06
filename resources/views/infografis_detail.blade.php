{{-- SECTION INFOGRAFIS --}}
<section class="section" id="infografis">
    <div class="section-title">
        <h2>Infografis</h2>
        <p>Memberikan informasi lengkap mengenai karakteristik demografi penduduk suatu wilayah. Mulai dari jumlah penduduk, usia, jenis kelamin, tingkat pendidikan, pekerjaan, dan aspek penting lainnya yang menggambarkan komposisi populasi secara rinci.</p>
    </div>

    <!-- BAGIAN 1: Berdasarkan Jumlah Penduduk Dan Kepala Keluarga -->
    <div class="infografis-subtitle">Berdasarkan Jumlah Penduduk Dan Kepala Keluarga</div>
    <div class="infografis-grid">
        
        <!-- Total Penduduk -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['total_penduduk']['icon'] ?? asset('assets/icons/penduduk.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Total Penduduk</h3>
                <div class="number">{{ number_format($infografis['total_penduduk']['value'] ?? 4456) }}</div>
                <small>Jiwa</small>
            </div>
        </div>

        <!-- Kepala Keluarga -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['kepala_keluarga']['icon'] ?? asset('assets/icons/family.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Kepala Keluarga</h3>
                <div class="number">{{ number_format($infografis['kepala_keluarga']['value'] ?? 1250) }}</div>
                <small>KK</small>
            </div>
        </div>

        <!-- Laki-laki -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['laki_laki']['icon'] ?? asset('assets/icons/male.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Laki-laki</h3>
                <div class="number">{{ number_format($infografis['laki_laki']['value'] ?? 2200) }}</div>
                <small>Jiwa</small>
            </div>
        </div>

        <!-- Perempuan -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['perempuan']['icon'] ?? asset('assets/icons/female.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Perempuan</h3>
                <div class="number">{{ number_format($infografis['perempuan']['value'] ?? 2256) }}</div>
                <small>Jiwa</small>
            </div>
        </div>
    </div>

    <!-- BAGIAN 2: Berdasarkan Perkawinan -->
    <h3 class="infografis-subtitle">Berdasarkan Perkawinan</h3>
    <div class="infografis-grid">
        
        <!-- Belum Kawin -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['perkawinan']['belum_kawin']['icon'] ?? asset('assets/icons/bk.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Belum Kawin</h3>
                <div class="number">{{ number_format($infografis['perkawinan']['belum_kawin']['value'] ?? 1200) }}</div>
            </div>
        </div>

        <!-- Kawin -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['perkawinan']['kawin']['icon'] ?? asset('assets/icons/k.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Kawin</h3>
                <div class="number">{{ number_format($infografis['perkawinan']['kawin']['value'] ?? 2800) }}</div>
            </div>
        </div>

        <!-- Cerai Mati -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['perkawinan']['cerai_mati']['icon'] ?? asset('assets/icons/cm.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Cerai Mati</h3>
                <div class="number">{{ number_format($infografis['perkawinan']['cerai_mati']['value'] ?? 200) }}</div>
            </div>
        </div>

        <!-- Cerai Hidup -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['perkawinan']['cerai_hidup']['icon'] ?? asset('assets/icons/ch.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Cerai Hidup</h3>
                <div class="number">{{ number_format($infografis['perkawinan']['cerai_hidup']['value'] ?? 150) }}</div>
            </div>
        </div>

        <!-- Kawin Tercatat -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['perkawinan']['kawin_tercatat']['icon'] ?? asset('assets/icons/kt.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Kawin Tercatat</h3>
                <div class="number">{{ number_format($infografis['perkawinan']['kawin_tercatat']['value'] ?? 2500) }}</div>
            </div>
        </div>

        <!-- Kawin Tidak Tercatat -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['perkawinan']['kawin_tidak_tercatat']['icon'] ?? asset('assets/icons/ktt.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Kawin Tidak Tercatat</h3>
                <div class="number">{{ number_format($infografis['perkawinan']['kawin_tidak_tercatat']['value'] ?? 300) }}</div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 3: Berdasarkan Kelompok Umur (Pyramid Chart) -->
    <h3 class="infografis-subtitle">Berdasarkan Kelompok Umur</h3>
    <div class="pyramid-chart-container">
        <canvas id="pyramidChart"></canvas>
    </div>

    <!-- BAGIAN 4: Berdasarkan Pendidikan -->
    <h3 class="infografis-subtitle">Berdasarkan Pendidikan</h3>
    <div class="chart-container">
        <canvas id="pendidikanChart"></canvas>
    </div>

    <!-- BAGIAN 5: Berdasarkan Pekerjaan -->
    <h3 class="infografis-subtitle">Berdasarkan Pekerjaan</h3>
    <div class="infografis-grid">
        
        <!-- Belum/Tidak Bekerja -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['pekerjaan']['belum_tidak_bekerja']['icon'] ?? asset('assets/icons/bb.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Belum/Tidak Bekerja</h3>
                <div class="number">{{ number_format($infografis['pekerjaan']['belum_tidak_bekerja']['value'] ?? 1850) }}</div>
            </div>
        </div>

        <!-- Pelajar/Mahasiswa -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['pekerjaan']['pelajar_mahasiswa']['icon'] ?? asset('assets/icons/m.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Pelajar/Mahasiswa</h3>
                <div class="number">{{ number_format($infografis['pekerjaan']['pelajar_mahasiswa']['value'] ?? 680) }}</div>
            </div>
        </div>

        <!-- Pegawai Negeri -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['pekerjaan']['pegawai_negeri']['icon'] ?? asset('assets/icons/pn.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Pegawai Negeri</h3>
                <div class="number">{{ number_format($infografis['pekerjaan']['pegawai_negeri']['value'] ?? 320) }}</div>
            </div>
        </div>

        <!-- Karyawan Swasta -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['pekerjaan']['karyawan_swasta']['icon'] ?? asset('assets/icons/ps.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Karyawan Swasta</h3>
                <div class="number">{{ number_format($infografis['pekerjaan']['karyawan_swasta']['value'] ?? 550) }}</div>
            </div>
        </div>

        <!-- Petani/Pekebun -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['pekerjaan']['petani_pekebun']['icon'] ?? asset('assets/icons/p.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Petani/Pekebun</h3>
                <div class="number">{{ number_format($infografis['pekerjaan']['petani_pekebun']['value'] ?? 420) }}</div>
            </div>
        </div>

        <!-- Pedagang -->
        <div class="info-card">
            <div class="info-left">
                <img src="{{ $infografis['pekerjaan']['pedagang']['icon'] ?? asset('assets/icons/D.png') }}" 
                     alt="Icon" class="info-icon" onerror="this.style.display='none'">
            </div>
            <div class="info-content">
                <h3>Pedagang</h3>
                <div class="number">{{ number_format($infografis['pekerjaan']['pedagang']['value'] ?? 280) }}</div>
            </div>
        </div>
    </div>
</section>

{{-- CSS KHUSUS INFOGRAFIS --}}
<style>
    .infografis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .info-card {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #f5f7fb;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        min-height: 110px;
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .info-left {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-icon {
        width: 60px;
        height: 60px;
        object-fit: contain;
    }

    .info-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex: 1;
    }

    .info-content h3 {
        font-size: 15px;
        font-weight: 600;
        color: #1c3f9f;
        margin-bottom: 5px;
        line-height: 1.3;
    }

    .info-content .number {
        font-size: 26px;
        font-weight: 700;
        color: #5b6ee1;
        line-height: 1.2;
    }

    .info-content small {
        font-size: 12px;
        color: #6b7280;
        margin-top: 2px;
    }

    .pyramid-chart-container,
    .chart-container {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-top: 30px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .infografis-grid {
            grid-template-columns: 1fr;
        }
        
        .info-card {
            min-height: 90px;
            padding: 15px;
        }
        
        .info-icon {
            width: 50px;
            height: 50px;
        }
        
        .info-content h3 {
            font-size: 14px;
        }
        
        .info-content .number {
            font-size: 22px;
        }
    }
</style>

{{-- JAVASCRIPT KHUSUS INFOGRAFIS (CHARTS) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pyramid Chart (Kelompok Umur)
        const pyramidCtx = document.getElementById('pyramidChart');
        if (pyramidCtx) {
            const umurLabels = ['0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60-64', '65-69', '70-74', '75-79', '80-84', '85+'];
            
            const lakiData = [
                @foreach($infografis['kelompok_umur'] as $kelompok) {{ $kelompok['laki'] }}, @endforeach
            ];
            const perempuanData = [
                @foreach($infografis['kelompok_umur'] as $kelompok) {{ $kelompok['perempuan'] }}, @endforeach
            ];

            new Chart(pyramidCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: umurLabels,
                    datasets: [
                        { label: 'Laki-Laki', data: lakiData, backgroundColor: 'rgba(46, 204, 113, 0.8)', borderColor: 'rgba(46, 204, 113, 1)', borderWidth: 1 },
                        { label: 'Perempuan', data: perempuanData, backgroundColor: 'rgba(255, 99, 132, 0.8)', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 1 }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Kelompok Umur (Laki-Laki vs Perempuan)', font: { size: 16, weight: 'bold' } }
                    },
                    scales: {
                        x: { stacked: false, title: { display: true, text: 'Jumlah Penduduk' } },
                        y: { stacked: false, title: { display: true, text: 'Kelompok Umur' } }
                    }
                }
            });
        }

        // Pendidikan Chart
        const pendidikanCtx = document.getElementById('pendidikanChart');
        if (pendidikanCtx) {
            const pendidikanLabels = ['Tidak/Belum Sekolah', 'Belum Tamat SD/Sederajat', 'Tamat SD/Sederajat', 'SLTP/Sederajat', 'SLTA/Sederajat', 'Diploma I/II', 'Diploma III/Sarjana Muda', 'Diploma IV/Strata I', 'Strata II', 'Strata III'];
            const pendidikanData = [
                {{ $infografis['pendidikan']['tidak_belum_sekolah'] }},
                {{ $infografis['pendidikan']['belum_tamat_sd'] }},
                {{ $infografis['pendidikan']['tamat_sd'] }},
                {{ $infografis['pendidikan']['sltp_sederajat'] }},
                {{ $infografis['pendidikan']['slta_sederajat'] }},
                {{ $infografis['pendidikan']['diploma_i_ii'] }},
                {{ $infografis['pendidikan']['diploma_iii_sarjana_muda'] }},
                {{ $infografis['pendidikan']['diploma_iv_strata_i'] }},
                {{ $infografis['pendidikan']['strata_ii'] }},
                {{ $infografis['pendidikan']['strata_iii'] }}
            ];

            new Chart(pendidikanCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: pendidikanLabels,
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: pendidikanData,
                        backgroundColor: 'rgba(28, 63, 159, 0.8)',
                        borderColor: 'rgba(28, 63, 159, 1)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Tingkat Pendidikan Penduduk', font: { size: 16, weight: 'bold' } },
                        tooltip: { callbacks: { label: function(context) { return context.parsed.y + ' jiwa'; } } }
                    },
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Jumlah Penduduk' } },
                        x: { ticks: { maxRotation: 45, minRotation: 45 } }
                    }
                }
            });
        }
    });
</script>