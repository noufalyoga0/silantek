@extends('layouts.app')

@section('title', 'Kelola OPD')
@section('page-title', 'Kelola OPD')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-building me-2 text-primary"></i>Kelola OPD</h4>
        <p class="text-muted mb-0">Manajemen data Organisasi Perangkat Daerah</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahOpd">
        <i class="bi bi-plus-circle me-1"></i>Tambah OPD
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Nama OPD</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th class="text-center">Jumlah User</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opd as $i => $o)
                    <tr>
                        <td class="ps-3 text-muted">{{ ($opd->currentPage()-1) * $opd->perPage() + $i + 1 }}</td>
                        <td class="fw-semibold">{{ $o->nama_opd }}</td>
                        <td class="small text-muted">{{ $o->alamat ?? '-' }}</td>
                        <td class="small">{{ $o->no_telepon ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary rounded-pill">{{ $o->users_count }}</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditOpd{{ $o->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.opd.destroy', $o) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus OPD {{ $o->nama_opd }}? Data user terkait akan terpengaruh.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit OPD -->
                    <div class="modal fade" id="modalEditOpd{{ $o->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title fw-semibold">Edit OPD</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.opd.update', $o) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Nama OPD <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_opd" class="form-control" value="{{ $o->nama_opd }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Alamat</label>
                                            <textarea name="alamat" class="form-control" rows="2">{{ $o->alamat }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">No. Telepon</label>
                                            <input type="text" name="no_telepon" class="form-control" value="{{ $o->no_telepon }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-building fs-2 d-block mb-2 opacity-50"></i>
                            Belum ada data OPD.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($opd->hasPages())
            <div class="p-3 border-top">{{ $opd->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
</div>

<!-- Modal Tambah OPD -->
<div class="modal fade" id="modalTambahOpd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah OPD Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.opd.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama OPD <span class="text-danger">*</span></label>
                        <input type="text" name="nama_opd" class="form-control @error('nama_opd') is-invalid @enderror"
                            value="{{ old('nama_opd') }}" required placeholder="Contoh: Dinas Kesehatan">
                        @error('nama_opd')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat kantor OPD">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}" placeholder="(0321) xxxxxx">
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

@if($errors->any() || session('success') || session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->has('nama_opd'))
            new bootstrap.Modal(document.getElementById('modalTambahOpd')).show();
        @endif
    });
</script>
@endif
@endsection
