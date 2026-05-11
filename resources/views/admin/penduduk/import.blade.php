@extends('layouts.app')

@section('content')

<style>
    /* ===== RESET & MAIN CONTAINER ===== */
    a { text-decoration: none !important; color: inherit; }
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
    .card-header h2 { margin: 0; font-size: 20px; font-weight: 700; color: #1e293b; }
    
    /* ===== IMPORT BOX ===== */
    .import-box {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 40px;
        text-align: center;
        background: #f8fafc;
        transition: all 0.3s;
        margin-bottom: 24px;
    }
    .import-box:hover, .import-box.dragover {
        border-color: #2f80ed;
        background: #eff6ff;
    }
    .import-icon {
        font-size: 48px;
        color: #2f80ed;
        margin-bottom: 16px;
    }
    .import-title {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
    }
    .import-desc {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 20px;
    }
    .import-form input[type="file"] {
        display: none;
    }
    .btn-upload {
        background: linear-gradient(135deg, #2b6cb0, #2f80ed);
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 128, 237, 0.4);
    }
    
    /* ===== TEMPLATE BOX ===== */
    .template-box {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
    }
    .template-title {
        font-weight: 600;
        color: #0369a1;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .template-list {
        margin: 0;
        padding-left: 20px;
        color: #64748b;
        font-size: 14px;
    }
    .template-list li { margin-bottom: 4px; }
    .btn-template {
        background: #0ea5e9;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        transition: all 0.2s;
    }
    .btn-template:hover {
        background: #0284c7;
    }
    
    /* ===== ALERT ===== */
    .alert { 
        margin-bottom: 20px; padding: 14px 20px; border-radius: 12px; 
        font-size: 14px; font-weight: 500;
    }
    .alert-success { background: #dcfce7; color: #166534; border: 2px solid #86efac; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 2px solid #fca5a5; }
    .alert-warning { background: #fef3c7; color: #92400e; border: 2px solid #fcd34d; }
    
    /* ===== ERROR LIST ===== */
    .error-list {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 12px;
        padding: 16px 20px;
        margin-top: 16px;
        max-height: 200px;
        overflow-y: auto;
    }
    .error-list ul {
        margin: 0;
        padding-left: 20px;
        color: #991b1b;
        font-size: 13px;
    }
    .error-list li { margin-bottom: 4px; }
    
    /* ===== BUTTONS ===== */
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        padding-top: 24px;
        border-top: 2px solid #e2e8f0;
        flex-wrap: wrap;
    }
    .btn {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #2b6cb0, #2f80ed);
        color: white;
        box-shadow: 0 4px 12px rgba(47, 128, 237, 0.3);
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(47, 128, 237, 0.4);
    }
    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
    }
    .btn-secondary:hover {
        background: #e2e8f0;
    }
    
    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .main-container { padding: 15px 20px; }
        .top-bar { flex-direction: column; align-items: stretch; padding: 15px 20px; }
        .search-wrapper { flex-direction: column; width: 100%; }
        .profile-wrapper { justify-content: center; width: 100%; }
    }
    @media (max-width: 768px) {
        .main-container { padding: 10px 15px; }
        .content-card { padding: 20px 15px; }
        .form-actions { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
        .card-header { flex-direction: column; align-items: stretch; }
    }
</style>

<div class="main-container">
    {{-- TOP BAR --}}
    <div class="top-bar">
        <div class="page-header">
            <h1>Import Data Penduduk</h1>
            <div class="breadcrumb">Dashboard / Data Penduduk / Import</div>
        </div>
        
        <div class="search-wrapper">
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

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">⚠️ {{ session('error') }}</div>
    @endif
    @if(session('import_errors'))
        <div class="alert alert-warning">
            <strong>⚠️ Terjadi kesalahan pada beberapa baris:</strong>
            <div class="error-list">
                <ul>
                    @foreach(session('import_errors') as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- CONTENT CARD --}}
    <div class="content-card">
        <div class="card-header">
            <h2>Upload File Excel/CSV</h2>
            <a href="{{ route('admin.penduduk.index') }}" class="btn btn-secondary">
                ← Kembali
            </a>
        </div>

        {{-- TEMPLATE BOX --}}
        <div class="template-box">
            <div class="template-title">📋 Format Kolom yang Diperlukan:</div>
            <ul class="template-list">
                <li><strong>nik</strong> - 16 digit angka, unik <em>(wajib)</em></li>
                <li><strong>nama_lengkap</strong> - Nama sesuai KTP <em>(wajib)</em></li>
                <li><strong>jenis_kelamin</strong> - L atau P <em>(wajib)</em></li>
                <li><strong>tanggal_lahir</strong> - Format: YYYY-MM-DD <em>(wajib)</em></li>
                <li><strong>pendidikan</strong> - SD, SMP, SMA, S1, dll <em>(wajib)</em></li>
                <li><strong>pekerjaan</strong> - Pekerjaan saat ini <em>(opsional)</em></li>
                <li><strong>status_perkawinan</strong> - Belum Kawin/Kawin/Cerai Hidup/Cerai Mati <em>(wajib)</em></li>
                <li><strong>kawin_tercatat</strong> - Ya atau Tidak <em>(opsional)</em></li>
                <li><strong>dusun</strong> - Nama dusun <em>(opsional)</em></li>
                <li><strong>status_keluarga</strong> - Kepala Keluarga atau Anggota <em>(opsional, default: Anggota)</em></li>
            </ul>
            <a href="{{ route('admin.penduduk.template') }}" class="btn-template">
                📥 Download Template Excel
            </a>
        </div>

        {{-- IMPORT BOX --}}
        <form method="POST" action="{{ route('admin.penduduk.import.process') }}" 
              enctype="multipart/form-data" class="import-form" id="importForm">
            @csrf
            
            <div class="import-box" id="dropZone">
                <div class="import-icon">📁</div>
                <div class="import-title">Drag & Drop File Excel/CSV</div>
                <div class="import-desc">atau klik tombol di bawah untuk memilih file</div>
                
                <input type="file" name="file" id="fileInput" accept=".xlsx,.xls,.csv" required>
                <label for="fileInput" class="btn-upload">
                    📂 Pilih File
                </label>
                
                <div id="fileName" style="margin-top: 12px; color: #64748b; font-size: 14px;"></div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.penduduk.index') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    🚀 Import Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Show selected file name
    document.getElementById('fileInput').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        document.getElementById('fileName').textContent = fileName ? '📄 ' + fileName : '';
    });

    // Drag & drop functionality
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dropZone.classList.add('dragover');
    }

    function unhighlight() {
        dropZone.classList.remove('dragover');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files[0]) {
            fileInput.files = files;
            document.getElementById('fileName').textContent = '📄 ' + files[0].name;
        }
    }

    // Confirm before submit
    document.getElementById('importForm').addEventListener('submit', function(e) {
        if (!fileInput.files[0]) {
            e.preventDefault();
            alert('Silakan pilih file terlebih dahulu!');
            return;
        }
        
        if (!confirm('Apakah Anda yakin ingin mengimport data dari file ini? Pastikan format file sudah sesuai template.')) {
            e.preventDefault();
        }
    });
</script>

@endsection