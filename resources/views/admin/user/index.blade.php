@extends('layouts.app')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-people me-2 text-primary"></i>Kelola User</h4>
        <p class="text-muted mb-0">Manajemen akun pengguna sistem SILANTEK</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
        <i class="bi bi-person-plus me-1"></i>Tambah User
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Role</th>
                        <th>OPD</th>
                        <th>No. HP</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $u)
                    <tr>
                        <td class="ps-3 text-muted">{{ ($users->currentPage()-1) * $users->perPage() + $i + 1 }}</td>
                        <td class="small fw-semibold">{{ $u->nip }}</td>
                        <td>{{ $u->nama }}</td>
                        <td class="small text-muted">{{ $u->jabatan ?? '-' }}</td>
                        <td>
                            @php
                                $roleColor = match($u->role) {
                                    'admin'        => 'dark',
                                    'csirt'        => 'primary',
                                    'kabid_aptika' => 'info',
                                    'pic_opd'      => 'success',
                                    default        => 'secondary',
                                };
                                $roleLabel = match($u->role) {
                                    'admin'        => 'Admin',
                                    'csirt'        => 'Tim CSIRT',
                                    'kabid_aptika' => 'Kabid APTIKA',
                                    'pic_opd'      => 'PIC IT OPD',
                                    default        => ucfirst($u->role),
                                };
                            @endphp
                            <span class="badge bg-{{ $roleColor }}">{{ $roleLabel }}</span>
                        </td>
                        <td class="small">{{ $u->opd->nama_opd ?? '-' }}</td>
                        <td class="small">{{ $u->no_hp ?? '-' }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditUser{{ $u->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            @if($u->id !== auth()->id())
                            <form action="{{ route('admin.user.destroy', $u) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus user {{ $u->nama }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal Edit User -->
                    <div class="modal fade" id="modalEditUser{{ $u->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title fw-semibold">Edit User: {{ $u->nama }}</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.user.update', $u) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">NIP</label>
                                                <input type="text" class="form-control bg-light" value="{{ $u->nip }}" readonly>
                                                <div class="form-text small">NIP tidak dapat diubah</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Nama <span class="text-danger">*</span></label>
                                                <input type="text" name="nama" class="form-control" value="{{ $u->nama }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control" value="{{ $u->jabatan }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">No. HP</label>
                                                <input type="text" name="no_hp" class="form-control" value="{{ $u->no_hp }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Role <span class="text-danger">*</span></label>
                                                <select name="role" class="form-select" required>
                                                    <option value="pic_opd" {{ $u->role=='pic_opd' ? 'selected' : '' }}>PIC IT OPD</option>
                                                    <option value="csirt" {{ $u->role=='csirt' ? 'selected' : '' }}>Tim CSIRT</option>
                                                    <option value="kabid_aptika" {{ $u->role=='kabid_aptika' ? 'selected' : '' }}>Kabid APTIKA</option>
                                                    <option value="admin" {{ $u->role=='admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">OPD</label>
                                                <select name="opd_id" class="form-select">
                                                    <option value="">-- Tidak Terikat OPD --</option>
                                                    @foreach($opd as $o)
                                                        <option value="{{ $o->id }}" {{ $u->opd_id == $o->id ? 'selected' : '' }}>
                                                            {{ $o->nama_opd }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <hr class="my-1">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <span class="small fw-semibold">Ganti Password</span>
                                                    <span class="badge" style="background:#f1f5f9; color:#64748b; font-size:0.65rem; font-weight:500;">Opsional</span>
                                                </div>
                                                <p class="small text-muted mb-0">Kosongkan jika tidak ingin mengubah password.</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">
                                                    Password Baru
                                                    <span class="text-muted fw-normal">(opsional)</span>
                                                </label>
                                                <input type="password" name="password" class="form-control"
                                                    minlength="6" placeholder="Min. 6 karakter">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                                                <input type="password" name="password_confirmation" class="form-control"
                                                    placeholder="Ulangi password baru">
                                                <div class="form-text small">Wajib diisi jika mengubah password.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-people fs-2 d-block mb-2 opacity-50"></i>
                            Belum ada data user.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="p-3 border-top">{{ $users->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="bi bi-person-plus me-2 text-primary"></i>Tambah User Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip"
                                class="form-control @error('nip') is-invalid @enderror"
                                value="{{ old('nip') }}"
                                maxlength="18" inputmode="numeric"
                                placeholder="18 digit NIP ASN"
                                required>
                            @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control"
                                value="{{ old('jabatan') }}"
                                placeholder="Contoh: Pengelola Teknologi Informasi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">
                                No. HP
                                <span class="text-muted fw-normal">(opsional)</span>
                            </label>
                            <input type="text" name="no_hp" class="form-control"
                                value="{{ old('no_hp') }}"
                                placeholder="Contoh: 08123456789">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="pic_opd" {{ old('role')=='pic_opd' ? 'selected' : '' }}>PIC IT OPD</option>
                                <option value="csirt" {{ old('role')=='csirt' ? 'selected' : '' }}>Tim CSIRT</option>
                                <option value="kabid_aptika" {{ old('role')=='kabid_aptika' ? 'selected' : '' }}>Kabid APTIKA</option>
                                <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">OPD</label>
                            <select name="opd_id" class="form-select">
                                <option value="">-- Tidak Terikat OPD --</option>
                                @foreach($opd as $o)
                                    <option value="{{ $o->id }}" {{ old('opd_id')==$o->id ? 'selected' : '' }}>
                                        {{ $o->nama_opd }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                minlength="6" required placeholder="Min. 6 karakter">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password_confirmation"
                                class="form-control" required placeholder="Ulangi password">
                            <div class="form-text small">Harus sama dengan password di atas.</div>
                        </div>
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
        new bootstrap.Modal(document.getElementById('modalTambahUser')).show();
    });
</script>
@endif
@endsection
