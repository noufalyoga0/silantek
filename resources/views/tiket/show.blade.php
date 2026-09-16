@extends('layouts.app')

@section('title', 'Detail Tiket')
@section('page-title', 'Detail Tiket ' . $tiket->nomor_tiket)

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>
            <i class="bi bi-ticket me-2 text-primary"></i>{{ $tiket->nomor_tiket }}
            <span class="badge badge-{{ $tiket->status }} ms-2">{{ $tiket->status_label }}</span>
            @if($tiket->is_overdue && !in_array($tiket->status,['resolved','closed']))
                <span class="badge bg-danger ms-1 overdue-badge">OVERDUE</span>
            @endif
        </h4>
        <p class="text-muted mb-0">Dilaporkan {{ $tiket->created_at->diffForHumans() }} &bull; {{ $tiket->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
    <a href="{{ route('tiket.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row g-3">
    <!-- KOLOM KIRI -->
    <div class="col-lg-8">

        <!-- IDENTITAS PELAPOR -->
        <div class="card border-0 shadow-sm mb-3" style="overflow:hidden;">
            {{-- Header gradient --}}
            <div style="background:linear-gradient(135deg,#1e3a5f,#2563eb); padding:1rem 1.25rem;">
                <h6 class="mb-0 fw-semibold text-white d-flex align-items-center gap-2">
                    <i class="bi bi-person-badge-fill"></i>Identitas Pelapor
                </h6>
                <p class="mb-0 mt-1 text-white" style="font-size:0.72rem; opacity:0.65;">
                    Data diambil otomatis dari akun pelapor saat laporan dibuat
                </p>
            </div>
            <div class="card-body p-3">
                <div class="row g-3">
                    {{-- Nama --}}
                    <div class="col-md-6">
                        <div style="background:#f8fafc; border-radius:10px; padding:0.75rem 1rem;
                                    border-left:3px solid #2563eb; border:1px solid #f1f5f9;
                                    border-left:3px solid #2563eb;">
                            <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.3rem;">
                                <i class="bi bi-person me-1"></i>Nama Lengkap
                            </div>
                            <div class="fw-semibold" style="font-size:0.875rem; color:#0f172a;">{{ $tiket->nama_pelapor }}</div>
                        </div>
                    </div>
                    {{-- NIP --}}
                    <div class="col-md-6">
                        <div style="background:#f8fafc; border-radius:10px; padding:0.75rem 1rem;
                                    border:1px solid #f1f5f9; border-left:3px solid #7c3aed;">
                            <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.3rem;">
                                <i class="bi bi-credit-card me-1"></i>NIP
                            </div>
                            <div class="fw-semibold" style="font-size:0.875rem; color:#0f172a;
                                        font-variant-numeric:tabular-nums; letter-spacing:0.5px;">
                                {{ $tiket->nip_pelapor }}
                            </div>
                        </div>
                    </div>
                    {{-- Jabatan --}}
                    <div class="col-md-6">
                        <div style="background:#f8fafc; border-radius:10px; padding:0.75rem 1rem;
                                    border:1px solid #f1f5f9; border-left:3px solid #0891b2;">
                            <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.3rem;">
                                <i class="bi bi-briefcase me-1"></i>Jabatan
                            </div>
                            <div class="fw-semibold" style="font-size:0.875rem; color:#0f172a;">{{ $tiket->jabatan_pelapor ?? '-' }}</div>
                        </div>
                    </div>
                    {{-- No HP --}}
                    <div class="col-md-6">
                        <div style="background:#f8fafc; border-radius:10px; padding:0.75rem 1rem;
                                    border:1px solid #f1f5f9; border-left:3px solid #16a34a;">
                            <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.3rem;">
                                <i class="bi bi-telephone me-1"></i>No. HP / WA
                            </div>
                            <div class="fw-semibold" style="font-size:0.875rem; color:#0f172a;">
                                @if($tiket->no_hp_pelapor)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $tiket->no_hp_pelapor) }}"
                                       target="_blank"
                                       class="text-decoration-none d-inline-flex align-items-center gap-1"
                                       style="color:#0f172a;">
                                        {{ $tiket->no_hp_pelapor }}
                                        <i class="bi bi-whatsapp" style="color:#22c55e; font-size:0.85rem;"></i>
                                    </a>
                                @else -
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- OPD full width --}}
                    <div class="col-12">
                        <div style="background:linear-gradient(135deg,#eff6ff,#f0f9ff); border-radius:10px;
                                    padding:0.85rem 1rem; border:1px solid #bfdbfe; border-left:3px solid #2563eb;">
                            <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.6px; color:#60a5fa; margin-bottom:0.3rem;">
                                <i class="bi bi-buildings me-1"></i>Organisasi Perangkat Daerah
                            </div>
                            <div class="fw-bold" style="font-size:0.95rem; color:#1e40af;">
                                {{ $tiket->opd->nama_opd ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DETAIL INSIDEN -->
        <div class="card border-0 shadow-sm mb-3" style="overflow:hidden;">
            {{-- Header gradient sesuai urgensi AKTIF (override jika ada) --}}
            @php
                $slaAktif  = $tiket->sla_aktif;
                $gradients = [
                    'kritis' => 'linear-gradient(135deg, #7f1d1d, #dc2626)',
                    'tinggi' => 'linear-gradient(135deg, #78350f, #d97706)',
                    'sedang' => 'linear-gradient(135deg, #164e63, #0891b2)',
                    'rendah' => 'linear-gradient(135deg, #14532d, #16a34a)',
                ];
                $grad = $gradients[$slaAktif->urgensi ?? 'rendah'] ?? $gradients['rendah'];
                $borderColors = ['kritis'=>'#dc2626','tinggi'=>'#d97706','sedang'=>'#0891b2','rendah'=>'#16a34a'];
                $borderColor  = $borderColors[$slaAktif->urgensi ?? 'rendah'] ?? '#64748b';
            @endphp
            <div style="background:{{ $grad }}; padding:1rem 1.25rem;">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-semibold text-white d-flex align-items-center gap-2">
                        <i class="bi bi-shield-exclamation"></i>Detail Insiden
                    </h6>
                    <div class="d-flex align-items-center gap-2">
                        @if($tiket->sudahDioverride())
                            {{-- Urgensi asal (coret) --}}
                            <span class="badge fw-bold"
                                  style="background:rgba(255,255,255,0.15); color:rgba(255,255,255,0.5);
                                         text-decoration:line-through; font-size:0.7rem;">
                                {{ ucfirst($tiket->slaConfig->urgensi ?? '-') }}
                            </span>
                            <i class="bi bi-arrow-right text-white" style="font-size:0.7rem; opacity:0.6;"></i>
                        @endif
                        {{-- Urgensi final --}}
                        <span class="badge text-white fw-bold px-3 py-2"
                              style="background:rgba(255,255,255,0.2); backdrop-filter:blur(4px);
                                     border-radius:8px; font-size:0.78rem;">
                            ⚡ {{ ucfirst($slaAktif->urgensi ?? '-') }}
                            @if($tiket->sudahDioverride())
                                <i class="bi bi-patch-check-fill ms-1" style="font-size:0.7rem;"></i>
                            @endif
                        </span>
                    </div>
                </div>
                @if($tiket->sudahDioverride())
                <div class="mt-1" style="font-size:0.7rem; color:rgba(255,255,255,0.55);">
                    <i class="bi bi-hourglass-split me-1"></i>Menunggu verifikasi urgensi oleh Tim CSIRT
                </div>
                @endif
            </div>
            <div class="card-body p-0">
                {{-- 2 info utama --}}
                <div class="d-flex border-bottom">
                    <div class="flex-fill p-3 border-end">
                        <div style="font-size:0.65rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.3rem;">
                            <i class="bi bi-tag me-1"></i>Jenis Insiden
                        </div>
                        <div class="fw-semibold" style="font-size:0.85rem;">
                            <span class="badge me-1" style="background:#f1f5f9; color:#475569; font-size:0.65rem;">
                                {{ $tiket->kategoriInsiden->kode ?? '-' }}
                            </span>
                            {{ $tiket->kategoriInsiden->nama ?? '-' }}
                        </div>
                    </div>
                    <div class="flex-fill p-3">
                        <div style="font-size:0.65rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.3rem;">
                            <i class="bi bi-calendar-event me-1"></i>Tanggal Kejadian
                        </div>
                        <div class="fw-semibold" style="font-size:0.875rem;">
                            {{ $tiket->tanggal_kejadian ? $tiket->tanggal_kejadian->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                </div>
                {{-- Deskripsi --}}
                <div class="p-3">
                    <div style="font-size:0.65rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.5rem;">
                        <i class="bi bi-file-text me-1"></i>Deskripsi Kejadian
                    </div>
                    <div style="background:#f8fafc; border-radius:10px; padding:0.85rem 1rem;
                                border-left:3px solid {{ $borderColor }};
                                font-size:0.85rem; color:#334155; white-space:pre-wrap; line-height:1.65;">{{ $tiket->deskripsi }}</div>
                </div>
            </div>
        </div>

        <!-- LAMPIRAN -->
        @if($tiket->lampiranTiket->count() > 0)
        <div class="card border-0 shadow-sm mb-3" style="overflow:hidden;">
            <div style="background:linear-gradient(135deg,#334155,#475569); padding:1rem 1.25rem;">
                <h6 class="mb-0 fw-semibold text-white d-flex align-items-center gap-2">
                    <i class="bi bi-paperclip"></i>Lampiran
                    <span class="badge ms-1" style="background:rgba(255,255,255,0.2); font-size:0.68rem;">
                        {{ $tiket->lampiranTiket->count() }} file
                    </span>
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    @foreach($tiket->lampiranTiket as $lamp)
                    @php
                        $isPdf   = str_contains($lamp->file_type ?? '', 'pdf');
                        $isImg   = str_contains($lamp->file_type ?? '', 'image');
                        $iconBg  = $isPdf ? '#fff1f0' : '#eff6ff';
                        $iconCl  = $isPdf ? '#ef4444' : '#2563eb';
                        $icon    = $isPdf ? 'bi-file-earmark-pdf-fill' : 'bi-file-earmark-image-fill';
                    @endphp
                    <div class="col-6 col-md-4">
                        <a href="{{ $lamp->url }}" target="_blank" class="text-decoration-none">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-3"
                                 style="background:#f8fafc; border:1px solid #e2e8f0; transition:all .15s;"
                                 onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#bfdbfe';"
                                 onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0';">
                                <div style="width:36px; height:36px; border-radius:8px; background:{{ $iconBg }};
                                            display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="bi {{ $icon }}" style="color:{{ $iconCl }}; font-size:1rem;"></i>
                                </div>
                                <div style="overflow:hidden; min-width:0;">
                                    <div class="fw-semibold text-truncate" style="font-size:0.78rem; color:#0f172a;">
                                        {{ $lamp->file_name ?? 'File' }}
                                    </div>
                                    <div style="font-size:0.65rem; color:#94a3b8;">
                                        Klik untuk buka
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- TIMELINE LOG STATUS -->
        <div class="card border-0 shadow-sm" style="overflow:hidden;">
            <div style="background:linear-gradient(135deg,#1e2a3a,#1e3a5f); padding:1rem 1.25rem;">
                <h6 class="mb-0 fw-semibold text-white d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history"></i>Timeline Penanganan
                    <span class="badge ms-1" style="background:rgba(255,255,255,0.15); font-size:0.65rem;">
                        {{ $tiket->logStatus->count() }} aktivitas
                    </span>
                </h6>
            </div>
            <div class="card-body py-3 px-4">
                @foreach($tiket->logStatus as $index => $log)
                @php
                    $isLast = $index === $tiket->logStatus->count() - 1;
                    $dotConfig = match($log->status_baru) {
                        'open'        => ['#dbeafe', '#2563eb', 'bi-ticket-perforated-fill'],
                        'triase'      => ['#fef3c7', '#d97706', 'bi-search'],
                        'in_progress' => ['#cffafe', '#0891b2', 'bi-tools'],
                        'resolved'    => ['#dcfce7', '#16a34a', 'bi-check-circle-fill'],
                        'reopen'      => ['#fee2e2', '#dc2626', 'bi-arrow-counterclockwise'],
                        'closed'      => ['#f1f5f9', '#475569', 'bi-lock-fill'],
                        default       => ['#f1f5f9', '#94a3b8', 'bi-circle-fill'],
                    };
                @endphp
                <div class="d-flex gap-3 {{ $isLast ? '' : 'mb-0' }}" style="position:relative;">

                    {{-- Kolom kiri: dot + connector --}}
                    <div class="d-flex flex-column align-items-center flex-shrink-0" style="width:32px;">
                        {{-- Dot buletan berwarna --}}
                        <div style="width:32px; height:32px; border-radius:50%;
                                    background:{{ $dotConfig[0] }};
                                    border:2px solid {{ $dotConfig[1] }};
                                    display:flex; align-items:center; justify-content:center;
                                    flex-shrink:0; position:relative; z-index:1;">
                            <i class="bi {{ $dotConfig[2] }}" style="font-size:0.75rem; color:{{ $dotConfig[1] }};"></i>
                        </div>
                        {{-- Connector garis ke bawah (kecuali item terakhir) --}}
                        @if(!$isLast)
                        <div style="width:2px; flex:1; min-height:24px;
                                    background:linear-gradient(to bottom, {{ $dotConfig[1] }}60, #e2e8f0);
                                    margin:3px 0;"></div>
                        @endif
                    </div>

                    {{-- Kolom kanan: konten --}}
                    <div class="{{ $isLast ? 'pb-0' : 'pb-4' }} flex-grow-1">
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-2" style="margin-top:4px;">
                            {{-- Badge warna dari dotConfig --}}
                            <span class="fw-semibold px-2 py-1"
                                  style="background:{{ $dotConfig[0] }}; color:{{ $dotConfig[1] }};
                                         border-radius:6px; font-size:0.72rem;">
                                {{ $log->status_baru_label }}
                            </span>
                            <span style="font-size:0.72rem; color:#94a3b8;">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </span>
                            <span style="font-size:0.72rem; color:#cbd5e1;">·</span>
                            <span style="font-size:0.72rem; font-weight:600; color:#475569;">
                                {{ $log->pengubah->nama ?? '-' }}
                            </span>
                        </div>
                        @if($log->catatan)
                        <div style="background:#f8fafc; border-radius:10px; padding:0.65rem 0.85rem;
                                    border-left:3px solid {{ $dotConfig[1] }};
                                    font-size:0.82rem; color:#334155; white-space:pre-wrap; line-height:1.55;">
                            {{ $log->catatan }}
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Entri override urgensi: muncul tepat setelah log triase --}}
                @if($log->status_baru === 'triase' && $tiket->sudahDioverride())
                <div class="d-flex gap-3 mb-0" style="position:relative;">
                    {{-- Dot --}}
                    <div class="d-flex flex-column align-items-center flex-shrink-0" style="width:32px;">
                        <div style="width:32px; height:32px; border-radius:50%;
                                    background:#fef3c7; border:2px solid #d97706;
                                    display:flex; align-items:center; justify-content:center;
                                    flex-shrink:0; position:relative; z-index:1;">
                            <i class="bi bi-arrow-left-right" style="font-size:0.75rem; color:#d97706;"></i>
                        </div>
                        {{-- Connector ke bawah jika masih ada log setelahnya --}}
                        @if(!$isLast)
                        <div style="width:2px; flex:1; min-height:24px;
                                    background:linear-gradient(to bottom, #d97706aa, #e2e8f0);
                                    margin:3px 0;"></div>
                        @endif
                    </div>
                    {{-- Konten --}}
                    <div class="{{ $isLast ? 'pb-0' : 'pb-4' }} flex-grow-1">
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-2" style="margin-top:4px;">
                            <span class="fw-semibold px-2 py-1"
                                  style="background:#fef3c7; color:#d97706; border-radius:6px; font-size:0.72rem;">
                                Verifikasi Urgensi
                            </span>
                            <span style="font-size:0.72rem; color:#94a3b8;">oleh Tim CSIRT saat Triase</span>
                        </div>
                        <div style="background:#fffbeb; border-radius:10px; padding:0.65rem 0.85rem;
                                    border-left:3px solid #d97706; font-size:0.82rem; color:#334155; line-height:1.55;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span style="font-size:0.75rem; color:#78350f;">Urgensi diubah dari</span>
                                <span class="badge fw-bold" style="background:#fee2e2; color:#dc2626; font-size:0.7rem;">
                                    {{ ucfirst($tiket->slaConfig->urgensi ?? '-') }}
                                </span>
                                <i class="bi bi-arrow-right" style="color:#d97706; font-size:0.7rem;"></i>
                                <span class="badge fw-bold" style="background:#dcfce7; color:#16a34a; font-size:0.7rem;">
                                    {{ ucfirst($tiket->slaConfigOverride->urgensi ?? '-') }}
                                </span>
                            </div>
                            @if($tiket->catatan_triase)
                            <div style="font-size:0.78rem; color:#92400e; margin-top:4px;">
                                <i class="bi bi-chat-quote me-1"></i>"{{ $tiket->catatan_triase }}"
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @endforeach

            </div>
        </div>
    </div>

    <!-- KOLOM KANAN -->
    <div class="col-lg-4">

        <!-- INFO SLA -->
        <div class="card border-0 shadow-sm mb-3" id="slaCard" style="overflow:hidden;">
            {{-- Header SLA --}}
            @php
                $slaHeaderBg = $tiket->is_overdue && !in_array($tiket->status,['resolved','closed'])
                    ? 'linear-gradient(135deg,#7f1d1d,#dc2626)'
                    : 'linear-gradient(135deg,#1e3a5f,#2563eb)';
            @endphp
            <div id="slaCardHeader" style="background:{{ $slaHeaderBg }}; padding:1rem 1.25rem;">
                <h6 class="mb-0 fw-semibold text-white d-flex align-items-center gap-2" id="slaCardTitle">
                    <i class="bi bi-clock"></i>Informasi SLA
                    @if($tiket->is_overdue && !in_array($tiket->status,['resolved','closed']))
                        <span class="badge overdue-badge ms-auto" style="background:rgba(255,255,255,0.25); font-size:0.65rem;">⚠ OVERDUE</span>
                    @endif
                </h6>
            </div>

            <div class="card-body p-3" style="font-size:0.82rem;">

                {{-- Mini cards: Dilaporkan + Deadline --}}
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div style="background:#f8fafc; border-radius:10px; padding:0.6rem 0.75rem; border:1px solid #f1f5f9;">
                            <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.5px; color:#94a3b8; margin-bottom:0.25rem;">
                                <i class="bi bi-send me-1"></i>Dilaporkan
                            </div>
                            <div class="fw-semibold" style="font-size:0.78rem; color:#0f172a;">{{ $tiket->created_at->format('d/m/Y') }}</div>
                            <div style="font-size:0.7rem; color:#2563eb; font-weight:600;">{{ $tiket->created_at->format('H:i:s') }}</div>
                            <div style="font-size:0.68rem; color:#94a3b8; margin-top:2px;">{{ $tiket->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:{{ $tiket->is_overdue && !in_array($tiket->status,['resolved','closed']) ? '#fff1f2' : '#f8fafc' }}; border-radius:10px; padding:0.6rem 0.75rem; border:1px solid {{ $tiket->is_overdue && !in_array($tiket->status,['resolved','closed']) ? '#fecdd3' : '#f1f5f9' }};">
                            <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.5px; color:#94a3b8; margin-bottom:0.25rem;">
                                <i class="bi bi-flag me-1"></i>Deadline SLA
                            </div>
                            @if($tiket->sla_deadline)
                            <div class="fw-semibold" style="font-size:0.78rem; color:{{ $tiket->is_overdue && !in_array($tiket->status,['resolved','closed']) ? '#dc2626' : '#0f172a' }};">
                                {{ $tiket->sla_deadline->format('d/m/Y') }}
                            </div>
                            <div style="font-size:0.7rem; font-weight:600; color:{{ $tiket->is_overdue && !in_array($tiket->status,['resolved','closed']) ? '#dc2626' : '#2563eb' }};">
                                {{ $tiket->sla_deadline->format('H:i:s') }}
                            </div>
                            <div style="font-size:0.68rem; color:#94a3b8; margin-top:2px;">
                                {{ ucfirst($tiket->slaConfig->urgensi ?? '-') }} · {{ $tiket->slaConfig->durasi_jam ?? '-' }} jam
                            </div>
                            @else
                            <div class="text-muted">-</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Countdown realtime (hanya jika tiket aktif) --}}
                @if(!in_array($tiket->status, ['resolved','closed']) && $tiket->sla_deadline)
                <div class="mb-3 pb-2 border-bottom">
                    <span class="text-muted d-block mb-1" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">
                        {{ $tiket->is_overdue ? 'Keterlambatan' : 'Sisa Waktu SLA' }}
                    </span>

                    {{-- Countdown display --}}
                    <div id="slaCountdown"
                         class="fw-bold"
                         style="font-size:1.35rem; font-variant-numeric:tabular-nums; letter-spacing:-0.5px; color:{{ $tiket->is_overdue ? '#dc2626' : '#16a34a' }};">
                        --:--:--
                    </div>

                    {{-- Progress bar SLA --}}
                    @php
                        $totalDetik  = $tiket->slaConfig->durasi_jam * 3600;
                        $sisaDetik   = max(0, now()->diffInSeconds($tiket->sla_deadline, false));
                        $persen      = $tiket->is_overdue ? 0 : round(($sisaDetik / $totalDetik) * 100);
                        $barColor    = $persen > 50 ? '#22c55e' : ($persen > 20 ? '#f59e0b' : '#ef4444');
                    @endphp
                    <div class="mt-2" style="background:#f1f5f9; border-radius:6px; height:6px; overflow:hidden;">
                        <div id="slaProgressBar"
                             style="height:100%; width:{{ $persen }}%; background:{{ $barColor }}; border-radius:6px; transition:width 1s linear;"></div>
                    </div>
                    {{-- Label intuitif bawah progress bar --}}
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span style="font-size:0.68rem; color:#94a3b8;">Deadline</span>
                        <span id="slaPersenText" class="fw-semibold"
                              style="font-size:0.72rem; color:{{ $barColor }};">
                            {{ $persen }}% tersisa
                        </span>
                        <span style="font-size:0.68rem; color:#94a3b8;">Waktu mulai</span>
                    </div>
                </div>
                @endif

                {{-- Diselesaikan --}}
                @if($tiket->resolved_at)
                <div class="mb-2 pb-2 border-bottom">
                    <span class="text-muted d-block" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">Diselesaikan</span>
                    <div class="fw-semibold text-success">{{ $tiket->resolved_at->format('d/m/Y H:i:s') }}</div>
                </div>
                <div class="mb-0">
                    <span class="text-muted d-block" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">Durasi Penanganan</span>
                    <div class="fw-semibold">
                        @php
                            $menitTotal = (int) $tiket->created_at->diffInMinutes($tiket->resolved_at);
                            $jamDur     = intdiv($menitTotal, 60);
                            $menitDur   = $menitTotal % 60;
                        @endphp
                        @if($jamDur > 0){{ $jamDur }} jam @endif{{ $menitDur }} menit
                    </div>
                </div>
                @endif

            </div>
        </div>

        <!-- AKSI CSIRT: UPDATE STATUS -->
        @if(auth()->user()->isCsirt() && in_array($tiket->status, ['open','triase','in_progress','reopen']))
        <div class="card border-0 shadow-sm mb-3" style="overflow:hidden;">
            <div style="background:linear-gradient(135deg,#1e3a5f,#2563eb); padding:1rem 1.25rem;">
                <h6 class="mb-0 fw-semibold text-white d-flex align-items-center gap-2">
                    <i class="bi bi-tools"></i>Update Status Penanganan
                </h6>
                <p class="mb-0 mt-1 text-white" style="font-size:0.72rem; opacity:0.7;">
                    Perbarui progress penanganan insiden ini
                </p>
            </div>
            <div class="card-body p-3">
                <form action="{{ route('tiket.update-status', $tiket) }}" method="POST">
                    @csrf
                    {{-- Pilih Status --}}
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Status Baru <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex flex-column gap-2">
                            @if(in_array($tiket->status, ['open']))
                            <label class="d-flex align-items-center gap-2 p-2 rounded-3 cursor-pointer"
                                   style="border:2px solid #e2e8f0; cursor:pointer; transition:all .15s;"
                                   onmouseover="this.style.borderColor='#d97706'; this.style.background='#fefce8'"
                                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.background=''">
                                <input type="radio" name="status" value="triase" class="form-check-input mt-0" required>
                                <div>
                                    <div class="fw-semibold small">Triase</div>
                                    <div style="font-size:0.68rem; color:#94a3b8;">Sedang memeriksa tingkat keparahan</div>
                                </div>
                                <span class="badge ms-auto" style="background:#fef3c7; color:#92400e;">Triase</span>
                            </label>
                            @endif
                            @if(in_array($tiket->status, ['triase','reopen']))
                            <label class="d-flex align-items-center gap-2 p-2 rounded-3"
                                   style="border:2px solid #e2e8f0; cursor:pointer; transition:all .15s;"
                                   onmouseover="this.style.borderColor='#0891b2'; this.style.background='#ecfeff'"
                                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.background=''">
                                <input type="radio" name="status" value="in_progress" class="form-check-input mt-0">
                                <div>
                                    <div class="fw-semibold small">In Progress</div>
                                    <div style="font-size:0.68rem; color:#94a3b8;">Sedang aktif ditangani</div>
                                </div>
                                <span class="badge ms-auto" style="background:#cffafe; color:#0e7490;">In Progress</span>
                            </label>
                            @endif
                            @if(in_array($tiket->status, ['in_progress','reopen']))
                            <label class="d-flex align-items-center gap-2 p-2 rounded-3"
                                   style="border:2px solid #e2e8f0; cursor:pointer; transition:all .15s;"
                                   onmouseover="this.style.borderColor='#16a34a'; this.style.background='#f0fdf4'"
                                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.background=''">
                                <input type="radio" name="status" value="resolved" class="form-check-input mt-0">
                                <div>
                                    <div class="fw-semibold small">Resolved</div>
                                    <div style="font-size:0.68rem; color:#94a3b8;">Insiden selesai ditangani</div>
                                </div>
                                <span class="badge ms-auto" style="background:#dcfce7; color:#15803d;">Resolved</span>
                            </label>
                            @endif
                        </div>
                    </div>
                    {{-- Catatan --}}
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Catatan Teknis <span class="text-danger">*</span>
                        </label>
                        <textarea name="catatan"
                                  class="form-control form-control-sm"
                                  rows="4"
                                  placeholder="Jelaskan tindakan yang telah dilakukan untuk menangani insiden ini..."
                                  required id="catatanCsirt"
                                  oninput="updateCatatanHint(this.value)"></textarea>
                        <div class="form-text small d-flex justify-content-between mt-1">
                            <span id="catatanHint" style="color:#94a3b8; font-variant-numeric:tabular-nums;">0 karakter</span>
                        </div>
                    </div>

                    {{-- ── OVERRIDE URGENSI (muncul saat pilih Triase) ── --}}
                    <div id="sectionOverride" style="display:none;" class="mb-3">
                        <div class="p-3 rounded-3 mb-3"
                             style="background:linear-gradient(135deg,#fef3c7,#fffbeb); border:1px solid #fde68a;">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-shield-check text-warning mt-1 flex-shrink-0" style="font-size:1rem;"></i>
                                <div>
                                    <div class="fw-semibold small" style="color:#92400e;">
                                        Verifikasi Urgensi oleh Tim CSIRT
                                    </div>
                                    <div style="font-size:0.72rem; color:#78350f; margin-top:2px; line-height:1.5;">
                                        Pelapor mengklaim urgensi
                                        <strong>{{ ucfirst($tiket->slaConfig->urgensi ?? '-') }}</strong>
                                        (SLA: {{ $tiket->slaConfig->durasi_jam ?? '-' }} jam).
                                        Setelah triase, apakah tingkat urgensi ini sudah tepat?
                                    </div>
                                </div>
                            </div>
                        </div>

                        <label class="form-label small fw-semibold mb-2">
                            Urgensi Final
                            <span class="text-muted fw-normal">(kosongkan jika sudah tepat)</span>
                        </label>

                        @php
                            $slaAll = \App\Models\SlaConfig::orderByRaw("FIELD(urgensi,'rendah','sedang','tinggi','kritis')")->get();
                            $overrideColors = [
                                'rendah' => ['#f0fdf4','#dcfce7','#16a34a'],
                                'sedang' => ['#ecfeff','#cffafe','#0891b2'],
                                'tinggi' => ['#fefce8','#fef3c7','#d97706'],
                                'kritis' => ['#fff1f2','#fee2e2','#dc2626'],
                            ];
                        @endphp

                        {{-- Opsi: tidak override --}}
                        <div class="mb-2">
                            <label class="d-flex align-items-center gap-2 p-2 rounded-3"
                                   id="labelNoOverride"
                                   style="border:2px solid #2563eb; cursor:pointer; background:#eff6ff;">
                                <input type="radio" name="sla_config_override_id" value=""
                                       class="form-check-input mt-0" id="radioNoOverride"
                                       checked onchange="selectOverride(null)">
                                <div>
                                    <div class="fw-semibold small" style="color:#2563eb;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Urgensi Tepat
                                    </div>
                                    <div style="font-size:0.68rem; color:#3b82f6;">
                                        Tidak perlu diubah — {{ ucfirst($tiket->slaConfig->urgensi ?? '-') }} sudah sesuai
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="row g-2 mb-2">
                            @foreach($slaAll as $sla)
                            @php [$bgLight, $bg, $tc] = $overrideColors[$sla->urgensi] ?? ['#f8fafc','#f1f5f9','#475569']; @endphp
                            <div class="col-6">
                                <label class="d-flex align-items-center gap-2 p-2 rounded-3 h-100"
                                       id="labelOverride{{ $sla->id }}"
                                       style="border:2px solid {{ $bg }}; cursor:pointer;
                                              background:{{ $bgLight }}; transition:all .15s;">
                                    <input type="radio" name="sla_config_override_id"
                                           value="{{ $sla->id }}"
                                           class="form-check-input mt-0"
                                           onchange="selectOverride({{ $sla->id }})">
                                    <div>
                                        <div class="fw-bold small" style="color:{{ $tc }};">
                                            {{ ucfirst($sla->urgensi) }}
                                        </div>
                                        <div style="font-size:0.65rem; color:{{ $tc }}; opacity:0.8;">
                                            SLA: {{ $sla->durasi_jam }} jam
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        {{-- Alasan override --}}
                        <div id="boxAlasanOverride" style="display:none;">
                            <label class="form-label small fw-semibold">
                                Alasan Perubahan Urgensi <span class="text-danger">*</span>
                            </label>
                            <textarea name="catatan_triase"
                                      class="form-control form-control-sm"
                                      rows="2"
                                      id="inputCatatanTriase"
                                      placeholder="Contoh: Website masih bisa diakses sebagian, diturunkan dari Kritis ke Sedang."
                                      maxlength="500"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="bi bi-check-circle-fill me-2"></i>Perbarui Status
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- AKSI PIC OPD: KONFIRMASI SELESAI -->
        @if(auth()->user()->isPicOpd() && $tiket->status === 'resolved')
        <div class="card border-0 shadow-sm mb-3" style="overflow:hidden;">
            <div style="background:linear-gradient(135deg,#14532d,#16a34a); padding:1rem 1.25rem;">
                <h6 class="mb-0 fw-semibold text-white d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i>Konfirmasi Penyelesaian
                </h6>
                <p class="mb-0 mt-1 text-white" style="font-size:0.72rem; opacity:0.75;">
                    Tim CSIRT telah menyelesaikan penanganan insiden ini
                </p>
            </div>
            <div class="card-body p-3">
                <div class="d-flex align-items-start gap-2 p-3 rounded-3 mb-3"
                     style="background:#f0fdf4; border:1px solid #bbf7d0;">
                    <i class="bi bi-info-circle-fill text-success mt-1 flex-shrink-0"></i>
                    <p class="mb-0 small" style="color:#15803d; line-height:1.5;">
                        Apakah insiden di OPD Anda sudah benar-benar selesai?
                        Jika belum, klik "Belum Selesai" untuk meminta CSIRT menangani ulang.
                    </p>
                </div>
                <form action="{{ route('tiket.konfirmasi', $tiket) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Catatan
                            <span class="badge" style="background:#f1f5f9; color:#64748b; font-size:0.65rem; font-weight:500;">Opsional</span>
                        </label>
                        <textarea name="catatan" class="form-control form-control-sm" rows="2"
                            placeholder="Contoh: Website sudah kembali normal, terima kasih."></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="keputusan" value="setuju"
                                class="btn fw-semibold"
                                style="background:linear-gradient(135deg,#16a34a,#15803d); color:#fff; border:none; padding:0.65rem;">
                            <i class="bi bi-check-lg me-2"></i>Ya, Insiden Sudah Selesai
                        </button>
                        <button type="submit" name="keputusan" value="tolak"
                                class="btn btn-outline-danger fw-semibold"
                                style="padding:0.65rem;"
                                onclick="return confirm('Yakin ingin reopen tiket ini? Tim CSIRT akan menangani ulang.')">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Belum Selesai — Reopen
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- STATUS SUDAH CLOSED -->
        @if($tiket->status === 'closed')
        <div class="card border-0 shadow-sm mb-3" style="overflow:hidden;">
            <div style="background:linear-gradient(135deg,#1e293b,#334155); padding:1.5rem; text-align:center;">
                <div style="width:56px; height:56px; background:rgba(255,255,255,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 0.75rem;">
                    <i class="bi bi-lock-fill text-white" style="font-size:1.5rem;"></i>
                </div>
                <h6 class="fw-bold text-white mb-1">Tiket Ditutup</h6>
                <p class="mb-0 text-white" style="font-size:0.75rem; opacity:0.6;">
                    Insiden selesai &amp; dikonfirmasi PIC OPD<br>
                    {{ $tiket->closed_at ? $tiket->closed_at->format('d/m/Y H:i:s') : '' }}
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
@if(!in_array($tiket->status, ['resolved','closed']) && $tiket->sla_deadline)
<script>
(function() {
    // Deadline dalam milidetik (dari server, sudah WIB)
    const deadlineMs   = {{ $tiket->sla_deadline->valueOf() }};
    const totalDetik   = {{ $tiket->slaConfig->durasi_jam * 3600 }};
    const isOverdue    = {{ $tiket->is_overdue ? 'true' : 'false' }};

    const elCountdown  = document.getElementById('slaCountdown');
    const elBar        = document.getElementById('slaProgressBar');
    const elPersen     = document.getElementById('slaPersenText');

    function pad(n) { return String(n).padStart(2, '0'); }

    function tick() {
        const nowMs  = Date.now();
        const diffMs = deadlineMs - nowMs; // positif = sisa, negatif = overdue
        const totalMs = totalDetik * 1000;

        let hh, mm, ss;

        if (diffMs > 0) {
            // Masih dalam SLA
            const sisaDetik = Math.floor(diffMs / 1000);
            hh = Math.floor(sisaDetik / 3600);
            mm = Math.floor((sisaDetik % 3600) / 60);
            ss = sisaDetik % 60;

            elCountdown.style.color = hh === 0 && mm < 30 ? '#f59e0b' : '#16a34a';
            elCountdown.textContent = `${pad(hh)}:${pad(mm)}:${pad(ss)}`;

            // Progress bar
            const persen = Math.max(0, Math.min(100, Math.round((diffMs / totalMs) * 100)));
            const barColor = persen > 50 ? '#22c55e' : (persen > 20 ? '#f59e0b' : '#ef4444');
            if (elBar) {
                elBar.style.width   = persen + '%';
                elBar.style.background = barColor;
            }
            if (elPersen) {
                elPersen.textContent   = persen + '% tersisa';
                elPersen.style.color   = barColor;
            }

        } else {
            // OVERDUE — tampilkan keterlambatan
            const terlambatDetik = Math.floor(Math.abs(diffMs) / 1000);
            hh = Math.floor(terlambatDetik / 3600);
            mm = Math.floor((terlambatDetik % 3600) / 60);
            ss = terlambatDetik % 60;

            elCountdown.style.color   = '#dc2626';
            elCountdown.textContent   = `+${pad(hh)}:${pad(mm)}:${pad(ss)}`;
            if (elBar) { elBar.style.width = '0%'; elBar.style.background = '#ef4444'; }
            if (elPersen) {
                elPersen.textContent = 'Waktu habis';
                elPersen.style.color = '#dc2626';
            }

            // Flash card merah kalau baru overdue
            const card = document.getElementById('slaCard');
            const header = document.getElementById('slaCardHeader');
            if (card && !card.classList.contains('border-danger')) {
                card.classList.add('border-danger');
                if (header) header.style.background = '#fee2e2';
            }
        }
    }

    tick();
    setInterval(tick, 1000);
})();
</script>
@endif

<script>
function updateCatatanHint(val) {
    const hint = document.getElementById('catatanHint');
    if (!hint) return;
    const n = val.length;
    if (n === 0) { hint.textContent = '0 karakter'; hint.style.color = '#94a3b8'; }
    else if (n < 10) { hint.textContent = n + ' karakter (kurang ' + (10-n) + ' lagi)'; hint.style.color = '#dc2626'; }
    else { hint.textContent = n + ' karakter ✓'; hint.style.color = '#16a34a'; }
}

// ── TOGGLE SECTION OVERRIDE ──────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[name="status"]').forEach(r => {
        r.addEventListener('change', function () {
            const box = document.getElementById('sectionOverride');
            if (!box) return;
            if (this.value === 'triase') {
                box.style.display = 'block';
            } else {
                box.style.display = 'none';
                resetOverride();
            }
        });
    });
});

