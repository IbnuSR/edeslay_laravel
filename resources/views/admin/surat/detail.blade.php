@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.surat.index', ['jenis' => $jenis]) }}" class="text-decoration-none">
                    Pengajuan {{ ucfirst($jenis) }}
                </a>
            </li>
            <li class="breadcrumb-item active">Detail #{{ $surat->id }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-alt me-2"></i>Detail Pengajuan {{ ucfirst($jenis) }}
        </h2>
        <a href="{{ route('admin.surat.index', ['jenis' => $jenis]) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- KOLOM KIRI: DATA PEMOHON (READ ONLY) -->
        <div class="col-lg-8">
            <!-- Informasi Pemohon -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user me-2"></i>Informasi Pemohon
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">Nama Lengkap</label>
                            <span class="fw-bold">{{ $surat->nama_lengkap ?? $surat->nama_pelapor ?? '-' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">NIK</label>
                            <span>{{ $surat->nik ?? $surat->nik_pelapor ?? '-' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">No. Telepon</label>
                            <span>{{ $surat->no_hp ?? '-' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">Tanggal Pengajuan</label>
                            <span>{{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->format('d F Y') }}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small d-block">Alamat</label>
                            <span>{{ $surat->alamat ?? '-' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">Metode Pengambilan</label>
                            @if($surat->metode_pengambilan == 'cetak_online')
                                <span class="badge bg-info"><i class="fas fa-download me-1"></i>Cetak/Unduh Online</span>
                            @else
                                <span class="badge bg-purple"><i class="fas fa-store me-1"></i>Ambil di Kantor Desa</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">Status</label>
                            @if($surat->status == 'proses' && empty($surat->nomor_surat))
                                <span class="badge bg-warning text-dark"><i class="fas fa-spinner fa-spin me-1"></i>Menunggu</span>
                            @elseif($surat->status == 'proses')
                                <span class="badge bg-info"><i class="fas fa-cog fa-spin me-1"></i>Sedang Dikerjakan</span>
                            @elseif($surat->status == 'selesai')
                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Selesai</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Ditolak</span>
                            @endif
                        </div>
                    </div>

                    <!-- Dokumen Scan -->
                    @if($surat->dokumen_scan)
                    <hr>
                    <h6 class="mb-3"><i class="fas fa-paperclip me-2"></i>Dokumen Terlampir</h6>
                    @php $docs = is_string($surat->dokumen_scan) ? json_decode($surat->dokumen_scan, true) : $surat->dokumen_scan; @endphp
                    @if(is_array($docs) && count($docs) > 0)
                        <div class="row">
                            @foreach($docs as $doc)
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 text-center bg-light">
                                    <i class="fas fa-file-image fa-2x text-secondary mb-2"></i>
                                    <p class="small mb-2 text-truncate">{{ basename($doc) }}</p>
                                    <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                    @endif
                </div>
            </div>

            <!-- Data Khusus Surat -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-2"></i>Data Tambahan
                    </h6>
                </div>
                <div class="card-body">
                    @if($jenis == 'domisili')
                        <div class="row">
                            <div class="col-md-6"><label class="text-muted small">Tempat Tinggal</label><p>{{ $surat->tempat_tinggal ?? '-' }}</p></div>
                            <div class="col-md-6"><label class="text-muted small">Keperluan</label><p>{{ $surat->keperluan ?? '-' }}</p></div>
                        </div>
                    @elseif($jenis == 'sktm')
                        <div class="row">
                            <div class="col-md-4"><label class="text-muted small">Tanggungan</label><p>{{ $surat->jumlah_tanggungan ?? '-' }} orang</p></div>
                            <div class="col-md-4"><label class="text-muted small">Status Ekonomi</label><p>{{ $surat->status_ekonomi ?? '-' }}</p></div>
                            <div class="col-md-4"><label class="text-muted small">Tujuan</label><p>{{ $surat->tujuan_skmt ?? '-' }}</p></div>
                        </div>
                    @elseif($jenis == 'kelahiran')
                        <div class="row">
                            <div class="col-md-6"><label class="text-muted small">Nama Bayi</label><p>{{ $surat->nama_bayi ?? '-' }}</p></div>
                            <div class="col-md-6"><label class="text-muted small">TTL Bayi</label><p>{{ $surat->tempat_lahir_bayi ?? '-' }}, {{ $surat->tanggal_lahir_bayi }}</p></div>
                            <div class="col-md-6"><label class="text-muted small">Nama Ayah</label><p>{{ $surat->nama_ayah ?? '-' }}</p></div>
                            <div class="col-md-6"><label class="text-muted small">Nama Ibu</label><p>{{ $surat->nama_ibu ?? '-' }}</p></div>
                        </div>
                    @elseif($jenis == 'ktp')
                        <div class="row">
                            <div class="col-md-6"><label class="text-muted small">Jenis Permohonan</label><p>{{ $surat->jenis_permohonan ?? '-' }}</p></div>
                            <div class="col-md-6"><label class="text-muted small">Alasan</label><p>{{ $surat->alasan_permohonan ?? '-' }}</p></div>
                        </div>
                    @elseif($jenis == 'kematian')
                        <div class="row">
                            <div class="col-md-6"><label class="text-muted small">Nama Almarhum</label><p>{{ $surat->nama_almarhum ?? '-' }}</p></div>
                            <div class="col-md-6"><label class="text-muted small">Tanggal Kematian</label><p>{{ $surat->tanggal_kematian }}</p></div>
                            <div class="col-md-6"><label class="text-muted small">Sebab Kematian</label><p>{{ $surat->sebab_kematian ?? '-' }}</p></div>
                            <div class="col-md-6"><label class="text-muted small">Hubungan Pelapor</label><p>{{ $surat->hubungan_pelapor ?? '-' }}</p></div>
                        </div>
                    @else
                        <p class="text-muted small">Data khusus tidak tersedia.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: PANEL WORKFLOW (2 TAHAP) -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-4">
                    
                    <!-- TAHAP 1: MENUNGGU / SEDANG DIKERJAKAN -->
                    <div id="stageWaiting">
                        @if($surat->status == 'proses' && empty($surat->nomor_surat))
                            <!-- Status: Baru Masuk -->
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2 mb-3 d-inline-block">
                                🟡 Menunggu Diproses
                            </span>
                            <p class="text-muted small mb-4">Pengajuan baru masuk. Klik di bawah untuk mulai mengerjakan surat ini.</p>
                            <form action="{{ route('admin.surat.update', ['jenis' => $jenis, 'id' => $surat->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="proses">
                                <input type="hidden" name="action" value="start">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    🔨 Mulai Dikerjakan
                                </button>
                            </form>

                        @elseif($surat->status == 'proses')
                            <!-- Status: Sedang Dikerjakan -->
                            <span class="badge bg-info text-white fs-6 px-3 py-2 mb-3 d-inline-block">
                                🔵 Sedang Dikerjakan
                            </span>
                            <p class="text-muted small mb-4">Surat sedang dalam tahap pengerjaan oleh admin.</p>
                            <button type="button" class="btn btn-outline-primary btn-lg w-100" onclick="showFinalizeForm()">
                                ✅ Finalisasi Surat
                            </button>
                        @endif
                    </div>

                    <!-- TAHAP 2: FORM FINALISASI (MUNCUL SETELAH KLIK) -->
                    <div id="stageFinalize" style="display: none;">
                        <span class="badge bg-success fs-6 px-3 py-2 mb-3 d-inline-block">
                            📝 Finalisasi Surat
                        </span>
                        <form action="{{ route('admin.surat.update', ['jenis' => $jenis, 'id' => $surat->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="status" value="selesai">
                            
                            <div class="text-start mb-3">
                                <label class="form-label fw-bold">Nomor Surat:</label>
                                <input type="text" name="nomor_surat" class="form-control" placeholder="403/DS/TK/001/2026" required>
                            </div>

                            @if($surat->metode_pengambilan == 'cetak_online')
                                <div class="text-start mb-3">
                                    <label class="form-label text-danger fw-bold">📤 Upload Surat Jadi (PDF):</label>
                                    <input type="file" name="file_surat" accept=".pdf" class="form-control" required>
                                    <small class="text-muted d-block mt-1">File ini akan otomatis muncul di HP masyarakat.</small>
                                    @if($surat->file_surat_jadi)
                                        <span class="text-success small"><i class="fas fa-check"></i> File sudah ada: {{ basename($surat->file_surat_jadi) }}</span>
                                    @endif
                                </div>
                            @else
                                <div class="text-start mb-3">
                                    <label class="form-label text-primary fw-bold">📝 Keterangan Pengambilan:</label>
                                    <textarea name="keterangan_admin" rows="3" class="form-control" placeholder="Contoh: Surat siap diambil jam 08.00-14.00 di Loket Pelayanan." required>{{ $surat->keterangan_admin ?? '' }}</textarea>
                                    <small class="text-muted d-block mt-1">Info ini akan ditampilkan ke pemohon di mobile.</small>
                                </div>
                            @endif

                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-success btn-lg">
                                    💾 Simpan & Tandai Selesai
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="hideFinalizeForm()">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- JIKA SUDAH SELESAI -->
                    @if($surat->status == 'selesai')
                        <div class="mt-3">
                            <span class="badge bg-success fs-6 px-3 py-2">✅ Selesai</span>
                            @if($surat->nomor_surat) <p class="mt-2 mb-0 small text-muted">No: {{ $surat->nomor_surat }}</p> @endif
                            @if($surat->file_surat_jadi) <p class="mt-1 small text-success"><i class="fas fa-check"></i> PDF Terupload</p> @endif
                            @if($surat->keterangan_admin) <p class="mt-1 small text-primary"><i class="fas fa-info-circle"></i> {{ $surat->keterangan_admin }}</p> @endif
                        </div>
                    @endif

                    <!-- JIKA DITOLAK -->
                    @if($surat->status == 'ditolak')
                        <div class="mt-3">
                            <span class="badge bg-danger fs-6 px-3 py-2">❌ Ditolak</span>
                            <p class="mt-2 small text-muted">{{ $surat->alasan_tolak ?? 'Tidak ada alasan' }}</p>
                            <form action="{{ route('admin.surat.update', ['jenis' => $jenis, 'id' => $surat->id]) }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="status" value="proses">
                                <button type="submit" class="btn btn-outline-warning btn-sm">🔄 Buka Kembali</button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>

            <!-- Timeline Singkat -->
            <div class="card shadow-sm mt-3">
                <div class="card-body py-3">
                    <h6 class="small text-muted mb-2"><i class="fas fa-history me-1"></i>Riwayat</h6>
                    <div class="small">
                        <p class="mb-1"><i class="fas fa-circle text-primary me-1" style="font-size:8px;"></i> Diterima: {{ \Carbon\Carbon::parse($surat->created_at)->format('d/m H:i') }}</p>
                        @if($surat->updated_at != $surat->created_at)
                            <p class="mb-0"><i class="fas fa-circle text-success me-1" style="font-size:8px;"></i> Update: {{ \Carbon\Carbon::parse($surat->updated_at)->format('d/m H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.bg-purple { background-color: #6f42c1 !important; }
.card { border: none; border-radius: 0.5rem; }
</style>

<script>
function showFinalizeForm() {
    document.getElementById('stageWaiting').style.display = 'none';
    document.getElementById('stageFinalize').style.display = 'block';
}
function hideFinalizeForm() {
    document.getElementById('stageWaiting').style.display = 'block';
    document.getElementById('stageFinalize').style.display = 'none';
}
</script>
@endsection