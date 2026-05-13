{{-- SECTION LAYANAN SURAT ONLINE --}}
<section class="section" id="layanan">
    <div class="section-header">
        <div class="section-title">
            <h2>Pengajuan Surat Online</h2>
            <p>Layanan pembuatan surat administrasi desa secara digital.</p>
        </div>
        <button class="see-all-btn" onclick="bukaLayananFullView()">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </button>
    </div>
    
    <!-- MODE SLIDER (Default) -->
    <div class="layanan-wrapper" id="layananSliderMode">
        <button class="layanan-nav-btn prev" onclick="geserLayanan(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <div class="layanan-track" id="layananTrack">
            <div class="layanan-card" onclick="bukaDetailLayanan('ktp')">
                <div class="layanan-icon"><i class="fas fa-id-card"></i></div>
                <p>Surat Pengantar KTP</p>
            </div>
            <div class="layanan-card" onclick="bukaDetailLayanan('skck')">
                <div class="layanan-icon"><i class="fas fa-shield-alt"></i></div>
                <p>Surat Keterangan SKCK</p>
            </div>
            <div class="layanan-card" onclick="bukaDetailLayanan('domisili')">
                <div class="layanan-icon"><i class="fas fa-home"></i></div>
                <p>Surat Keterangan Domisili</p>
            </div>
            <div class="layanan-card" onclick="bukaDetailLayanan('miskin')">
                <div class="layanan-icon"><i class="fas fa-hand-holding-heart"></i></div>
                <p>Surat Tidak Mampu</p>
            </div>
            <div class="layanan-card" onclick="bukaDetailLayanan('kelahiran')">
                <div class="layanan-icon"><i class="fas fa-baby"></i></div>
                <p>Surat Kelahiran</p>
            </div>
            <div class="layanan-card" onclick="bukaDetailLayanan('kematian')">
                <div class="layanan-icon"><i class="fas fa-book-dead"></i></div>
                <p>Surat Kematian</p>
            </div>
            <div class="layanan-card" onclick="bukaDetailLayanan('pindah')">
                <div class="layanan-icon"><i class="fas fa-truck-moving"></i></div>
                <p>Surat Pindah Domisili</p>
            </div>
            <div class="layanan-card" onclick="bukaDetailLayanan('usaha')">
                <div class="layanan-icon"><i class="fas fa-store"></i></div>
                <p>Surat Keterangan Usaha</p>
            </div>
        </div>

        <button class="layanan-nav-btn next" onclick="geserLayanan(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <!-- MODE FULL VIEW (Hidden by default) -->
    <div class="fullview" id="layananFullView" style="display: none;">
        <div class="fullview-header">
            <h3>Daftar Semua Layanan Surat Online</h3>
            <button class="btn-close-fullview" onclick="tutupLayananFullView()">
                <i class="fas fa-times"></i> Tutup
            </button>
        </div>
        
        <div class="fullview-grid">
            <div class="card-full" onclick="bukaDetailLayanan('ktp')">
                <div class="layanan-icon-full"><i class="fas fa-id-card"></i></div>
                <p>Surat Pengantar KTP</p>
            </div>
            <div class="card-full" onclick="bukaDetailLayanan('skck')">
                <div class="layanan-icon-full"><i class="fas fa-shield-alt"></i></div>
                <p>Surat Keterangan SKCK</p>
            </div>
            <div class="card-full" onclick="bukaDetailLayanan('domisili')">
                <div class="layanan-icon-full"><i class="fas fa-home"></i></div>
                <p>Surat Keterangan Domisili</p>
            </div>
            <div class="card-full" onclick="bukaDetailLayanan('miskin')">
                <div class="layanan-icon-full"><i class="fas fa-hand-holding-heart"></i></div>
                <p>Surat Tidak Mampu</p>
            </div>
            <div class="card-full" onclick="bukaDetailLayanan('kelahiran')">
                <div class="layanan-icon-full"><i class="fas fa-baby"></i></div>
                <p>Surat Kelahiran</p>
            </div>
            <div class="card-full" onclick="bukaDetailLayanan('kematian')">
                <div class="layanan-icon-full"><i class="fas fa-book-dead"></i></div>
                <p>Surat Kematian</p>
            </div>
            <div class="card-full" onclick="bukaDetailLayanan('pindah')">
                <div class="layanan-icon-full"><i class="fas fa-truck-moving"></i></div>
                <p>Surat Pindah Domisili</p>
            </div>
            <div class="card-full" onclick="bukaDetailLayanan('usaha')">
                <div class="layanan-icon-full"><i class="fas fa-store"></i></div>
                <p>Surat Keterangan Usaha</p>
            </div>
        </div>
    </div>
</section>

{{-- MODAL DETAIL LAYANAN --}}
<div id="layananModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Judul Layanan</h2>
            <button class="modal-close-btn" onclick="tutupModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="modal-section">
                <h3><i class="fas fa-clipboard-list"></i> Cara Mengurus</h3>
                <ol id="modalSteps" class="modal-steps-list">
                    <!-- List item akan diisi JS -->
                </ol>
            </div>
            <div class="modal-section">
                <h3><i class="fas fa-folder-open"></i> Dokumen Wajib Dibawa</h3>
                <ul id="modalDocs" class="modal-docs-list">
                    <!-- List item akan diisi JS -->
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-primary-modal" onclick="tutupModal()">Tutup</button>
        </div>
    </div>
