@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Administrator')

@section('content')

{{-- ── HEADER ── --}}
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">
            <i class="bi bi-shield-lock-fill me-2 text-primary"></i>Dashboard Administrator
        </h4>
        <p class="text-muted mb-0 small">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            &nbsp;·&nbsp; Selamat datang, <strong>{{ auth()->user()->nama }}</strong>
        </p>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">

    {{-- Total User --}}
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden; border-top:3px solid #2563eb !important;">
            <div class="card-body p-3 pt-4">
                <div style="width:46px; height:46px; border-radius:12px; background:#eff6ff;
                            display:flex; align-items:center; justify-content:center; margin:0 auto .85rem;">
                    <i class="bi bi-people-fill" style="color:#2563eb; font-size:1.2rem;"></i>
                </div>
                <div style="font-size:2rem; font-weight:800; color:#0f172a; line-height:1;">{{ $stats['total_user'] }}</div>
                <div class="fw-semibold mt-2" style="font-size:0.8rem; color:#374151;">Total User</div>
                <div class="mt-2 pt-2 border-top" style="font-size:0.68rem; color:#94a3b8;">
                    {{ $stats['pic_opd'] }} PIC · {{ $stats['csirt'] }} CSIRT
                </div>
            </div>
        </div>
    </div>
                <div style="font-size:2rem; font-weight:800; color:#0f172a; line-height:1;">
                    {{ $stats['total_user'] }}
                </div>
                <div class="text-muted mt-1" style="font-size:0.72rem;">Total User Terdaftar</div>
                <div class="mt-2 pt-2 border-top d-flex gap-2" style="font-size:0.68rem;">
                    <span style="color:#2563eb;">{{ $stats['pic_opd'] }} PIC OPD</span>
                    <span style="color:#94a3b8;">·</span>
                    <span style="color:#7c3aed;">{{ $stats['csirt'] }} CSIRT</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Total OPD --}}
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px !important; overflow:hidden;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div style="width:42px; height:42px; border-radius:10px;
                                background:#ecfeff;
                                display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-buildings-fill" style="color:#0891b2; font-size:1.1rem;"></i>
                    </div>
                    <span style="font-size:0.68rem; background:#cffafe; color:#0e7490;
                                 padding:2px 8px; border-radius:20px; font-weight:600;">
                        OPD
                    </span>
                </div>
                <div style="font-size:2rem; font-weight:800; color:#0f172a; line-height:1;">
                    {{ $stats['total_opd'] }}
                </div>
                <div class="text-muted mt-1" style="font-size:0.72rem;">OPD Terdaftar</div>
                <div class="mt-2 pt-2 border-top" style="font-size:0.68rem;">
                    @if($stats['opd_tanpa_pic'] > 0)
                        <span style="color:#d97706;">⚠ {{ $stats['opd_tanpa_pic'] }} belum ada PIC IT</span>
                    @else
                        <span style="color:#16a34a;">✓ Semua OPD sudah ada PIC IT</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Total Tiket --}}
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px !important; overflow:hidden;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div style="width:42px; height:42px; border-radius:10px;
                                background:#f0fdf4;
                                display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-ticket-perforated-fill" style="color:#16a34a; font-size:1.1rem;"></i>
                    </div>
                    <span style="font-size:0.68rem; background:#dcfce7; color:#15803d;
                                 padding:2px 8px; border-radius:20px; font-weight:600;">
                        Tiket
                    </span>
                </div>
                <div style="font-size:2rem; font-weight:800; color:#0f172a; line-height:1;">
                    {{ $stats['total_tiket'] }}
                </div>
                <div class="text-muted mt-1" style="font-size:0.72rem;">Total Tiket di Sistem</div>
                <div class="mt-2 pt-2 border-top" style="font-size:0.68rem; color:#94a3b8;">
                    Semua periode
                </div>
            </div>
        </div>
    </div>

    {{-- Overdue --}}
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius:14px !important; overflow:hidden;
                    {{ $stats['overdue'] > 0 ? 'border:1px solid #fecaca !important;' : '' }}">
            <div class="card-body p-3"
                 style="{{ $stats['overdue'] > 0 ? 'background:#fff1f2;' : '' }}">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div style="width:42px; height:42px; border-radius:10px;
                                background:{{ $stats['overdue'] > 0 ? '#fee2e2' : '#f1f5f9' }};
                                display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-exclamation-triangle-fill {{ $stats['overdue'] > 0 ? 'overdue-badge' : '' }}"
                           style="color:{{ $stats['overdue'] > 0 ? '#dc2626' : '#94a3b8' }}; font-size:1.1rem;"></i>
                    </div>
                    <span style="font-size:0.68rem;
                                 background:{{ $stats['overdue'] > 0 ? '#fee2e2' : '#f1f5f9' }};
                                 color:{{ $stats['overdue'] > 0 ? '#b91c1c' : '#64748b' }};
                                 padding:2px 8px; border-radius:20px; font-weight:600;">
                        {{ $stats['overdue'] > 0 ? 'Perhatian' : 'Normal' }}
                    </span>
                </div>
                <div style="font-size:2rem; font-weight:800; line-height:1;
                            color:{{ $stats['overdue'] > 0 ? '#dc2626' : '#0f172a' }};">
                    {{ $stats['overdue'] }}
                </div>
                <div class="mt-1" style="font-size:0.72rem; color:#64748b;">Tiket Overdue</div>
                <div class="mt-2 pt-2 border-top" style="font-size:0.68rem;">
                    @if($stats['overdue'] > 0)
                        <span style="color:#dc2626; font-weight:600;">Segera tangani!</span>
                    @else
                        <span style="color:#16a34a;">Semua terkendali</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── QUICK ACCESS ── --}}
