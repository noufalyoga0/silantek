@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard PIC IT OPD')

@section('content')

{{-- ── HERO BANNER ── --}}
<div class="mb-4" style="border-radius:16px; overflow:hidden; position:relative;
     background:linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #2563eb 100%);
     padding:1.75rem 2rem;">
    {{-- Decorative circles --}}
    <div style="position:absolute; top:-30px; right:-30px; width:160px; height:160px;
                border-radius:50%; background:rgba(255,255,255,0.05);"></div>
    <div style="position:absolute; bottom:-40px; right:80px; width:100px; height:100px;
                border-radius:50%; background:rgba(255,255,255,0.04);"></div>
    <div style="position:absolute; top:20px; right:160px; width:60px; height:60px;
                border-radius:50%; background:rgba(255,255,255,0.06);"></div>

    <div class="d-flex align-items-center justify-content-between" style="position:relative; z-index:1;">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,.15);
                            display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-person-fill text-white" style="font-size:1rem;"></i>
                </div>
                <span class="text-white" style="font-size:0.78rem; opacity:0.75;">PIC IT OPD</span>
            </div>
            <h4 class="text-white fw-bold mb-1" style="font-size:1.3rem;">
                Selamat datang, {{ $user->nama }}
            </h4>
            <p class="mb-0" style="color:rgba(255,255,255,.65); font-size:0.82rem;">
                <i class="bi bi-buildings me-1"></i>{{ $user->opd->nama_opd ?? '-' }}
            </p>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('tiket.create') }}"
               class="btn fw-semibold px-4"
               style="background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.3);
                      backdrop-filter:blur(4px); border-radius:10px; transition:all .2s;"
               onmouseover="this.style.background='rgba(255,255,255,.25)'"
               onmouseout="this.style.background='rgba(255,255,255,.15)'">
                <i class="bi bi-plus-circle me-2"></i>Laporkan Insiden
            </a>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">
    @php
        $cards = [
            ['val'=>$stats['total'],       'label'=>'Total Tiket',     'sub'=>'Semua periode',         'icon'=>'bi-ticket-perforated-fill', 'color'=>'#2563eb', 'bg'=>'#eff6ff', 'line'=>'#2563eb'],
            ['val'=>$stats['open'],        'label'=>'Sedang Diproses', 'sub'=>'Open & in progress',    'icon'=>'bi-hourglass-split',        'color'=>'#d97706', 'bg'=>'#fef3c7', 'line'=>'#f59e0b'],
            ['val'=>$stats['in_progress'], 'label'=>'In Progress',     'sub'=>'Aktif ditangani CSIRT', 'icon'=>'bi-tools',                  'color'=>'#0891b2', 'bg'=>'#ecfeff', 'line'=>'#06b6d4'],
            ['val'=>$stats['resolved'],    'label'=>'Selesai',         'sub'=>'Resolved & closed',     'icon'=>'bi-check-circle-fill',      'color'=>'#16a34a', 'bg'=>'#f0fdf4', 'line'=>'#22c55e'],
        ];
    @endphp
    @foreach($cards as $c)
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden;
                    border-top:3px solid {{ $c['line'] }} !important;">
            <div class="card-body p-3 pt-4">
                <div style="width:48px; height:48px; border-radius:12px;
                            background:{{ $c['bg'] }};
                            display:flex; align-items:center; justify-content:center;
                            margin:0 auto 0.75rem;">
                    <i class="bi {{ $c['icon'] }}" style="color:{{ $c['color'] }}; font-size:1.3rem;"></i>
                </div>
                <div style="font-size:2.25rem; font-weight:800; color:#0f172a; line-height:1;">
                    {{ $c['val'] }}
                </div>
                <div class="fw-semibold mt-2" style="font-size:0.82rem; color:#374151;">
                    {{ $c['label'] }}
                </div>
                <div class="text-muted mt-1" style="font-size:0.7rem;">{{ $c['sub'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Mobile: tombol laporan --}}
<div class="d-md-none mb-4">
    <a href="{{ route('tiket.create') }}" class="btn btn-primary w-100 fw-semibold">
        <i class="bi bi-plus-circle me-2"></i>Laporkan Insiden Baru
    </a>
</div>

{{-- ── GRAFIK + TIKET ── --}}
<div class="row g-3">
    {{-- Grafik bulanan --}}
    @if(array_sum(array_column($grafikBulanan, 'jumlah')) > 0)
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:14px !important;">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-bar-chart-line me-2 text-primary"></i>Riwayat Laporan 6 Bulan Terakhir
                </h6>
            </div>
            <div class="card-body pb-3">
                <canvas id="grafikPicOpd" height="60"></canvas>
            </div>
        </div>
    </div>
    @endif

    {{-- Tabel tiket terbaru --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:14px !important;">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Tiket Terbaru OPD Anda
                </h6>
                <a href="{{ route('tiket.index') }}" class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Tiket</th>
                                <th>Jenis Insiden</th>
                                <th>Urgensi</th>
                                <th>Status</th>
                                <th>SLA Deadline</th>
                                <th>Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tiketTerbaru as $t)
                            <tr class="{{ $t->is_overdue && !in_array($t->status,['resolved','closed']) ? 'overdue-row' : '' }}">
                                <td>
                                    <span class="fw-semibold">{{ $t->nomor_tiket }}</span>
                                    @if($t->is_overdue && !in_array($t->status,['resolved','closed']))
                                        <span class="badge bg-danger ms-1 overdue-badge" style="font-size:0.6rem;">OVERDUE</span>
                                    @endif
                                </td>
                                <td class="small">{{ $t->kategoriInsiden->nama ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $t->slaConfig->badge_color ?? 'secondary' }}">
                                        {{ ucfirst($t->slaConfig->urgensi ?? '-') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $t->status }}">{{ $t->status_label }}</span>
                                </td>
                                <td class="small {{ $t->is_overdue && !in_array($t->status,['resolved','closed']) ? 'text-danger fw-bold' : 'text-muted' }}">
                                    {{ $t->sla_deadline ? $t->sla_deadline->format('d/m/Y H:i:s') : '-' }}
                                </td>
                                <td class="text-muted small">{{ $t->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('tiket.show', $t) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div style="width:64px; height:64px; background:#f1f5f9; border-radius:50%;
                                                display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                                        <i class="bi bi-inbox fs-3 opacity-50"></i>
                                    </div>
                                    <p class="fw-semibold mb-1">Belum ada laporan insiden</p>
                                    <p class="small mb-2">Buat laporan pertama OPD Anda sekarang</p>
                                    <a href="{{ route('tiket.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle me-1"></i>Laporkan Insiden
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
@if(array_sum(array_column($grafikBulanan, 'jumlah')) > 0)
new Chart(document.getElementById('grafikPicOpd').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($grafikBulanan, 'bulan')) !!},
        datasets: [{
            label: 'Laporan',
            data: {!! json_encode(array_column($grafikBulanan, 'jumlah')) !!},
            backgroundColor: 'rgba(37,99,235,0.12)',
            borderColor: '#2563eb',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false } }
        }
    }
});
@endif
</script>
@endpush