</div>

{{-- CSS KHUSUS LAYANAN --}}
<style>
    /* ===== LAYANAN SLIDER ===== */
    .layanan-wrapper {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 50px;
    }
    .layanan-track {
        display: flex;
        gap: 1.5rem;
        overflow: hidden;
        scroll-behavior: smooth;
        padding: 1rem 0;
        scrollbar-width: none;
    }
    .layanan-track::-webkit-scrollbar { display: none; }
    
    .layanan-card {
        flex: 0 0 calc(33.333% - 1rem);
        min-width: 0;
        background: white;
        border-radius: 16px;
        padding: 2rem 1rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }
    .layanan-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    .layanan-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        transition: transform 0.3s;
    }
    .layanan-card:hover .layanan-icon { transform: scale(1.05); }
    .layanan-card p {
        color: #374151;
        font-weight: 600;
        font-size: 0.9rem;
        margin: 0;
        line-height: 1.4;
    }
    .layanan-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: white;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        cursor: pointer;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-size: 1.1rem;
        transition: all 0.3s;
    }
    .layanan-nav-btn:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-50%) scale(1.1);
    }
    .layanan-nav-btn.prev { left: 0; }
    .layanan-nav-btn.next { right: 0; }

    .layanan-icon-full {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 18px;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.2rem;
    }
    .card-full {
        background: white;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
        cursor: pointer;
    }
    .card-full:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }
    .card-full p {
        color: #374151;
        font-weight: 600;
        font-size: 1rem;
        margin: 0;
    }
</style>

