@extends('layouts.app')

@section('title', 'Kategori & SLA')
@section('page-title', 'Kategori Insiden & Konfigurasi SLA')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-tags me-2 text-primary"></i>Kategori Insiden &amp; Konfigurasi SLA</h4>
    <p class="text-muted mb-0">Kelola jenis insiden dan batas waktu penanganan (SLA)</p>
</div>

<div class="row g-3">
    <!-- KATEGORI INSIDEN -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-tags me-2 text-primary"></i>Kategori Insiden</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                    <i class="bi bi-plus-circle me-1"></i>Tambah
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Kode</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $k)
                        <tr>
                            <td class="ps-3">
                                <span class="badge bg-secondary">{{ $k->kode }}</span>
                            </td>
                            <td class="fw-semibold small">{{ $k->nama }}</td>
                            <td class="small text-muted">{{ $k->deskripsi ?? '-' }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.kategori.destroy', $k) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus kategori {{ $k->nama }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Belum ada kategori insiden.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SLA CONFIG -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-clock me-2 text-warning"></i>Konfigurasi SLA
                    <span class="badge bg-secondary ms-1" style="font-size:0.7rem;">Dapat diubah tanpa edit kode</span>
                </h6>
            </div>
            <div class="card-body">
                @foreach($slaConfig as $sla)
                <div class="card mb-3 border-{{ $sla->badge_color }}">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-{{ $sla->badge_color }} fs-6">
                                {{ $sla->label_urgensi }}
                            </span>
                            <span class="text-muted small">Saat ini: <strong>{{ $sla->durasi_jam }} jam</strong></span>
                        </div>
                        <form action="{{ route('admin.sla.update', $sla) }}" method="POST" class="d-flex gap-2">
                            @csrf @method('PUT')
                            <div class="input-group input-group-sm">
                                <input type="number" name="durasi_jam"
                                    class="form-control"
                                    value="{{ $sla->durasi_jam }}"
                                    min="1" max="720" required>
                                <span class="input-group-text">jam</span>
                            </div>
                            <button type="submit" class="btn btn-sm btn-{{ $sla->badge_color }} text-white">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </form>
                        <div class="form-text small mt-1">
                            @if($sla->urgensi === 'kritis') Sistem lumpuh / data bocor masif
                            @elseif($sla->urgensi === 'tinggi') Website defacing / tidak bisa diakses
                            @elseif($sla->urgensi === 'sedang') Gangguan sebagian / potensi ancaman
                            @else Laporan informatif / insiden minor
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="alert alert-info py-2 small mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Perubahan SLA hanya berlaku untuk tiket <strong>baru</strong> yang dibuat setelah perubahan disimpan.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Kategori Insiden</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kode <span class="text-danger">*</span></label>
                        <input type="text" name="kode"
                            class="form-control @error('kode') is-invalid @enderror"
                            value="{{ old('kode') }}"
                            placeholder="Contoh: I-08"
                            required>
                        @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama"
                            class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}"
                            placeholder="Contoh: DDoS Attack"
                            required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="2"
                            placeholder="Deskripsi singkat kategori insiden ini">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-save me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('modalTambahKategori')).show();
    });
</script>
@endif
@endsection
