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
    .btn-tambah { 
        background: #1976d2; color: white; border-radius: 12px; padding: 12px 24px; 
        font-size: 14px; border: none; cursor: pointer; font-weight: 600; 
        display: flex; align-items: center; gap: 8px; transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3); white-space: nowrap;
    }
    .btn-tambah:hover { 
        background: #1565c0; transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(25, 118, 210, 0.4);
    }
    
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
    .btn-edit { color: #f59e0b; }
    .btn-edit:hover { background: #fef3c7; transform: scale(1.1); }
    .btn-delete { color: #ef4444; }
    .btn-delete:hover { background: #fee2e2; transform: scale(1.1); }
    
    /* ===== FORM ===== */
    .form-wrapper { margin-top: 20px; }
    .form-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 24px; }
    .form-section { 
        background: #f8fafc; padding: 28px; border-radius: 16px; border: 2px solid #e2e8f0;
    }
    .form-group { margin-bottom: 20px; }
    .form-group label { 
        display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #334155;
    }
    .form-group input[type="text"], .form-group textarea { 
        width: 100%; padding: 12px 16px; border-radius: 10px; border: 2px solid #e2e8f0; 
        font-size: 14px; transition: all 0.3s; font-family: inherit; box-sizing: border-box;
    }
    .form-group input:focus, .form-group textarea:focus { 
        border-color: #1976d2; outline: none; box-shadow: 0 0 0 4px rgba(25, 118, 210, 0.1);
    }
    .form-group textarea { min-height: 120px; resize: vertical; }
    
    /* ===== UPLOAD BOX ===== */
    .upload-container { 
        width: 100%; min-height: 260px; border: 2px dashed #cbd5e1; border-radius: 16px; 
        display: flex; align-items: center; justify-content: center; cursor: pointer; 
        background: white; position: relative; overflow: hidden; transition: all 0.3s;
    }
    .upload-container:hover { border-color: #1976d2; background: #f0f7ff; }
    .upload-preview { 
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
        object-fit: cover; border-radius: 16px; z-index: 1;
    }
    .upload-placeholder { 
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
        display: flex; flex-direction: column; align-items: center; justify-content: center; 
        z-index: 2; color: #64748b;
    }
    .upload-placeholder i { font-size: 48px; color: #1976d2; margin-bottom: 12px; }
    .upload-placeholder span { font-size: 15px; font-weight: 600; color: #334155; }
    .upload-input { 
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
        cursor: pointer; opacity: 0; z-index: 3;
    }
    
    /* ===== BUTTONS ===== */
    .form-actions { 
        display: flex; gap: 12px; margin-top: 24px; padding-top: 24px;
        border-top: 2px solid #e2e8f0; flex-wrap: wrap;
    }
    .btn-secondary { 
        border-radius: 10px; padding: 12px 24px; background: #e2e8f0; border: none; 
        font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s;
        color: #475569; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-secondary:hover { background: #cbd5e1; transform: translateY(-2px); }
    .btn-primary { 
        background: #10b981; color: white; border-radius: 10px; padding: 12px 24px; 
        border: none; font-size: 14px; font-weight: 600; cursor: pointer;
        display: flex; align-items: center; gap: 8px; transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    .btn-primary:hover { background: #059669; transform: translateY(-2px); }
    
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
    .btn-detail-edit { 
        background: #1976d2; color: white; padding: 12px 24px; border-radius: 10px; 
        border: none; font-weight: 600; cursor: pointer; display: flex;
        align-items: center; gap: 8px; transition: all 0.3s;
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
            <h1>Pelayanan Desa</h1>
            <div class="breadcrumb">Dashboard / Pelayanan / Daftar Panduan</div>
        </div>
        <div class="search-wrapper">
            <form method="get" action="{{ route('admin.pelayanan.index') }}" class="search-box">
                <input type="hidden" name="action" value="list">
                <i class="fas fa-search" style="color: #94a3b8;"></i>
                <input type="text" name="search" placeholder="Cari Panduan" value="{{ old('search', $search ?? '') }}">
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
                <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">Daftar Panduan Surat</h2>
                <a href="{{ route('admin.pelayanan.index', ['action' => 'tambah']) }}">
                    <button class="btn-tambah"><i class="fas fa-plus"></i> Tambah</button>
                </a>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="no-col">No</th>
                            <th class="img-col">Foto</th>
                            <th>Judul Panduan</th>
                            <th>Deskripsi Singkat</th>
                            <th class="aksi-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelayananList as $row)
                            @php
                                // ✅ Gunakan Storage::url() untuk path file
                                $fotoSrc = !empty($row->foto_pendukung) ? Storage::url($row->foto_pendukung) : '';
                                $shortDesc = strlen($row->deskripsi_singkat) > 100 
                                    ? substr($row->deskripsi_singkat, 0, 100) . '...' 
                                    : $row->deskripsi_singkat;
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
                                    <a href="{{ route('admin.pelayanan.index', ['action' => 'view', 'id' => $row->id]) }}" class="judul-link">
                                        {{ $row->judul }}
                                    </a>
                                </td>
                                <td><div class="deskripsi-text">{{ $shortDesc }}</div></td>
                                <td class="aksi-col">
                                    <div class="aksi-buttons">
                                        <a href="{{ route('admin.pelayanan.index', ['action' => 'edit', 'id' => $row->id]) }}" title="Edit">
                                            <button class="btn-icon btn-edit"><i class="fas fa-pencil-alt"></i></button>
                                        </a>
                                        <button class="btn-icon btn-delete" title="Hapus" onclick="openDeleteModal({{ $row->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center;padding:40px;color:#94a3b8;">Belum ada data panduan.</td></tr>
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
                <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">Detail Panduan</h2>
                <a href="{{ route('admin.pelayanan.index') }}"><button class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</button></a>
            </div>
            @if(isset($detail) && $detail)
                @php $fotoSrc = !empty($detail->foto_pendukung) ? Storage::url($detail->foto_pendukung) : ''; @endphp
                <div class="detail-container">
                    @if(!empty($fotoSrc))
                        <img src="{{ $fotoSrc }}" alt="Foto" class="detail-image">
                    @else
                        <div class="detail-image" style="display:flex;align-items:center;justify-content:center;background:#f1f5f9;color:#94a3b8;">
                            <i class="fas fa-image" style="font-size:80px;opacity:0.3;"></i>
                        </div>
                    @endif
                    <h1 style="font-size:26px;font-weight:700;color:#1e293b;margin:16px 0;">{{ $detail->judul }}</h1>
                    <div class="detail-content">
                        <p><strong>Deskripsi Singkat:</strong></p>
                        <p>{{ $detail->deskripsi_singkat }}</p>
                        <p><strong>Isi Panduan:</strong></p>
                        <p>{!! nl2br(e($detail->isi_panduan)) !!}</p>
                    </div>
                    <div class="detail-actions">
                        <a href="{{ route('admin.pelayanan.index', ['action' => 'edit', 'id' => $detail->id]) }}" class="btn-detail-edit"><i class="fas fa-edit"></i> Edit</a>
                        <button class="btn-detail-delete" onclick="openDeleteModal({{ $detail->id }})"><i class="fas fa-trash-alt"></i> Hapus</button>
                    </div>
                </div>
            @endif
        </div>
    @endif

{{-- FORM TAMBAH / EDIT --}}
@if($action === 'tambah' || $action === 'edit' || $action === 'add_form')
    <div class="content-card">
        <div class="card-header">
            <div>
                <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0;">
                    {{ $page_title ?? ($action === 'tambah' ? 'Tambah Panduan' : 'Edit Panduan') }}
                </h2>
                <div class="breadcrumb" style="margin:0;">Dashboard / Pelayanan / {{ $action === 'tambah' ? 'Tambah' : 'Edit' }}</div>
            </div>
        </div>

        @php
            // ✅ LOGIKA PALING AMAN: Edit hanya jika action='edit' DAN ada ID numerik valid
            $isEditMode = ($action === 'edit') 
                && isset($detail) 
                && $detail 
                && is_numeric($detail->id) 
                && $detail->id > 0;
            
            // Tentukan URL & method berdasarkan mode
            if ($isEditMode) {
                $formAction = route('admin.pelayanan.update', $detail->id);
                $formMethod = 'PUT';
                $buttonText = 'Update Data';
            } else {
                $formAction = route('admin.pelayanan.store');
                $formMethod = 'POST';
                $buttonText = 'Simpan Data';
            }
        @endphp

        {{-- ✅ Form dengan action & method dinamis --}}
        <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" id="pelayananForm">
            @csrf
            
            {{-- Hanya tambahkan spoof method jika PUT --}}
            @if($formMethod === 'PUT')
                @method('PUT')
            @endif

            <div class="form-wrapper">
                <div class="form-grid">
                    <div class="form-section">
                        <div class="form-group">
                            <label>Judul Panduan</label>
                            <input type="text" name="judul" required value="{{ old('judul', $detail->judul ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Singkat</label>
                            <textarea name="deskripsi_singkat" required>{{ old('deskripsi_singkat', $detail->deskripsi_singkat ?? '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Isi Panduan</label>
                            <textarea name="isi_panduan" required style="min-height:200px;">{{ old('isi_panduan', $detail->isi_panduan ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="form-section">
                        <div class="form-group">
                            <label>Upload Foto Pendukung</label>
                            <div class="upload-container" id="uploadBox">
                                @php
                                    $previewSrc = '';
                                    if ($isEditMode && !empty($detail->foto_pendukung)) {
                                        $previewSrc = Storage::url($detail->foto_pendukung);
                                    }
                                @endphp
                                <img id="previewImg" class="upload-preview" src="{{ $previewSrc }}" style="{{ $previewSrc ? 'display:block;' : 'display:none;' }}" alt="Preview">
                                <div class="upload-placeholder" id="uploadPlaceholder" style="{{ $previewSrc ? 'display:none;' : 'display:flex;' }}">
                                    <i class="fas fa-cloud-upload-alt"></i><span>Klik untuk upload foto</span>
                                </div>
                                <input type="file" id="uploadFoto" name="foto_pendukung" class="upload-input" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.pelayanan.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> {{ $buttonText }}</button>
                </div>
            </div>
        </form>
    </div>
@endif
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi delete dengan SweetAlert
    function openDeleteModal(id){
        Swal.fire({
            title: 'Hapus Panduan?',
            text: 'Data yang sudah dihapus tidak dapat dikembalikan. Apakah Anda yakin ingin melanjutkan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("admin.pelayanan.index") }}?action=delete&id=' + id;
            }
        });
    }
    
    // Preview upload gambar
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('uploadFoto');
        const previewImg = document.getElementById('previewImg');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        if (!fileInput || !previewImg) return;
        fileInput.addEventListener('change', function () {
            const file = this.files[0]; if (!file) return;
            const reader = new FileReader();
            reader.onload = e => { 
                previewImg.src = e.target.result; 
                previewImg.style.display = 'block'; 
                if(uploadPlaceholder) uploadPlaceholder.style.display = 'none'; 
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection