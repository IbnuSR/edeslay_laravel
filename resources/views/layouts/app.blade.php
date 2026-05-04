<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Desa Banjardowo</title>
    <!-- CSS Global (Font, Icon, dll) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* CSS Dasar Layout */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #f5f9ff; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .app { display: flex; min-height: 100vh; }
        .main { margin-left: 280px; padding: 30px 40px; flex: 1; }
    </style>
</head>
<body>
    <div class="app">
        <!-- PANGGIL SIDEBAR -->
        @include('layouts.sidebar')

        <!-- KONTEN HALAMAN -->
        <div class="main">
            @yield('content')
        </div>
    </div>
</body>
</html>