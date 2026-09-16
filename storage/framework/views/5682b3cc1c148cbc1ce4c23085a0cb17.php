<?php $__env->startSection('title', 'Kelola OPD'); ?>
<?php $__env->startSection('page-title', 'Kelola OPD'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $opd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3 text-muted"><?php echo e(($opd->currentPage()-1) * $opd->perPage() + $i + 1); ?></td>
                        <td class="fw-semibold"><?php echo e($o->nama_opd); ?></td>
                        <td class="small text-muted"><?php echo e($o->alamat ?? '-'); ?></td>
                        <td class="small"><?php echo e($o->no_telepon ?? '-'); ?></td>
                        <td class="text-center">
                            <span class="badge bg-primary rounded-pill"><?php echo e($o->users_count); ?></span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditOpd<?php echo e($o->id); ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="<?php echo e(route('admin.opd.destroy', $o)); ?>" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus OPD <?php echo e($o->nama_opd); ?>? Data user terkait akan terpengaruh.')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit OPD -->
                    <div class="modal fade" id="modalEditOpd<?php echo e($o->id); ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title fw-semibold">Edit OPD</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="<?php echo e(route('admin.opd.update', $o)); ?>" method="POST">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Nama OPD <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_opd" class="form-control" value="<?php echo e($o->nama_opd); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Alamat</label>
                                            <textarea name="alamat" class="form-control" rows="2"><?php echo e($o->alamat); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">No. Telepon</label>
                                            <input type="text" name="no_telepon" class="form-control" value="<?php echo e($o->no_telepon); ?>">
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-building fs-2 d-block mb-2 opacity-50"></i>
                            Belum ada data OPD.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($opd->hasPages()): ?>
            <div class="p-3 border-top"><?php echo e($opd->links('pagination::bootstrap-5')); ?></div>
        <?php endif; ?>
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
            <form action="<?php echo e(route('admin.opd.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama OPD <span class="text-danger">*</span></label>
                        <input type="text" name="nama_opd" class="form-control <?php $__errorArgs = ['nama_opd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            value="<?php echo e(old('nama_opd')); ?>" required placeholder="Contoh: Dinas Kesehatan">
                        <?php $__errorArgs = ['nama_opd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat kantor OPD"><?php echo e(old('alamat')); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="<?php echo e(old('no_telepon')); ?>" placeholder="(0321) xxxxxx">
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

<?php if($errors->any() || session('success') || session('error')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if($errors->has('nama_opd')): ?>
            new bootstrap.Modal(document.getElementById('modalTambahOpd')).show();
        <?php endif; ?>
    });
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project New Kominfo - Copy\silantek\resources\views/admin/opd/index.blade.php ENDPATH**/ ?>