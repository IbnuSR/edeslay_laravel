<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengajuan Surat {{ ucfirst($jenis) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        .header { 
            text-align: center; 
            margin-bottom: 25px;
            padding-bottom: 12px;
            border-bottom: 3px double #000;
        }
        .header h1 { font-size: 16pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; }
        .header h2 { font-size: 12pt; font-weight: normal; margin-bottom: 12px; }
        .header .report-title { font-size: 13pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; margin-bottom: 4px; }
        .header .period { font-size: 11pt; margin-bottom: 0; }
        
        .info { margin: 20px 0; padding: 10px 15px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; }
        .info-row { display: flex; justify-content: space-around; flex-wrap: wrap; gap: 10px; }
        .info-row span { font-weight: bold; }
        
        table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 10pt; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; font-weight: bold; text-align: center; }
        .text-center { text-align: center !important; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 8pt; font-weight: bold; border: 1px solid #000; }
        .badge-proses { background: #fff3cd; }
        .badge-selesai { background: #d4edda; }
        .badge-ditolak { background: #f8d7da; }
        .badge-online { background: #d1ecf1; }
        .badge-desa { background: #e2d9f3; }
        
        .signature-block {
            margin-top: 40px;
            text-align: center;
            width: 100%;
            page-break-inside: avoid;
        }
        .signature-space {
            height: 60px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 5px;
        }
        
        .nav-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px dashed #ccc; }
        .btn { display: inline-block; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-family: sans-serif; font-size: 10pt; cursor: pointer; border: none; }
        .btn-back { background: #6c757d; color: white; }
        .btn-print { background: #0d6efd; color: white; }
        .btn:hover { opacity: 0.9; }
        
        @media print {
            @page { margin: 1.5cm; size: A4 portrait; }
            body { margin: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            .header { border-bottom-color: #000 !important; }
            th { background-color: #f0f0f0 !important; }
            .badge { border: 1px solid #000 !important; }
            .signature-block { text-align: center !important; margin: 0 auto; }
        }
    </style>
</head>
<body>
    <div class="nav-bar no-print">
        <a href="{{ route('admin.surat.index', ['jenis' => $jenis]) }}" class="btn btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak / Simpan PDF</button>
    </div>

    <div class="header">
        <h1>PEMERINTAH DESA BANJARDOWO</h1>
        <h2>Kecamatan Lengkong, Kabupaten Nganjuk</h2>
        <p class="report-title">LAPORAN PENGAJUAN SURAT {{ strtoupper($jenis) }}</p>
        <p class="period">Periode: {{ now()->format('d F Y') }}</p>
    </div>

    <div class="info">
        <div class="info-row">
            <span>Total: {{ $total }}</span>
            <span>Selesai: {{ $selesai }}</span>
            <span>Proses: {{ $proses }}</span>
            <span>Ditolak: {{ $ditolak }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="22%">Nama Pemohon</th>
                <th width="14%">NIK</th>
                <th width="12%">Tanggal</th>
                <th width="12%">Metode</th>
                <th width="12%">Status</th>
                <th width="23%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $row->nama_lengkap ?? $row->nama_pelapor ?? '-' }}</strong><br>
                    <small>{{ $row->no_hp ?? '-' }}</small>
                </td>
                <td class="text-center">{{ $row->nik ?? $row->nik_pelapor ?? '-' }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($row->tanggal_pengajuan)->format('d/m/Y') }}</td>
                <td class="text-center">
                    <span class="badge {{ $row->metode_pengambilan == 'cetak_online' ? 'badge-online' : 'badge-desa' }}">
                        {{ $row->metode_pengambilan == 'cetak_online' ? 'Online' : 'Ambil Desa' }}
                    </span>
                </td>
                <td class="text-center">
                    <span class="badge badge-{{ $row->status }}">
                        {{ ucfirst($row->status) }}
                    </span>
                </td>
                <td>
                    @if($row->status == 'selesai')
                        {{ $row->nomor_surat ?? '-' }}
                    @elseif($row->status == 'ditolak')
                        <small>{{ Str::limit($row->alasan_tolak, 40) }}</small>
                    @else
                        <small class="text-muted">-</small>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 30px;">Tidak ada data pengajuan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-block">
        <div style="margin-bottom: 10px;">Banjardowo, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</div>
        <div>Kepala Desa Banjardowo</div>
        <div class="signature-space"></div>
        <div class="signature-name">( AGUS SUDIONO )</div>
    </div>
</body>
</html>