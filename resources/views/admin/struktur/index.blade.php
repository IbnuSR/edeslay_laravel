@extends('layouts.app')
@section('content')
<style>
    .main-container { padding: 2rem; }
    
    /* ===== TOP BAR ===== */
    .top-bar { 
        display: flex; 
        justify-content: space-between; 
        background: #bdddff; 
        align-items: center; 
        margin-bottom: 2rem;
        padding: 20px 30px;
        border-radius: 16px;
        flex-wrap: wrap;
        gap: 20px;
    }
    .page-header h1 { 
        font-size: 24px; 
        color: #1e293b; 
        margin: 0; 
        font-weight: 700;
    }
    .breadcrumb { 
        font-size: 13px; 
        color: #64748b;
        margin-top: 4px;
    }
    
    /* ===== SEARCH & PROFILE WRAPPER ===== */
    .search-wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
        justify-content: flex-end;
    }
    
    .search-box {
        background: white;
        border-radius: 999px;
        padding: 12px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        width: 350px;
        max-width: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .search-box input {
        border: none;
        outline: none;
        background: transparent;
        flex: 1;
        font-size: 14px;
        color: #334155;
        min-width: 0;
    }
    .search-box input::placeholder {
        color: #94a3b8;
    }
    
    .profile-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 16px;
        background: white;
        border-radius: 999px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        white-space: nowrap;
    }
    .profile-avatar {
        width: 40px;
        height: 40px;
        border-radius: 999px;
        background: linear-gradient(135deg, #f97316, #fb923c);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
        color: white;
        overflow: hidden;
        flex-shrink: 0;
        text-decoration: none !important;
    }
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-info {
        text-align: right;
    }
    .profile-info .name {
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
    }
    .profile-info .role {
        font-size: 12px;
        color: #94a3b8;
    }
    
    /* ===== BUTTONS ===== */
    .btn { 
        padding: 10px 20px; 
        border-radius: 8px; 
        border: none; 
        cursor: pointer; 
        font-weight: 500; 
        text-decoration: none; 
        display: inline-block;
        transition: all 0.3s;
    }
    .btn-primary { 
        background: linear-gradient(135deg, #2b6cb0, #2f80ed); 
        color: white;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 128, 237, 0.3);
    }
    .btn-warning { 
        background: #f59e0b; 
        color: white;
    }
    .btn-warning:hover {
        background: #d97706;
    }
    .btn-danger { 
        background: #ef4444; 
        color: white;
    }
    .btn-danger:hover {
        background: #dc2626;
    }
    .btn-sm { 
        padding: 6px 12px; 
        font-size: 13px; 
    }
    
    /* ===== CONTENT CARD ===== */
    .content-card { 
        background: white; 
        border-radius: 12px; 
        padding: 24px; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.08); 
    }
    
    /* ===== ALERT ===== */
    .alert { 
        padding: 12px 16px; 
        border-radius: 8px; 
        margin-bottom: 1rem; 
    }
    .alert-success { 
        background: #dcfce7; 
        color: #166534; 
        border: 1px solid #86efac; 
    }
    
    /* ===== TABLE ===== */
    .table { 
        width: 100%; 
        border-collapse: collapse; 
    }
    .table th, .table td { 
        padding: 12px; 
        text-align: left; 
        border-bottom: 1px solid #e2e8f0; 
    }
    .table th { 
        background: #f8fafc; 
        font-weight: 600; 
        color: #475569; 
    }
    .table tbody tr:hover {
        background: #f8fafc;
    }
    .table img { 
        border-radius: 8px; 
    }
    .text-center { 
        text-align: center; 
    }
    
    /* ===== ACTION BUTTONS ===== */
    .action-buttons { 
        display: flex; 
        gap: 8px; 
    }
    
    /* ===== NO RESULTS ===== */
    .no-results {
        text-align: center;
        padding: 40px;
        color: #94a3b8;
        display: none;
    }
    .no-results.show {
        display: block;
    }
    
    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .top-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .search-wrapper {
            flex-direction: column;
            width: 100%;
        }
        .search-box {
            width: 100%;
        }
        .profile-wrapper {
            justify-content: center;
        }
    }
</style>

<div class="main-container">
    <div class="top-bar">
        <div class="page-header">
            <h1>Struktur Perangkat Desa</h1>
            <div class="breadcrumb">Dashboard / Struktur / Daftar Struktur</div>
        </div>
        
        <div class="search-wrapper">
            {{-- Search Box --}}
            <div class="search-box">
                <i class="fas fa-search" style="color: #94a3b8;"></i>
                <input type="text" id="searchStruktur" placeholder="Cari nama / jabatan / NIP...">
            </div>
            
            {{-- ✅ TOMBOL TAMBAH DATA --}}
            <a href="{{ route('admin.struktur.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Data
            </a>
            
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

    <div class="content-card">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table" id="strukturTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>NIP</th>
                        <th>Urutan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($struktur as $index => $item)
                    <tr data-nama="{{ strtolower($item->nama) }}" 
                        data-jabatan="{{ strtolower($item->jabatan) }}" 
                        data-nip="{{ strtolower($item->nip ?? '') }}">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ $item->foto ? asset('storage/'.$item->foto) : asset('assets/images/default-avatar.png') }}" 
                                 style="width:50px; height:50px; object-fit:cover;">
                        </td>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td>{{ $item->jabatan }}</td>
                        <td>{{ $item->nip ?? '-' }}</td>
                        <td>{{ $item->urutan }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.struktur.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                
                                {{-- ✅ TOMBOL HAPUS (FIXED) --}}
                                <button type="button" 
                                        class="btn btn-danger btn-sm btn-delete"
                                        data-url="{{ route('admin.struktur.destroy', $item->id) }}"
                                        data-nama="{{ $item->nama }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 40px; color: #94a3b8;">
                            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 12px; display: block;"></i>
                            Belum ada data perangkat desa
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="no-results" id="noResults">
                <i class="fas fa-search" style="font-size: 48px; margin-bottom: 12px; display: block;"></i>
                <div>Tidak ada data yang sesuai dengan pencarian</div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ SWEETALERT2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ================= 1. SEARCH STRUKTUR =================
document.getElementById('searchStruktur')?.addEventListener('keyup', function(){
    let value = this.value.toLowerCase().trim();
    let rows = document.querySelectorAll('#strukturTable tbody tr');
    let visibleCount = 0;
    
    rows.forEach(function(row){
        let nama = row.dataset.nama || '';
        let jabatan = row.dataset.jabatan || '';
        let nip = row.dataset.nip || '';
        
        let match = nama.includes(value) || 
                    jabatan.includes(value) || 
                    nip.includes(value);
        
        if (match) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Show/hide no results message
    let noResults = document.getElementById('noResults');
    if (noResults) {
        if (visibleCount === 0 && value !== '') {
            noResults.classList.add('show');
        } else {
            noResults.classList.remove('show');
        }
    }
});

// ================= 2. SWEETALERT DELETE (FIXED) =================
document.addEventListener('DOMContentLoaded', function() {
    // Ambil CSRF token dari meta tag (harus ada di app.blade.php)
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            let destroyUrl = this.getAttribute('data-url');
            let nama = this.getAttribute('data-nama') || 'data ini';
            
            Swal.fire({
                title: 'Hapus Data?',
                text: `Apakah Anda yakin ingin menghapus "${nama}"? Data tidak bisa dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form dinamis untuk submit DELETE
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = destroyUrl;
                    form.style.display = 'none';
                    
                    // Tambahkan CSRF token
                    let csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                    
                    // Tambahkan method DELETE spoofing
                    let methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection