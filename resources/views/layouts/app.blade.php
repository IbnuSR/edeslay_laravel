<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Deslay - Desa Banjardowo')</title>
    
    {{-- Global CSS (jika ada) --}}
    @stack('styles')
</head>
<body>
    {{-- Konten dari child view akan muncul di sini --}}
    @yield('content')
    
    {{-- Global JS (jika ada) --}}
    @stack('scripts')
</body>
</html>