<div class="row g-3 mb-4">

    {{-- Kelola OPD --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div style="width:48px; height:48px; border-radius:12px;
                                background:linear-gradient(135deg,#0891b2,#06b6d4);
                                display:flex; align-items:center; justify-content:center;
                                flex-shrink:0; box-shadow:0 4px 12px rgba(8,145,178,.25);">
                        <i class="bi bi-buildings-fill text-white" style="font-size:1.25rem;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color:#0f172a;">Kelola OPD</h6>
                        <p class="text-muted mb-0" style="font-size:0.78rem;">
                            {{ $stats['total_opd'] }} OPD terdaftar di sistem
                        </p>
                    </div>
                </div>

                @if($stats['opd_tanpa_pic'] > 0)
                <div class="d-flex align-items-center gap-2 p-2 rounded-3 mb-3"
                     style="background:#fef3c7; border:1px solid #fde68a;">
                    <i class="bi bi-exclamation-triangle-fill" style="color:#d97706; font-size:0.82rem; flex-shrink:0;"></i>
                    <span style="font-size:0.75rem; color:#92400e; font-weight:500;">
                        {{ $stats['opd_tanpa_pic'] }} OPD belum memiliki PIC IT
                    </span>
                </div>
                @else
                <div class="d-flex align-items-center gap-2 p-2 rounded-3 mb-3"
                     style="background:#f0fdf4; border:1px solid #bbf7d0;">
                    <i class="bi bi-check-circle-fill" style="color:#16a34a; font-size:0.82rem; flex-shrink:0;"></i>
                    <span style="font-size:0.75rem; color:#15803d; font-weight:500;">
                        Semua OPD sudah memiliki PIC IT
                    </span>
                </div>
                @endif

                <a href="{{ route('admin.opd.index') }}"
                   class="btn btn-sm w-100 fw-semibold"
                   style="background:#0891b2; color:#fff; border:none; border-radius:8px; padding:0.55rem;">
                    <i class="bi bi-arrow-right-circle me-1"></i>Kelola OPD
                </a>
            </div>
        </div>
    </div>

    {{-- Kelola User --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div style="width:48px; height:48px; border-radius:12px;
                                background:linear-gradient(135deg,#2563eb,#7c3aed);
                                display:flex; align-items:center; justify-content:center;
                                flex-shrink:0; box-shadow:0 4px 12px rgba(37,99,235,.25);">
                        <i class="bi bi-person-badge-fill text-white" style="font-size:1.25rem;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color:#0f172a;">Kelola User</h6>
                        <p class="text-muted mb-0" style="font-size:0.78rem;">
                            {{ $stats['total_user'] }} akun pengguna terdaftar
                        </p>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <div class="text-center p-2 rounded-3" style="background:#eff6ff; border:1px solid #dbeafe;">
                            <div class="fw-bold" style="color:#2563eb; font-size:1.1rem;">{{ $stats['pic_opd'] }}</div>
                            <div style="font-size:0.62rem; color:#3b82f6; line-height:1.2;">PIC OPD</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center p-2 rounded-3" style="background:#faf5ff; border:1px solid #ddd6fe;">
                            <div class="fw-bold" style="color:#7c3aed; font-size:1.1rem;">{{ $stats['csirt'] }}</div>
                            <div style="font-size:0.62rem; color:#8b5cf6; line-height:1.2;">CSIRT</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center p-2 rounded-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
                            <div class="fw-bold" style="color:#475569; font-size:1.1rem;">{{ $stats['total_user'] - $stats['pic_opd'] - $stats['csirt'] }}</div>
                            <div style="font-size:0.62rem; color:#94a3b8; line-height:1.2;">Lainnya</div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.user.index') }}"
                   class="btn btn-sm w-100 fw-semibold"
                   style="background:linear-gradient(135deg,#2563eb,#7c3aed); color:#fff; border:none; border-radius:8px; padding:0.55rem;">
                    <i class="bi bi-arrow-right-circle me-1"></i>Kelola User
                </a>
            </div>
        </div>
    </div>

    {{-- Kategori & SLA --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div style="width:48px; height:48px; border-radius:12px;
                                background:linear-gradient(135deg,#d97706,#f59e0b);
                                display:flex; align-items:center; justify-content:center;
                                flex-shrink:0; box-shadow:0 4px 12px rgba(217,119,6,.25);">
                        <i class="bi bi-sliders2 text-white" style="font-size:1.25rem;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color:#0f172a;">Kategori &amp; SLA</h6>
                        <p class="text-muted mb-0" style="font-size:0.78rem;">
                            Konfigurasi jenis insiden &amp; batas waktu
                        </p>
                    </div>
                </div>

                @php
                    $slaList = \App\Models\SlaConfig::orderByRaw("FIELD(urgensi,'kritis','tinggi','sedang','rendah')")->get();
                    $slaColors = ['kritis'=>['#fee2e2','#dc2626'],'tinggi'=>['#fef3c7','#d97706'],'sedang'=>['#cffafe','#0891b2'],'rendah'=>['#dcfce7','#16a34a']];
                @endphp
                <div class="d-flex flex-column gap-2 mb-3">
                    @foreach($slaList as $sla)
                    @php [$bg, $tc] = $slaColors[$sla->urgensi] ?? ['#f1f5f9','#64748b']; @endphp
                    <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded-3"
                         style="background:{{ $bg }};">
                        <span style="font-size:0.75rem; color:{{ $tc }}; font-weight:600;">
                            {{ ucfirst($sla->urgensi) }}
                        </span>
                        <span class="fw-semibold" style="font-size:0.75rem; color:{{ $tc }};">
                            {{ $sla->durasi_jam }} jam
                        </span>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('admin.kategori.index') }}"
                   class="btn btn-sm w-100 fw-semibold"
                   style="background:#d97706; color:#fff; border:none; border-radius:8px; padding:0.55rem;">
                    <i class="bi bi-arrow-right-circle me-1"></i>Kelola Kategori &amp; SLA
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── TIKET TERBARU ── --}}
<div class="card border-0 shadow-sm" style="border-radius:14px !important;">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="border-radius:14px 14px 0 0 !important;">
        <h6 class="mb-0 fw-semibold">
            <i class="bi bi-clock-history me-2 text-primary"></i>Tiket Terbaru di Sistem
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
                        <th>OPD</th>
                        <th>Jenis Insiden</th>
                        <th>Urgensi</th>
                        <th>Status</th>
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
                        <td class="small">{{ Str::limit($t->opd->nama_opd ?? '-', 28) }}</td>
                        <td class="small">{{ $t->kategoriInsiden->nama ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $t->slaConfig->badge_color ?? 'secondary' }}">
                                {{ ucfirst($t->slaConfig->urgensi ?? '-') }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $t->status }}">{{ $t->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('tiket.show', $t) }}"
                               class="btn btn-sm btn-outline-secondary"
                               style="font-size:0.72rem;">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                            Belum ada tiket di sistem.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
