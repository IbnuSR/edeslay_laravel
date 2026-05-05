@extends('layouts.app')

@section('content')

<style>
    .edit-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    .edit-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
    }
    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
    }
    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .btn-save {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        margin-right: 10px;
    }
    .btn-cancel {
        background: #e5e7eb;
        color: #374151;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .upload-preview {
        margin-top: 10px;
    }
    .upload-preview img {
        max-width: 200px;
        border-radius: 8px;
        margin-top: 10px;
    }
</style>

<div class="edit-container">
    <div class="edit-card">
        <h2 style="margin-bottom: 24px; color: #1f2937;">
            <i class="fas fa-user-edit" style="margin-right: 8px;"></i>
            Edit Profil Admin
        </h2>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" 
                       value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telepon" class="form-control" 
                       value="{{ old('no_telepon', $user->no_telepon ?? '') }}" placeholder="08xx-xxxx-xxxx">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" 
                          placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label>Foto Profil</label>
                <input type="file" name="foto" class="form-control" accept="image/*" 
                       onchange="previewImage(this, 'previewFoto')">
                @if($user->foto)
                    <div class="upload-preview" id="previewFoto">
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil">
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label>Foto Sampul/Cover</label>
                <input type="file" name="foto_sampul" class="form-control" accept="image/*"
                       onchange="previewImage(this, 'previewSampul')">
                @if($user->foto_sampul)
                    <div class="upload-preview" id="previewSampul">
                        <img src="{{ asset('storage/' . $user->foto_sampul) }}" alt="Foto Sampul">
                    </div>
                @endif
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.profile') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="max-width: 200px; border-radius: 8px; margin-top: 10px;">';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
