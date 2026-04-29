@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Kegiatan Desa</h2>
    <div class="row">
        @foreach($kegiatan as $item)
            <div class="col-md-4">
                <div class="card kegiatan-card" style="margin-bottom:20px;">
                    <img src="{{ asset('storage/'.$item->foto) }}" class="card-img-top" alt="{{ $item->judul }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->judul }}</h5>
                        <p class="card-text">{{ $item->deskripsi }}</p>
                        <small class="text-muted">Tanggal: {{ $item->tanggal }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