{{-- JAVASCRIPT KHUSUS LAYANAN --}}
<script>
    // ===== DATA DETAIL LAYANAN =====
    const layananData = {
        'ktp': {
            title: 'Surat Pengantar KTP',
            steps: [
                'Datang ke Kantor Desa/Kelurahan membawa dokumen persyaratan.',
                'Minta formulir pengajuan Surat Pengantar KTP ke petugas.',
                'Isi formulir dengan lengkap dan benar.',
                'Serahkan formulir beserta dokumen persyaratan.',
                'Tunggu proses verifikasi data oleh petugas.',
                'Ambil surat pengantar yang sudah ditandatangani oleh Kepala Desa/Lurah.'
            ],
            docs: [
                'Fotokopi Kartu Keluarga (KK) terbaru.',
                'Fotokopi Akta Kelahiran.',
                'Pas foto berwarna 3x4 (latar biru/merah).',
                'Surat Pengantar dari RT/RW (jika diminta).'
            ]
        },
        'skck': {
            title: 'Surat Keterangan SKCK',
            steps: [
                'Datang ke Kantor Desa/Kelurahan.',
                'Minta formulir pengantar SKCK.',
                'Isi data diri sesuai dengan KTP/KK.',
                'Serahkan ke petugas untuk diproses.',
                'Cek kembali nama dan data pada surat pengantar.',
                'Bawa surat pengantar ini ke Kepolisian (Polsek).'
            ],
            docs: [
                'Fotokopi KTP yang masih berlaku.',
                'Fotokopi Kartu Keluarga (KK).',
                'Fotokopi Akta Kelahiran.',
                'Pas foto berwarna 4x6 (latar merah) - 6 lembar.'
            ]
        },
        'domisili': {
            title: 'Surat Keterangan Domisili',
            steps: [
                'Kunjungi Kantor Desa/Kelurahan tempat tinggal.',
                'Jelaskan tujuan pembuatan Surat Keterangan Domisili.',
                'Isi formulir yang diberikan petugas.',
                'Lampirkan bukti pendukung tempat tinggal.',
                'Tunggu proses tanda tangan dan stempel resmi.'
            ],
            docs: [
                'KTP Asli dan Fotokopi.',
                'Kartu Keluarga (KK) Asli dan Fotokopi.',
                'Pas foto 3x4 (2 lembar).'
            ]
        },
        'miskin': {
            title: 'Surat Keterangan Tidak Mampu',
            steps: [
                'Datang ke Kantor Desa/Kelurahan.',
                'Sampaikan tujuan pengurusan Surat Keterangan Tidak Mampu.',
                'Petugas akan melakukan verifikasi data.',
                'Isi formulir pernyataan tidak mampu.',
                'Surat akan diterbitkan dan ditandatangani.'
            ],
            docs: [
                'Fotokopi KTP Pemohon.',
                'Fotokopi Kartu Keluarga (KK).',
                'Surat Pengantar dari RT/RW.'
            ]
        },
        'kelahiran': {
            title: 'Surat Pengantar Kelahiran',
            steps: [
                'Laporkan kelahiran anak ke Desa/Kelurahan.',
                'Bawa surat keterangan dari bidan/dokter.',
                'Isi formulir laporan kelahiran.',
                'Desa akan menerbitkan surat pengantar.'
            ],
            docs: [
                'Surat Keterangan Lahir dari Bidan/Dokter.',
                'Fotokopi KTP Ayah dan Ibu.',
                'Fotokopi Kartu Keluarga (KK).',
                'Fotokopi Buku Nikah Orang Tua.'
            ]
        },
        'kematian': {
            title: 'Surat Pengantar Kematian',
            steps: [
                'Laporkan kematian ke Desa/Kelurahan.',
                'Bawa surat keterangan kematian dari dokter/RS.',
                'Isi formulir laporan kematian.',
                'Desa akan menerbitkan surat pengantar.'
            ],
            docs: [
                'Surat Keterangan Kematian dari Dokter/RS.',
                'Fotokopi KTP Almarhum/Almarhumah.',
                'Fotokopi Kartu Keluarga (KK).'
            ]
        },
        'pindah': {
            title: 'Surat Pindah Domisili',
            steps: [
                'Datang ke Kantor Desa/Kelurahan asal.',
                'Isi formulir permohonan pindah.',
                'Serahkan dokumen pendukung.',
                'Desa akan menerbitkan Surat Pengantar Pindah.'
            ],
            docs: [
                'KTP Asli dan Fotokopi seluruh anggota keluarga.',
                'Kartu Keluarga (KK) Asli.',
                'Surat Pengantar dari RT/RW.'
            ]
        },
        'usaha': {
            title: 'Surat Keterangan Usaha',
            steps: [
                'Datang ke Kantor Desa/Kelurahan.',
                'Minta formulir Surat Keterangan Usaha.',
                'Isi detail jenis usaha, lokasi, dan pemilik.',
                'Surat diterbitkan dan ditandatangani.'
            ],
            docs: [
                'Fotokopi KTP Pemilik Usaha.',
                'Fotokopi Kartu Keluarga (KK).',
                'Bukti kepemilikan tempat usaha.'
            ]
        }
    };

    // ===== FUNGSI MODAL LAYANAN =====
    function bukaDetailLayanan(key) {
        const data = layananData[key];
        if (!data) return;

        document.getElementById('modalTitle').textContent = data.title;

        const stepsList = document.getElementById('modalSteps');
        stepsList.innerHTML = '';
        data.steps.forEach(step => {
            const li = document.createElement('li');
            li.textContent = step;
            stepsList.appendChild(li);
        });

        const docsList = document.getElementById('modalDocs');
        docsList.innerHTML = '';
        data.docs.forEach(doc => {
            const li = document.createElement('li');
            li.innerHTML = `<i class="fas fa-check-circle" style="color:#10b981; margin-right:5px;"></i> ${doc}`;
            docsList.appendChild(li);
        });

        const modal = document.getElementById('layananModal');
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('active');
            modal.querySelector('.modal-content').classList.add('active');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function tutupModal() {
        const modal = document.getElementById('layananModal');
        modal.classList.remove('active');
        modal.querySelector('.modal-content').classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
        document.body.style.overflow = '';
    }

    document.getElementById('layananModal').addEventListener('click', function(e) {
        if (e.target === this) {
            tutupModal();
        }
    });

    // ===== LAYANAN SLIDER NAVIGATION =====
    function geserLayanan(direction) {
        const track = document.getElementById('layananTrack');
        if (!track) return;
        
        const CARD_WIDTH = track.querySelector('.layanan-card').offsetWidth;
        const GAP = 24;
        track.scrollBy({ left: direction * (CARD_WIDTH + GAP), behavior: 'smooth' });
    }

    // ===== AUTO SCROLL LAYANAN SLIDER =====
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.getElementById('layananTrack');
        if (!track) return;

        let autoInterval = null;
        let isHovering = false;

        function scrollNext() {
            const CARD_WIDTH = track.querySelector('.layanan-card').offsetWidth;
            const GAP = 24;
            const maxScroll = track.scrollWidth - track.clientWidth;
            
            if (track.scrollLeft >= maxScroll - 1) {
                track.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: CARD_WIDTH + GAP, behavior: 'smooth' });
            }
        }

        function startAuto() {
            if (autoInterval) clearInterval(autoInterval);
            if (!isHovering) {
                autoInterval = setInterval(scrollNext, 4000);
            }
        }

        function stopAuto() {
            if (autoInterval) {
                clearInterval(autoInterval);
                autoInterval = null;
            }
        }

        track.addEventListener('mouseenter', () => { isHovering = true; stopAuto(); });
        track.addEventListener('mouseleave', () => { isHovering = false; startAuto(); });

        startAuto();
    });

    // ===== FUNGSI BUKA/TUTUP FULL VIEW LAYANAN =====
    function bukaLayananFullView() {
        document.getElementById('layananSliderMode').style.display = 'none';
        document.querySelector('#layanan .see-all-btn').style.display = 'none';
        document.getElementById('layananFullView').style.display = 'block';
        document.getElementById('layanan').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    function tutupLayananFullView() {
        document.getElementById('layananFullView').style.display = 'none';
        document.getElementById('layananSliderMode').style.display = 'block';
        document.querySelector('#layanan .see-all-btn').style.display = 'inline-flex';
    }
</script>