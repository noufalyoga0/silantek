@extends('layouts.app')

@section('title', 'Dashboard CSIRT')
@section('page-title', 'Dashboard Tim CSIRT')

@section('content')

{{-- ── HERO BANNER ── --}}
<div class="mb-4" style="border-radius:16px; overflow:hidden; position:relative;
     background:linear-gradient(135deg, #0f172a 0%, #1e2a3a 40%, #1a3a5f 100%);
     padding:1.75rem 2rem;">
    <div style="position:absolute; top:-20px; right:-20px; width:180px; height:180px;
                border-radius:50%; background:rgba(37,99,235,0.12);"></div>
    <div style="position:absolute; bottom:-50px; right:100px; width:120px; height:120px;
                border-radius:50%; background:rgba(124,58,237,0.08);"></div>

    <div class="d-flex align-items-center justify-content-between" style="position:relative; z-index:1;">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:36px; height:36px; border-radius:10px; background:rgba(239,68,68,.2);
                            display:flex; align-items:center; justify-content:center; border:1px solid rgba(239,68,68,.3);">
                    <i class="bi bi-shield-fill-check" style="color:#f87171; font-size:1rem;"></i>
                </div>
                <span class="text-white" style="font-size:0.78rem; opacity:0.7;">Tim CSIRT · Diskominfo Kab. Jombang</span>
            </div>
            <h4 class="text-white fw-bold mb-1" style="font-size:1.3rem;">
                Command Center Keamanan TIK
            </h4>
            <p class="mb-0" style="color:rgba(255,255,255,.6); font-size:0.82rem;">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY · HH:mm') }} WIB
            </p>
        </div>
        <div class="d-none d-md-flex flex-column align-items-end gap-2">
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                 style="background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.15);">
                <div style="width:8px; height:8px; border-radius:50%; background:#22c55e;
                            box-shadow:0 0 8px #22c55e; animation:pulse-green 2s infinite;"></div>
                <span class="text-white" style="font-size:0.75rem;">Sistem Aktif</span>
            </div>
            @if($stats['overdue'] > 0)
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                 style="background:rgba(239,68,68,.15); border:1px solid rgba(239,68,68,.3);">
                <i class="bi bi-exclamation-triangle-fill" style="color:#f87171; font-size:0.8rem;"></i>
                <span style="color:#fca5a5; font-size:0.75rem; font-weight:600;">
                    {{ $stats['overdue'] }} Tiket OVERDUE
                </span>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
@keyframes pulse-green {
    0%, 100% { box-shadow: 0 0 4px #22c55e; }
    50% { box-shadow: 0 0 12px #22c55e; }
}
</style>

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">

    {{-- Bulan ini + trend --}}
    <div class="col-6 col-lg-2">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden; border-top:3px solid #2563eb !important;">
            <div class="card-body p-3 pt-4">
                <div style="width:44px; height:44px; border-radius:11px; background:#eff6ff;
                            display:flex; align-items:center; justify-content:center; margin:0 auto .75rem;">
                    <i class="bi bi-calendar3" style="color:#2563eb; font-size:1.1rem;"></i>
                </div>
                <div style="font-size:2rem; font-weight:800; color:#0f172a; line-height:1;">{{ $stats['total_bulan_ini'] }}</div>
                <div class="fw-semibold mt-2" style="font-size:0.78rem; color:#374151;">Bulan Ini</div>
                @if($stats['trend_persen'] != 0)
                <div class="mt-1" style="font-size:0.68rem; font-weight:600;
                     color:{{ $stats['trend_persen'] > 0 ? '#dc2626' : '#16a34a' }};">
                    {{ $stats['trend_persen'] > 0 ? '↑' : '↓' }} {{ abs($stats['trend_persen']) }}% vs bulan lalu
                </div>
                @else
                <div class="text-muted mt-1" style="font-size:0.68rem;">Sama dgn bulan lalu</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Open/Triase --}}
    <div class="col-6 col-lg-2">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden; border-top:3px solid #f59e0b !important;">
            <div class="card-body p-3 pt-4">
                <div style="width:44px; height:44px; border-radius:11px; background:#fef3c7;
                            display:flex; align-items:center; justify-content:center; margin:0 auto .75rem;">
                    <i class="bi bi-hourglass-split" style="color:#d97706; font-size:1.1rem;"></i>
                </div>
                <div style="font-size:2rem; font-weight:800; color:#d97706; line-height:1;">{{ $stats['open'] }}</div>
                <div class="fw-semibold mt-2" style="font-size:0.78rem; color:#374151;">Open / Triase</div>
                <div class="text-muted mt-1" style="font-size:0.68rem;">Menunggu ditangani</div>
            </div>
        </div>
    </div>

    {{-- In Progress --}}
    <div class="col-6 col-lg-2">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden; border-top:3px solid #06b6d4 !important;">
            <div class="card-body p-3 pt-4">
                <div style="width:44px; height:44px; border-radius:11px; background:#ecfeff;
                            display:flex; align-items:center; justify-content:center; margin:0 auto .75rem;">
                    <i class="bi bi-tools" style="color:#0891b2; font-size:1.1rem;"></i>
                </div>
                <div style="font-size:2rem; font-weight:800; color:#0891b2; line-height:1;">{{ $stats['in_progress'] }}</div>
                <div class="fw-semibold mt-2" style="font-size:0.78rem; color:#374151;">In Progress</div>
                @if($stats['reopen'] > 0)
                <div class="mt-1" style="font-size:0.68rem; color:#dc2626; font-weight:600;">+{{ $stats['reopen'] }} reopen</div>
                @else
                <div class="text-muted mt-1" style="font-size:0.68rem;">Sedang ditangani</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Overdue --}}
    <div class="col-6 col-lg-2">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden;
                    border-top:3px solid {{ $stats['overdue'] > 0 ? '#ef4444' : '#94a3b8' }} !important;
                    {{ $stats['overdue'] > 0 ? 'background:#fff1f2;' : '' }}">
            <div class="card-body p-3 pt-4">
                <div style="width:44px; height:44px; border-radius:11px;
                            background:{{ $stats['overdue'] > 0 ? '#fee2e2' : '#f1f5f9' }};
                            display:flex; align-items:center; justify-content:center; margin:0 auto .75rem;">
                    <i class="bi bi-exclamation-triangle-fill {{ $stats['overdue'] > 0 ? 'overdue-badge' : '' }}"
                       style="color:{{ $stats['overdue'] > 0 ? '#dc2626' : '#94a3b8' }}; font-size:1.1rem;"></i>
                </div>
                <div style="font-size:2rem; font-weight:800; line-height:1;
                            color:{{ $stats['overdue'] > 0 ? '#dc2626' : '#0f172a' }};">{{ $stats['overdue'] }}</div>
                <div class="fw-semibold mt-2" style="font-size:0.78rem; color:#374151;">Overdue</div>
                @if($stats['overdue'] > 0)
                <div class="mt-1" style="font-size:0.68rem; color:#dc2626; font-weight:700;">Segera tangani!</div>
                @else
                <div class="mt-1" style="font-size:0.68rem; color:#16a34a;">Terkendali</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Resolved --}}
    <div class="col-6 col-lg-2">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden; border-top:3px solid #22c55e !important;">
            <div class="card-body p-3 pt-4">
                <div style="width:44px; height:44px; border-radius:11px; background:#f0fdf4;
                            display:flex; align-items:center; justify-content:center; margin:0 auto .75rem;">
                    <i class="bi bi-check-circle-fill" style="color:#16a34a; font-size:1.1rem;"></i>
                </div>
                <div style="font-size:2rem; font-weight:800; color:#16a34a; line-height:1;">{{ $stats['resolved_bulan'] }}</div>
                <div class="fw-semibold mt-2" style="font-size:0.78rem; color:#374151;">Selesai Bulan Ini</div>
                <div class="text-muted mt-1" style="font-size:0.68rem;">Resolved & closed</div>
            </div>
        </div>
    </div>

    {{-- Rata-rata --}}
    <div class="col-6 col-lg-2">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden; border-top:3px solid #8b5cf6 !important;">
            <div class="card-body p-3 pt-4">
                <div style="width:44px; height:44px; border-radius:11px; background:#faf5ff;
                            display:flex; align-items:center; justify-content:center; margin:0 auto .75rem;">
                    <i class="bi bi-clock-history" style="color:#7c3aed; font-size:1.1rem;"></i>
                </div>
                @php
                    $rataM = round($stats['rata_rata_jam'] * 60);
                    $rJ = intdiv($rataM, 60); $rM = $rataM % 60;
                @endphp
                <div style="font-size:1.5rem; font-weight:800; color:#7c3aed; line-height:1;">
                    @if($rJ > 0){{ $rJ }}j @endif{{ $rM }}m
                </div>
                <div class="fw-semibold mt-2" style="font-size:0.78rem; color:#374151;">Rata-rata</div>
                <div class="text-muted mt-1" style="font-size:0.68rem;">{{ $stats['total_opd_lapor'] }} OPD lapor</div>
            </div>
        </div>
    </div>
