<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* ✅ Toast Notification Style */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .toast {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .toast-success {
            background: #dcfce7;
            border-left: 4px solid #22c55e;
            color: #166534;
        }
        .toast-error {
            background: #fee2e2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="app">
        <!-- PANGGIL SIDEBAR -->
        @include('layouts.sidebar')

        <!-- KONTEN HALAMAN -->
        <div class="main">
            {{-- ✅ VARIABEL USER SUDAH DARI AppServiceProvider, TIDAK PERLU @php BLOCK --}}
            
            {{-- ✅ TOAST NOTIFICATION CONTAINER (Untuk pesan upload sukses/error) --}}
            <div class="toast-container">
                @if(session('success'))
                <div class="toast toast-success show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
                @endif
                @if(session('error'))
                <div class="toast toast-error show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
                @endif
            </div>
            
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- ✅ Global JS: Handle Toast & AJAX Setup -->
    <script>
        // Setup CSRF Token untuk semua AJAX request
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken) {
                // Untuk Fetch API
                window.fetch = (function(originalFetch) {
                    return function(url, options = {}) {
                        if (!options.headers) options.headers = {};
                        options.headers['X-CSRF-TOKEN'] = csrfToken;
                        return originalFetch(url, options);
                    };
                })(window.fetch);
                
                // Untuk jQuery AJAX (jika pakai)
                if (window.jQuery) {
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    });
                }
            }
            
            // Auto-hide toast setelah 5 detik
            const toastElList = document.querySelectorAll('.toast');
            toastElList.forEach(toastEl => {
                const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
                toast.show();
            });
        });
    </script>
    
    <!-- Optional: Custom JS per halaman -->
    @stack('scripts')
</body>
</html>