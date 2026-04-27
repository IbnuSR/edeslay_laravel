<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $prestasi->judul }} - Desa Banjardowo</title>

    <style>
        body {
            margin: 0;
            background: #e5e7eb;
            font-family: Arial, sans-serif;
        }

        /* HEADER UNGU */
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

        /* WRAPPER PUTIH */
        .content-wrapper {
            max-width: 900px;
            margin: 25px auto;
            background: white;
            border-radius: 12px;
            padding: 25px 35px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.10);
        }

        /* TOMBOL KEMBALI */
        .back-btn {
            display: inline-flex;
            background: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            text-decoration: none;
            color: #111;
            box-shadow: 0 3px 7px rgba(0,0,0,0.2);
            margin-bottom: 10px;
        }
        .back-btn:hover { background: #f3f4f6; }

        /* BREADCRUMB */
        .breadcrumb-box {
            margin-bottom: 10px;
            font-size: 14px;
            color: #6b7280;
        }
        .breadcrumb-box a {
            text-decoration: none;
            color: #6b7280;
            transition: 0.2s;
        }
        .breadcrumb-box a:hover { color: #4f46e5; }

        /* JUDUL */
        h1 {
            font-size: 30px;
            margin: 10px 0;
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

        /* GAMBAR */
        .main-img {
            width: 100%;
            max-height: 480px;
            object-fit: contain;
            margin: 20px 0;
            border-radius: 8px;
        }

        .article p {
            text-align: justify;
            font-size: 15px;
            line-height: 1.7;
            color: #374151;
            margin-bottom: 14px;
        }
    </style>
</head>
<body>

<!-- HEADER UNGU -->
<div class="top-header">
    {{-- GANTI: assets/ → {{ asset('assets/') }} --}}
    <img src="{{ asset('assets/images/logo-big.png') }}" alt="Logo">
    Desa Banjardowo
</div>

<div class="content-wrapper">

    <!-- TOMBOL KEMBALI -->
    {{-- GANTI: href native → route() --}}
    <a href="{{ route('home') }}#prestasi" class="back-btn">←</a>

    <!-- BREADCRUMB -->
    <div class="breadcrumb-box">
        <a href="{{ route('home') }}">Dashboard</a> /
        <a href="{{ route('home') }}#prestasi">Prestasi</a> /
        <span>{{ Str::limit($prestasi->judul, 30) }}</span>
    </div>

    <!-- JUDUL -->
    <h1>{{ $prestasi->judul }}</h1>

    <!-- INFO PENULIS -->
    <div class="author">
        <img src="{{ asset('assets/images/logo-big.png') }}" alt="avatar">
        <div>
            <b>E-Deslay</b><br>
            {{-- GANTI: date() native → Carbon dari Controller --}}
            {{ $formatted_date }}
        </div>
    </div>

    <!-- FOTO -->
    @if($image_url)
        <img class="main-img" src="{{ $image_url }}" alt="{{ $prestasi->judul }}">
    @endif

    <!-- ARTIKEL -->
    <div class="article">
        {{-- GANTI: nl2br(htmlspecialchars()) → {!! nl2br(e()) !!} --}}
        <p>{!! nl2br(e($prestasi->deskripsi)) !!}</p>
    </div>

</div>

</body>
</html>