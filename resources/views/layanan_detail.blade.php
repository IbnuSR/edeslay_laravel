{{-- SECTION LAYANAN SURAT ONLINE --}}
<section class="section" id="layanan">
    <div class="section-title">
        <h2>Pengajuan Surat Online</h2>
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

    <!-- MODE FULL VIEW -->
    <div class="layanan-fullview" id="layananFullView" style="display: none;">
        <div class="layanan-fullview-header">
            <h3>Daftar Semua Layanan Surat Online</h3>
            <button class="btn-close-fullview" onclick="tutupFullView()">
                <i class="fas fa-times"></i> Tutup
            </button>
        </div>
        
        <div class="layanan-fullview-grid">
            <div class="layanan-card-full" onclick="bukaDetailLayanan('ktp')">
                <div class="layanan-icon-full"><i class="fas fa-id-card"></i></div>
                <p>Surat Pengantar KTP</p>
            </div>
            <div class="layanan-card-full" onclick="bukaDetailLayanan('skck')">
                <div class="layanan-icon-full"><i class="fas fa-shield-alt"></i></div>
                <p>Surat Keterangan SKCK</p>
            </div>
            <div class="layanan-card-full" onclick="bukaDetailLayanan('domisili')">
                <div class="layanan-icon-full"><i class="fas fa-home"></i></div>
                <p>Surat Keterangan Domisili</p>
            </div>
            <div class="layanan-card-full" onclick="bukaDetailLayanan('miskin')">
                <div class="layanan-icon-full"><i class="fas fa-hand-holding-heart"></i></div>
                <p>Surat Tidak Mampu</p>
            </div>
            <div class="layanan-card-full" onclick="bukaDetailLayanan('kelahiran')">
                <div class="layanan-icon-full"><i class="fas fa-baby"></i></div>
                <p>Surat Kelahiran</p>
            </div>
            <div class="layanan-card-full" onclick="bukaDetailLayanan('kematian')">
                <div class="layanan-icon-full"><i class="fas fa-book-dead"></i></div>
                <p>Surat Kematian</p>
            </div>
            <div class="layanan-card-full" onclick="bukaDetailLayanan('pindah')">
                <div class="layanan-icon-full"><i class="fas fa-truck-moving"></i></div>
                <p>Surat Pindah Domisili</p>
            </div>
            <div class="layanan-card-full" onclick="bukaDetailLayanan('usaha')">
                <div class="layanan-icon-full"><i class="fas fa-store"></i></div>
                <p>Surat Keterangan Usaha</p>
            </div>
        </div>
    </div>

    <button class="slider-btn" id="btnLihatSemua" onclick="bukaFullView()" style="margin-top: 2rem;">
        Lihat Semua Pengajuan Surat Online
    </button>
</section>

