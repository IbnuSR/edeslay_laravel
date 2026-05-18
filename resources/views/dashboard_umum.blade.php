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
    
    /* ===== LOGIN BUTTON (GRADIEN BIRU) ===== */
    .login-btn { 
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); 
        color: white !important; 
        padding: 8px 20px; 
        border-radius: 25px; 
        font-weight: 600; 
        font-size: 0.85rem; 
        transition: all 0.3s; 
    }
    .login-btn:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 5px 15px rgba(30, 64, 175, 0.4); 
    }
    
    .mobile-menu-btn { display: none; background: none; border: none; color: #1c3f9f; font-size: 1.5rem; cursor: pointer; padding: 8px; }

    /* ===== HERO SLIDER ===== */
    .hero-slider { margin-top: 72px; position: relative; height: 580px; overflow: hidden; border-radius: 0 0 30px 30px; }
    .hero-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease-in-out; z-index: 1; }
    .hero-slide.active { opacity: 1; z-index: 2; transition: opacity 0.8s ease-in-out; }
    .hero-slide video { width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1; }
    .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.7) 100%); display: flex; align-items: center; justify-content: center; text-align: center; color: white; z-index: 1; }
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

    /* ===== VISI MISI (GRADIEN BIRU) ===== */
    .visi-misi-box { 
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); 
        padding: 3rem; 
        border-radius: 20px; 
        color: white; 
        max-width: 1000px; 
        margin: 0 auto; 
        text-align: left; 
    }
    .visi-misi-box h2 { text-align: center; }
    .visi-misi-box p { text-align: justify; line-height: 1.9; }

    /* ===== INFOGRAFIS & STRUKTUR ===== */
    .infografis-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem; }
    .info-card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 1.5rem; }
    .info-icon { width: 80px; height: 80px; flex-shrink: 0; }
    .info-content h3 { color: #1c3f9f; font-size: 1.1rem; margin-bottom: 0.5rem; }
    .info-content .number { color: #3b82f6; font-size: 1.8rem; font-weight: 700; }
    .struktur-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem; }
    .struktur-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s; overflow: hidden; display: flex; flex-direction: column; align-items: center; padding: 2rem 1.5rem; height: 100%; min-height: 320px; }
    .struktur-card:hover { transform: translateY(-8px); box-shadow: 0 12px 40px rgba(0,0,0,0.15); }
    .struktur-foto { width: 120px; height: 120px; object-fit: cover; border-radius: 50%; margin-bottom: 1.5rem; border: 4px solid #e3f2fd; background: #f1f5f9; flex-shrink: 0; }
    .struktur-card h3 { color: #1c3f9f; font-size: 1.1rem; font-weight: 600; margin: 0.5rem 0 0.25rem; text-align: center; line-height: 1.3; }
    .struktur-jabatan { color: #3b82f6; font-size: 0.95rem; font-weight: 500; margin: 0.5rem 0; text-align: center; }
    .struktur-nip { color: #94a3b8; font-size: 0.8rem; margin-top: 0.5rem; text-align: center; }

    /* ===== DOWNLOAD SECTION (GRADIEN BIRU) ===== */
    .download-section { 
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); 
        padding: 4rem 5%; 
        text-align: center; 
    }
    .download-section h2 { color: white; font-size: 2rem; margin-bottom: 0.5rem; }
    .download-section p { color: rgba(255,255,255,0.9); margin-bottom: 2rem; }
    
    /* ===== DOWNLOAD BUTTON (PUTIH DENGAN TEKS BIRU) ===== */
    .download-btn { 
        background: white; 
        color: #1e40af; 
        padding: 16px 40px; 
        border-radius: 30px; 
        text-decoration: none; 
        font-weight: 600; 
        display: inline-flex; 
        align-items: center; 
        gap: 12px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
        transition: all 0.3s; 
    }
    .download-btn:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 6px 20px rgba(0,0,0,0.3); 
    }
    
    /* ===== FOOTER (GRADIEN BIRU GELAP) ===== */
    .footer { 
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); 
        color: white; 
        padding: 3rem 5% 1.5rem; 
    }
    .footer-content { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; margin-bottom: 2rem; }
    .footer-logo { width: 120px; margin-bottom: 1rem; }
    .footer-section h3 { font-size: 1.25rem; margin-bottom: 1rem; }
    .footer-section p { line-height: 1.8; opacity: 0.9; }
    .footer-section a { color: white; text-decoration: none; }
    .footer-bottom { text-align: center; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.2); opacity: 0.9; }

    /* ===== MODAL STYLES ===== */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(5px);
        z-index: 9999; display: none; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.3s ease;
    }
    .modal-overlay.active { display: flex; opacity: 1; }
    .modal-content {
        background: white; width: 90%; max-width: 800px; max-height: 90vh;
        border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        overflow-y: auto; transform: scale(0.9); transition: transform 0.3s ease;
    }
    .modal-overlay.active .modal-content { transform: scale(1); }
    .modal-header {
        padding: 2rem 2rem 1rem; border-bottom: 1px solid #eee;
        display: flex; justify-content: space-between; align-items: flex-start;
        position: sticky; top: 0; background: white; z-index: 10;
    }
    .modal-header h2 { margin: 0; font-size: 1.5rem; color: #1c3f9f; flex: 1; padding-right: 20px; }
    .modal-close-btn {
        background: #f3f4f6; border: none; width: 36px; height: 36px;
        border-radius: 50%; font-size: 1.5rem; cursor: pointer; color: #666;
        display: flex; align-items: center; justify-content: center; transition: all 0.2s;
    }
    .modal-close-btn:hover { background: #e5e7eb; color: #000; }
    .modal-body { padding: 2rem; }
    .modal-img { width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px; margin-bottom: 1.5rem; }
    .modal-date { color: #6b7280; font-size: 0.95rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; }
    .modal-section { margin-bottom: 2rem; }
    .modal-section h3 { font-size: 1.1rem; color: #374151; margin-bottom: 1rem; display: flex; align-items: center; gap: 10px; }
    .modal-section h3 i { color: #3b82f6; }
    .modal-section p { color: #4b5563; line-height: 1.8; font-size: 1rem; text-align: justify; }
    .modal-footer { padding: 1rem 2rem 2rem; text-align: center; border-top: 1px solid #eee; }
    
    /* ===== BUTTON PRIMARY MODAL (GRADIEN BIRU) ===== */
    .btn-primary-modal {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white; border: none; padding: 10px 30px; border-radius: 25px;
        font-weight: 600; cursor: pointer; transition: all 0.3s;
    }
    .btn-primary-modal:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 5px 15px rgba(30, 64, 175, 0.4); 
    }

    /* ===== CARDS SLIDER ===== */
    .cards-slider-wrapper { position: relative; padding: 0 45px; margin-top: 1rem; }
    .cards-slider { overflow-x: auto; scroll-snap-type: x mandatory; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none; padding: 10px 0; }
    .cards-slider::-webkit-scrollbar { display: none; }
    .cards-track { display: flex; gap: 24px; }
    .card { flex: 0 0 calc(33.333% - 16px); scroll-snap-align: start; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column; cursor: pointer; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
    .card-image { width: 100%; height: 200px; object-fit: cover; flex-shrink: 0; }
    .card-content { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
    .card h3 { color: #1c3f9f; font-size: 1.1rem; margin-bottom: 0.75rem; font-weight: 600; }
    .card p { color: #6b7280; font-size: 0.9rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1; }
    .card-date { display: flex; align-items: center; gap: 8px; color: #9ca3af; font-size: 0.8rem; margin-top: 1rem; }
    .slider-nav-btn { position: absolute; top: 50%; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; background: white; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.1); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; transition: all 0.3s; color: #1c3f9f; font-size: 1rem; }
    .slider-nav-btn:hover { background: #f8fafc; transform: translateY(-50%) scale(1.1); box-shadow: 0 6px 16px rgba(0,0,0,0.15); }
    .slider-nav-btn.prev { left: 0; }
    .slider-nav-btn.next { right: 0; }
    .section-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem; }
    .section-header .section-title { text-align: left; margin-bottom: 0; }
    .see-all-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; background: transparent; border: 1.5px solid #1c3f9f; color: #1c3f9f; border-radius: 25px; font-weight: 500; cursor: pointer; transition: all 0.3s; text-decoration: none; font-size: 0.9rem; }
    .see-all-btn:hover { background: #1c3f9f; color: white; transform: translateY(-2px); }

    /* ===== FULL VIEW MODE ===== */
    .fullview { animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .fullview-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb; }
    .fullview-header h3 { color: #1c3f9f; font-size: 1.8rem; font-weight: 700; margin: 0; }
    .btn-close-fullview { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; padding: 12px 28px; border-radius: 25px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.95rem; transition: all 0.3s; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); }
    .btn-close-fullview:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4); }
    .fullview-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; }
    .card-full { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s; cursor: pointer; }
    .card-full:hover { transform: translateY(-8px); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .card-full-img { width: 100%; height: 220px; object-fit: cover; }
    .card-full-content { padding: 1.5rem; }
    .card-full-content h3 { color: #1c3f9f; font-size: 1.2rem; margin: 0 0 0.75rem; font-weight: 600; }
    .card-full-content p { color: #6b7280; font-size: 0.95rem; line-height: 1.6; margin: 0 0 1rem; }

    /* ===== STRUKTUR DESA SPECIFIC ===== */
    .struktur-card-mini {
        flex: 0 0 calc(25% - 18px);
        min-width: 0;
        background: white;
        border-radius: 16px;
        padding: 1.5rem 1rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }
    .struktur-card-mini:hover { transform: translateY(-6px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); }
    .struktur-img {
        width: 90px; height: 90px; object-fit: cover; border-radius: 50%;
        margin: 0 auto 1rem; border: 3px solid #e3f2fd; background: #f1f5f9;
    }
    .struktur-info h4 { color: #1c3f9f; font-size: 1rem; margin: 0 0 0.25rem; font-weight: 600; }
    .struktur-info p { color: #3b82f6; font-size: 0.85rem; margin: 0; font-weight: 500; }
    .struktur-grid-full {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;
    }
    .struktur-modal-img {
        width: 150px; height: 150px; object-fit: cover; border-radius: 50%;
        margin: 0 auto 1.5rem; border: 4px solid #e3f2fd; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .nav-menu { display: none; position: fixed; top: 72px; left: 0; right: 0; background: white; flex-direction: column; padding: 2rem; gap: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 0 0 20px 20px; }
        .nav-menu.active { display: flex; }
        .mobile-menu-btn { display: block; }
        .card { flex: 0 0 calc(50% - 12px); }
        .struktur-card-mini { flex: 0 0 calc(33.333% - 16px); }
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
        .section { padding: 3rem 5%; }
        .card { flex: 0 0 100%; }
        .cards-slider-wrapper { padding: 0 35px; }
        .slider-nav-btn { width: 36px; height: 36px; font-size: 0.85rem; }
        .section-header { flex-direction: column; align-items: flex-start; }
        .struktur-grid { grid-template-columns: 1fr; }
        .struktur-card { min-height: 280px; padding: 1.5rem 1rem; }
        .struktur-foto { width: 100px; height: 100px; }
        .fullview-grid { grid-template-columns: 1fr; }
        .struktur-card-mini { flex: 0 0 calc(50% - 12px); }
        .struktur-grid-full { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
    }
    @media (max-width: 480px) {
        .hero-slider { height: 380px; }
        .hero-content h1 { font-size: 1.5rem; }
        .hero-content p { font-size: 0.9rem; }
        .struktur-card { min-height: 260px; padding: 1rem 0.75rem; }
        .struktur-foto { width: 80px; height: 80px; margin-bottom: 1rem; }
        .struktur-card-mini { flex: 0 0 100%; }
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
        @foreach($heroSlides as $index => $slide)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}">
                <video @if($index === 0) autoplay @endif muted loop playsinline preload="auto" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
                    <source src="{{ asset($slide['file']) }}" type="video/mp4">
                </video>
                <div class="hero-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
                    <div class="hero-content">
                        <h1>{{ $slide['title'] }}</h1>
                        <p>{{ $slide['subtitle'] }}</p>
                        <span class="hero-tagline">{{ $slide['tagline'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
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

    <!-- KEGIATAN DESA (MODAL MODEL) -->
    <section class="section" id="kegiatan">
        <div class="section-header">
            <div class="section-title">
                <h2>Kegiatan Desa</h2>
                <p>Informasi terbaru seputar aktivitas di desa.</p>
            </div>
            @if(count($kegiatanList) > 3)
                <button class="see-all-btn" onclick="bukaKegiatanFullView()">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </button>
            @endif
        </div>
        
        <!-- MODE SLIDER -->
        <div class="cards-slider-wrapper" id="kegiatanSliderMode">
            <button class="slider-nav-btn prev" data-slider="kegiatanSlider"><i class="fas fa-chevron-left"></i></button>
            <div class="cards-slider" id="kegiatanSlider">
                <div class="cards-track">
                    @forelse($kegiatanList as $kegiatan)
                    <div class="card" onclick="bukaKegiatanModal({{ $kegiatan->id }})">
                        <img src="{{ $kegiatan->image_url }}" alt="{{ $kegiatan->judul }}" class="card-image">
                        <div class="card-content">
                            <h3>{{ Str::limit($kegiatan->judul, 50) }}</h3>
                            <p>{{ Str::limit($kegiatan->deskripsi, 80) }}</p>
                            <div class="card-date"><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal)->isoFormat('D MMM Y') }}</div>
                        </div>
                    </div>
                    @empty
                    <div style="flex: 0 0 100%; color: #6b7280; padding: 2rem; text-align: center;">
                        <i class="fas fa-calendar-alt" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>Belum ada kegiatan terbaru.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <button class="slider-nav-btn next" data-slider="kegiatanSlider"><i class="fas fa-chevron-right"></i></button>
        </div>

        <!-- MODE FULL VIEW (Hidden) -->
        <div class="fullview" id="kegiatanFullView" style="display: none;">
            <div class="fullview-header">
                <h3>Daftar Semua Kegiatan Desa</h3>
                <button class="btn-close-fullview" onclick="tutupKegiatanFullView()">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
            <div class="fullview-grid">
                @foreach($kegiatanList as $kegiatan)
                <div class="card-full" onclick="bukaKegiatanModal({{ $kegiatan->id }})">
                    <img src="{{ $kegiatan->image_url }}" alt="{{ $kegiatan->judul }}" class="card-full-img">
                    <div class="card-full-content">
                        <h3>{{ $kegiatan->judul }}</h3>
                        <p>{{ Str::limit($kegiatan->deskripsi, 120) }}</p>
                        <div class="card-date"><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal)->isoFormat('D MMMM Y') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- PRESTASI DESA (MODAL MODEL) -->
    <section class="section" id="prestasi">
        <div class="section-header">
            <div class="section-title">
                <h2>Prestasi Desa</h2>
                <p>Pencapaian membanggakan dari masyarakat Desa Banjardowo.</p>
            </div>
            @if(count($prestasiList) > 3)
                <button class="see-all-btn" onclick="bukaPrestasiFullView()">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </button>
            @endif
        </div>
        
        <!-- MODE SLIDER -->
        <div class="cards-slider-wrapper" id="prestasiSliderMode">
            <button class="slider-nav-btn prev" data-slider="prestasiSlider"><i class="fas fa-chevron-left"></i></button>
            <div class="cards-slider" id="prestasiSlider">
                <div class="cards-track">
                    @forelse($prestasiList as $prestasi)
                    <div class="card" onclick="bukaPrestasiModal({{ $prestasi->id }})">
                        <img src="{{ $prestasi->image_url }}" alt="{{ $prestasi->judul }}" class="card-image">
                        <div class="card-content">
                            <h3>{{ Str::limit($prestasi->judul, 50) }}</h3>
                            <p>{{ Str::limit($prestasi->deskripsi, 80) }}</p>
                            <div class="card-date"><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($prestasi->tanggal)->isoFormat('D MMM Y') }}</div>
                        </div>
                    </div>
                    @empty
                    <div style="flex: 0 0 100%; color: #6b7280; padding: 2rem; text-align: center;">
                        <i class="fas fa-trophy" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>Belum ada prestasi terbaru.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <button class="slider-nav-btn next" data-slider="prestasiSlider"><i class="fas fa-chevron-right"></i></button>
        </div>

        <!-- MODE FULL VIEW (Hidden) -->
        <div class="fullview" id="prestasiFullView" style="display: none;">
            <div class="fullview-header">
                <h3>Daftar Semua Prestasi Desa</h3>
                <button class="btn-close-fullview" onclick="tutupPrestasiFullView()">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
            <div class="fullview-grid">
                @foreach($prestasiList as $prestasi)
                <div class="card-full" onclick="bukaPrestasiModal({{ $prestasi->id }})">
                    <img src="{{ $prestasi->image_url }}" alt="{{ $prestasi->judul }}" class="card-full-img">
                    <div class="card-full-content">
                        <h3>{{ $prestasi->judul }}</h3>
                        <p>{{ Str::limit($prestasi->deskripsi, 120) }}</p>
                        <div class="card-date"><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($prestasi->tanggal)->isoFormat('D MMMM Y') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- STRUKTUR DESA (MODAL + SLIDER MODEL) -->
    <section class="section" id="struktur">
        <div class="section-header">
            <div class="section-title">
                <h2>Struktur Perangkat Desa</h2>
                <p>Kenali jajaran perangkat desa yang siap melayani masyarakat Banjardowo.</p>
            </div>
            @if(count($strukturDesa) > 4)
            <button class="see-all-btn" onclick="bukaStrukturFullView()">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </button>
            @endif
        </div>
        
        <!-- MODE SLIDER -->
        <div class="cards-slider-wrapper" id="strukturSliderMode">
            <button class="slider-nav-btn prev" data-slider="strukturSlider"><i class="fas fa-chevron-left"></i></button>
            <div class="cards-slider" id="strukturSlider">
                <div class="cards-track">
                    @forelse($strukturDesa as $st)
                    <div class="struktur-card-mini" onclick="bukaStrukturModal({{ $st->id }})">
                        <img src="{{ $st->foto_url }}" alt="{{ $st->nama }}" class="struktur-img">
                        <div class="struktur-info">
                            <h4>{{ $st->nama }}</h4>
                            <p>{{ $st->jabatan }}</p>
                        </div>
                    </div>
                    @empty
                    <div style="flex: 0 0 100%; color: #6b7280; padding: 2rem; text-align: center;">
                        <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>Belum ada data struktur desa.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <button class="slider-nav-btn next" data-slider="strukturSlider"><i class="fas fa-chevron-right"></i></button>
        </div>

        <!-- MODE FULL VIEW (Hidden) -->
        <div class="fullview" id="strukturFullView" style="display: none;">
            <div class="fullview-header">
                <h3>Seluruh Perangkat Desa</h3>
                <button class="btn-close-fullview" onclick="tutupStrukturFullView()">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
            <div class="struktur-grid-full">
                @foreach($strukturDesa as $st)
                <div class="struktur-card-mini" onclick="bukaStrukturModal({{ $st->id }})">
                    <img src="{{ $st->foto_url }}" alt="{{ $st->nama }}" class="struktur-img">
                    <div class="struktur-info">
                        <h4>{{ $st->nama }}</h4>
                        <p>{{ $st->jabatan }}</p>
                    </div>
                </div>
                @endforeach
            </div>
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
            <p>&copy; {{ date('Y') }} Desa Banjardowo. All Rights Reserved. | Website Resmi E-DESLAY.</p>
        </div>
    </footer>

    <!-- MODAL KEGIATAN -->
    <div id="kegiatanModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="kegiatanModalTitle">Judul Kegiatan</h2>
                <button class="modal-close-btn" onclick="tutupKegiatanModal()">&times;</button>
            </div>
            <div class="modal-body">
                <img id="kegiatanModalImage" src="" alt="" class="modal-img">
                <div class="modal-date"><i class="far fa-calendar"></i> <span id="kegiatanModalDate"></span></div>
                <div class="modal-section">
                    <h3><i class="fas fa-info-circle"></i> Deskripsi</h3>
                    <p id="kegiatanModalDesc"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-primary-modal" onclick="tutupKegiatanModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- MODAL PRESTASI -->
    <div id="prestasiModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="prestasiModalTitle">Judul Prestasi</h2>
                <button class="modal-close-btn" onclick="tutupPrestasiModal()">&times;</button>
            </div>
            <div class="modal-body">
                <img id="prestasiModalImage" src="" alt="" class="modal-img">
                <div class="modal-date"><i class="far fa-calendar"></i> <span id="prestasiModalDate"></span></div>
                <div class="modal-section">
                    <h3><i class="fas fa-info-circle"></i> Deskripsi</h3>
                    <p id="prestasiModalDesc"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-primary-modal" onclick="tutupPrestasiModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- MODAL STRUKTUR -->
    <div id="strukturModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 500px; text-align: center;">
            <div class="modal-header">
                <h2 id="strukturModalName">Nama Perangkat</h2>
                <button class="modal-close-btn" onclick="tutupStrukturModal()">&times;</button>
            </div>
            <div class="modal-body">
                <img id="strukturModalImg" src="" alt="" class="struktur-modal-img">
                <div class="modal-section">
                    <h3><i class="fas fa-briefcase"></i> Jabatan</h3>
                    <p id="strukturModalJabatan"></p>
                </div>
                <div class="modal-section" id="strukturNipSection" style="display:none;">
                    <h3><i class="fas fa-id-card"></i> NIP</h3>
                    <p id="strukturModalNip"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-primary-modal" onclick="tutupStrukturModal()">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        // ===== DATA DARI CONTROLLER KE JS =====
        const kegiatanData = @json($kegiatanList);
        const prestasiData = @json($prestasiList);
        const strukturData = @json($strukturDesa);

        // ===== FUNGSI MODAL KEGIATAN =====
        function bukaKegiatanModal(id) {
            const data = kegiatanData.find(k => k.id == id);
            if (!data) return;
            document.getElementById('kegiatanModalTitle').textContent = data.judul;
            document.getElementById('kegiatanModalImage').src = data.image_url;
            document.getElementById('kegiatanModalDate').textContent = new Date(data.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            document.getElementById('kegiatanModalDesc').textContent = data.deskripsi;
            const modal = document.getElementById('kegiatanModal');
            modal.style.display = 'flex';
            setTimeout(() => { modal.classList.add('active'); modal.querySelector('.modal-content').classList.add('active'); }, 10);
            document.body.style.overflow = 'hidden';
        }
        function tutupKegiatanModal() {
            const modal = document.getElementById('kegiatanModal');
            modal.classList.remove('active');
            modal.querySelector('.modal-content').classList.remove('active');
            setTimeout(() => { modal.style.display = 'none'; }, 300);
            document.body.style.overflow = '';
        }
        document.getElementById('kegiatanModal').addEventListener('click', function(e) { if (e.target === this) tutupKegiatanModal(); });

        // ===== FUNGSI MODAL PRESTASI =====
        function bukaPrestasiModal(id) {
            const data = prestasiData.find(p => p.id == id);
            if (!data) return;
            document.getElementById('prestasiModalTitle').textContent = data.judul;
            document.getElementById('prestasiModalImage').src = data.image_url;
            document.getElementById('prestasiModalDate').textContent = new Date(data.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            document.getElementById('prestasiModalDesc').textContent = data.deskripsi;
            const modal = document.getElementById('prestasiModal');
            modal.style.display = 'flex';
            setTimeout(() => { modal.classList.add('active'); modal.querySelector('.modal-content').classList.add('active'); }, 10);
            document.body.style.overflow = 'hidden';
        }
        function tutupPrestasiModal() {
            const modal = document.getElementById('prestasiModal');
            modal.classList.remove('active');
            modal.querySelector('.modal-content').classList.remove('active');
            setTimeout(() => { modal.style.display = 'none'; }, 300);
            document.body.style.overflow = '';
        }
        document.getElementById('prestasiModal').addEventListener('click', function(e) { if (e.target === this) tutupPrestasiModal(); });

        // ===== FUNGSI MODAL STRUKTUR =====
        function bukaStrukturModal(id) {
            const data = strukturData.find(s => s.id == id);
            if (!data) return;
            
            document.getElementById('strukturModalName').textContent = data.nama;
            document.getElementById('strukturModalImg').src = data.foto_url;
            document.getElementById('strukturModalJabatan').textContent = data.jabatan;
            
            const nipSection = document.getElementById('strukturNipSection');
            if (data.nip) {
                document.getElementById('strukturModalNip').textContent = data.nip;
                nipSection.style.display = 'block';
            } else {
                nipSection.style.display = 'none';
            }
            
            const modal = document.getElementById('strukturModal');
            modal.style.display = 'flex';
            setTimeout(() => { modal.classList.add('active'); modal.querySelector('.modal-content').classList.add('active'); }, 10);
            document.body.style.overflow = 'hidden';
        }
        function tutupStrukturModal() {
            const modal = document.getElementById('strukturModal');
            modal.classList.remove('active');
            modal.querySelector('.modal-content').classList.remove('active');
            setTimeout(() => { modal.style.display = 'none'; }, 300);
            document.body.style.overflow = '';
        }
        document.getElementById('strukturModal').addEventListener('click', function(e) { if (e.target === this) tutupStrukturModal(); });

        // ===== FUNGSI FULL VIEW =====
        function bukaKegiatanFullView() {
            document.getElementById('kegiatanSliderMode').style.display = 'none';
            document.querySelector('#kegiatan .see-all-btn').style.display = 'none';
            document.getElementById('kegiatanFullView').style.display = 'block';
            document.getElementById('kegiatan').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        function tutupKegiatanFullView() {
            document.getElementById('kegiatanFullView').style.display = 'none';
            document.getElementById('kegiatanSliderMode').style.display = 'block';
            document.querySelector('#kegiatan .see-all-btn').style.display = 'inline-flex';
        }
        function bukaPrestasiFullView() {
            document.getElementById('prestasiSliderMode').style.display = 'none';
            document.querySelector('#prestasi .see-all-btn').style.display = 'none';
            document.getElementById('prestasiFullView').style.display = 'block';
            document.getElementById('prestasi').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        function tutupPrestasiFullView() {
            document.getElementById('prestasiFullView').style.display = 'none';
            document.getElementById('prestasiSliderMode').style.display = 'block';
            document.querySelector('#prestasi .see-all-btn').style.display = 'inline-flex';
        }
        function bukaStrukturFullView() {
            document.getElementById('strukturSliderMode').style.display = 'none';
            document.querySelector('#struktur .see-all-btn').style.display = 'none';
            document.getElementById('strukturFullView').style.display = 'block';
            document.getElementById('struktur').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        function tutupStrukturFullView() {
            document.getElementById('strukturFullView').style.display = 'none';
            document.getElementById('strukturSliderMode').style.display = 'block';
            document.querySelector('#struktur .see-all-btn').style.display = 'inline-flex';
        }

        // ===== HERO SLIDER =====
        (function() {
            const slides = document.querySelectorAll('.hero-slide');
            const indicatorsContainer = document.getElementById('heroIndicators');
            let currentHeroSlide = 0, heroAutoInterval;
            slides.forEach((_, i) => {
                const dot = document.createElement('div'); dot.classList.add('hero-dot');
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => goToHeroSlide(i));
                indicatorsContainer.appendChild(dot);
            });
            const dots = document.querySelectorAll('.hero-dot');
            function goToHeroSlide(index) {
                const oldVideo = slides[currentHeroSlide].querySelector('video');
                if (oldVideo) { oldVideo.pause(); oldVideo.currentTime = 0; }
                slides[currentHeroSlide].classList.remove('active');
                dots[currentHeroSlide]?.classList.remove('active');
                currentHeroSlide = (index + slides.length) % slides.length;
                slides[currentHeroSlide].classList.add('active');
                dots[currentHeroSlide]?.classList.add('active');
                setTimeout(() => { const newVideo = slides[currentHeroSlide].querySelector('video'); if (newVideo) newVideo.play().catch(() => {}); }, 800);
            }
            window.geserHero = function(direction) { goToHeroSlide(currentHeroSlide + direction); resetHeroAuto(); };
            function startHeroAuto() { heroAutoInterval = setInterval(() => { goToHeroSlide(currentHeroSlide + 1); }, 8000); }
            function resetHeroAuto() { clearInterval(heroAutoInterval); startHeroAuto(); }
            const heroSlider = document.getElementById('heroSlider');
            heroSlider.addEventListener('mouseenter', () => clearInterval(heroAutoInterval));
            heroSlider.addEventListener('mouseleave', startHeroAuto);
            let touchStartX = 0, touchEndX = 0;
            heroSlider.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
            heroSlider.addEventListener('touchend', e => { touchEndX = e.changedTouches[0].screenX; const diff = touchStartX - touchEndX; if (Math.abs(diff) > 50) { goToHeroSlide(diff > 0 ? currentHeroSlide + 1 : currentHeroSlide - 1); resetHeroAuto(); } }, { passive: true });
            startHeroAuto();
        })();

        // ===== CARD SLIDER FUNCTION =====
        function initCardSlider(sliderId) {
            const slider = document.getElementById(sliderId); if (!slider) return;
            const prevBtn = document.querySelector(`.slider-nav-btn.prev[data-slider="${sliderId}"]`);
            const nextBtn = document.querySelector(`.slider-nav-btn.next[data-slider="${sliderId}"]`);
            const card = slider.querySelector('.card'); const gap = 24;
            const scrollAmount = card ? card.offsetWidth + gap : 320; let autoInterval;
            function scrollNext() { const maxScroll = slider.scrollWidth - slider.clientWidth; if (slider.scrollLeft >= maxScroll - 10) { slider.scrollTo({ left: 0, behavior: 'smooth' }); } else { slider.scrollBy({ left: scrollAmount, behavior: 'smooth' }); } }
            function scrollPrev() { slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' }); }
            if (prevBtn) prevBtn.addEventListener('click', () => { scrollPrev(); resetAuto(); });
            if (nextBtn) nextBtn.addEventListener('click', () => { scrollNext(); resetAuto(); });
            function startAuto() { autoInterval = setInterval(scrollNext, 4000); }
            function resetAuto() { clearInterval(autoInterval); startAuto(); }
            startAuto();
            slider.addEventListener('mouseenter', () => clearInterval(autoInterval));
            slider.addEventListener('mouseleave', startAuto);
            let isDown = false, startX, scrollLeft;
            slider.addEventListener('mousedown', (e) => { isDown = true; startX = e.pageX - slider.offsetLeft; scrollLeft = slider.scrollLeft; slider.style.cursor = 'grabbing'; });
            slider.addEventListener('mouseleave', () => { isDown = false; slider.style.cursor = ''; });
            slider.addEventListener('mouseup', () => { isDown = false; slider.style.cursor = ''; });
            slider.addEventListener('mousemove', (e) => { if (!isDown) return; e.preventDefault(); const x = e.pageX - slider.offsetLeft; const walk = (x - startX) * 1.5; slider.scrollLeft = scrollLeft - walk; });
        }
        document.addEventListener('DOMContentLoaded', function() { 
            initCardSlider('kegiatanSlider'); 
            initCardSlider('prestasiSlider');
            initCardSlider('strukturSlider');
        });

        // ===== MOBILE MENU =====
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