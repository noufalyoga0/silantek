

<?php $__env->startSection('title', 'Laporan Insiden'); ?>
<?php $__env->startSection('page-title', 'Laporan Insiden Bulanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header mb-4">
    <div style="border-radius:16px; overflow:hidden; position:relative;
         background:linear-gradient(135deg,#0f172a 0%,#14532d 50%,#16a34a 100%);
         padding:1.5rem 2rem;">
        <div style="position:absolute; top:-20px; right:-20px; width:140px; height:140px;
                    border-radius:50%; background:rgba(255,255,255,0.05);"></div>
        <div style="position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-bar-chart-line-fill" style="color:#86efac; font-size:1rem;"></i>
                    <span style="color:rgba(255,255,255,0.6); font-size:0.78rem;">
                        Rekap Data Insiden · Kabupaten Jombang
                    </span>
                </div>
                <h4 class="text-white fw-bold mb-1" style="font-size:1.3rem;">Laporan Insiden</h4>
                <p style="color:rgba(255,255,255,0.55); font-size:0.8rem; margin:0;">
                    Rekap data insiden keamanan TIK Kabupaten Jombang
                </p>
            </div>
            <a href="<?php echo e(route('laporan.pdf', ['bulan' => $bulan, 'tahun' => $tahun])); ?>"
               class="btn fw-semibold"
               style="background:rgba(255,255,255,0.15); color:#fff;
                      border:1px solid rgba(255,255,255,0.25); border-radius:10px;
                      white-space:nowrap;"
               onmouseover="this.style.background='rgba(255,255,255,0.25)'"
               onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
            </a>
        </div>
    </div>
</div>

<!-- FILTER -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" action="<?php echo e(route('laporan.index')); ?>" class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Bulan</label>
                <select name="bulan" class="form-select form-select-sm">
                    <?php $__currentLoopData = range(1,12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($b); ?>" <?php echo e($bulan == $b ? 'selected' : ''); ?>>
                            <?php echo e(\Carbon\Carbon::createFromDate(2024, (int)$b, 1)->locale('id')->isoFormat('MMMM')); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Tahun</label>
                <select name="tahun" class="form-select form-select-sm">
                    <?php $__currentLoopData = range(date('Y'), date('Y')-3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($y); ?>" <?php echo e($tahun == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">OPD</label>
                <select name="opd_id" class="form-select form-select-sm">
                    <option value="">Semua OPD</option>
                    <?php $__currentLoopData = $opd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($o->id); ?>" <?php echo e(request('opd_id') == $o->id ? 'selected' : ''); ?>>
                            <?php echo e($o->nama_opd); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-search me-1"></i>Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- STAT CARDS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; border-top:3px solid #2563eb !important;">
            <div class="card-body py-3">
                <div style="width:40px; height:40px; background:#eff6ff; border-radius:10px;
                            display:flex; align-items:center; justify-content:center; margin:0 auto .65rem;">
                    <i class="bi bi-ticket-perforated-fill" style="color:#2563eb; font-size:1rem;"></i>
                </div>
                <div class="fw-bold" style="font-size:1.85rem; color:#2563eb; line-height:1;"><?php echo e($stats['total']); ?></div>
                <div class="text-muted small mt-1">Total Insiden</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; border-top:3px solid #f59e0b !important;">
            <div class="card-body py-3">
                <div style="width:40px; height:40px; background:#fef3c7; border-radius:10px;
                            display:flex; align-items:center; justify-content:center; margin:0 auto .65rem;">
                    <i class="bi bi-hourglass-split" style="color:#d97706; font-size:1rem;"></i>
                </div>
                <div class="fw-bold" style="font-size:1.85rem; color:#d97706; line-height:1;"><?php echo e($stats['open']); ?></div>
                <div class="text-muted small mt-1">Belum Selesai</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; border-top:3px solid #22c55e !important;">
            <div class="card-body py-3">
                <div style="width:40px; height:40px; background:#f0fdf4; border-radius:10px;
                            display:flex; align-items:center; justify-content:center; margin:0 auto .65rem;">
                    <i class="bi bi-check-circle-fill" style="color:#16a34a; font-size:1rem;"></i>
                </div>
                <div class="fw-bold" style="font-size:1.85rem; color:#16a34a; line-height:1;"><?php echo e($stats['resolved']); ?></div>
                <div class="text-muted small mt-1">Selesai</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important;
                    border-top:3px solid <?php echo e($stats['overdue'] > 0 ? '#ef4444' : '#94a3b8'); ?> !important;
                    <?php echo e($stats['overdue'] > 0 ? 'background:#fff1f2;' : ''); ?>">
            <div class="card-body py-3">
                <div style="width:40px; height:40px;
                            background:<?php echo e($stats['overdue'] > 0 ? '#fee2e2' : '#f1f5f9'); ?>;
                            border-radius:10px;
                            display:flex; align-items:center; justify-content:center; margin:0 auto .65rem;">
                    <i class="bi bi-exclamation-triangle-fill <?php echo e($stats['overdue'] > 0 ? 'overdue-badge' : ''); ?>"
                       style="color:<?php echo e($stats['overdue'] > 0 ? '#dc2626' : '#94a3b8'); ?>; font-size:1rem;"></i>
                </div>
                <div class="fw-bold" style="font-size:1.85rem; color:<?php echo e($stats['overdue'] > 0 ? '#dc2626' : '#0f172a'); ?>; line-height:1;"><?php echo e($stats['overdue']); ?></div>
                <div class="text-muted small mt-1">Overdue</div>
            </div>
        </div>
    </div>
</div>

<!-- TABEL LAPORAN -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold">
            <i class="bi bi-table me-2 text-primary"></i>
            Data Insiden —
            <?php echo e(\Carbon\Carbon::createFromDate((int)$tahun, (int)$bulan, 1)->locale('id')->isoFormat('MMMM')); ?> <?php echo e($tahun); ?>

            (<?php echo e($tiket->count()); ?> insiden)
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>No. Tiket</th>
                        <th>OPD</th>
                        <th>Jenis Insiden</th>
                        <th>Urgensi</th>
                        <th>Status</th>
                        <th>Overdue</th>
                        <th>Tanggal Lapor</th>
                        <th>Diselesaikan</th>
                        <th>Durasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tiket; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($t->is_overdue ? 'overdue-row' : ''); ?>">
                        <td class="ps-3 text-muted"><?php echo e($i + 1); ?></td>
                        <td>
                            <a href="<?php echo e(route('tiket.show', $t)); ?>" class="text-decoration-none fw-semibold">
                                <?php echo e($t->nomor_tiket); ?>

                            </a>
                        </td>
                        <td><?php echo e($t->opd->nama_opd ?? '-'); ?></td>
                        <td><?php echo e($t->kategoriInsiden->nama ?? '-'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($t->slaConfig->badge_color ?? 'secondary'); ?>">
                                <?php echo e(ucfirst($t->slaConfig->urgensi ?? '-')); ?>

                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($t->status); ?>"><?php echo e($t->status_label); ?></span>
                        </td>
                        <td class="text-center">
                            <?php if($t->is_overdue): ?>
                                <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                            <?php else: ?>
                                <i class="bi bi-check-circle text-success"></i>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($t->created_at->format('d/m/Y H:i:s')); ?></td>
                        <td><?php echo e($t->resolved_at ? $t->resolved_at->format('d/m/Y H:i:s') : '-'); ?></td>
                        <td>
                            <?php if($t->resolved_at): ?>
                                <?php
                                    $menitTotal = (int) $t->created_at->diffInMinutes($t->resolved_at);
                                    $jam  = intdiv($menitTotal, 60);
                                    $menit = $menitTotal % 60;
                                ?>
                                <?php if($jam > 0): ?><?php echo e($jam); ?>j <?php endif; ?><?php echo e($menit); ?>m
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                            Tidak ada data insiden pada periode ini.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <?php if($tiket->count() > 0): ?>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="9" class="ps-3 text-muted" style="font-size:0.8rem;">
                            <i class="bi bi-clock-history me-1"></i>Rata-rata waktu penanganan
                        </td>
                        <td class="fw-bold text-primary" style="font-size:0.85rem; white-space:nowrap;">
                            <?php
                                $rataRataMenit = round($stats['rata_rata_jam'] * 60);
                                $rataJam       = intdiv((int)$rataRataMenit, 60);
                                $rataMenit     = (int)$rataRataMenit % 60;
                            ?>
                            <?php if($rataJam > 0): ?><?php echo e($rataJam); ?>j <?php endif; ?><?php echo e($rataMenit); ?>m
                        </td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project New Kominfo - Copy\silantek\resources\views/laporan/index.blade.php ENDPATH**/ ?>