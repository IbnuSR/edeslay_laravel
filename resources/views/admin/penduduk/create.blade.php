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
    
    /* ===== FORM SECTIONS ===== */
    .form-section {
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 2px solid #e3f2fd;
    }
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }
    .form-group label .required {
        color: #ef4444;
    }
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    .form-control:focus {
        outline: none;
        border-color: #2f80ed;
        box-shadow: 0 0 0 3px rgba(47, 128, 237, 0.1);
    }
    .form-control.error {
        border-color: #ef4444;
    }
    select.form-control {
        cursor: pointer;
        appearance: none;
        background-image: url("image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
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
    
    /* ===== ALERT ===== */
    .alert { 
        margin-bottom: 20px; padding: 14px 20px; border-radius: 12px; 
        font-size: 14px; font-weight: 500;
    }
    .alert-success { background: #dcfce7; color: #166534; border: 2px solid #86efac; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 2px solid #fca5a5; }
    
    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 1024px) {
        .main-container { padding: 15px 20px; }
        .top-bar { flex-direction: column; align-items: stretch; padding: 15px 20px; }
        .search-wrapper { flex-direction: column; width: 100%; }
        .profile-wrapper { justify-content: center; width: 100%; }
    }
    
    @media (max-width: 768px) {
        .main-container { padding: 10px 15px; }
        .content-card { padding: 20px 15px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
        .card-header { flex-direction: column; align-items: stretch; }
    }
</style>

<div class="main-container">
    {{-- TOP BAR --}}
    <div class="top-bar">
        <div class="page-header">
            <h1>Tambah Data Penduduk</h1>
            <div class="breadcrumb">Dashboard / Data Penduduk / Tambah</div>
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

    {{-- ALERT ERRORS --}}
    @if($errors->any())
        <div class="alert alert-error">
            <strong>⚠️ Terjadi kesalahan:</strong>
            <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CONTENT CARD --}}
    <div class="content-card">
        <div class="card-header">
            <h2>Form Tambah Penduduk</h2>
        </div>

        <form method="POST" action="{{ route('admin.penduduk.store') }}">
            @csrf

            {{-- IDENTITAS DIRI --}}
            <div class="form-section">
                <h3 class="section-title">👤 Identitas Diri</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>NIK <span class="required">*</span></label>
                        <input type="text" name="nik" maxlength="16" pattern="\d{16}" 
                               class="form-control @error('nik') error @enderror" 
                               placeholder="16 digit angka" value="{{ old('nik') }}" required>
                        @error('nik')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                        <small style="color: #94a3b8; font-size: 11px;">Masukkan 16 digit NIK tanpa spasi</small>
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="nama" 
                               class="form-control @error('nama') error @enderror" 
                               placeholder="Nama lengkap sesuai KTP" value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin <span class="required">*</span></label>
                        <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') error @enderror" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir <span class="required">*</span></label>
                        <input type="date" name="tanggal_lahir" 
                               class="form-control @error('tanggal_lahir') error @enderror" 
                               value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- STATUS KELUARGA --}}
            <div class="form-section">
                <h3 class="section-title">🏠 Status Keluarga</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Status dalam Keluarga <span class="required">*</span></label>
                        <select name="status_keluarga" class="form-control @error('status_keluarga') error @enderror" required>
                            <option value="">Pilih Status</option>
                            <option value="Kepala Keluarga" {{ old('status_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="Anggota" {{ old('status_keluarga') == 'Anggota' ? 'selected' : '' }}>Anggota Keluarga</option>
                        </select>
                        @error('status_keluarga')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                        <small style="color: #94a3b8; font-size: 11px;">Digunakan untuk menghitung jumlah Kepala Keluarga di infografis</small>
                    </div>
                </div>
            </div>

            {{-- DATA DEMOGRAFI --}}
            <div class="form-section">
                <h3 class="section-title">📊 Data Demografi</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Pendidikan Terakhir <span class="required">*</span></label>
                        <select name="pendidikan" class="form-control @error('pendidikan') error @enderror" required>
                            <option value="">Pilih Pendidikan</option>
                            <option value="Tidak Sekolah" {{ old('pendidikan') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                            <option value="Belum Tamat SD" {{ old('pendidikan') == 'Belum Tamat SD' ? 'selected' : '' }}>Belum Tamat SD</option>
                            <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>Tamat SD/Sederajat</option>
                            <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SLTP/Sederajat</option>
                            <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SLTA/Sederajat</option>
                            <option value="D1" {{ old('pendidikan') == 'D1' ? 'selected' : '' }}>Diploma I/II</option>
                            <option value="D2" {{ old('pendidikan') == 'D2' ? 'selected' : '' }}>Diploma I/II</option>
                            <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>Diploma III</option>
                            <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>Strata I</option>
                            <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>Strata II</option>
                            <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>Strata III</option>
                        </select>
                        @error('pendidikan')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Pekerjaan <span class="required">*</span></label>
                        <select name="pekerjaan" class="form-control @error('pekerjaan') error @enderror" required>
                            <option value="">Pilih Pekerjaan</option>
                            <option value="Belum Bekerja" {{ old('pekerjaan') == 'Belum Bekerja' ? 'selected' : '' }}>Belum/Tidak Bekerja</option>
                            <option value="Pelajar/Mahasiswa" {{ old('pekerjaan') == 'Pelajar/Mahasiswa' ? 'selected' : '' }}>Pelajar/Mahasiswa</option>
                            <option value="Pegawai Negeri" {{ old('pekerjaan') == 'Pegawai Negeri' ? 'selected' : '' }}>Pegawai Negeri</option>
                            <option value="Karyawan Swasta" {{ old('pekerjaan') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                            <option value="Petani/Pekebun" {{ old('pekerjaan') == 'Petani/Pekebun' ? 'selected' : '' }}>Petani/Pekebun</option>
                            <option value="Pedagang" {{ old('pekerjaan') == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                            <option value="Lainnya" {{ old('pekerjaan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('pekerjaan')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status Perkawinan <span class="required">*</span></label>
                        <select name="status_perkawinan" class="form-control @error('status_perkawinan') error @enderror" required onchange="toggleKawinTercatat(this.value)">
                            <option value="">Pilih Status</option>
                            <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                        @error('status_perkawinan')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kawin Tercatat - Hidden by default --}}
                    <div class="form-group" id="kawinTercatatGroup" style="display: {{ old('status_perkawinan') == 'Kawin' ? 'block' : 'none' }};">
                        <label>Kawin Tercatat</label>
                        <select name="kawin_tercatat" class="form-control @error('kawin_tercatat') error @enderror">
                            <option value="">Pilih</option>
                            <option value="Ya" {{ old('kawin_tercatat') == 'Ya' ? 'selected' : '' }}>Kawin Tercatat</option>
                            <option value="Tidak" {{ old('kawin_tercatat') == 'Tidak' ? 'selected' : '' }}>Kawin Tidak Tercatat</option>
                        </select>
                        @error('kawin_tercatat')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                        <small style="color: #94a3b8; font-size: 11px;">Digunakan untuk infografis perkawinan</small>
                    </div>
                </div>
            </div>

            {{-- ALAMAT --}}
            <div class="form-section">
                <h3 class="section-title">📍 Alamat</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Dusun</label>
                        <input type="text" name="dusun" 
                               class="form-control @error('dusun') error @enderror" 
                               placeholder="Nama dusun" value="{{ old('dusun') }}">
                        @error('dusun')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- BUTTONS --}}
            <div class="form-actions">
                <a href="{{ route('admin.penduduk.index') }}" class="btn btn-secondary">
                    ← Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    💾 Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle field "Kawin Tercatat" hanya muncul jika status perkawinan = Kawin
function toggleKawinTercatat(value) {
    const group = document.getElementById('kawinTercatatGroup');
    const select = group.querySelector('select');
    
    if (value === 'Kawin') {
        group.style.display = 'block';
    } else {
        group.style.display = 'none';
        select.value = '';
    }
}

// Jalankan saat page load untuk handle old input
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.querySelector('[name="status_perkawinan"]');
    if (statusSelect) {
        toggleKawinTercatat(statusSelect.value);
    }
});
</script>

@endsection