@extends('layouts.app')

@section('content')
<style>
    .main-container { padding: 2rem; display: flex; justify-content: center; align-items: center; min-height: 60vh; }
    .content-card { background: white; border-radius: 12px; padding: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 500px; text-align: center; }
    .content-card h2 { margin-bottom: 1rem; color: #1e293b; }
    .content-card p { margin-bottom: 2rem; color: #64748b; }
    .btn { padding: 10px 24px; border-radius: 8px; border: none; cursor: pointer; font-weight: 500; margin: 0 8px; }
    .btn-danger { background: #ef4444; color: white; }
    .btn-secondary { background: #64748b; color: white; }
</style>

<div class="main-container">
    <div class="content-card">
        <h2>Hapus Data?</h2>
        <p>Apakah Anda yakin ingin menghapus <strong>{{ $struktur->nama }}</strong>?</p>
        
        <form action="{{ route('admin.struktur.destroy', $struktur->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            <a href="{{ route('admin.struktur.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection