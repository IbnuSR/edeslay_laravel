{{-- SECTION LAYANAN SURAT ONLINE --}}
<section class="section" id="layanan">
    <div class="section-header">
        <div class="section-title">
            <h2>Panduan Pengajuan Surat Desa</h2>
            <p>Layanan pembuatan surat administrasi desa secara digital.</p>
        </div>
        @if($layananList->count() > 0)
        <button class="see-all-btn" onclick="bukaLayananFullView()">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </button>
        @endif
    </div>
    
    <!-- MODE SLIDER (Default) -->
    <div class="layanan-wrapper" id="layananSliderMode">
        <button class="layanan-nav-btn prev" onclick="geserLayanan(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <div class="layanan-track" id="layananTrack">
            @forelse($layananList as $layanan)
            <div class="layanan-card" onclick="bukaDetailLayanan({{ $layanan->id }}, 'db')">
                @if($layanan->foto_url)
                <img src="{{ $layanan->foto_url }}" alt="{{ $layanan->judul }}" class="layanan-img">
                @else
                <div class="layanan-icon"><i class="fas fa-file-alt"></i></div>
                @endif
                <p>{{ Str::limit($layanan->judul, 30) }}</p>
            </div>
            @empty
            <div style="flex: 0 0 100%; color: #6b7280; padding: 2rem; text-align: center;">
                <i class="fas fa-info-circle" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>Belum ada layanan tersedia.</p>
            </div>
            @endforelse
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
            @foreach($layananList as $layanan)
            <div class="card-full" onclick="bukaDetailLayanan({{ $layanan->id }}, 'db')">
                @if($layanan->foto_url)
                <img src="{{ $layanan->foto_url }}" alt="{{ $layanan->judul }}" class="card-full-img">
                @else
                <div class="layanan-icon-full"><i class="fas fa-file-alt"></i></div>
                @endif
                <p>{{ $layanan->judul }}</p>
            </div>
            @endforeach
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
            <img id="modalImage" src="" alt="" style="width: 100%; max-height: 300px; object-fit: contain; margin-bottom: 1.5rem; border-radius: 12px; display: none;">
            <div class="modal-section">
                <h3><i class="fas fa-info-circle"></i> Deskripsi</h3>
                <p id="modalDeskripsi"></p>
            </div>
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
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }
    .layanan-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    .layanan-img {
        width: 70px;
        height: 70px;
        object-fit: contain;
        margin: 0 auto 1rem;
        border-radius: 16px;
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
        font-size: 0.95rem;
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
    .card-full-img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        margin: 0 auto 1rem;
        border-radius: 18px;
    }
</style>

{{-- JAVASCRIPT KHUSUS LAYANAN --}}
<script>
    // ===== DATA DARI CONTROLLER (DATABASE) =====
    const layananDataDB = @json($layananList);
    
    // ===== FUNGSI MODAL LAYANAN =====
    function bukaDetailLayanan(id, source = 'db') {
        let data;
        
        if (source === 'db') {
            // Ambil dari database
            data = layananDataDB.find(l => l.id == id);
        }
        
        if (!data) return;

        // Set judul
        document.getElementById('modalTitle').textContent = data.judul || data.title;
        
        // Set gambar jika ada (hanya untuk database)
        const modalImg = document.getElementById('modalImage');
        if (modalImg && data.foto_url) {
            modalImg.src = data.foto_url;
            modalImg.style.display = 'block';
        } else if (modalImg) {
            modalImg.style.display = 'none';
        }
        
        // Set deskripsi
        const deskripsiEl = document.getElementById('modalDeskripsi');
        if (deskripsiEl) {
            deskripsiEl.textContent = data.deskripsi_singkat || 'Tidak ada deskripsi tersedia.';
        }

        // Set steps (Cara Mengurus) - dari isi_panduan
        const stepsList = document.getElementById('modalSteps');
        stepsList.innerHTML = '';
        
        if (data.isi_panduan) {
            // Pisahkan berdasarkan baris baru
            const steps = data.isi_panduan.split('\n');
            steps.forEach(step => {
                const trimmedStep = step.trim();
                if (trimmedStep) {
                    const li = document.createElement('li');
                    li.textContent = trimmedStep;
                    stepsList.appendChild(li);
                }
            });
        } else {
            const li = document.createElement('li');
            li.textContent = 'Informasi cara mengurus belum tersedia.';
            stepsList.appendChild(li);
        }

        // ✅ SET DOCS (Dokumen Wajib Dibawa) - dari dokumen_wajib (TEXT, bukan JSON)
        const docsList = document.getElementById('modalDocs');
        docsList.innerHTML = '';
        
        if (data.dokumen_wajib && data.dokumen_wajib.trim() !== '') {
            // Pisahkan berdasarkan baris baru
            const docs = data.dokumen_wajib.split('\n');
            docs.forEach(doc => {
                const trimmedDoc = doc.trim();
                if (trimmedDoc) {
                    const li = document.createElement('li');
                    li.innerHTML = `<i class="fas fa-check-circle" style="color:#10b981; margin-right:5px;"></i> ${trimmedDoc}`;
                    docsList.appendChild(li);
                }
            });
        } else {
            const li = document.createElement('li');
            li.textContent = 'Informasi dokumen belum tersedia.';
            docsList.appendChild(li);
        }

        // Show modal
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
        if (!track || track.children.length === 0) return;

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