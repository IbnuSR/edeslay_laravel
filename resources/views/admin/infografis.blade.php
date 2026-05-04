{{-- SECTION INFOGRAFIS --}}
<section class="section" id="infografis">
    <div class="section-title">
        <h2>Infografis</h2>
        <p>Memberikan informasi lengkap mengenai karakteristik demografi penduduk suatu wilayah. Mulai dari jumlah penduduk, usia, jenis kelamin, tingkat pendidikan, pekerjaan, dan aspek penting lainnya yang menggambarkan komposisi populasi secara rinci.</p>
    </div>

    <h3 class="infografis-subtitle">Berdasarkan Jumlah Penduduk Dan Kepala Keluarga</h3>
    <div class="infografis-grid">
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content">
                <h3>Total Penduduk</h3>
                <div class="number">{{ number_format($infografis['total_penduduk']) }} Jiwa</div>
            </div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content">
                <h3>Kepala Keluarga</h3>
                <div class="number">{{ number_format($infografis['kepala_keluarga']) }} Jiwa</div>
            </div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content">
                <h3>Laki-Laki</h3>
                <div class="number">{{ number_format($infografis['laki_laki']) }} Jiwa</div>
            </div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content">
                <h3>Perempuan</h3>
                <div class="number">{{ number_format($infografis['perempuan']) }} Jiwa</div>
            </div>
        </div>
    </div>

    <h3 class="infografis-subtitle">Berdasarkan Perkawinan</h3>
    <div class="infografis-grid">
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Belum Kawin</h3><div class="number">{{ number_format($infografis['perkawinan']['belum_kawin']) }}</div></div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Kawin</h3><div class="number">{{ number_format($infografis['perkawinan']['kawin']) }}</div></div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Cerai Mati</h3><div class="number">{{ number_format($infografis['perkawinan']['cerai_mati']) }}</div></div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Cerai Hidup</h3><div class="number">{{ number_format($infografis['perkawinan']['cerai_hidup']) }}</div></div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Kawin Tercatat</h3><div class="number">{{ number_format($infografis['perkawinan']['kawin_tercatat']) }}</div></div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Kawin Tidak Tercatat</h3><div class="number">{{ number_format($infografis['perkawinan']['kawin_tidak_tercatat']) }}</div></div>
        </div>
    </div>

    <h3 class="infografis-subtitle">Berdasarkan Kelompok Umur</h3>
    <div class="pyramid-chart-container">
        <canvas id="pyramidChart"></canvas>
    </div>

    <h3 class="infografis-subtitle">Berdasarkan Pendidikan</h3>
    <div class="chart-container">
        <canvas id="pendidikanChart"></canvas>
    </div>

    <h3 class="infografis-subtitle">Berdasarkan Pekerjaan</h3>
    <div class="infografis-grid">
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Belum/Tidak Bekerja</h3><div class="number">{{ number_format($infografis['pekerjaan']['belum_tidak_bekerja']) }}</div></div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Pelajar/Mahasiswa</h3><div class="number">{{ number_format($infografis['pekerjaan']['pelajar_mahasiswa']) }}</div></div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Pegawai Negeri</h3><div class="number">{{ number_format($infografis['pekerjaan']['pegawai_negeri']) }}</div></div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Karyawan Swasta</h3><div class="number">{{ number_format($infografis['pekerjaan']['karyawan_swasta']) }}</div></div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Petani/Pekebun</h3><div class="number">{{ number_format($infografis['pekerjaan']['petani_pekebun']) }}</div></div>
        </div>
        <div class="info-card">
            <img src="https://via.placeholder.com/80?text=Icon" alt="Icon" class="info-icon">
            <div class="info-content"><h3>Pedagang</h3><div class="number">{{ number_format($infografis['pekerjaan']['pedagang']) }}</div></div>
        </div>
    </div>
</section>

{{-- JAVASCRIPT KHUSUS INFOGRAFIS (CHARTS) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pyramid Chart (Kelompok Umur)
        const pyramidCtx = document.getElementById('pyramidChart');
        if (pyramidCtx) {
            const umurLabels = ['0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60-64', '65-69', '70-74', '75-79', '80-84', '85+'];
            const lakiData = [122, 181, 225, 217, 180, 174, 156, 167, 173, 140, 123, 81, 80, 56, 31, 30, 26, 0];
            const perempuanData = [111, 211, 205, 204, 191, 172, 164, 161, 177, 147, 105, 99, 61, 57, 30, 52, 0, 0];

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
            const pendidikanData = [931, 249, 1533, 708, 674, 16, 32, 302, 11, 0];

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