@extends('layouts.app')
a
@section('content')
<style>
    .main-container { padding: 2rem; }
    .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-header h1 { font-size: 24px; color: #1e293b; margin: 0; }
    .breadcrumb { font-size: 14px; color: #64748b; }
    .btn { padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-block; }
    .btn-primary { background: linear-gradient(135deg, #2b6cb0, #2f80ed); color: white; }
    .btn-warning { background: #f59e0b; color: white; }
    .btn-danger { background: #ef4444; color: white; }
    .btn-sm { padding: 6px 12px; font-size: 13px; }
    .content-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 1rem; }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
    .table th { background: #f8fafc; font-weight: 600; color: #475569; }
    .table img { border-radius: 8px; }
    .text-center { text-align: center; }
    .action-buttons { display: flex; gap: 8px; }
</style>

<div class="main-container">
    <div class="top-bar">
        <div class="page-header">
            <h1>Struktur Perangkat Desa</h1>
            <div class="breadcrumb">Dashboard / Struktur</div>
        </div>
        <a href="{{ route('admin.struktur.create') }}" class="btn btn-primary">+ Tambah Data</a>
    </div>

    <div class="content-card">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
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
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <img src="{{ $item->foto ? asset('storage/'.$item->foto) : asset('assets/images/default-avatar.png') }}" 
                             style="width:50px; height:50px; object-fit:cover;">
                    </td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->nip ?? '-' }}</td>
                    <td>{{ $item->urutan }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.struktur.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('admin.struktur.delete', $item->id) }}" class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data perangkat desa</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    </div>
@endsection