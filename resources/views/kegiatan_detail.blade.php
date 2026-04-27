<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kegiatan->judul }} - Desa Banjardowo</title>

    <style>
        body {
            margin: 0;
            background: #e5e7eb;
            font-family: Arial, sans-serif;
            overflow-y: auto;
        }

        /* HEADER ATAS */
        .top-header {
            background: #4f46e5;
            padding: 14px 22px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .top-header img { height: 45px; }

        /* WRAPPER KONTEN */
        .content-wrapper {
            max-width: 900px;
            margin: 25px auto;
            background: white;
            border-radius: 10px;
            padding: 25px 35px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        /* BREADCRUMB */
        .breadcrumb-box {
            margin-bottom: 20px;
            font-size: 14px;
            color: #6b7280;
        }
        .breadcrumb {
            text-decoration: none;
            color: #6b7280;
            transition: 0.2s;
        }
        .breadcrumb:hover { color: #4f46e5; }

        /* TOMBOL KEMBALI BULAT */
        .back-btn {
            display: inline-flex;
            background: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            cursor: pointer;
            text-decoration: none;
            color: black;
            font-size: 22px;
        }
        .back-btn:hover { background: #f3f4f6; }

        /* JUDUL */
        h1 {
            font-size: 26px;
            margin: 10px 0 5px;
            line-height: 1.4;
            color: #111827;
        }

        /* INFO PENULIS */
        .author {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #444;
            margin-bottom: 20px;
        }
        .author img { width: 40px; height: 40px; border-radius: 50%; }

        /* GAMBAR UTAMA */
        .main-img {
            width: 100%;
            max-height: 450px;
            object-fit: contain;
            margin: 20px 0;
            border-radius: 8px;
        }

        /* TEKS ARTIKEL */
        .article p {
            line-height: 1.7;
            font-size: 15px;
            margin-bottom: 14px;
            text-align: justify;
            color: #374151;
        }
    </style>
</head>

<body>
<!-- HEADER Logo -->
<div class="top-header">
    {{-- GANTI: assets/ → {{ asset('assets/') }} --}}
    <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo Desa">
    Desa Banjardowo
</div>

<!-- KONTEN UTAMA -->
<div class="content-wrapper">

    {{-- GANTI: href native → route() --}}
    <a href="{{ route('home') }}" class="back-btn">←</a>
    
    <div class="breadcrumb-box">
        <a href="{{ route('home') }}" class="breadcrumb">Dashboard</a> /
        <a href="{{ route('home') }}#kegiatan" class="breadcrumb">Kegiatan Desa</a> /
        <span>{{ $kegiatan->judul }}</span>
    </div>

    <!-- JUDUL -->
    <h1>{{ $kegiatan->judul }}</h1>

    <!-- PENULIS -->
    <div class="author">
        <img src="{{ asset('assets/images/logo-big.png') }}" alt="avatar">
        <div>
            <b>E-Deslay</b><br>
            {{-- GANTI: date() native → Carbon dari Controller --}}
            {{ $formatted_date }}
        </div>
    </div>

    <!-- GAMBAR -->
    @if($image_url)
        <img class="main-img" src="{{ $image_url }}" alt="{{ $kegiatan->judul }}">
    @endif

    <!-- ISI ARTIKEL -->
    <div class="article">
        {{-- GANTI: nl2br(htmlspecialchars()) → {!! nl2br(e()) !!} --}}
        <p>{!! nl2br(e($kegiatan->deskripsi)) !!}</p>
    </div>
    
</div>

</body>
</html>