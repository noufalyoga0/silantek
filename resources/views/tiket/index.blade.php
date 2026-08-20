@extends('layouts.app')

@section('title', 'Daftar Tiket')
@section('page-title', auth()->user()->isPicOpd() ? 'Tiket Saya' : 'Kelola Tiket')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    {{-- Hero Banner --}}
    <div class="w-100 mb-4" style="border-radius:16px; overflow:hidden; position:relative;
         background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 50%,#2563eb 100%);
         padding:1.5rem 2rem;">
        <div style="position:absolute; top:-20px; right:-20px; width:140px; height:140px;
                    border-radius:50%; background:rgba(255,255,255,0.05);"></div>
        <div style="position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-ticket-perforated-fill" style="color:#93c5fd; font-size:1rem;"></i>
                    <span style="color:rgba(255,255,255,0.6); font-size:0.78rem;">
                        {{ auth()->user()->isPicOpd() ? 'Riwayat Laporan OPD Anda' : 'Manajemen Tiket Insiden' }}
                    </span>
                </div>
                <h4 class="text-white fw-bold mb-1" style="font-size:1.3rem;">
                    {{ auth()->user()->isPicOpd() ? 'Tiket Saya' : 'Kelola Tiket' }}
                </h4>
                <p style="color:rgba(255,255,255,0.55); font-size:0.8rem; margin:0;">
                    Daftar semua laporan insiden keamanan TIK
                </p>
            </div>
            @if(auth()->user()->isPicOpd())
            <a href="{{ route('tiket.create') }}"
               class="btn fw-semibold"
               style="background:rgba(255,255,255,0.15); color:#fff;
                      border:1px solid rgba(255,255,255,0.25); border-radius:10px;
                      white-space:nowrap;"
               onmouseover="this.style.background='rgba(255,255,255,0.25)'"
               onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                <i class="bi bi-plus-circle me-1"></i>Laporkan Insiden
            </a>
            @endif
        </div>
    </div>
</div>

<!-- FILTER -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('tiket.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="No. tiket / deskripsi..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach(['open','triase','in_progress','resolved','reopen','closed'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_',' ',$s)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Urgensi</label>
                <select name="urgensi" class="form-select form-select-sm">
                    <option value="">Semua Urgensi</option>
                    @foreach(['rendah','sedang','tinggi','kritis'] as $u)
                        <option value="{{ $u }}" {{ request('urgensi') == $u ? 'selected' : '' }}>
                            {{ ucfirst($u) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
            @if(request()->hasAny(['search','status','urgensi','opd_id']))
                <div class="col-md-1">
                    <a href="{{ route('tiket.index') }}" class="btn btn-outline-secondary btn-sm w-100">Reset</a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- TABEL -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">No. Tiket</th>
                        @if(!auth()->user()->isPicOpd())
                            <th>OPD Pelapor</th>
                        @endif
                        <th>Jenis Insiden</th>
                        <th>Urgensi</th>
                        <th>Status</th>
                        <th>SLA Deadline</th>
                        <th>Tanggal Lapor</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tiket as $t)
                    <tr class="{{ $t->is_overdue && !in_array($t->status,['resolved','closed']) ? 'overdue-row' : '' }}">
                        <td class="ps-3">
                            <div class="fw-semibold">{{ $t->nomor_tiket }}</div>
                            @if($t->is_overdue && !in_array($t->status,['resolved','closed']))
                                <span class="badge bg-danger overdue-badge" style="font-size:0.65rem;">OVERDUE</span>
                            @endif
                        </td>
                        @if(!auth()->user()->isPicOpd())
                            <td class="small text-muted">{{ $t->opd->nama_opd ?? '-' }}</td>
                        @endif
                        <td class="small">{{ $t->kategoriInsiden->nama ?? '-' }}</td>
                        <td>
                            @php $slaFinal = $t->slaConfigOverride ?? $t->slaConfig; @endphp
                            <span class="badge bg-{{ $slaFinal->badge_color ?? 'secondary' }}">
                                {{ ucfirst($slaFinal->urgensi ?? '-') }}
                            </span>
                            @if($t->sudahDioverride())
                                <i class="bi bi-patch-check-fill text-primary ms-1"
                                   style="font-size:0.65rem;"
                                   title="Diverifikasi CSIRT dari {{ ucfirst($t->slaConfig->urgensi ?? '-') }}"></i>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $t->status }}">{{ $t->status_label }}</span>
                        </td>
                        <td class="small {{ $t->is_overdue && !in_array($t->status,['resolved','closed']) ? 'text-danger fw-bold' : 'text-muted' }}">
                            @if($t->sla_deadline)
                                {{ $t->sla_deadline->format('d/m/Y H:i:s') }}
                                @if(!in_array($t->status,['resolved','closed']))
                                    <div style="font-size:0.7rem;">{{ $t->sisa_waktu_sla }}</div>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td class="small text-muted">{{ $t->created_at->format('d/m/Y H:i:s') }}</td>
                        <td class="text-center">
                            @php
                                $sudahSelesai = in_array($t->status, ['resolved', 'closed']);
                                $bisaTangani  = auth()->user()->isCsirt() && !$sudahSelesai;
                            @endphp
                            <a href="{{ route('tiket.show', $t) }}"
                               class="btn btn-sm {{ $bisaTangani ? 'btn-primary' : 'btn-outline-secondary' }}">
                                <i class="bi bi-{{ $bisaTangani ? 'tools' : 'eye' }} me-1"></i>
                                {{ $bisaTangani ? 'Tangani' : 'Detail' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Tidak ada tiket ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if($tiket->hasPages())
            <div class="p-3 border-top">
                {{ $tiket->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