</div>

{{-- ── ROW: PERHATIAN + TOP OPD ── --}}
<div class="row g-3 mb-4">

    {{-- Tiket Butuh Perhatian --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px !important; overflow:hidden;">
            <div class="card-header py-3 d-flex align-items-center justify-content-between"
                 style="{{ $tiketPerhatian->count() > 0 ? 'background:#fff1f2 !important;' : '' }}">
                <h6 class="mb-0 fw-semibold {{ $tiketPerhatian->count() > 0 ? 'text-danger' : '' }}">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    Butuh Perhatian Segera
                    @if($tiketPerhatian->count() > 0)
                        <span class="badge bg-danger ms-1" style="font-size:0.6rem;">{{ $tiketPerhatian->count() }}</span>
                    @endif
                </h6>
                <span class="text-muted" style="font-size:0.7rem;">Overdue · Reopen · Kritis</span>
            </div>
            <div class="card-body p-0">
                @forelse($tiketPerhatian as $t)
                <div class="d-flex align-items-center gap-3 px-3 py-2 border-bottom">
                    <div style="width:8px; height:8px; border-radius:50%; flex-shrink:0;
                                background:{{ $t->is_overdue ? '#ef4444' : ($t->status === 'reopen' ? '#f59e0b' : '#8b5cf6') }};"
                         class="{{ $t->is_overdue ? 'overdue-badge' : '' }}"></div>
                    <div class="flex-grow-1" style="overflow:hidden; min-width:0;">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-semibold" style="font-size:0.82rem;">{{ $t->nomor_tiket }}</span>
                            @if($t->is_overdue)
                                <span class="badge" style="background:#fee2e2; color:#dc2626; font-size:0.58rem;">OVERDUE</span>
                            @elseif($t->status === 'reopen')
                                <span class="badge" style="background:#fef3c7; color:#92400e; font-size:0.58rem;">REOPEN</span>
                            @else
                                <span class="badge" style="background:#f3e8ff; color:#6d28d9; font-size:0.58rem;">KRITIS</span>
                            @endif
                            <span class="badge badge-{{ $t->status }}" style="font-size:0.58rem;">{{ $t->status_label }}</span>
                        </div>
                        <div class="text-muted text-truncate" style="font-size:0.72rem;">
                            {{ Str::limit($t->opd->nama_opd ?? '-', 30) }} · {{ $t->kategoriInsiden->nama ?? '-' }}
                        </div>
                    </div>
                    <a href="{{ route('tiket.show', $t) }}"
                       class="btn btn-sm fw-semibold flex-shrink-0"
                       style="background:#dc2626; color:#fff; border:none; border-radius:8px;
                              font-size:0.72rem; padding:0.3rem 0.7rem;">
                        Tangani
                    </a>
                </div>
                @empty
                <div class="text-center py-5">
                    <div style="width:56px; height:56px; background:#f0fdf4; border-radius:50%;
                                display:flex; align-items:center; justify-content:center; margin:0 auto 0.75rem;">
                        <i class="bi bi-check-all fs-3 text-success"></i>
                    </div>
                    <p class="fw-semibold mb-1" style="font-size:0.85rem;">Semua aman</p>
                    <p class="text-muted" style="font-size:0.75rem;">Tidak ada tiket yang butuh perhatian segera</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Top OPD --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px !important;">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-trophy-fill me-2 text-warning"></i>Top OPD Pelapor
                </h6>
            </div>
            <div class="card-body">
                @php $maxJumlah = $topOpd->max('jumlah') ?: 1; @endphp
                @php $podiumColors = ['#2563eb','#7c3aed','#0891b2','#16a34a','#d97706']; @endphp
                @forelse($topOpd as $i => $opd)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:22px; height:22px; border-radius:6px;
                                        background:{{ $podiumColors[$i] ?? '#94a3b8' }}22;
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:0.65rem; font-weight:700;
                                        color:{{ $podiumColors[$i] ?? '#94a3b8' }};">
                                {{ $i + 1 }}
                            </div>
                            <span class="small fw-semibold text-truncate" style="max-width:180px; font-size:0.78rem;">
                                {{ $opd['nama'] }}
                            </span>
                        </div>
                        <span class="fw-bold" style="color:{{ $podiumColors[$i] ?? '#94a3b8' }}; font-size:0.85rem; flex-shrink:0;">
                            {{ $opd['jumlah'] }}
                        </span>
                    </div>
                    <div style="height:5px; background:#f1f5f9; border-radius:3px; overflow:hidden;">
                        <div style="height:100%; border-radius:3px;
                                    width:{{ round(($opd['jumlah']/$maxJumlah)*100) }}%;
                                    background:{{ $podiumColors[$i] ?? '#94a3b8' }};
                                    transition:width .5s ease;"></div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-3 small">Belum ada data.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ── GRAFIK + TABEL ── --}}
