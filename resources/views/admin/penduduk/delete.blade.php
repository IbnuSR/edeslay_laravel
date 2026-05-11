@extends('layouts.app')

@section('content')

<style>
    /* ===== RESET LINK DEFAULT ===== */
    a { text-decoration: none !important; color: inherit; }
    
    /* ===== MAIN CONTENT ===== */
    .main-container { 
        padding: 20px 30px; width: 100%; max-width: 100%;
        background: #f5f9ff; box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 100px);
    }
    
    /* ===== TOP BAR ===== */
    .top-bar { 
        display: flex; align-items: center; justify-content: space-between; 
        margin-bottom: 30px; background: #e3f2fd; padding: 20px 30px;
        border-radius: 16px; flex-wrap: wrap; gap: 20px;
    }
    .page-header h1 { font-size: 26px; font-weight: 700; color: #1e293b; margin-bottom: 4px; margin-top: 0; }
    .breadcrumb { font-size: 13px; color: #94a3b8; }
    .search-wrapper { display: flex; align-items: center; gap: 20px; flex: 1; justify-content: flex-end; }
    .profile-wrapper { 
        display: flex; align-items: center; gap: 12px; padding: 8px 16px;
        background: white; border-radius: 999px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); white-space: nowrap;
    }
    .profile-avatar { 
        width: 40px; height: 40px; border-radius: 999px; 
        background: linear-gradient(135deg, #f97316, #fb923c);
        display: flex; align-items: center; justify-content: center; 
        font-weight: 600; font-size: 16px; color: white;
        overflow: hidden; flex-shrink: 0; text-decoration: none !important;
    }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-info { text-align: right; }
    .profile-info .name { font-weight: 600; font-size: 14px; color: #1e293b; }
    .profile-info .role { font-size: 12px; color: #94a3b8; }
    
    /* ===== DELETE CARD ===== */
    .delete-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        padding: 40px;
        max-width: 500px;
        width: 100%;
        text-align: center;
    }

    .icon-box {
        width: 80px;
        height: 80px;
        background: #fee2e2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        font-size: 40px;
        color: #ef4444;
    }

    .delete-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .delete-desc {
        color: #64748b;
        margin-bottom: 30px;
        font-size: 15px;
    }

    .data-summary {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        text-align: left;
    }

    .data-summary h4 {
        margin: 0 0 10px 0;
        font-size: 14px;
        color: #94a3b8;
        text-transform: uppercase;
        font-weight: 600;
    }

    .data-summary p {
        margin: 0;
        font-weight: 600;
        color: #1e293b;
        font-size: 18px;
    }
    
    .data-summary small {
        color: #64748b;
        font-size: 13px;
    }

    .actions {
        display: flex;
        gap: 12px;
    }

    .btn {
        flex: 1;
        padding: 14px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    .btn-danger:hover { 
        background: #dc2626; 
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4);
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
    }
    .btn-secondary:hover { 
        background: #e2e8f0; 
    }
    
    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 1024px) {
        .main-container { padding: 15px 20px; }
        .top-bar { flex-direction: column; align-items: stretch; padding: 15px 20px; }
        .search-wrapper { flex-direction: column; width: 100%; }
        .profile-wrapper { justify-content: center; width: 100%; }
    }
    
    @media (max-width: 768px) {
        .main-container { padding: 10px 15px; }
        .delete-card { padding: 30px 20px; }
        .actions { flex-direction: column; }
        .btn { width: 100%; }
    }
</style>

<div class="main-container">
    {{-- TOP BAR --}}
    <div class="top-bar">
        <div class="page-header">
            <h1>Konfirmasi Hapus</h1>
            <div class="breadcrumb">Dashboard / Data Penduduk / Hapus</div>
        </div>
        
        <div class="search-wrapper">
            {{-- Profile --}}
            <div class="profile-wrapper">
                <div class="profile-info">
                    <div class="name">{{ $namaAdmin ?? 'Administrator' }}</div>
                    <div class="role">{{ $roleAdmin ?? 'admin' }}</div>
                </div>
                <a href="{{ route('admin.profile') }}" class="profile-avatar">
                    @if(isset($fotoProfilSrc) && $fotoProfilSrc)
                        <img src="{{ $fotoProfilSrc }}" alt="Foto">
                    @else
                        {{ $inisialAdmin ?? 'A' }}
                    @endif
                </a>
            </div>
        </div>
    </div>

    {{-- DELETE CARD --}}
    <div class="delete-card">
        <div class="icon-box">⚠️</div>
        <h2 class="delete-title">Hapus Data Penduduk?</h2>
        <p class="delete-desc">
            Apakah kamu yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="data-summary">
            <h4>Data yang akan dihapus:</h4>
            <p>{{ $penduduk->nama }}</p>
            <small>NIK: {{ $penduduk->nik }}</small>
        </div>

        <form action="{{ route('admin.penduduk.destroy', $penduduk) }}" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="actions">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    ❌ Batal
                </a>
                <button type="submit" class="btn btn-danger">
                    🗑️ Ya, Hapus Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

@endsection