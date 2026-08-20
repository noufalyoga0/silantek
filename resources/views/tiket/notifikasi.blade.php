@extends('layouts.app')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')

@section('content')
<div class="page-header">
    <div class="mb-4" style="border-radius:16px; overflow:hidden; position:relative;
         background:linear-gradient(135deg,#0f172a 0%,#1e2a3a 50%,#374151 100%);
         padding:1.5rem 2rem;">
        <div style="position:absolute; top:-20px; right:-20px; width:120px; height:120px;
                    border-radius:50%; background:rgba(255,255,255,0.04);"></div>
        <div style="position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-bell-fill" style="color:#93c5fd; font-size:1rem;"></i>
                    <span style="color:rgba(255,255,255,0.6); font-size:0.78rem;">Pusat Notifikasi</span>
                </div>
                <h4 class="text-white fw-bold mb-1" style="font-size:1.3rem;">Notifikasi</h4>
                <p style="color:rgba(255,255,255,0.55); font-size:0.8rem; margin:0;">
                    Semua notifikasi terkait insiden keamanan TIK
                </p>
            </div>
            @if($notifikasi->total() > 0)
            <span class="badge px-3 py-2" style="background:rgba(255,255,255,0.15); color:#fff; font-size:0.78rem; border-radius:8px;">
                {{ $notifikasi->total() }} notifikasi
            </span>
            @endif
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @forelse($notifikasi as $notif)
        <div class="d-flex align-items-start gap-3 p-3 border-bottom position-relative
            {{ !$notif->is_read ? 'bg-white' : '' }}"
            style="{{ !$notif->is_read ? 'border-left: 3px solid #2563eb !important;' : 'border-left: 3px solid transparent !important;' }}">

            {{-- Icon --}}
            <div class="flex-shrink-0 mt-1">
                @php
                    $iconMap = [
                        'tiket_masuk'   => ['bi-ticket-perforated-fill', '#2563eb', '#dbeafe'],
                        'update_status' => ['bi-arrow-repeat',           '#0891b2', '#cffafe'],
                        'overdue'       => ['bi-exclamation-triangle-fill','#dc2626', '#fee2e2'],
                        'reopen'        => ['bi-arrow-counterclockwise', '#d97706', '#fef3c7'],
                        'selesai'       => ['bi-check-circle-fill',      '#16a34a', '#dcfce7'],
                    ];
                    $ic   = $iconMap[$notif->jenis_notifikasi] ?? ['bi-bell-fill', '#6b7280', '#f3f4f6'];
                    $iIcon  = $ic[0];
                    $iColor = $ic[1];
                    $iBg    = $ic[2];
                @endphp
                <div style="width:36px; height:36px; border-radius:10px; background:{{ $iBg }};
                            display:flex; align-items:center; justify-content:center;">
                    <i class="bi {{ $iIcon }}" style="color:{{ $iColor }}; font-size:0.95rem;"></i>
                </div>
            </div>

            {{-- Konten --}}
            <div class="flex-grow-1 min-w-0">
                <p class="mb-1 small {{ !$notif->is_read ? 'fw-semibold text-dark' : 'text-secondary' }}"
                   style="line-height:1.4;">
                    {{ $notif->pesan }}
                </p>
                @if($notif->tiket)
                <a href="{{ route('tiket.show', $notif->tiket) }}"
                   class="btn btn-sm btn-outline-primary py-0 px-2 mt-1"
                   style="font-size:0.72rem;">
                    <i class="bi bi-eye me-1"></i>Lihat Tiket {{ $notif->tiket->nomor_tiket }}
                </a>
                @endif
            </div>

            {{-- Waktu + badge --}}
            <div class="flex-shrink-0 text-end">
                <div class="text-muted" style="font-size:0.72rem; white-space:nowrap;">
                    {{ $notif->created_at->diffForHumans() }}
                </div>
                @if(!$notif->is_read)
                    <span class="badge mt-1 d-inline-block"
                          style="background:#dbeafe; color:#1d4ed8; font-size:0.65rem; border-radius:6px;">
                        Baru
                    </span>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <div style="width:64px; height:64px; background:#f1f5f9; border-radius:50%;
                        display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                <i class="bi bi-bell-slash fs-3 text-muted opacity-50"></i>
            </div>
            <p class="fw-semibold mb-1">Belum ada notifikasi</p>
            <p class="small text-muted mb-0">Notifikasi akan muncul saat ada aktivitas terkait tiket Anda</p>
        </div>
        @endforelse
    </div>

    @if($notifikasi->hasPages())
        <div class="p-3 border-top">
            {{ $notifikasi->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
