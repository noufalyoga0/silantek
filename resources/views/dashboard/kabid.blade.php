@extends('layouts.app')

@section('title', 'Dashboard Kabid APTIKA')
@section('page-title', 'Dashboard Kepala Bidang APTIKA')

@section('content')

{{-- ── HERO BANNER ── --}}
<div class="mb-4" style="border-radius:16px; overflow:hidden; position:relative;
     background:linear-gradient(135deg, #1e3a5f 0%, #0f172a 60%, #14532d 100%);
     padding:1.75rem 2rem;">
    <div style="position:absolute; top:-30px; right:-20px; width:200px; height:200px;
                border-radius:50%; background:rgba(22,163,74,0.1);"></div>
    <div style="position:absolute; bottom:-40px; left:50%; width:140px; height:140px;
                border-radius:50%; background:rgba(37,99,235,0.08);"></div>

    <div class="d-flex align-items-center justify-content-between" style="position:relative; z-index:1;">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:36px; height:36px; border-radius:10px;
                            background:rgba(255,255,255,.12);
                            display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-person-workspace text-white" style="font-size:1rem;"></i>
                </div>
                <span class="text-white" style="font-size:0.78rem; opacity:0.7;">
                    Kepala Bidang APTIKA · Diskominfo Kab. Jombang
                </span>
            </div>
            <h4 class="text-white fw-bold mb-1" style="font-size:1.3rem;">
                Monitoring &amp; Eskalasi Insiden TIK
            </h4>
            <p class="mb-0" style="color:rgba(255,255,255,.6); font-size:0.82rem;">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </p>
        </div>

        {{-- Summary pill --}}
        <div class="d-none d-md-flex gap-2">
            <div class="text-center px-3 py-2 rounded-3"
                 style="background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.12); min-width:80px;">
                <div class="fw-bold text-white" style="font-size:1.25rem;">{{ $stats['total_bulan_ini'] }}</div>
                <div style="font-size:0.65rem; color:rgba(255,255,255,.55);">Insiden bulan ini</div>
            </div>
            <div class="text-center px-3 py-2 rounded-3"
                 style="background:{{ $stats['overdue'] > 0 ? 'rgba(239,68,68,.2)' : 'rgba(255,255,255,.08)' }};
                        border:1px solid {{ $stats['overdue'] > 0 ? 'rgba(239,68,68,.4)' : 'rgba(255,255,255,.12)' }};
                        min-width:80px;">
                <div class="fw-bold {{ $stats['overdue'] > 0 ? 'overdue-badge' : '' }}"
                     style="font-size:1.25rem; color:{{ $stats['overdue'] > 0 ? '#f87171' : '#fff' }};">
                    {{ $stats['overdue'] }}
                </div>
                <div style="font-size:0.65rem; color:{{ $stats['overdue'] > 0 ? 'rgba(248,113,113,.8)' : 'rgba(255,255,255,.55)' }};">
                    Overdue
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden; border-top:3px solid #2563eb !important;">
            <div class="card-body p-4 pt-4">
                <div style="width:52px; height:52px; border-radius:14px;
                            background:#eff6ff;
                            display:flex; align-items:center; justify-content:center;
                            margin:0 auto 1rem;">
                    <i class="bi bi-ticket-perforated-fill" style="color:#2563eb; font-size:1.4rem;"></i>
                </div>
                <div style="font-size:2.25rem; font-weight:800; color:#0f172a; line-height:1;">
                    {{ $stats['total_bulan_ini'] }}
                </div>
                <div class="fw-semibold mt-2" style="font-size:0.85rem; color:#374151;">
                    Total Insiden Bulan Ini
                </div>
                <div class="text-muted mt-1" style="font-size:0.72rem;">Seluruh OPD Kabupaten Jombang</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden;
                    border-top:3px solid {{ $stats['overdue'] > 0 ? '#ef4444' : '#94a3b8' }} !important;
                    {{ $stats['overdue'] > 0 ? 'background:linear-gradient(180deg,#fff1f2,#fff);' : '' }}">
            <div class="card-body p-4 pt-4">
                <div style="width:52px; height:52px; border-radius:14px;
                            background:{{ $stats['overdue'] > 0 ? '#fee2e2' : '#f1f5f9' }};
                            display:flex; align-items:center; justify-content:center;
                            margin:0 auto 1rem;">
                    <i class="bi bi-exclamation-triangle-fill {{ $stats['overdue'] > 0 ? 'overdue-badge' : '' }}"
                       style="color:{{ $stats['overdue'] > 0 ? '#dc2626' : '#94a3b8' }}; font-size:1.4rem;"></i>
                </div>
                <div style="font-size:2.25rem; font-weight:800; line-height:1;
                            color:{{ $stats['overdue'] > 0 ? '#dc2626' : '#0f172a' }};">
                    {{ $stats['overdue'] }}
                </div>
                <div class="fw-semibold mt-2" style="font-size:0.85rem; color:#374151;">Tiket OVERDUE</div>
                @if($stats['overdue'] > 0)
                <div class="mt-1" style="font-size:0.72rem; color:#dc2626; font-weight:600;">Eskalasi diperlukan!</div>
                @else
                <div class="mt-1" style="font-size:0.72rem; color:#16a34a;">Semua terkendali</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden; border-top:3px solid #22c55e !important;">
            <div class="card-body p-4 pt-4">
                <div style="width:52px; height:52px; border-radius:14px;
                            background:#f0fdf4;
                            display:flex; align-items:center; justify-content:center;
                            margin:0 auto 1rem;">
                    <i class="bi bi-clock-history" style="color:#16a34a; font-size:1.4rem;"></i>
                </div>
                @php
                    $rataM = round($stats['rata_rata_jam'] * 60);
                    $jRata = intdiv((int)$rataM, 60);
                    $mRata = (int)$rataM % 60;
                @endphp
                <div style="font-size:1.85rem; font-weight:800; color:#0f172a; line-height:1;">
                    @if($jRata > 0){{ $jRata }}j @endif{{ $mRata }}m
                </div>
                <div class="fw-semibold mt-2" style="font-size:0.85rem; color:#374151;">Rata-rata Penanganan</div>
                <div class="text-muted mt-1" style="font-size:0.72rem;">Waktu open → resolved</div>
            </div>
        </div>
    </div>
</div>

{{-- ── GRAFIK TREN ── --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px !important;">
    <div class="card-header py-3">
        <h6 class="mb-0 fw-semibold">
            <i class="bi bi-graph-up me-2 text-primary"></i>Tren Insiden 6 Bulan Terakhir
        </h6>
    </div>
    <div class="card-body">
        <canvas id="grafikKabid" height="65"></canvas>
    </div>
</div>

{{-- ── TABEL OVERDUE ── --}}
<div class="card border-0 shadow-sm" style="border-radius:14px !important; overflow:hidden;">
    <div class="card-header py-3"
         style="{{ $tiketOverdue->count() > 0 ? 'background:#fff1f2 !important;' : '' }}">
        <h6 class="mb-0 fw-semibold {{ $tiketOverdue->count() > 0 ? 'text-danger' : 'text-success' }}">
            @if($tiketOverdue->count() > 0)
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Tiket OVERDUE — Perlu Eskalasi ({{ $tiketOverdue->count() }})
            @else
                <i class="bi bi-check-circle-fill me-2"></i>
                Tidak Ada Tiket OVERDUE
            @endif
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Tiket</th>
                        <th>OPD</th>
                        <th>Jenis Insiden</th>
                        <th>Urgensi</th>
                        <th>Status</th>
                        <th>SLA Deadline</th>
                        <th>Terlambat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tiketOverdue as $t)
                    <tr class="overdue-row">
                        <td>
                            <span class="fw-semibold">{{ $t->nomor_tiket }}</span>
                            <span class="badge bg-danger ms-1 overdue-badge" style="font-size:0.58rem;">OVERDUE</span>
                        </td>
                        <td class="small">{{ Str::limit($t->opd->nama_opd ?? '-', 28) }}</td>
                        <td class="small">{{ $t->kategoriInsiden->nama ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $t->slaConfig->badge_color ?? 'secondary' }}">
                                {{ ucfirst($t->slaConfig->urgensi ?? '-') }}
                            </span>
                        </td>
                        <td><span class="badge badge-{{ $t->status }}">{{ $t->status_label }}</span></td>
                        <td class="small text-danger fw-bold">
                            {{ $t->sla_deadline ? $t->sla_deadline->format('d/m/Y H:i:s') : '-' }}
                        </td>
                        <td class="small text-danger">
                            @if($t->sla_deadline) {{ $t->sla_deadline->diffForHumans() }} @endif
                        </td>
                        <td>
                            <a href="{{ route('tiket.show', $t) }}"
                               class="btn btn-sm btn-outline-danger"
                               style="font-size:0.72rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <div style="width:64px; height:64px; background:#f0fdf4; border-radius:50%;
                                        display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                                <i class="bi bi-check-all fs-2 text-success"></i>
                            </div>
                            <p class="fw-semibold mb-1">Tidak ada tiket OVERDUE</p>
                            <p class="text-muted small mb-0">Tim CSIRT menangani semua insiden tepat waktu</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
new Chart(document.getElementById('grafikKabid').getContext('2d'), {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($grafikBulanan, 'bulan')) !!},
        datasets: [{
            label: 'Insiden',
            data: {!! json_encode(array_column($grafikBulanan, 'jumlah')) !!},
            borderColor: '#2563eb',
            backgroundColor: function(context) {
                const chart = context.chart;
                const {ctx, chartArea} = chart;
                if (!chartArea) return 'rgba(37,99,235,0.05)';
                const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                gradient.addColorStop(0, 'rgba(37,99,235,0.15)');
                gradient.addColorStop(1, 'rgba(37,99,235,0)');
                return gradient;
            },
            borderWidth: 2.5,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#2563eb',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7,
            fill: true,
            tension: 0.4,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#0f172a',
                titleColor: '#94a3b8',
                bodyColor: '#f1f5f9',
                cornerRadius: 8,
                padding: 10,
            }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush
