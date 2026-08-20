<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Insiden Keamanan TIK — {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        @page { margin: 1.5cm 2cm; size: A4 landscape; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 9px; color: #1a1a1a; line-height: 1.4; }

        /* ── KOP SURAT ── */
        .kop {
            display: table;
            width: 100%;
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }
        .kop-left  { display: table-cell; width: 80px; vertical-align: middle; }
        .kop-mid   { display: table-cell; text-align: center; vertical-align: middle; padding: 0 10px; }
        .kop-right { display: table-cell; width: 80px; vertical-align: middle; text-align: right; }
        .kop-logo {
            width: 64px; height: 64px;
            background: #1e3a5f;
            border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; font-weight: 900; color: #fff;
            text-align: center; line-height: 64px;
        }
        .kop-instansi { font-size: 8px; color: #475569; margin-bottom: 1px; text-transform: uppercase; letter-spacing: 0.3px; }
        .kop-nama     { font-size: 14px; font-weight: 900; color: #1e3a5f; margin-bottom: 1px; letter-spacing: -0.3px; }
        .kop-alamat   { font-size: 7.5px; color: #64748b; }

        /* ── JUDUL LAPORAN ── */
        .judul-laporan {
            text-align: center;
            margin-bottom: 14px;
        }
        .judul-laporan h2 {
            font-size: 12px;
            font-weight: 700;
            color: #1e3a5f;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .judul-laporan p {
            font-size: 8.5px;
            color: #64748b;
        }
        .nomor-laporan {
            display: inline-block;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 3px 10px;
            font-size: 8px;
            color: #475569;
            margin-top: 4px;
        }

        /* ── RINGKASAN ── */
        .ringkasan {
            display: table;
            width: 100%;
            margin-bottom: 14px;
            border-collapse: collapse;
        }
        .ringkasan-cell {
            display: table-cell;
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            text-align: center;
            width: 20%;
        }
        .ringkasan-cell:first-child { border-radius: 6px 0 0 6px; background: #f0f7ff; }
        .ringkasan-cell:last-child  { border-radius: 0 6px 6px 0; }
        .ringkasan-num   { font-size: 18px; font-weight: 800; display: block; margin-bottom: 2px; }
        .ringkasan-label { font-size: 7px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .c-blue   { color: #2563eb; }
        .c-yellow { color: #d97706; }
        .c-green  { color: #16a34a; }
        .c-red    { color: #dc2626; }
        .c-purple { color: #7c3aed; }

        /* ── TABEL DATA ── */
        .section-title {
            font-size: 9px;
            font-weight: 700;
            color: #1e3a5f;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 8px;
        }

        table.data-tabel {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        table.data-tabel thead tr {
            background: #1e3a5f;
            color: #fff;
        }
        table.data-tabel thead th {
            padding: 6px 7px;
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        table.data-tabel tbody tr { border-bottom: 1px solid #f1f5f9; }
        table.data-tabel tbody tr:nth-child(even) { background: #f8fafc; }
        table.data-tabel tbody tr.overdue-row { background: #fff1f2 !important; }
        table.data-tabel tbody td {
            padding: 5px 7px;
            font-size: 8px;
            vertical-align: top;
        }
        table.data-tabel tfoot tr { background: #f1f5f9; border-top: 2px solid #e2e8f0; }
        table.data-tabel tfoot td { padding: 5px 7px; font-size: 8px; font-weight: 700; }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            padding: 1px 5px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: 700;
            white-space: nowrap;
        }
        .badge-open        { background: #dbeafe; color: #1d4ed8; }
        .badge-triase      { background: #fef3c7; color: #92400e; }
        .badge-in_progress { background: #cffafe; color: #0e7490; }
        .badge-resolved    { background: #dcfce7; color: #15803d; }
        .badge-reopen      { background: #fee2e2; color: #b91c1c; }
        .badge-closed      { background: #f1f5f9; color: #475569; }
        .badge-kritis      { background: #fee2e2; color: #dc2626; }
        .badge-tinggi      { background: #fef3c7; color: #92400e; }
        .badge-sedang      { background: #cffafe; color: #0e7490; }
        .badge-rendah      { background: #dcfce7; color: #15803d; }
        .badge-overdue     { background: #dc2626; color: #fff; }

        /* ── TANDA TANGAN ── */
        .ttd-section {
            display: table;
            width: 100%;
            margin-top: 20px;
        }
        .ttd-cell { display: table-cell; width: 50%; }
        .ttd-box {
            text-align: center;
            width: 200px;
        }
        .ttd-box.right { float: right; }
        .ttd-title { font-size: 8px; margin-bottom: 2px; }
        .ttd-tempat { font-size: 8px; color: #64748b; margin-bottom: 60px; }
        .ttd-garis { border-bottom: 1px solid #1a1a1a; margin-bottom: 3px; }
        .ttd-nama  { font-weight: 700; font-size: 9px; }
        .ttd-nip   { font-size: 7.5px; color: #64748b; }

        /* ── FOOTER ── */
        .footer-doc {
            position: fixed;
            bottom: 0.5cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 4px;
        }
    </style>
</head>
<body>

{{-- Footer tetap di tiap halaman --}}
<div class="footer-doc">
    SILANTEK — Sistem Pelaporan Insiden Keamanan TIK &nbsp;|&nbsp;
    Dinas Komunikasi dan Informatika Kabupaten Jombang &nbsp;|&nbsp;
    Dicetak: {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }} pukul {{ now()->format('H:i:s') }} WIB &nbsp;|&nbsp;
    Halaman <span class="pagenum"></span>
</div>

{{-- KOP SURAT --}}
<div class="kop">
    <div class="kop-left">
        <div class="kop-logo">S</div>
    </div>
    <div class="kop-mid">
        <div class="kop-instansi">Pemerintah Kabupaten Jombang</div>
        <div class="kop-nama">Dinas Komunikasi dan Informatika</div>
        <div class="kop-alamat">
            Jl. KH. Wahid Hasyim No.141, Jombang, Jawa Timur 61411<br>
            Telp. (0321) 861555 &nbsp;|&nbsp; csirt.jombangkab.go.id &nbsp;|&nbsp; diskominfo@jombangkab.go.id
        </div>
    </div>
    <div class="kop-right">
        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHJ4PSI4IiBmaWxsPSIjMWUzYTVmIi8+PHBhdGggZD0iTTMyIDhMMjAgMjBoMjRMMzIgOHoiIGZpbGw9IiNmZmYiIG9wYWNpdHk9Ii44Ii8+PHJlY3QgeD0iMTQiIHk9IjI0IiB3aWR0aD0iMzYiIGhlaWdodD0iMzIiIHJ4PSI0IiBmaWxsPSIjZmZmIiBvcGFjaXR5PSIuMiIvPjxwYXRoIGQ9Ik0yNCAzMmgxNk0yNCAzOGgxNk0yNCA0NGg4IiBzdHJva2U9IiNmZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+PC9zdmc+"
             style="width:56px; height:56px;" alt="logo">
    </div>
</div>

{{-- JUDUL LAPORAN --}}
<div class="judul-laporan">
    <h2>Laporan Insiden Keamanan Teknologi Informasi dan Komunikasi</h2>
    <p>Periode: {{ $namaBulan }} {{ $tahun }} &nbsp;·&nbsp; Bidang Aplikasi Telekomunikasi dan Informatika (APTIKA)</p>
    <div class="nomor-laporan">
        No. Laporan: {{ str_pad($tiket->count(), 3, '0', STR_PAD_LEFT) }}/SILANTEK/APTIKA/{{ strtoupper(substr($namaBulan, 0, 3)) }}/{{ $tahun }}
    </div>
</div>

{{-- RINGKASAN --}}
<div class="section-title">I. Ringkasan Eksekutif</div>
<div class="ringkasan">
    <div class="ringkasan-cell">
        <span class="ringkasan-num c-blue">{{ $stats['total'] }}</span>
        <span class="ringkasan-label">Total Insiden</span>
    </div>
    <div class="ringkasan-cell">
        <span class="ringkasan-num c-yellow">{{ $stats['open'] }}</span>
        <span class="ringkasan-label">Belum Selesai</span>
    </div>
    <div class="ringkasan-cell">
        <span class="ringkasan-num c-green">{{ $stats['resolved'] }}</span>
        <span class="ringkasan-label">Selesai Ditangani</span>
    </div>
    <div class="ringkasan-cell">
        <span class="ringkasan-num c-red">{{ $stats['overdue'] }}</span>
        <span class="ringkasan-label">Melewati SLA</span>
    </div>
    <div class="ringkasan-cell">
        <span class="ringkasan-num c-purple">{{ $stats['rata_rata_jam'] }}j</span>
        <span class="ringkasan-label">Rata-rata Penanganan</span>
    </div>
</div>

{{-- TABEL DETAIL --}}
<div class="section-title">II. Detail Insiden Periode {{ $namaBulan }} {{ $tahun }}</div>
<table class="data-tabel">
    <thead>
        <tr>
            <th style="width:20px;">No</th>
            <th style="width:85px;">No. Tiket</th>
            <th>OPD Pelapor</th>
            <th>Nama &amp; NIP Pelapor</th>
            <th>Jenis Insiden</th>
            <th>Urgensi</th>
            <th>Status</th>
            <th>SLA</th>
            <th>Tgl Lapor</th>
            <th>Diselesaikan</th>
            <th>Durasi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tiket as $i => $t)
        <tr class="{{ $t->is_overdue ? 'overdue-row' : '' }}">
            <td style="text-align:center; color:#94a3b8;">{{ $i + 1 }}</td>
            <td>
                <strong>{{ $t->nomor_tiket }}</strong>
                @if($t->is_overdue)
                    <br><span class="badge badge-overdue">OVERDUE</span>
                @endif
            </td>
            <td>{{ $t->opd->nama_opd ?? '-' }}</td>
            <td>
                {{ $t->nama_pelapor }}<br>
                <span style="color:#94a3b8; font-size:7px;">{{ $t->nip_pelapor }}</span>
            </td>
            <td>{{ $t->kategoriInsiden->nama ?? '-' }}</td>
            <td><span class="badge badge-{{ $t->slaConfig->urgensi ?? 'secondary' }}">{{ ucfirst($t->slaConfig->urgensi ?? '-') }}</span></td>
            <td><span class="badge badge-{{ $t->status }}">{{ $t->status_label }}</span></td>
            <td style="text-align:center;">{{ $t->slaConfig->durasi_jam ?? '-' }}j</td>
            <td>{{ $t->created_at->format('d/m/Y') }}<br><span style="color:#94a3b8;">{{ $t->created_at->format('H:i:s') }}</span></td>
            <td>
                @if($t->resolved_at)
                    {{ $t->resolved_at->format('d/m/Y') }}<br>
                    <span style="color:#94a3b8;">{{ $t->resolved_at->format('H:i:s') }}</span>
                @else
                    <span style="color:#94a3b8;">-</span>
                @endif
            </td>
            <td style="text-align:center;">
                @if($t->resolved_at)
                    @php
                        $menitTotal = (int) $t->created_at->diffInMinutes($t->resolved_at);
                        $jamDur = intdiv($menitTotal, 60);
                        $menitDur = $menitTotal % 60;
                    @endphp
                    @if($jamDur > 0){{ $jamDur }}j @endif{{ $menitDur }}m
                @else
                    -
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="11" style="text-align:center; color:#94a3b8; padding:20px;">
                Tidak ada data insiden pada periode ini.
            </td>
        </tr>
        @endforelse
    </tbody>
    @if($tiket->count() > 0)
    <tfoot>
        <tr>
            <td colspan="10" style="text-align:right;">Rata-rata waktu penanganan:</td>
            <td style="text-align:center; color:#2563eb; font-weight:700;">
                @php
                    $rataRataMenit = round($stats['rata_rata_jam'] * 60);
                    $rataJam   = intdiv((int)$rataRataMenit, 60);
                    $rataMenit = (int)$rataRataMenit % 60;
                @endphp
                @if($rataJam > 0){{ $rataJam }}j @endif{{ $rataMenit }}m
            </td>
        </tr>
    </tfoot>
    @endif
</table>

{{-- PENUTUP --}}
<div class="section-title">III. Penutup</div>
<p style="font-size:8px; color:#475569; line-height:1.6; margin-bottom:16px;">
    Laporan ini disusun berdasarkan data sistem SILANTEK (Sistem Pelaporan Insiden Keamanan TIK)
    Pemerintah Kabupaten Jombang periode {{ $namaBulan }} {{ $tahun }}.
    Laporan ini merupakan dokumen resmi yang dapat digunakan sebagai bahan evaluasi
    kinerja Tim CSIRT Diskominfo Kabupaten Jombang.
</p>

{{-- TANDA TANGAN --}}
<div class="ttd-section">
    <div class="ttd-cell">
        {{-- kosong kiri --}}
    </div>
    <div class="ttd-cell">
        <div class="ttd-box right">
            <div class="ttd-title">Jombang, {{ now()->locale('id')->isoFormat('D MMMM YYYY') }}</div>
            <div class="ttd-title">Kepala Bidang Aplikasi Telekomunikasi dan Informatika</div>
            <div class="ttd-title">Diskominfo Kabupaten Jombang</div>
            <div class="ttd-tempat"></div>
            <div class="ttd-garis"></div>
            <div class="ttd-nama">( _________________________ )</div>
            <div class="ttd-nip">NIP. ___________________________</div>
        </div>
    </div>
</div>

</body>
</html>
