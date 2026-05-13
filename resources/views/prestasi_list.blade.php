<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Prestasi - Desa Banjardowo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8f9fc; margin: 0; color: #333; }
        .header { background: white; padding: 1rem 5%; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        .logo { font-weight: bold; font-size: 1.2rem; color: #1c3f9f; text-decoration: none; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .section-title { text-align: center; margin-bottom: 2rem; }
        .section-title h1 { color: #1c3f9f; font-size: 2rem; margin-bottom: 0.5rem; }
        .section-title p { color: #6b7280; font-size: 1rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; }
        .card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; text-decoration: none; color: inherit; display: block; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); }
        .card img { width: 100%; height: 200px; object-fit: cover; }
        .card-content { padding: 1.5rem; }
        .card h3 { color: #1c3f9f; margin-top: 0; font-size: 1.1rem; margin-bottom: 0.75rem; }
        .card p { color: #666; line-height: 1.6; font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .card-date { color: #999; font-size: 0.85rem; margin-top: 1rem; display: flex; align-items: center; gap: 8px; }
        .btn-back { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 1rem; color: #667eea; text-decoration: none; font-weight: 500; padding: 8px 16px; border: 1px solid #667eea; border-radius: 20px; transition: all 0.3s; }
        .btn-back:hover { background: #667eea; color: white; }
        .empty-state { grid-column: 1/-1; text-align: center; padding: 3rem; color: #666; }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
        
        @media (max-width: 768px) {
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('home') }}" class="logo"><i class="fas fa-home"></i> Desa Banjardowo</a>
    </header>

    <div class="container">
        <a href="{{ route('home') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
        
        <div class="section-title">
            <h1>Semua Prestasi Desa</h1>
            <p>Pencapaian membanggakan dari masyarakat Desa Banjardowo.</p>
        </div>

        <div class="grid">
            @forelse($prestasiList as $prestasi)
            <a href="{{ route('prestasi.detail', $prestasi->id) }}" class="card">
                <img src="{{ $prestasi->image_url }}" alt="{{ $prestasi->judul }}" onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                <div class="card-content">
                    <h3>{{ $prestasi->judul }}</h3>
                    <p>{{ Str::limit($prestasi->deskripsi, 150) }}</p>
                    <div class="card-date">
                        <i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($prestasi->tanggal)->isoFormat('D MMMM Y') }}
                    </div>
                </div>
            </a>
            @empty
                <div class="empty-state">
                    <i class="fas fa-trophy"></i>
                    <p>Belum ada prestasi yang ditampilkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>