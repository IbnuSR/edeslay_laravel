<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Deslay - Desa Banjardowo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* ===== GLOBAL RESET & BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f8f9fc; color: #333; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }
        
        /* ===== HEADER ===== */
        .header {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(12px);
            padding: 0.8rem 5%;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }
        .header-container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo-section { display: flex; align-items: center; gap: 12px; }
        .header-logo { width: 48px; height: 48px; object-fit: contain; flex-shrink: 0; }
        .logo-text h1 { color: #1c3f9f; font-size: 1.15rem; font-weight: 700; margin: 0; line-height: 1.2; }
        .logo-text p { color: #6b7280; font-size: 0.78rem; margin: 0; line-height: 1.2; }
        .nav-menu { display: flex; gap: 1.2rem; align-items: center; }
        .nav-menu a { color: #6b7280; font-weight: 500; font-size: 0.88rem; transition: all 0.3s; padding: 6px 10px; border-radius: 6px; }
        .nav-menu a:hover { color: #1c3f9f; background: rgba(28, 63, 159, 0.06); }
        .login-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white !important; padding: 8px 20px; border-radius: 25px; font-weight: 600; font-size: 0.85rem; transition: all 0.3s; }
        .login-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .mobile-menu-btn { display: none; background: none; border: none; color: #1c3f9f; font-size: 1.5rem; cursor: pointer; padding: 8px; }

        /* ===== HERO SLIDER ===== */
        .hero-slider { margin-top: 72px; position: relative; height: 580px; overflow: hidden; border-radius: 0 0 30px 30px; }
        .hero-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-size: cover; background-position: center; opacity: 0; transition: opacity 0.8s ease-in-out; transform: scale(1.05); }
        .hero-slide.active { opacity: 1; transform: scale(1); transition: opacity 0.8s ease-in-out, transform 6s ease-out; }
        .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.7) 100%); display: flex; align-items: center; justify-content: center; text-align: center; color: white; }
        .hero-content { max-width: 700px; padding: 2rem; animation: fadeInUp 0.8s ease; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .hero-content h1 { font-size: 3rem; font-weight: 800; margin-bottom: 0.8rem; text-shadow: 0 2px 10px rgba(0,0,0,0.3); line-height: 1.2; }
        .hero-content p { font-size: 1.3rem; margin-bottom: 1rem; opacity: 0.95; font-weight: 500; }
        .hero-tagline { display: inline-block; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); padding: 10px 24px; border-radius: 25px; font-size: 0.95rem; border: 1px solid rgba(255,255,255,0.25); }
        .hero-nav-btn { position: absolute; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; border-radius: 50%; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); color: white; font-size: 1.2rem; cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; transition: all 0.3s; }
        .hero-nav-btn:hover { background: rgba(255,255,255,0.4); transform: translateY(-50%) scale(1.1); }
        .hero-nav-btn.prev { left: 25px; }
        .hero-nav-btn.next { right: 25px; }
        .hero-indicators { position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); display: flex; gap: 10px; z-index: 10; }
        .hero-dot { width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.4); cursor: pointer; transition: all 0.3s; border: 2px solid rgba(255,255,255,0.6); }
        .hero-dot.active { background: white; transform: scale(1.2); border-color: white; }

        /* ===== SECTIONS & TITLES ===== */
        .section { padding: 4rem 5%; max-width: 1400px; margin: 0 auto; }
        .section-title { text-align: center; margin-bottom: 3rem; }
        .section-title h2 { font-size: 2rem; color: #1c3f9f; font-weight: 700; margin-bottom: 0.5rem; }
        .section-title p { color: #6b7280; font-size: 1rem; max-width: 800px; margin: 0 auto; }
        .infografis-subtitle { font-size: 1.5rem; color: #1c3f9f; font-weight: 700; margin-bottom: 1.5rem; margin-top: 3rem; }

        /* ===== VISI MISI ===== */
        .visi-misi-box { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 3rem; border-radius: 20px; color: white; text-align: center; max-width: 1000px; margin: 0 auto; }
        .visi-misi-box h2 { font-size: 2rem; margin-bottom: 1.5rem; }
        .visi-misi-box p { font-size: 1.1rem; line-height: 1.8; }

        /* ===== CARDS SLIDER (Kegiatan & Prestasi) ===== */
        .cards-slider { position: relative; overflow: hidden; }
        .cards-track { display: flex; gap: 2rem; transition: transform 0.5s ease; }
        .card { min-width: calc(33.333% - 1.33rem); background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        .card-image { width: 100%; height: 200px; object-fit: cover; }
        .card-content { padding: 1.5rem; }
        .card h3 { color: #1c3f9f; font-size: 1.1rem; margin-bottom: 0.75rem; font-weight: 600; }
        .card p { color: #6b7280; font-size: 0.9rem; line-height: 1.6; }
        .card-date { display: flex; align-items: center; gap: 8px; color: #9ca3af; font-size: 0.8rem; margin-top: 1rem; }
        .slider-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 28px; border-radius: 25px; border: none; font-weight: 600; cursor: pointer; transition: all 0.3s; display: block; margin: 2rem auto 0; }
        .slider-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }

        /* ===== INFOGRAFIS GRID & CHARTS ===== */
        .infografis-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem; }
        .info-card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 1.5rem; }
        .info-icon { width: 80px; height: 80px; flex-shrink: 0; }
        .info-content h3 { color: #1c3f9f; font-size: 1.1rem; margin-bottom: 0.5rem; }
        .info-content .number { color: #667eea; font-size: 1.8rem; font-weight: 700; }
        .pyramid-chart-container, .chart-container { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 2rem; }

        /* ===== STRUKTUR GRID ===== */
        .struktur-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
        .struktur-card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); text-align: center; transition: all 0.3s; }
        .struktur-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        .struktur-card h3 { color: #1c3f9f; font-size: 1.1rem; margin-bottom: 0.5rem; }
        .struktur-card p { color: #6b7280; font-size: 0.95rem; }

        /* ===== DOWNLOAD & FOOTER ===== */
        .download-section { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 4rem 5%; text-align: center; }
        .download-section h2 { color: white; font-size: 2rem; margin-bottom: 0.5rem; }
        .download-section p { color: rgba(255,255,255,0.9); margin-bottom: 2rem; }
        .download-btn { background: white; color: #667eea; padding: 16px 40px; border-radius: 30px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: all 0.3s; }
        .download-btn:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.3); }
        .footer { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 5% 1.5rem; }
        .footer-content { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; margin-bottom: 2rem; }
        .footer-logo { width: 120px; margin-bottom: 1rem; }
        .footer-section h3 { font-size: 1.25rem; margin-bottom: 1rem; }
        .footer-section p { line-height: 1.8; opacity: 0.9; }
        .footer-section a { color: white; text-decoration: none; }
        .footer-bottom { text-align: center; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.2); opacity: 0.9; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .nav-menu { display: none; position: fixed; top: 72px; left: 0; right: 0; background: white; flex-direction: column; padding: 2rem; gap: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 0 0 20px 20px; }
            .nav-menu.active { display: flex; }
            .mobile-menu-btn { display: block; }
        }
        @media (max-width: 768px) {
            .hero-slider { height: 450px; border-radius: 0 0 20px 20px; }
            .hero-content h1 { font-size: 2rem; }
            .hero-content p { font-size: 1rem; }
            .hero-tagline { font-size: 0.85rem; padding: 8px 16px; }
            .hero-nav-btn { width: 40px; height: 40px; font-size: 1rem; }
            .hero-nav-btn.prev { left: 15px; }
            .hero-nav-btn.next { right: 15px; }
            .header-logo { width: 40px; height: 40px; }
            .logo-text h1 { font-size: 1rem; }
            .cards-grid, .infografis-grid, .struktur-grid { grid-template-columns: 1fr; }
            .section { padding: 3rem 5%; }
        }
        @media (max-width: 480px) {
            .hero-slider { height: 380px; }
            .hero-content h1 { font-size: 1.5rem; }
            .hero-content p { font-size: 0.9rem; }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-container">
            <div class="logo-section">
                <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo Desa Banjardowo" class="header-logo">
                <div class="logo-text">
                    <h1>Desa Banjardowo</h1>
                    <p>Kec. Lengkong, Kab. Nganjuk</p>
                </div>
            </div>
            <nav class="nav-menu" id="navMenu">
                <a href="#visimisi">Visi-Misi</a>
                <a href="#layanan">Layanan</a>
                <a href="#infografis">Infografis</a>
                <a href="#kegiatan">Kegiatan Desa</a>
                <a href="#prestasi">Prestasi</a>
                <a href="#struktur">Struktur Desa</a>
                <a href="{{ route('login') }}" class="login-btn">Login Admin</a>
            </nav>
            <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <!-- HERO SLIDER -->
    <section class="hero-slider" id="heroSlider">
        <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1600&q=80');">
            <div class="hero-overlay"><div class="hero-content"><h1>Selamat Datang di E-Deslay</h1><p>Website Resmi Kelurahan Banjardowo</p><span class="hero-tagline">Layanan Digital Desa Yang Lebih Mudah Dan Cepat</span></div></div>
        </div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1600&q=80');">
            <div class="hero-overlay"><div class="hero-content"><h1>Membangun Desa Bersama</h1><p>Transparan, Efisien, dan Berkarakter</p><span class="hero-tagline">Mewujudkan Pelayanan Publik yang Berorientasi pada Masyarakat</span></div></div>
        </div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=1600&q=80');">
            <div class="hero-overlay"><div class="hero-content"><h1>Inovasi Digital untuk Kesejahteraan</h1><p>Desa Banjardowo Menuju Smart Village</p><span class="hero-tagline">Akses Informasi Cepat, Jelas, dan Terstruktur</span></div></div>
        </div>
        <button class="hero-nav-btn prev" onclick="geserHero(-1)"><i class="fas fa-chevron-left"></i></button>
        <button class="hero-nav-btn next" onclick="geserHero(1)"><i class="fas fa-chevron-right"></i></button>
        <div class="hero-indicators" id="heroIndicators"></div>
    </section>

    <!-- VISI MISI -->
    <section class="section" id="visimisi">
        <div class="visi-misi-box">
            <h2>Visi-Misi</h2>
            <p>Pemerintah Desa berkomitmen mewujudkan pelayanan yang transparan, efisien, dan berbasis digital untuk meningkatkan kesejahteraan masyarakat, dengan menyediakan akses informasi yang cepat dan jelas, panduan tata cara pengurusan administrasi yang terstruktur, transparansi kegiatan serta pengumuman resmi, serta mendorong partisipasi masyarakat dalam pembangunan desa melalui keterbukaan informasi.</p>
        </div>
    </section>

    {{-- LAYANAN SURAT ONLINE --}}
    @include('layanan_detail')

    {{-- INFOGRAFIS --}}
    @include('infografis_detail')

    <!-- KEGIATAN DESA -->
    <section class="section" id="kegiatan">
        <div class="section-title">
            <h2>Kegiatan Desa</h2>
            <p>Informasi mengenai berbagai kegiatan yang dilaksanakan di desa untuk meningkatkan kesejahteraan masyarakat.</p>
        </div>
        <div class="cards-slider">
            <div class="cards-track">
                @foreach($kegiatanList as $kegiatan)
                <div class="card">
                    <img src="{{ $kegiatan->image_url }}" alt="{{ $kegiatan->judul }}" class="card-image">
                    <div class="card-content">
                        <h3>{{ $kegiatan->judul }}</h3>
                        <p>{{ Str::limit($kegiatan->deskripsi, 100) }}</p>
                        <div class="card-date"><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal)->isoFormat('D MMMM Y') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- PRESTASI DESA -->
    <section class="section" id="prestasi">
        <div class="section-title">
            <h2>Prestasi Desa</h2>
            <p>Berbagai prestasi yang telah diraih menjadi bukti nyata semangat gotong royong dan komitmen masyarakat dalam membangun desa yang unggul dan berdaya saing.</p>
        </div>
        <div class="cards-slider">
            <div class="cards-track">
                @foreach($prestasiList as $prestasi)
                <div class="card">
                    <img src="{{ $prestasi->image_url }}" alt="{{ $prestasi->judul }}" class="card-image">
                    <div class="card-content">
                        <h3>{{ $prestasi->judul }}</h3>
                        <p>{{ Str::limit($prestasi->deskripsi, 100) }}</p>
                        <div class="card-date"><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($prestasi->tanggal)->isoFormat('D MMMM Y') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- STRUKTUR DESA -->
    <section class="section" id="struktur">
        <div class="section-title"><h2>Struktur Perangkat Desa</h2></div>
        <div class="struktur-grid">
            @foreach($strukturDesa as $struktur)
            <div class="struktur-card"><h3>{{ $struktur->jabatan }}</h3><p>{{ $struktur->nama ?? '-' }}</p></div>
            @endforeach
        </div>
    </section>

    <!-- DOWNLOAD APP -->
    <section class="download-section">
        <h2>Aplikasi Desa</h2>
        <p>Praktis. Cepat. Mudah.</p>
        <a href="https://www.mediafire.com/file/pwagazsqup9t87d/E-Deslay.apk/file" class="download-btn" target="_blank"><i class="fas fa-download"></i> Download Sekarang</a>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <img src="{{ asset('assets/images/logo-big.png') }}" alt="E-Deslay Logo" class="footer-logo">
                <h3>Desa Banjardowo</h3>
                <p>Kecamatan Lengkong, Kabupaten Nganjuk</p>
            </div>
            <div class="footer-section">
                <h3>Kontak Kami</h3>
                <p>
                    <i class="fas fa-map-marker-alt"></i> JL. Gondang Timur No.41A Banjardowo, Kec. Lengkong, Kab. Nganjuk<br>
                    <i class="fas fa-envelope"></i> <a href="mailto:banjardowolengkong@gmail.com">banjardowolengkong@gmail.com</a><br>
                    <i class="fas fa-phone"></i> 0857-4664-1970
                </p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Desa Banjardowo. All Rights Reserved. | Website Resmi E-DESLAY — Layanan Digital Desa.</p>
        </div>
    </footer>

    <script>
        // ===== HERO SLIDER =====
        (function() {
            const slides = document.querySelectorAll('.hero-slide');
            const indicatorsContainer = document.getElementById('heroIndicators');
            let currentHeroSlide = 0;
            let heroAutoInterval;
            slides.forEach((_, i) => {
                const dot = document.createElement('div');
                dot.classList.add('hero-dot');
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => goToHeroSlide(i));
                indicatorsContainer.appendChild(dot);
            });
            const dots = document.querySelectorAll('.hero-dot');
            function goToHeroSlide(index) {
                slides[currentHeroSlide].classList.remove('active');
                dots[currentHeroSlide].classList.remove('active');
                currentHeroSlide = (index + slides.length) % slides.length;
                slides[currentHeroSlide].classList.add('active');
                dots[currentHeroSlide].classList.add('active');
            }
            window.geserHero = function(direction) { goToHeroSlide(currentHeroSlide + direction); resetHeroAuto(); };
            function startHeroAuto() { heroAutoInterval = setInterval(() => { goToHeroSlide(currentHeroSlide + 1); }, 5000); }
            function resetHeroAuto() { clearInterval(heroAutoInterval); startHeroAuto(); }
            const heroSlider = document.getElementById('heroSlider');
            heroSlider.addEventListener('mouseenter', () => clearInterval(heroAutoInterval));
            heroSlider.addEventListener('mouseleave', startHeroAuto);
            let touchStartX = 0, touchEndX = 0;
            heroSlider.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
            heroSlider.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                const diff = touchStartX - touchEndX;
                if (Math.abs(diff) > 50) { goToHeroSlide(diff > 0 ? currentHeroSlide + 1 : currentHeroSlide - 1); resetHeroAuto(); }
            }, { passive: true });
            startHeroAuto();
        })();

        // ===== MOBILE MENU & SMOOTH SCROLL =====
        document.getElementById('mobileMenuBtn').addEventListener('click', () => { document.getElementById('navMenu').classList.toggle('active'); });
        document.querySelectorAll('.nav-menu a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); document.getElementById('navMenu').classList.remove('active'); }
            });
        });
    </script>

</body>
</html>