@extends('layouts.app')

@section('content')

<style>
.container-form {
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    font-family: 'Poppins', sans-serif;
}

h2 {
    margin-bottom: 20px;
    font-size: 22px;
    font-weight: 600;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-size: 13px;
    font-weight: 500;
    display: block;
    margin-bottom: 6px;
}

input, textarea {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
    outline: none;
    font-size: 13px;
}

textarea {
    min-height: 120px;
    resize: vertical;
}

.btn {
    background: #1c3f9f;
    color: #fff;
    padding: 10px 18px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
}

.btn:hover {
    background: #3B82F6;
}
</style>

<div class="container-form">

    <h2>Tambah Kegiatan Desa</h2>

    <form action="{{ route('admin.kegiatan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Judul Kegiatan</label>
            <input type="text" name="judul" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" required></textarea>
        </div>

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" required>
        </div>

        <div class="form-group">
            <label>Foto</label>
            <input type="file" name="foto" accept="image/*">
        </div>

        <button type="submit" class="btn">Simpan Data</button>

    </form>

</div>

@endsection