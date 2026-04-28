@extends('layouts.app')

@section('content')
<style>
    /* Paste CSS dari struktur.php native kamu */
</style>

<div class="app">
    {{-- SIDEBAR --}}
    <div class="sidebar">
        {{-- ... sidebar content ... --}}
    </div>

    <div class="main">
        <h1>Kelola Struktur Perangkat Desa</h1>

        {{-- FORM TAMBAH/EDIT --}}
        <div class="form">
            <h3>{{ $edit ? 'Edit' : 'Tambah' }} Struktur</h3>
            <form method="post" action="{{ route('admin.struktur.index') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $edit->id ?? '' }}">
                
                <label>Jabatan</label>
                <input type="text" name="jabatan" required value="{{ old('jabatan', $edit->jabatan ?? '') }}">
                
                <label>Nama</label>
                <input type="text" name="nama" required value="{{ old('nama', $edit->nama ?? '') }}">
                
                <button type="submit" name="save_struktur" class="btn primary">
                    {{ $edit ? 'Update' : 'Simpan' }}
                </button>
                @if($edit)
                    <a href="{{ route('admin.struktur.index') }}" class="btn">Batal</a>
                @endif
            </form>
        </div>

        {{-- TABEL DAFTAR --}}
        <div class="table">
            <h3>Daftar Struktur</h3>
            <table width="100%">
                <tr><th>Jabatan</th><th>Nama</th><th>Aksi</th></tr>
                @forelse($strukturList as $item)
                <tr>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        <a href="{{ route('admin.struktur', ['action' => 'edit_form', 'id' => $item->id]) }}">Edit</a> |
                        <a href="{{ route('admin.struktur', ['action' => 'delete', 'id' => $item->id]) }}" 
                           onclick="return confirm('Hapus?')">Hapus</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:#9ca3af;padding:20px;">Belum ada data.</td></tr>
                @endforelse
            </table>
        </div>
    </div>
</div>
@endsection