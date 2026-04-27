@extends('layouts.app')

@section('content')
{{-- CSS sama seperti kode native kamu, paste di sini --}}
<style>
    /* Paste semua CSS dari profile.php native kamu */
</style>

<div class="app">
    {{-- SIDEBAR (sama seperti halaman admin lain) --}}
    <div class="sidebar">
        {{-- ... sidebar content ... --}}
    </div>

    <div class="main">
        <!-- Header Cover User -->
        <div class="profile-header" style="background-image: url('{{ $coverSrc }}');" onclick="openCoverModal()"></div>

        <!-- MODAL COVER FULL -->
        <div id="coverModal" class="cover-modal" onclick="closeCoverModal()">
            <span class="cover-modal-close" onclick="closeCoverModal(event)">&times;</span>
            <img src="{{ $coverSrc }}" class="cover-modal-content" alt="Foto Sampul">
        </div>

        <!-- MODAL FOTO PROFIL FULL -->
        <div id="fotoModal" class="cover-modal" onclick="closeFotoModal()">
            <span class="cover-modal-close" onclick="closeFotoModal(event)">&times;</span>
            <img src="{{ $fotoProfilSrc }}" class="cover-modal-content" alt="Foto Profil">
        </div>

        <div class="profile-box">
            <img class="profile-photo" src="{{ $fotoProfilSrc }}" alt="Foto Profil" onclick="openFotoModal()" style="cursor:pointer;">
            <h2>{{ $namaAdmin }}</h2>
            <button class="btn-edit-profile" onclick="window.location.href='{{ route('admin.profile.edit') }}'">Edit Profil</button>
        </div>

        <div class="info-grid">
            <div class="info-item item-1">
                <img src="{{ asset('assets/icons/icon_user.png') }}" width="28" />
                <span>{{ $username }}</span>
            </div>
            <div class="info-item item-2">
                <img src="{{ asset('assets/icons/gmail.png') }}" width="28" />
                <span>{{ $email }}</span>
            </div>
            <div class="info-item item-3">
                <img src="{{ asset('assets/icons/jenis_kelamin.png') }}" width="28" />
                <span>{{ $jenis_kelamin }}</span>
            </div>
            <div class="info-item item-4">
                <img src="{{ asset('assets/icons/telpon.png') }}" width="28" />
                <span>{{ $no_telp }}</span>
            </div>
            <div class="info-item item-5">
                <img src="{{ asset('assets/icons/google-maps.png') }}" width="28" />
                <span>{{ $alamat }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Scripts sama seperti native --}}
<script>
// ... paste JS modal & SweetAlert dari native ...
</script>
@endsection