@extends('layouts.app')

@section('content')

{{-- CSS Khusus Edit Profile --}}
<style>
    /* ===== PASTE SEMUA CSS ASLI KAMU DI SINI ===== */
    body { margin:0; padding:0; background:#ffffff; font-family:'Inter',sans-serif; }
    .container-profile-edit { max-width: 100%; margin: 0 0 40px 0; padding-bottom: 38px; }
    .sidebar-header { position: relative; padding: 20px 30px 15px 30px; display: flex; align-items: center; gap: 10px; justify-content: flex-start; margin-bottom: 0; }
    .sidebar-header img { width: 42px; height: 42px; }
    .sidebar-header .title { font-size: 20px; font-weight: 600; }
    .cover-edit { width: 100%; height: 260px; background-size: cover; background-position: center; margin: 0; border-radius: 0; position: relative; }
    .cover-btn-edit { position: absolute; bottom: 18px; right: 26px; background: rgba(0,0,0,0.55); color: #fff; border: none; display: flex; align-items: center; gap: 8px; border-radius: 20px; font-size: 13px; padding: 7px 16px; cursor: pointer; }
    .cover-btn-edit i { font-size:13px; }
    .profile-edit-head-row { display: flex; align-items: center; gap: 26px; margin-left: 60px; margin-top: -28px; }
    .avatar-box { position:relative; width:140px; height:140px; cursor:pointer; }
    .avatar-edit-img { width: 140px; height: 140px; border-radius: 50%; border: 4px solid #fff; box-shadow: 0 2px 16px rgba(0,0,0,0.15); object-fit: cover; background: #fff; }
    .avatar-edit-icon { position:absolute; right:8px; bottom:12px; width:30px;height:30px; border-radius:50%; background:#ffffff; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; font-size:13px; color:#111827; }
    .edit-main-info h2 { margin: 0 0 4px 0; font-size: 22px; font-weight: 700; }
    .edit-main-info small { color: #9ca3af; font-size: 13px; }
    .edit-nama { margin-top: 8px; font-size: 18px; font-weight: 500; color: #111827; }
    .profile-edit-form-section { margin-top: 26px; padding: 0 60px; }
    .form-section-title { font-size: 16px; font-weight: 600; color: #111827; margin-bottom: 10px; }
    .profile-edit-form-flex { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 60px; }
    .profile-edit-form-flex label { font-weight: 500; font-size: 13px; color: #374151; display: block; margin-bottom: 4px; }
    .profile-edit-form-flex input, .profile-edit-form-flex textarea, .profile-edit-form-flex select { width: 100%; border-radius: 6px; border: 1px solid #cbd5e1; background: #ffffff; font-size: 14px; padding: 8px 11px; margin-top: 1px; }
    .profile-edit-form-flex textarea { min-height: 60px; }
    .profile-edit-form-flex input:focus, .profile-edit-form-flex textarea:focus, .profile-edit-form-flex select:focus { outline:none; border-color:#fb923c; box-shadow:0 0 0 1px rgba(251,146,60,0.2); }
    .form-full { grid-column:1/3; }
    .help-text { font-size:12px; color:#9ca3af; margin-top:4px; }
    .form-btn-row { margin-top:34px; display: flex; gap:26px; grid-column:1/3; justify-content:flex-start; }
    .btn-edit-cancel { background: #fff; color: #fa9800; padding: 10px 32px; border:1.6px solid #fa9800; border-radius: 8px; font-size: 15px; font-weight: 500; cursor: pointer; text-decoration:none; display:inline-block; }
    .btn-edit-cancel:hover { background: #fff7ed; }
    .btn-edit-simpan { background: #fa9800; color: #fff; padding: 10px 36px; border:none; border-radius: 8px; font-size:15px; font-weight:600; cursor:pointer; }
    .btn-edit-simpan:hover { background: #ffa820; }
    .alert { padding:10px 60px; color:#92400e; font-size:13px; }
    .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6da; }
    .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    @media(max-width:900px) { .container-profile-edit{margin:0 0 30px 0;} .profile-edit-head-row{margin-left:24px;} .profile-edit-form-section{padding:0 24px;} }
    @media(max-width:700px) { .profile-edit-form-flex{ grid-template-columns:1fr; } .form-full{grid-column:1/2;} .profile-edit-head-row{ flex-direction:column; align-items:flex-start; margin-top:-40px; } }
</style>

<div class="container-profile-edit">

    <!-- BARIS 1: LOGO -->
    <div class="sidebar-header">
        {{-- GANTI: ../assets/ → {{ asset('assets/') }} --}}
        <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo">
        <span class="title">Desa Banjardowo</span>
    </div>

    <!-- BARIS 2: FOTO SAMPUL -->
    {{-- GANTI: PHP style → Blade --}}
    <div class="cover-edit" style="background-image: url('{{ !empty($user->cover) ? 'data:image/jpeg;base64,' . base64_encode($user->cover) : asset('assets/images/cover-default.jpg') }}');">
        
        {{-- Form upload cover (terpisah) --}}
        <form method="POST" action="{{ route('admin.profile.cover') }}" enctype="multipart/form-data" style="position:absolute;bottom:13px;right:20px;">
            @csrf
            <input type="file" name="cover" id="cover" accept=".png,.jpg,.jpeg"
                   style="display:none;" onchange="this.form.submit()"/>
            <button type="button" class="cover-btn-edit"
                    onclick="document.getElementById('cover').click();">
                <i class="fa fa-camera"></i> Edit Cover
            </button>
        </form>
    </div>

    <!-- AVATAR + TEKS -->
    <div class="profile-edit-head-row">
        <div class="avatar-box" onclick="document.getElementById('foto').click();">
            {{-- GANTI: PHP fotoSrc → Blade --}}
            <img src="{{ !empty($user->foto) ? 'data:image/jpeg;base64,' . base64_encode($user->foto) : asset('assets/images/default.png') }}" 
                 class="avatar-edit-img" id="avatarPreview" alt="Foto Profil">
            <div class="avatar-edit-icon">
                <i class="fa-solid fa-pen"></i>
            </div>
        </div>
        <div class="edit-main-info">
            <h2>Edit Profil</h2>
            <small>Profil / Edit Profil</small>
            {{-- GANTI: htmlspecialchars() → Blade auto-escape --}}
            <div class="edit-nama">{{ $user->nama_lengkap }}</div>
        </div>
    </div>

    {{-- GANTI: PHP msg → Blade session/alerts --}}
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    @if($errors->any())
        <p class="alert alert-error">{{ $errors->first() }}</p>
    @endif

    <!-- FORM -->
    <div class="profile-edit-form-section">
        <div class="form-section-title">Informasi Pribadi</div>

        {{-- GANTI: Form native → Blade form dengan @csrf, @method, route() --}}
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="profile-edit-form-flex">
            @csrf
            @method('PUT')
            
            <div>
                <label>Nama Lengkap</label>
                {{-- GANTI: value native → old() helper --}}
                <input type="text" name="nama_lengkap" required
                       value="{{ old('nama_lengkap', $user->nama_lengkap) }}">
            </div>
            <div>
                <label>Username</label>
                <input type="text" name="username" required
                       value="{{ old('username', $user->username) }}">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" required
                       value="{{ old('email', $user->email) }}">
            </div>
            <div>
                <label>No Telpon</label>
                <input type="text" name="no_telp"
                       value="{{ old('no_telp', $user->no_telp) }}">
            </div>
            <div>
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin">
                    <option value="Laki-Laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div>
                <label>Alamat</label>
                <textarea name="alamat">{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <!-- FOTO PROFIL (hidden input, trigger dari avatar) -->
            <div class="form-full">
                <input type="file" name="foto" id="foto" accept=".png,.jpg,.jpeg" style="display:none;">
            </div>

            <div class="form-btn-row">
                {{-- GANTI: href native → route() --}}
                <a href="{{ route('admin.profile') }}" class="btn-edit-cancel">Batal</a>
                <button type="submit" name="update_profile" class="btn-edit-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT (TETAP SAMA) --}}
<script>
// preview avatar ketika pilih file
const fotoInput = document.getElementById('foto');
if (fotoInput) {
    fotoInput.addEventListener('change', function(e){
        const file = e.target.files[0];
        if(!file) return;
        const reader = new FileReader();
        reader.onload = function(ev){
            const img = document.getElementById('avatarPreview');
            if (img) img.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });
}
</script>

@endsection