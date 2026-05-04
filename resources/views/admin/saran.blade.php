@extends('layouts.app')

@section('content')
<style>
    /* ===== RESET LINK DEFAULT ===== */
    a { text-decoration: none !important; color: inherit; }
    
    /* ===== MAIN CONTENT ===== */
    .main-container { 
        padding: 20px 30px; width: 100%; max-width: 100%;
        background: #f5f9ff; box-sizing: border-box;
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
    .search-box { 
        background: white; border-radius: 999px; padding: 12px 24px; 
        display: flex; align-items: center; gap: 12px; width: 270px;
        max-width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .search-box input { 
        border: none; outline: none; background: transparent; flex: 1; 
        font-size: 14px; color: #334155; min-width: 0;
    }
    .search-box input::placeholder { color: #94a3b8; }
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
    
    /* ===== CONTENT CARD ===== */
    .content-card { 
        background: white; border-radius: 20px; padding: 30px; 
        box-shadow: 0 2px 12px rgba(0,0,0,0.04); width: 100%; box-sizing: border-box;
    }
    .card-header { 
        display: flex; justify-content: space-between; align-items: center; 
        margin-bottom: 24px; flex-wrap: wrap; gap: 16px;
    }
    .card-header h2 { margin: 0; }
    
    /* ===== TABLE ===== */
    .table-container { overflow-x: auto; width: 100%; }
    table { width: 100%; border-collapse: collapse; min-width: 800px; }
    th { 
        padding: 16px; text-align: left; font-weight: 600; color: #64748b;
        font-size: 13px; border-bottom: 2px solid #e3f2fd; white-space: nowrap;
    }
    td { 
        padding: 20px 16px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;
        font-size: 14px; color: #334155;
    }
    tbody tr:hover { background: #f8fafc; }
    .no-col { width: 60px; text-align: center; font-weight: 600; color: #64748b; }
    .img-col { width: 80px; }
    .foto-item { 
        width: 60px; height: 60px; border-radius: 12px; 
        object-fit: cover; background: #f1f5f9;
    }
    .judul-link { 
        color: #1e293b; font-weight: 600; transition: color 0.3s;
    }
    .judul-link:hover { color: #1976d2; }
    .deskripsi-text { 
        color: #64748b; font-size: 13px; line-height: 1.6;
        max-width: 300px; overflow: hidden; text-overflow: ellipsis;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    }
    .aksi-col { width: 100px; text-align: center; }
    .aksi-buttons { display: flex; gap: 8px; justify-content: center; align-items: center; }
    .btn-icon { 
        width: 36px; height: 36px; border-radius: 8px; border: none !important; 
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: all 0.3s; background: transparent;
    }
    .btn-delete { color: #ef4444; }
    .btn-delete:hover { background: #fee2e2; transform: scale(1.1); }
    
    /* ===== DETAIL VIEW ===== */
    .detail-container { 
        background: white; border-radius: 16px; padding: 30px; max-width: 100%;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .detail-image { 
        width: 100%; max-height: 450px; object-fit: cover; border-radius: 16px; 
        margin-bottom: 24px; background: #f1f5f9;
    }
    .detail-content { font-size: 15px; line-height: 1.8; color: #475569; }
    .detail-content strong { color: #1e293b; font-weight: 600; }
    .detail-actions { 
        display: flex; gap: 12px; margin-top: 30px; padding-top: 24px;
        border-top: 2px solid #e2e8f0; flex-wrap: wrap;
    }
    .btn-detail-delete { 
        background: #fee2e2; color: #ef4444; padding: 12px 24px; border-radius: 10px; 
        border: none; font-weight: 600; cursor: pointer; display: flex;
        align-items: center; gap: 8px; transition: all 0.3s;
    }
    
    /* ===== ALERT ===== */
    .alert { 
        margin-bottom: 20px; padding: 14px 20px; border-radius: 12px; 
        font-size: 14px; font-weight: 500;
    }
    .alert-success { background: #dcfce7; color: #166534; border: 2px solid #86efac; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 2px solid #fca5a5; }
</style>

<div class="main-container">
    @if($action === 'list')
    <div class="top-bar">
        <div class="page-header">
            <h1>Kotak Saran</h1>
            <div class="breadcrumb">Dashboard / Kotak Saran / Daftar Saran</div>
        </div>
        <div class="search-wrapper">
            <form method="get" action="{{ route('admin.saran.index') }}" class="search-box">
                <input type="hidden" name="action" value="list">
                <i class="fas fa-search" style="color: #94a3b8;"></i>
                <input type="text" name="search" placeholder="Cari Saran" value="{{ old('search', $search ?? '') }}">
            </form>
            <div class="profile-wrapper">
                <div class="profile-info">
                    <div class="name">{{ $namaAdmin ?? 'Administrator' }}</div>
                    <div class="role">{{ $roleAdmin ?? 'admin' }}</div>
                </div>
                <a href="{{ route('admin.profile') }}" class="profile-avatar">
                    {{ $inisialAdmin ?? 'A' }}
                </a>
            </div>
        </div>
    </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    {{-- LIST VIEW --}}
    @if($action === 'list')
        <div class="content-card">
            <div class="card-header">
                <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">Daftar Saran Masuk</h2>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="no-col">No</th>
                            <th class="img-col">Foto</th>
                            <th>Tanggal Pengisian</th>
                            <th>Judul Saran</th>
                            <th>Isi Saran</th>
                            <th class="aksi-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($saranList as $row)
                            @php
                                // ✅ Gunakan Storage::url() untuk path file
                                $fotoSrc = !empty($row->foto_sampul) ? Storage::url($row->foto_sampul) : '';
                                $shortIsi = strlen($row->isi_saran) > 150 
                                    ? substr($row->isi_saran, 0, 150) . '...' 
                                    : $row->isi_saran;
                            @endphp
                            <tr>
                                <td class="no-col">{{ $loop->iteration }}</td>
                                <td>
                                    @if(!empty($fotoSrc))
                                        <img src="{{ $fotoSrc }}" alt="Foto" class="foto-item">
                                    @else
                                        <div class="foto-item" style="display:flex;align-items:center;justify-content:center;background:#e3f2fd;">
                                            <i class="fas fa-image" style="color:#94a3b8;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="tanggal-text" style="font-size:13px;color:#94a3b8;font-weight:500;">
                                        {{ \Carbon\Carbon::parse($row->tanggal_pengisian ?? $row->tanggal_dikirim)->isoFormat('D MMMM Y') }}
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.saran.index', ['action' => 'view', 'id' => $row->id]) }}" class="judul-link">
                                        {{ $row->judul }}
                                    </a>
                                </td>
                                <td><div class="deskripsi-text">{{ $shortIsi }}</div></td>
                                <td class="aksi-col">
                                    <div class="aksi-buttons">
                                        <button class="btn-icon btn-delete" title="Hapus" onclick="openDeleteModal({{ $row->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;">Belum ada saran masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- DETAIL VIEW --}}
    @if($action === 'view')
        <div class="content-card">
            <div class="card-header">
                <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">Detail Saran</h2>
                <a href="{{ route('admin.saran.index') }}"><button class="btn-secondary" style="border-radius:10px;padding:12px 24px;background:#e2e8f0;border:none;font-size:14px;font-weight:600;cursor:pointer;color:#475569;"><i class="fas fa-arrow-left"></i> Kembali</button></a>
            </div>
            @if(isset($detail) && $detail)
                @php $fotoSrc = !empty($detail->foto_sampul) ? Storage::url($detail->foto_sampul) : ''; @endphp
                <div class="detail-container">
                    @if(!empty($fotoSrc))
                        <img src="{{ $fotoSrc }}" alt="Foto Saran" class="detail-image">
                    @else
                        <div class="detail-image" style="display:flex;align-items:center;justify-content:center;background:#f1f5f9;color:#94a3b8;">
                            <i class="fas fa-image" style="font-size:80px;opacity:0.3;"></i>
                        </div>
                    @endif
                    <div style="margin-bottom:8px;font-size:14px;color:#94a3b8;">
                        <i class="far fa-calendar"></i> 
                        {{ \Carbon\Carbon::parse($detail->tanggal_pengisian ?? $detail->tanggal_dikirim)->isoFormat('D MMMM Y') }}
                    </div>
                    <h1 style="font-size:26px;font-weight:700;color:#1e293b;margin:16px 0;">{{ $detail->judul }}</h1>
                    <div class="detail-content">
                        <p><strong>Isi Saran:</strong></p>
                        <p>{!! nl2br(e($detail->isi_saran)) !!}</p>
                    </div>
                    <div class="detail-actions">
                        <button class="btn-detail-delete" onclick="openDeleteModal({{ $detail->id }})">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </div>
                </div>
            @else
                <div style="text-align:center;padding:60px 20px;background:#f8fafc;border-radius:16px;">
                    <i class="fas fa-exclamation-circle" style="font-size:64px;color:#f59e0b;margin-bottom:20px;"></i>
                    <h3 style="font-size:20px;color:#1e293b;margin-bottom:12px;margin-top:0;">Data Tidak Ditemukan</h3>
                    <p style="color:#64748b;margin-bottom:24px;">Saran dengan ID ini tidak ada atau telah dihapus.</p>
                    <a href="{{ route('admin.saran.index') }}" style="background:#e2e8f0;color:#475569;padding:12px 24px;border-radius:10px;border:none;font-weight:600;text-decoration:none;"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
                </div>
            @endif
        </div>
    @endif
</div>

{{-- MODAL HAPUS (SweetAlert) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openDeleteModal(id){
        Swal.fire({
            title: 'Hapus Saran?',
            text: 'Data yang sudah dihapus tidak dapat dikembalikan. Apakah Anda yakin ingin melanjutkan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("admin.saran.index") }}?action=delete&id=' + id;
            }
        });
    }
</script>
@endsection