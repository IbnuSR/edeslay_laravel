<!-- SIDEBAR CSS -->
<style>
    .sidebar { 
        width: 280px;

        /* ✅ Background Image */
        background-image: url("{{ asset('assets/images/aa.png') }}");

        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;

        padding: 24px 20px; 
        position: fixed; 
        height: 100vh;
        z-index: 1000;

        /* ✅ Shadow lebih soft modern */
        box-shadow: 0 4px 20px rgba(80, 168, 255, 0.12);

        overflow-y: auto; 
        
        /* ✅ Border kanan soft biru */
        border-right: 1px solid #dbeafe;

        display: flex; 
        flex-direction: column;
    }
    
    .sidebar-header { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        margin-bottom: 32px; 
        padding: 0 8px; 
    }

    .sidebar-header img { 
        height: 42px; 
    }

    .sidebar-header div { 
        font-weight: 600; 
        font-size: 18px; 
        color: #1e293b; 
    }

    .menu { 
        display: flex; 
        flex-direction: column; 
        gap: 10px; 
        flex-grow: 1; 
    }
    
    .menu-item { 
        display: flex; 
        align-items: center; 
        gap: 14px; 
        padding: 15px 18px;
        border-radius: 18px; 
        font-size: 15px; 
        font-weight: 600; 
        transition: all 0.3s ease;
        color: #64748b; 
        text-decoration: none !important; 
        border: none !important;

        /* ✅ WARNA CARD BARU */
        background: linear-gradient(
            135deg,
            rgba(244,247,255,0.95),
            rgba(235,242,255,0.88)
        );

        /* ✅ Border soft */
        border: 1px solid rgba(215,227,255,0.8) !important;

        /* ✅ Shadow */
        box-shadow: 
            0 4px 10px rgba(59,130,246,0.05),
            inset 0 1px 0 rgba(255,255,255,0.6);

        backdrop-filter: blur(6px);
    }
    
    /* ✅ Ikon Default */
    .menu-item img { 
        width: 24px; 
        height: 24px; 
        object-fit: contain; 
        filter: brightness(0) invert(0.42); 
        transition: all 0.3s ease;
    }
    
    /* ✅ Hover */
    .menu-item:hover { 
        background: linear-gradient(
            135deg,
            rgba(230,240,255,1),
            rgba(219,234,254,0.95)
        );

        color: #1976d2;

        transform: translateX(4px);
    }

    .menu-item:hover img { 
        filter: invert(32%) sepia(84%) saturate(3524%) hue-rotate(198deg) brightness(92%) contrast(95%);
    }
    
    /* ✅ Active */
    .menu-item.active { 
        background: linear-gradient(135deg, #2b6cb0, #2f80ed);
        color: white; 
        
        box-shadow: 
            0 8px 20px rgba(47, 128, 237, 0.28),
            inset 0 1px 0 rgba(255,255,255,0.18);
    }

    .menu-item.active img { 
        filter: brightness(0) invert(1); 
    }

    .sidebar-footer { 
        padding: 20px 0; 
        border-top: 1px solid rgba(226,232,240,0.7); 
    }
    
    .sidebar-footer .logout { 
        display: flex; 
        align-items: center; 
        gap: 14px; 
        padding: 15px 18px; 
        color: #64748b; 
        border-radius: 18px; 
        transition: all 0.3s; 
        cursor: pointer; 
        font-weight: 600; 
        text-decoration: none !important;

        /* ✅ WARNA CARD LOGOUT */
        background: linear-gradient(
            135deg,
            rgba(244,247,255,0.95),
            rgba(235,242,255,0.88)
        );

        border: 1px solid rgba(215,227,255,0.8);

        box-shadow: 
            0 4px 10px rgba(59,130,246,0.05),
            inset 0 1px 0 rgba(255,255,255,0.6);
    }

    .sidebar-footer .logout:hover { 
        color: #ef4444; 
        background: #fee2e2;

        transform: translateX(4px);
    }
    
    /* ✅ Ikon Logout */
    .sidebar-footer .logout img {
        width: 24px; 
        height: 24px; 
        object-fit: contain;
        filter: brightness(0) invert(0.42);
        transition: filter 0.3s ease;
    }

    .sidebar-footer .logout:hover img {
        filter: invert(28%) sepia(90%) saturate(5000%) hue-rotate(350deg) brightness(95%) contrast(95%);
    }
/* ✅ Logout Relative */
.sidebar-footer .logout{
    position: relative;

    /* ✅ Jangan hidden lagi */
    overflow: visible;
}

/* ✅ Bola Glow */
.sidebar-footer .logout::before{
    content: "";

    position: absolute;

    width: 12px;
    height: 12px;

    background: #ef4444;

    border-radius: 50%;

    box-shadow:
        0 0 8px #ef4444,
        0 0 16px #ef4444,
        0 0 24px rgba(239,68,68,0.7);

    animation: orbitLogout 2s linear infinite;

    opacity: 0;

    transition: opacity 0.3s ease;

    z-index: 10;
}

/* ✅ Hover muncul */
.sidebar-footer .logout:hover::before{
    opacity: 1;
}

/* ✅ Animasi keliling DI LUAR card */
@keyframes orbitLogout {

    /* ATAS KIRI */
    0%{
        top: -6px;
        left: -6px;
    }

    /* ATAS KANAN */
    25%{
        top: -6px;
        left: calc(100% - 6px);
    }

    /* BAWAH KANAN */
    50%{
        top: calc(100% - 6px);
        left: calc(100% - 6px);
    }

    /* BAWAH KIRI */
    75%{
        top: calc(100% - 6px);
        left: -6px;
    }

    /* BALIK */
    100%{
        top: -6px;
        left: -6px;
    }
}
</style>

<!-- SIDEBAR HTML -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo">
        <div>Desa Banjardowo</div>
    </div>

    <div class="menu">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/dashboard1.png') }}"> Dashboard
        </a>

        <!-- Kegiatan Desa -->
        <a href="{{ route('admin.kegiatan.index') }}" class="menu-item {{ Request::is('admin/kegiatan*') ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/kegiatandesa.png') }}"> Kegiatan Desa
        </a>

        <!-- Prestasi -->
        <a href="{{ route('admin.prestasi.index') }}" class="menu-item {{ Request::is('admin/prestasi*') ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/prestasi.png') }}"> Prestasi
        </a>

        <!-- Data Penduduk -->
        <a href="{{ route('admin.penduduk.index') }}" class="menu-item {{ Request::is('admin/penduduk*') ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/penduduk.png') }}"> Data Penduduk
        </a>

        <!-- Pengajuan Surat -->
        <a href="{{ route('admin.surat.index', ['jenis' => request('jenis', 'domisili')]) }}" class="menu-item {{ Request::is('admin/surat*') ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/pss.png') }}"> Pengajuan Surat
        </a>

        <!-- Pelayanan -->
        <a href="{{ route('admin.pelayanan.index') }}" class="menu-item {{ Request::is('admin/pelayanan*') ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/kotaksaran1.png') }}"> Pelayanan
        </a>

        <!-- Kotak Saran -->
        <a href="{{ route('admin.saran.index') }}" class="menu-item {{ Request::is('admin/saran*') ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/ks.png') }}"> Kotak Saran
        </a>

        <!-- ✅ STRUKTUR PERANGKAT DESA - BARU DITAMBAHKAN -->
        <a href="{{ route('admin.struktur.index') }}" class="menu-item {{ Request::is('admin/struktur*') ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/sd.png') }}"> Struktur Desa
        </a>
    </div>  

    <!-- ✅ SIDEBAR FOOTER: HANYA LOGOUT -->
    <div class="sidebar-footer">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        
        {{-- ✅ UBAH: Tambah id="logoutBtn" dan hapus onclick --}}
        <a href="#" id="logoutBtn" class="logout">
            <img src="{{ asset('assets/icons/logout1.png') }}" alt="Logout">
            <span>Keluar</span>
        </a>
    </div>
</div>

{{-- ✅ SWEETALERT2 CDN + Script Popup Logout --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('logoutBtn');
    const logoutForm = document.getElementById('logout-form');
    
    if (logoutBtn && logoutForm) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form logout
                    logoutForm.submit();
                }
            });
        });
    }
});
</script>