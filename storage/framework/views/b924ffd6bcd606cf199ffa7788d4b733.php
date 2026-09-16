<?php $__env->startSection('title', 'Kelola User'); ?>
<?php $__env->startSection('page-title', 'Kelola User'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3 text-muted"><?php echo e(($users->currentPage()-1) * $users->perPage() + $i + 1); ?></td>
                        <td class="small fw-semibold"><?php echo e($u->nip); ?></td>
                        <td><?php echo e($u->nama); ?></td>
                        <td class="small text-muted"><?php echo e($u->jabatan ?? '-'); ?></td>
                        <td>
                            <?php
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
                                    'pic_opd'      => 'PIC OPD',
                                    default        => ucfirst($u->role),
                                };
                            ?>
                            <span class="badge bg-<?php echo e($roleColor); ?>"><?php echo e($roleLabel); ?></span>
                        </td>
                        <td class="small"><?php echo e($u->opd->nama_opd ?? '-'); ?></td>
                        <td class="small"><?php echo e($u->no_hp ?? '-'); ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditUser<?php echo e($u->id); ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <?php if($u->id !== auth()->id()): ?>
                            <form action="<?php echo e(route('admin.user.destroy', $u)); ?>" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus user <?php echo e($u->nama); ?>?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- Modal Edit User -->
                    <div class="modal fade" id="modalEditUser<?php echo e($u->id); ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title fw-semibold">Edit User: <?php echo e($u->nama); ?></h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="<?php echo e(route('admin.user.update', $u)); ?>" method="POST">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">NIP</label>
                                                <input type="text" class="form-control bg-light" value="<?php echo e($u->nip); ?>" readonly>
                                                <div class="form-text small">NIP tidak dapat diubah</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Nama <span class="text-danger">*</span></label>
                                                <input type="text" name="nama" class="form-control" value="<?php echo e($u->nama); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control" value="<?php echo e($u->jabatan); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">No. HP</label>
                                                <input type="text" name="no_hp" class="form-control" value="<?php echo e($u->no_hp); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Role <span class="text-danger">*</span></label>
                                                <select name="role" class="form-select" required>
                                                    <option value="pic_opd" <?php echo e($u->role=='pic_opd' ? 'selected' : ''); ?>>PIC OPD</option>
                                                    <option value="csirt" <?php echo e($u->role=='csirt' ? 'selected' : ''); ?>>Tim CSIRT</option>
                                                    <option value="kabid_aptika" <?php echo e($u->role=='kabid_aptika' ? 'selected' : ''); ?>>Kabid APTIKA</option>
                                                    <option value="admin" <?php echo e($u->role=='admin' ? 'selected' : ''); ?>>Admin</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">OPD</label>
                                                <select name="opd_id" class="form-select">
                                                    <option value="">-- Tidak Terikat OPD --</option>
                                                    <?php $__currentLoopData = $opd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($o->id); ?>" <?php echo e($u->opd_id == $o->id ? 'selected' : ''); ?>>
                                                            <?php echo e($o->nama_opd); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-people fs-2 d-block mb-2 opacity-50"></i>
                            Belum ada data user.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($users->hasPages()): ?>
            <div class="p-3 border-top"><?php echo e($users->links('pagination::bootstrap-5')); ?></div>
        <?php endif; ?>
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
            <form action="<?php echo e(route('admin.user.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip"
                                class="form-control <?php $__errorArgs = ['nip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('nip')); ?>"
                                maxlength="18" inputmode="numeric"
                                placeholder="18 digit NIP ASN"
                                required>
                            <?php $__errorArgs = ['nip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama"
                                class="form-control <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('nama')); ?>" required>
                            <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control"
                                value="<?php echo e(old('jabatan')); ?>"
                                placeholder="Contoh: Pengelola Teknologi Informasi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">
                                No. HP
                                <span class="text-muted fw-normal">(opsional)</span>
                            </label>
                            <input type="text" name="no_hp" class="form-control"
                                value="<?php echo e(old('no_hp')); ?>"
                                placeholder="Contoh: 08123456789">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="pic_opd" <?php echo e(old('role')=='pic_opd' ? 'selected' : ''); ?>>PIC OPD</option>
                                <option value="csirt" <?php echo e(old('role')=='csirt' ? 'selected' : ''); ?>>Tim CSIRT</option>
                                <option value="kabid_aptika" <?php echo e(old('role')=='kabid_aptika' ? 'selected' : ''); ?>>Kabid APTIKA</option>
                                <option value="admin" <?php echo e(old('role')=='admin' ? 'selected' : ''); ?>>Admin</option>
                            </select>
                            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">OPD</label>
                            <select name="opd_id" class="form-select">
                                <option value="">-- Tidak Terikat OPD --</option>
                                <?php $__currentLoopData = $opd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($o->id); ?>" <?php echo e(old('opd_id')==$o->id ? 'selected' : ''); ?>>
                                        <?php echo e($o->nama_opd); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password"
                                class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                minlength="6" required placeholder="Min. 6 karakter">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

<?php if($errors->any()): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('modalTambahUser')).show();
    });
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project New Kominfo - Copy\silantek\resources\views/admin/user/index.blade.php ENDPATH**/ ?>