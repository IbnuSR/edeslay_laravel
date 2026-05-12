@extends('layouts.app')

@section('content')
<style>
    .main-container { padding: 2rem; }
    .content-card { background: white; border-radius: 12px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 600px; }
    .content-card h2 { margin-bottom: 1.5rem; color: #1e293b; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #475569; }
    .form-control { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; }
    .form-control:focus { outline: none; border-color: #2b6cb0; box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.1); }
    .btn { padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; font-weight: 500; margin-right: 8px; }
    .btn-primary { background: linear-gradient(135deg, #2b6cb0, #2f80ed); color: white; }
    .btn-secondary { background: #64748b; color: white; }
</style>

<div class="main-container">
    <div class="content-card">
        <h2>Tambah Perangkat Desa</h2>
        
        <form action="{{ route('admin.struktur.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Urutan Tampilan</label>
                <input type="number" name="urutan" value="{{ old('urutan', 0) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required class="form-control">
            </div>

            <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}" required class="form-control">
            </div>

            <div class="form-group">
                <label>NIP (Opsional)</label>
                <input type="text" name="nip" value="{{ old('nip') }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.struktur.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection