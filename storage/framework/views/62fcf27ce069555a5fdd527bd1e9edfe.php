<?php $__env->startSection('title', 'Daftar Tiket'); ?>
<?php $__env->startSection('page-title', auth()->user()->isPicOpd() ? 'Tiket Saya' : 'Kelola Tiket'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    
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
                        <?php echo e(auth()->user()->isPicOpd() ? 'Riwayat Laporan OPD Anda' : 'Manajemen Tiket Insiden'); ?>

                    </span>
                </div>
                <h4 class="text-white fw-bold mb-1" style="font-size:1.3rem;">
                    <?php echo e(auth()->user()->isPicOpd() ? 'Tiket Saya' : 'Kelola Tiket'); ?>

                </h4>
                <p style="color:rgba(255,255,255,0.55); font-size:0.8rem; margin:0;">
                    Daftar semua laporan insiden keamanan TIK
                </p>
            </div>
            <?php if(auth()->user()->isPicOpd()): ?>
            <a href="<?php echo e(route('tiket.create')); ?>"
               class="btn fw-semibold"
               style="background:rgba(255,255,255,0.15); color:#fff;
                      border:1px solid rgba(255,255,255,0.25); border-radius:10px;
                      white-space:nowrap;"
               onmouseover="this.style.background='rgba(255,255,255,0.25)'"
               onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                <i class="bi bi-plus-circle me-1"></i>Laporkan Insiden
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- FILTER -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-3">
        <form method="GET" action="<?php echo e(route('tiket.index')); ?>" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="No. tiket / deskripsi..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <?php $__currentLoopData = ['open','triase','in_progress','resolved','reopen','closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(request('status') == $s ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst(str_replace('_',' ',$s))); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Urgensi</label>
                <select name="urgensi" class="form-select form-select-sm">
                    <option value="">Semua Urgensi</option>
                    <?php $__currentLoopData = ['rendah','sedang','tinggi','kritis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($u); ?>" <?php echo e(request('urgensi') == $u ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($u)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
            <?php if(request()->hasAny(['search','status','urgensi','opd_id'])): ?>
                <div class="col-md-1">
                    <a href="<?php echo e(route('tiket.index')); ?>" class="btn btn-outline-secondary btn-sm w-100">Reset</a>
                </div>
            <?php endif; ?>
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
                        <?php if(!auth()->user()->isPicOpd()): ?>
                            <th>OPD Pelapor</th>
                        <?php endif; ?>
                        <th>Jenis Insiden</th>
                        <th>Urgensi</th>
                        <th>Status</th>
                        <th>SLA Deadline</th>
                        <th>Tanggal Lapor</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tiket; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($t->is_overdue && !in_array($t->status,['resolved','closed']) ? 'overdue-row' : ''); ?>">
                        <td class="ps-3">
                            <div class="fw-semibold"><?php echo e($t->nomor_tiket); ?></div>
                            <?php if($t->is_overdue && !in_array($t->status,['resolved','closed'])): ?>
                                <span class="badge bg-danger overdue-badge" style="font-size:0.65rem;">OVERDUE</span>
                            <?php endif; ?>
                        </td>
                        <?php if(!auth()->user()->isPicOpd()): ?>
                            <td class="small text-muted"><?php echo e($t->opd->nama_opd ?? '-'); ?></td>
                        <?php endif; ?>
                        <td class="small"><?php echo e($t->kategoriInsiden->nama ?? '-'); ?></td>
                        <td>
                            <?php $slaFinal = $t->slaConfigOverride ?? $t->slaConfig; ?>
                            <span class="badge bg-<?php echo e($slaFinal->badge_color ?? 'secondary'); ?>">
                                <?php echo e(ucfirst($slaFinal->urgensi ?? '-')); ?>

                            </span>
                            <?php if($t->sudahDioverride()): ?>
                                <i class="bi bi-patch-check-fill text-primary ms-1"
                                   style="font-size:0.65rem;"
                                   title="Diverifikasi CSIRT dari <?php echo e(ucfirst($t->slaConfig->urgensi ?? '-')); ?>"></i>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($t->status); ?>"><?php echo e($t->status_label); ?></span>
                        </td>
                        <td class="small <?php echo e($t->is_overdue && !in_array($t->status,['resolved','closed']) ? 'text-danger fw-bold' : 'text-muted'); ?>">
                            <?php if($t->sla_deadline): ?>
                                <?php echo e($t->sla_deadline->format('d/m/Y H:i:s')); ?>

                                <?php if(!in_array($t->status,['resolved','closed'])): ?>
                                    <div style="font-size:0.7rem;"><?php echo e($t->sisa_waktu_sla); ?></div>
                                <?php endif; ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted"><?php echo e($t->created_at->format('d/m/Y H:i:s')); ?></td>
                        <td class="text-center">
                            <?php
                                $sudahSelesai = in_array($t->status, ['resolved', 'closed']);
                                $bisaTangani  = auth()->user()->isCsirt() && !$sudahSelesai;
                            ?>
                            <a href="<?php echo e(route('tiket.show', $t)); ?>"
                               class="btn btn-sm <?php echo e($bisaTangani ? 'btn-primary' : 'btn-outline-secondary'); ?>">
                                <i class="bi bi-<?php echo e($bisaTangani ? 'tools' : 'eye'); ?> me-1"></i>
                                <?php echo e($bisaTangani ? 'Tangani' : 'Detail'); ?>

                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Tidak ada tiket ditemukan.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if($tiket->hasPages()): ?>
            <div class="p-3 border-top">
                <?php echo e($tiket->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project New Kominfo - Copy\silantek\resources\views/tiket/index.blade.php ENDPATH**/ ?>