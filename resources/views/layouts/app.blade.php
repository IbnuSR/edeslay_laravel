<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Desa Banjardowo</title>
    
    <!-- CSS Global (Font, Icon, dll) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS untuk halaman surat -->
    <style>
        /* CSS Dasar Layout */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #f5f9ff; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .app { display: flex; min-height: 100vh; }
        .main { margin-left: 280px; padding: 30px 40px; flex: 1; }
        
        /* CSS untuk Halaman Surat */
        .border-left-primary { border-left: 4px solid #4e73df !important; }
        .border-left-success { border-left: 4px solid #1cc88a !important; }
        .border-left-danger { border-left: 4px solid #e74a3b !important; }
        .border-left-info { border-left: 4px solid #36b9cc !important; }
        .bg-purple { background-color: #6f42c1 !important; }
        
        .nav-tabs .nav-link.active { 
            background-color: #4e73df !important; 
            color: white !important;
            border-color: #4e73df !important;
        }
        .nav-tabs .nav-link { 
            color: #6c757d; 
            border: none;
            padding: 1rem;
            font-weight: 500;
        }
        .nav-tabs .nav-link:hover { 
            color: #4e73df; 
            border: none;
        }
        
        .card {
            border: none;
            border-radius: 0.5rem;
        }
        
        .badge.bg-purple {
            background-color: #6f42c1 !important;
            color: white;
        }
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
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Optional: Custom JS -->
    @stack('scripts')
</body>
</html>