{{-- MODAL DETAIL LAYANAN --}}
<div id="layananModal" class="layanan-modal-overlay">
    <div class="layanan-modal-content">
        <div class="layanan-modal-header">
            <h2 id="modalTitle">Judul Layanan</h2>
            <button class="modal-close-btn" onclick="tutupModal()">&times;</button>
        </div>
        <div class="layanan-modal-body">
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
        <div class="layanan-modal-footer">
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

    /* ===== LAYANAN FULL VIEW MODE ===== */
    .layanan-fullview {
        animation: fadeIn 0.4s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .layanan-fullview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }
    .layanan-fullview-header h3 {
        color: #1c3f9f;
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }
    .btn-close-fullview {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }
    .btn-close-fullview:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }
    .layanan-fullview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 2rem;
    }
    .layanan-card-full {
        background: white;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
        cursor: pointer;
    }
    .layanan-card-full:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }
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
    .layanan-card-full p {
        color: #374151;
        font-weight: 600;
        font-size: 1rem;
        margin: 0;
    }

    /* ===== MODAL LAYANAN DETAIL ===== */
    .layanan-modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .layanan-modal-overlay.active {
        display: flex;
        opacity: 1;
    }
    .layanan-modal-content {
        background: white;
        width: 90%;
        max-width: 700px;
        max-height: 85vh;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        overflow-y: auto;
        transform: scale(0.9);
        transition: transform 0.3s ease;
        position: relative;
    }
    .layanan-modal-overlay.active .layanan-modal-content {
        transform: scale(1);
    }
    .layanan-modal-header {
        padding: 2rem 2rem 1rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
    }
    .layanan-modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
        color: #1c3f9f;
        flex: 1;
        padding-right: 20px;
    }
    .modal-close-btn {
        background: #f3f4f6;
        border: none;
        width: 36px; height: 36px;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }
    .modal-close-btn:hover { background: #e5e7eb; color: #000; }
    .layanan-modal-body { padding: 2rem; }
    .modal-section { margin-bottom: 2rem; }
    .modal-section h3 {
        font-size: 1.1rem;
        color: #374151;
        margin-bottom: 1rem;
        display: flex; align-items: center; gap: 10px;
    }
    .modal-section h3 i { color: #667eea; }
    .modal-steps-list, .modal-docs-list {
        padding-left: 20px;
        margin: 0;
    }
    .modal-steps-list li, .modal-docs-list li {
        margin-bottom: 0.8rem;
        line-height: 1.6;
        color: #4b5563;
    }
    .layanan-modal-footer {
        padding: 1rem 2rem 2rem;
        text-align: center;
        border-top: 1px solid #eee;
    }
    .btn-primary-modal {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 30px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-primary-modal:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }

    /* Custom Scrollbar for Modal */
    .layanan-modal-content::-webkit-scrollbar { width: 8px; }
    .layanan-modal-content::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .layanan-modal-content::-webkit-scrollbar-thumb { background: #c7c7c7; border-radius: 10px; }
    .layanan-modal-content::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }

    @media (max-width: 768px) {
        .layanan-wrapper { padding: 0 40px; }
        .layanan-card { flex: 0 0 calc(50% - 0.75rem); }
        .layanan-fullview-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
    }
    @media (max-width: 480px) {
        .layanan-card { flex: 0 0 100%; }
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
                'Pas foto berwarna 3x4 (latar biru/merah) - Sesuaikan kebutuhan kecamatan.',
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
                'Cek kembali nama dan data pada surat pengantar sebelum ditandatangani.',
                'Bawa surat pengantar ini ke Kepolisian (Polsek) untuk proses cetak SKCK.'
            ],
            docs: [
                'Fotokopi KTP yang masih berlaku.',
                'Fotokopi Kartu Keluarga (KK).',
                'Fotokopi Akta Kelahiran.',
                'Pas foto berwarna 4x6 (latar merah) - 6 lembar.',
                'Sidik jari (bisa dilakukan di Polsek).'
            ]
        },
        'domisili': {
            title: 'Surat Keterangan Domisili',
            steps: [
                'Kunjungi Kantor Desa/Kelurahan tempat tinggal saat ini.',
                'Jelaskan tujuan pembuatan Surat Keterangan Domisili.',
                'Isi formulir yang diberikan petugas.',
                'Lampirkan bukti pendukung tempat tinggal (misal: sewa rumah/kontrak jika bukan pemilik).',
                'Tunggu proses tanda tangan dan stempel resmi.'
            ],
            docs: [
                'KTP Asli dan Fotokopi.',
                'Kartu Keluarga (KK) Asli dan Fotokopi.',
                'Pas foto 3x4 (2 lembar).',
                'Surat sewa/kontrak rumah atau surat pernyataan tidak menumpang (jika diperlukan).'
            ]
        },
        'miskin': {
            title: 'Surat Keterangan Tidak Mampu',
            steps: [
                'Datang ke Kantor Desa/Kelurahan.',
                'Sampaikan tujuan pengurusan Surat Keterangan Tidak Mampu.',
                'Petugas akan melakukan verifikasi data kependudukan.',
                'Isi formulir pernyataan tidak mampu.',
                'Surat akan diterbitkan dan ditandatangani Kepala Desa.'
            ],
            docs: [
                'Fotokopi KTP Pemohon.',
                'Fotokopi Kartu Keluarga (KK).',
                'Surat Pengantar dari RT/RW.',
                'Fotokopi rekening listrik/air (sebagai bukti kondisi ekonomi - opsional).'
            ]
        },
        'kelahiran': {
            title: 'Surat Pengantar Kelahiran',
            steps: [
                'Laporkan kelahiran anak ke Desa/Kelurahan paling lambat 30 hari setelah kelahiran.',
                'Bawa surat keterangan dari bidan atau dokter yang menangani persalinan.',
                'Isi formulir laporan kelahiran.',
                'Desa akan menerbitkan surat pengantar untuk pembuatan Akta Kelahiran di Disdukcapil.'
            ],
            docs: [
                'Surat Keterangan Lahir dari Bidan/Dokter/Rumah Sakit.',
                'Fotokopi KTP Ayah dan Ibu.',
                'Fotokopi Kartu Keluarga (KK).',
                'Fotokopi Buku Nikah/Akta Nikah Orang Tua.',
                'Fotokopi KTP 2 orang saksi.'
            ]
        },
        'kematian': {
            title: 'Surat Pengantar Kematian',
            steps: [
                'Laporkan kematian ke Desa/Kelurahan paling lambat 30 hari setelah kematian.',
                'Bawa surat keterangan kematian dari dokter/Rumah Sakit (jika ada).',
                'Isi formulir laporan kematian.',
                'Desa akan menerbitkan surat pengantar untuk penghapusan data di Disdukcapil.'
            ],
            docs: [
                'Surat Keterangan Kematian dari Dokter/RS (jika meninggal di RS).',
                'Fotokopi KTP Almarhum/Almarhumah.',
                'Fotokopi Kartu Keluarga (KK).',
                'Fotokopi KTP Pelapor dan 2 orang saksi.'
            ]
        },
        'pindah': {
            title: 'Surat Pindah Domisili',
            steps: [
                'Datang ke Kantor Desa/Kelurahan asal.',
                'Isi formulir permohonan pindah.',
                'Serahkan dokumen pendukung.',
                'Desa akan menerbitkan Surat Pengantar Pindah (F-1.03) untuk diproses di Kecamatan dan Disdukcapil.',
                'Setelah surat pindah keluar, lapor ke Desa tujuan.'
            ],
            docs: [
                'KTP Asli dan Fotokopi seluruh anggota keluarga yang pindah.',
                'Kartu Keluarga (KK) Asli.',
                'Surat Pengantar dari RT/RW.',
                'Alasan pindah (opsional: kerja, ikut suami, dll).'
            ]
        },
        'usaha': {
            title: 'Surat Keterangan Usaha',
            steps: [
                'Datang ke Kantor Desa/Kelurahan.',
                'Minta formulir Surat Keterangan Usaha.',
                'Isi detail jenis usaha, lokasi, dan pemilik.',
                'Petugas desa mungkin melakukan survey lokasi usaha (tergantung kebijakan).',
                'Surat diterbitkan dan ditandatangani Kepala Desa.'
            ],
            docs: [
                'Fotokopi KTP Pemilik Usaha.',
                'Fotokopi Kartu Keluarga (KK).',
                'Bukti kepemilikan tempat usaha (Sertifikat tanah/Sewa/Kontrak).',
                'Pas foto pemilik 3x4 (2 lembar).'
            ]
        }
    };

    // ===== FUNGSI MODAL =====
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
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function tutupModal() {
        const modal = document.getElementById('layananModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    document.getElementById('layananModal').addEventListener('click', function(e) {
        if (e.target === this) {
            tutupModal();
        }
    });

    // ===== LAYANAN INFINITE CAROUSEL =====
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.getElementById('layananTrack');
        if (!track) return;
        
        const originalCards = Array.from(track.children);
        const GAP = 24;
        let CARD_WIDTH = 0;
        let autoInterval = null;
        const CLONE_COUNT = 3;
        let isHovering = false;
        let isTransitioning = false;

        function initInfiniteCarousel() {
            track.innerHTML = '';
            
            const clonesStart = originalCards.slice(0, CLONE_COUNT).map(c => c.cloneNode(true));
            const clonesEnd = originalCards.slice(-CLONE_COUNT).map(c => c.cloneNode(true));
            
            clonesEnd.forEach(c => track.appendChild(c));
            originalCards.forEach(c => track.appendChild(c));
            clonesStart.forEach(c => track.insertBefore(c, track.firstChild));
            
            updateDimensions();
            track.scrollLeft = CLONE_COUNT * (CARD_WIDTH + GAP);
        }

        function updateDimensions() {
            const trackWidth = track.clientWidth;
            CARD_WIDTH = (trackWidth - (GAP * 2)) / 3;
            track.querySelectorAll('.layanan-card').forEach(card => {
                card.style.minWidth = `${CARD_WIDTH}px`;
                card.style.flex = `0 0 ${CARD_WIDTH}px`;
            });
        }

        function scrollNext() {
            if (isTransitioning) return;
            isTransitioning = true;
            track.scrollBy({ left: CARD_WIDTH + GAP, behavior: 'smooth' });
            setTimeout(() => { isTransitioning = false; }, 600);
        }
        
        function scrollPrev() {
            if (isTransitioning) return;
            isTransitioning = true;
            track.scrollBy({ left: -(CARD_WIDTH + GAP), behavior: 'smooth' });
            setTimeout(() => { isTransitioning = false; }, 600);
        }

        track.addEventListener('scrollend', () => {
            const maxScroll = track.scrollWidth - track.clientWidth;
            const threshold = CLONE_COUNT * (CARD_WIDTH + GAP);
            
            if (track.scrollLeft >= maxScroll - 1) {
                track.style.scrollBehavior = 'auto';
                track.scrollLeft = threshold;
                setTimeout(() => { track.style.scrollBehavior = 'smooth'; }, 50);
            }
            else if (track.scrollLeft <= threshold - (CARD_WIDTH + GAP)) {
                track.style.scrollBehavior = 'auto';
                track.scrollLeft = maxScroll - threshold;
                setTimeout(() => { track.style.scrollBehavior = 'smooth'; }, 50);
            }
        });

        function startAuto() {
            if (autoInterval) {
                clearInterval(autoInterval);
                autoInterval = null;
            }
            
            if (!isHovering) {
                autoInterval = setInterval(() => {
                    if (!isHovering && !isTransitioning) {
                        scrollNext();
                    }
                }, 3000);
            }
        }
        
        function stopAuto() {
            if (autoInterval) {
                clearInterval(autoInterval);
                autoInterval = null;
            }
        }

        track.addEventListener('mouseenter', () => {
            isHovering = true;
            stopAuto();
        });
        
        track.addEventListener('mouseleave', () => {
            isHovering = false;
            startAuto();
        });

        const prevBtn = document.querySelector('.layanan-nav-btn.prev');
        const nextBtn = document.querySelector('.layanan-nav-btn.next');
        
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                scrollPrev();
                stopAuto();
                setTimeout(() => {
                    if (!isHovering) startAuto();
                }, 5000);
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                scrollNext();
                stopAuto();
                setTimeout(() => {
                    if (!isHovering) startAuto();
                }, 5000);
            });
        }

        initInfiniteCarousel();
        startAuto();
        
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                updateDimensions();
                track.scrollLeft = CLONE_COUNT * (CARD_WIDTH + GAP);
            }, 200);
        });
    });

    // ===== FUNGSI BUKA/TUTUP FULL VIEW =====
    let autoIntervalBackup = null;
    
    function bukaFullView() {
        document.getElementById('layananSliderMode').style.display = 'none';
        document.getElementById('btnLihatSemua').style.display = 'none';
        document.getElementById('layananFullView').style.display = 'block';
        
        if (typeof stopAuto === 'function') {
            stopAuto();
        }
        
        document.getElementById('layanan').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    function tutupFullView() {
        document.getElementById('layananFullView').style.display = 'none';
        document.getElementById('layananSliderMode').style.display = 'block';
        document.getElementById('btnLihatSemua').style.display = 'block';
        
        if (typeof startAuto === 'function') {
            startAuto();
        }
    }
    
    window.geserLayanan = function(direction) {
        const track = document.getElementById('layananTrack');
        if (!track) return;
        
        const CARD_WIDTH = track.querySelector('.layanan-card').offsetWidth;
        const GAP = 24;
        track.scrollBy({ left: direction * (CARD_WIDTH + GAP), behavior: 'smooth' });
    };
</script>