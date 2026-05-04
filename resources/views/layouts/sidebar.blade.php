<!-- SIDEBAR CSS -->
<!-- SIDEBAR CSS -->
<!-- SIDEBAR CSS -->
<style>
    .sidebar { 
        width: 280px; background: #FFFFFF; padding: 24px 20px; 
        position: fixed; height: 100vh; box-shadow: 0 4px 12px rgba(80, 168, 255, 0.3);
        overflow-y: auto; border-right: 1px solid #e3f2fd;
        display: flex; flex-direction: column;
    }
    
    .sidebar-header { display: flex; align-items: center; gap: 12px; margin-bottom: 32px; padding: 0 8px; }
    .sidebar-header img { height: 42px; }
    .sidebar-header div { font-weight: 600; font-size: 18px; color: #1e293b; }

    .menu { display: flex; flex-direction: column; gap: 8px; flex-grow: 1; }
    
    .menu-item { 
        display: flex; align-items: center; gap: 14px; padding: 14px 18px;
        border-radius: 16px; font-size: 15px; font-weight: 500; transition: all 0.3s;
        color: #64748b; text-decoration: none !important; border: none !important;
    }
    
    /* ✅ Ikon Default: Abu-abu silver (biar kelihatan di background putih) */
    .menu-item img { 
        width: 24px; height: 24px; object-fit: contain; 
        filter: brightness(0) invert(0.42); 
        transition: filter 0.3s ease;
    }
    
    /* ✅ Hover: Teks & Ikon jadi BIRU */
    .menu-item:hover { background: #f1f5f9; color: #1976d2; }
    .menu-item:hover img { 
        /* Filter khusus untuk mengubah warna ikon jadi biru (#1976d2) */
        filter: invert(32%) sepia(84%) saturate(3524%) hue-rotate(198deg) brightness(92%) contrast(95%);
    }
    
    /* ✅ Active: Teks & Ikon jadi PUTIH */
    .menu-item.active { 
        background: linear-gradient(135deg, #2b6cb0, #2f80ed);
        color: white; box-shadow: 0 8px 20px rgba(47, 128, 237, 0.3);
    }
    .menu-item.active img { 
        filter: brightness(0) invert(1); /* Balik jadi putih */
    }

    .sidebar-footer { padding: 20px 0; border-top: 1px solid #f1f5f9; }
    .sidebar-footer .logout { 
        display: flex; align-items: center; gap: 14px; padding: 14px 16px; 
        color: #64748b; border-radius: 14px; transition: all 0.3s; 
        cursor: pointer; font-weight: 500; text-decoration: none !important;
    }
    .sidebar-footer .logout:hover { color: #ef4444; background: #fee2e2; }
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

        <!-- Pelayanan -->
        <a href="{{ route('admin.pelayanan.index') }}" class="menu-item {{ Request::is('admin/pelayanan*') ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/pelayanan1.png') }}"> Pelayanan
        </a>

        <!-- Kotak Saran (NEW) -->
        <a href="{{ route('admin.saran.index') }}" class="menu-item {{ Request::is('admin/saran*') ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/kotaksaran1.png') }}"> Kotak Saran
        </a>
    </div>  

    <div class="sidebar-footer">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span>Keluar</span>
        </a>
    </div>
</div>