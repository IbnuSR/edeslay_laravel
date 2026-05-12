@extends('layouts.app')

@section('content')
<style>
    .main-container { padding: 2rem; }
    .content-card { background: white; border-radius: 12px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 600px; }
    .content-card h2 { margin-bottom: 1.5rem; color: #1e293b; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #475569; }
    .form-control { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; }
    .form-control:focus { outline: none; border-color: #2b6cb0; }
    .btn { padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; font-weight: 500; margin-right: 8px; }
    .btn-primary { background: linear-gradient(135deg, #2b6cb0, #2f80ed); color: white; }
    .btn-secondary { background: #64748b; color: white; }
</style>

<div class="main-container">
    <div class="content-card">
        <h2>Edit Perangkat Desa</h2>
        
        <form action="{{ route('admin.struktur.update', $struktur->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Urutan Tampilan</label>
                <input type="number" name="urutan" value="{{ old('urutan', $struktur->urutan) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $struktur->nama) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $struktur->jabatan) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label>NIP (Opsional)</label>
                <input type="text" name="nip" value="{{ old('nip', $struktur->nip) }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
                @if($struktur->foto)
                    <img src="{{ asset('storage/'.$struktur->foto) }}" style="width:100px; margin-top:10px; border-radius:8px;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.struktur.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection