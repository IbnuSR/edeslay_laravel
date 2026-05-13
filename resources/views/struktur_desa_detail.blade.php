<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Perangkat Desa - Desa Banjardowo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f8f9fc; color: #333; line-height: 1.6; }
        .header { background: rgba(255,255,255,0.97); backdrop-filter: blur(12px); padding: 0.8rem 5%; position: fixed; width: 100%; top: 0; z-index: 1000; box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
        .header-container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo-section { display: flex; align-items: center; gap: 12px; }
        .header-logo { width: 48px; height: 48px; object-fit: contain; }
        .logo-text h1 { color: #1c3f9f; font-size: 1.15rem; font-weight: 700; }
        .logo-text p { color: #6b7280; font-size: 0.78rem; }
        .nav-menu { display: flex; gap: 1.2rem; align-items: center; }
        .nav-menu a { color: #6b7280; font-weight: 500; font-size: 0.88rem; transition: all 0.3s; padding: 6px 10px; border-radius: 6px; text-decoration: none; }
        .nav-menu a:hover { color: #1c3f9f; background: rgba(28,63,159,0.06); }
        .mobile-menu-btn { display: none; background: none; border: none; color: #1c3f9f; font-size: 1.5rem; cursor: pointer; padding: 8px; }
        
        .section { padding: 4rem 5% 2rem; max-width: 1400px; margin: 0 auto; }
        .section-title { text-align: center; margin-bottom: 3rem; }
        .section-title h1 { font-size: 2rem; color: #1c3f9f; font-weight: 700; margin-bottom: 0.5rem; }
        .section-title p { color: #6b7280; font-size: 1rem; max-width: 800px; margin: 0 auto; }
        
        .struktur-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem; }
        .struktur-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: all 0.3s; overflow: hidden; display: flex; flex-direction: column; align-items: center; padding: 2rem 1.5rem; height: 100%; min-height: 320px; }
        .struktur-card:hover { transform: translateY(-8px); box-shadow: 0 12px 40px rgba(0,0,0,0.15); }
        .struktur-foto { width: 120px; height: 120px; object-fit: cover; border-radius: 50%; margin-bottom: 1.5rem; border: 4px solid #e3f2fd; background: #f1f5f9; }
        .struktur-card h3 { color: #1c3f9f; font-size: 1.1rem; font-weight: 600; margin: 0.5rem 0 0.25rem; text-align: center; }
        .struktur-jabatan { color: #667eea; font-size: 0.95rem; font-weight: 500; margin: 0.5rem 0; text-align: center; }
        .struktur-nip { color: #94a3b8; font-size: 0.8rem; margin-top: 0.5rem; text-align: center; }
        
        .footer { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 5% 1.5rem; margin-top: 3rem; }
        .footer-content { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; margin-bottom: 2rem; }
        .footer-logo { width: 120px; margin-bottom: 1rem; }
        .footer-section h3 { font-size: 1.25rem; margin-bottom: 1rem; }
        .footer-section p { line-height: 1.8; opacity: 0.9; }
        .footer-section a { color: white; text-decoration: none; }
        .footer-bottom { text-align: center; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.2); opacity: 0.9; }
        
        @media (max-width: 1024px) { .nav-menu { display: none; position: fixed; top: 72px; left: 0; right: 0; background: white; flex-direction: column; padding: 2rem; gap: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 0 0 20px 20px; } .nav-menu.active { display: flex; } .mobile-menu-btn { display: block; } }
        @media (max-width: 768px) { .section { padding: 3rem 5% 1rem; } .struktur-grid { grid-template-columns: 1fr; } .struktur-card { min-height: 280px; padding: 1.5rem 1rem; } .struktur-foto { width: 100px; height: 100px; } }
        @media (max-width: 480px) { .struktur-card { min-height: 260px; padding: 1rem 0.75rem; } .struktur-foto { width: 80px; height: 80px; margin-bottom: 1rem; } }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="logo-section">
                <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo" class="header-logo">
                <div class="logo-text">
                    <h1>Desa Banjardowo</h1>
                    <p>Kec. Lengkong, Kab. Nganjuk</p>
                </div>
            </div>
            <nav class="nav-menu" id="navMenu">
                <a href="{{ route('home') }}">Dashboard</a>
                <a href="{{ route('home') }}#kegiatan">Kegiatan</a>
                <a href="{{ route('home') }}#prestasi">Prestasi</a>
                <a href="{{ route('login') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white !important; padding: 8px 20px; border-radius: 25px;">Login Admin</a>
            </nav>
            <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <section class="section">
        <div class="section-title">
            <h1>Struktur Perangkat Desa</h1>
            <p>Kenali jajaran perangkat desa yang siap melayani masyarakat Banjardowo.</p>
        </div>
        <div class="struktur-grid">
            @forelse($strukturDesa as $struktur)
            <div class="struktur-card">
                <img src="{{ $struktur->foto_url }}" alt="{{ $struktur->nama }}" class="struktur-foto" onerror="this.src='{{ asset('assets/images/default-avatar.png') }}'; this.onerror=null;">
                <h3>{{ $struktur->nama }}</h3>
                <p class="struktur-jabatan">{{ $struktur->jabatan }}</p>
                @if($struktur->nip)
                    <small class="struktur-nip">{{ $struktur->nip }}</small>
                @endif
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #6b7280;">
                <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>Belum ada data struktur desa</p>
            </div>
            @endforelse
        </div>
    </section>

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

    <script>
        document.getElementById('mobileMenuBtn').addEventListener('click', () => { document.getElementById('navMenu').classList.toggle('active'); });
    </script>
</body>
</html>