<div class="card border-0 shadow-sm" style="border-radius:14px !important;">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-list-ul me-2 text-primary"></i>Tiket Masuk Terbaru</h6>
        <a href="{{ route('tiket.index') }}" class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;">
            Kelola Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tiketTerbaru as $t)
                    <tr class="{{ $t->is_overdue && !in_array($t->status,['resolved','closed']) ? 'overdue-row' : '' }}">
                        <td>
                            <span class="fw-semibold">{{ $t->nomor_tiket }}</span>
                            @if($t->is_overdue && !in_array($t->status,['resolved','closed']))
                                <span class="badge bg-danger ms-1 overdue-badge" style="font-size:0.58rem;">OVERDUE</span>
                            @endif
                        </td>
                        <td class="small">{{ Str::limit($t->opd->nama_opd ?? '-', 24) }}</td>
                        <td class="small">{{ $t->kategoriInsiden->nama ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $t->slaConfig->badge_color ?? 'secondary' }}">
                                {{ ucfirst($t->slaConfig->urgensi ?? '-') }}
                            </span>
                        </td>
                        <td><span class="badge badge-{{ $t->status }}">{{ $t->status_label }}</span></td>
                        <td class="small {{ $t->is_overdue && !in_array($t->status,['resolved','closed']) ? 'text-danger fw-bold' : 'text-muted' }}">
                            {{ $t->sla_deadline ? $t->sla_deadline->format('d/m/Y H:i:s') : '-' }}
                        </td>
                        <td>
                            @php $selesai = in_array($t->status, ['resolved','closed']); @endphp
                            <a href="{{ route('tiket.show', $t) }}"
                               class="btn btn-sm {{ $selesai ? 'btn-outline-secondary' : 'btn-primary' }}"
                               style="font-size:0.72rem; padding:0.25rem 0.6rem;">
                                <i class="bi bi-{{ $selesai ? 'eye' : 'tools' }}"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                            Belum ada tiket masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