function selectOverride(slaId) {
    // Reset semua label style
    document.querySelectorAll('[id^="labelOverride"]').forEach(el => {
        el.style.opacity    = '0.6';
        el.style.transform  = 'scale(0.98)';
        el.style.boxShadow  = '';
    });

    const labelNoOverride = document.getElementById('labelNoOverride');
    const boxAlasan       = document.getElementById('boxAlasanOverride');
    const inputCatatan    = document.getElementById('inputCatatanTriase');

    if (slaId === null) {
        // Pilih "Tepat"
        if (labelNoOverride) {
            labelNoOverride.style.borderColor = '#2563eb';
            labelNoOverride.style.background  = '#eff6ff';
        }
        document.querySelectorAll('[id^="labelOverride"]').forEach(el => {
            el.style.opacity   = '1';
            el.style.transform = 'scale(1)';
        });
        if (boxAlasan) boxAlasan.style.display = 'none';
        if (inputCatatan) { inputCatatan.required = false; inputCatatan.value = ''; }
        return;
    }

    // Pilih salah satu urgensi override
    if (labelNoOverride) {
        labelNoOverride.style.borderColor = '#e2e8f0';
        labelNoOverride.style.background  = '#fff';
    }

    const selectedLabel = document.getElementById('labelOverride' + slaId);
    if (selectedLabel) {
        selectedLabel.style.opacity    = '1';
        selectedLabel.style.transform  = 'scale(1.02)';
        selectedLabel.style.boxShadow  = '0 0 0 3px rgba(37,99,235,0.15)';
    }

    // Tampilkan kotak alasan
    if (boxAlasan) boxAlasan.style.display = 'block';
    if (inputCatatan) inputCatatan.required = true;
}

function resetOverride() {
    document.querySelectorAll('input[name="sla_config_override_id"]').forEach(r => r.checked = false);
    const noOverride = document.getElementById('radioNoOverride');
    if (noOverride) noOverride.checked = true;
    selectOverride(null);
}
</script>
@endpush
