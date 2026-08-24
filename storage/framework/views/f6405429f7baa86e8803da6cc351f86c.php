<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard PIC OPD'); ?>

<?php $__env->startSection('content'); ?>


<div class="mb-4" style="border-radius:16px; overflow:hidden; position:relative;
     background:linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #2563eb 100%);
     padding:1.75rem 2rem;">
    
    <div style="position:absolute; top:-30px; right:-30px; width:160px; height:160px;
                border-radius:50%; background:rgba(255,255,255,0.05);"></div>
    <div style="position:absolute; bottom:-40px; right:80px; width:100px; height:100px;
                border-radius:50%; background:rgba(255,255,255,0.04);"></div>
    <div style="position:absolute; top:20px; right:160px; width:60px; height:60px;
                border-radius:50%; background:rgba(255,255,255,0.06);"></div>

    <div class="d-flex align-items-center justify-content-between" style="position:relative; z-index:1;">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,.15);
                            display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-person-fill text-white" style="font-size:1rem;"></i>
                </div>
                <span class="text-white" style="font-size:0.78rem; opacity:0.75;">PIC OPD</span>
            </div>
            <h4 class="text-white fw-bold mb-1" style="font-size:1.3rem;">
                Selamat datang, <?php echo e($user->nama); ?>

            </h4>
            <p class="mb-0" style="color:rgba(255,255,255,.65); font-size:0.82rem;">
                <i class="bi bi-buildings me-1"></i><?php echo e($user->opd->nama_opd ?? '-'); ?>

            </p>
        </div>
        <div class="d-none d-md-block">
            <a href="<?php echo e(route('tiket.create')); ?>"
               class="btn fw-semibold px-4"
               style="background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.3);
                      backdrop-filter:blur(4px); border-radius:10px; transition:all .2s;"
               onmouseover="this.style.background='rgba(255,255,255,.25)'"
               onmouseout="this.style.background='rgba(255,255,255,.15)'">
                <i class="bi bi-plus-circle me-2"></i>Laporkan Insiden
            </a>
        </div>
    </div>
</div>


<div class="row g-3 mb-4">
    <?php
        $cards = [
            ['val'=>$stats['total'],       'label'=>'Total Tiket',     'sub'=>'Semua periode',         'icon'=>'bi-ticket-perforated-fill', 'color'=>'#2563eb', 'bg'=>'#eff6ff', 'line'=>'#2563eb'],
            ['val'=>$stats['open'],        'label'=>'Sedang Diproses', 'sub'=>'Open & in progress',    'icon'=>'bi-hourglass-split',        'color'=>'#d97706', 'bg'=>'#fef3c7', 'line'=>'#f59e0b'],
            ['val'=>$stats['in_progress'], 'label'=>'In Progress',     'sub'=>'Aktif ditangani CSIRT', 'icon'=>'bi-tools',                  'color'=>'#0891b2', 'bg'=>'#ecfeff', 'line'=>'#06b6d4'],
            ['val'=>$stats['resolved'],    'label'=>'Selesai',         'sub'=>'Resolved & closed',     'icon'=>'bi-check-circle-fill',      'color'=>'#16a34a', 'bg'=>'#f0fdf4', 'line'=>'#22c55e'],
        ];
    ?>
    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center"
             style="border-radius:14px !important; overflow:hidden;
                    border-top:3px solid <?php echo e($c['line']); ?> !important;">
            <div class="card-body p-3 pt-4">
                <div style="width:48px; height:48px; border-radius:12px;
                            background:<?php echo e($c['bg']); ?>;
                            display:flex; align-items:center; justify-content:center;
                            margin:0 auto 0.75rem;">
                    <i class="bi <?php echo e($c['icon']); ?>" style="color:<?php echo e($c['color']); ?>; font-size:1.3rem;"></i>
                </div>
                <div style="font-size:2.25rem; font-weight:800; color:#0f172a; line-height:1;">
                    <?php echo e($c['val']); ?>

                </div>
                <div class="fw-semibold mt-2" style="font-size:0.82rem; color:#374151;">
                    <?php echo e($c['label']); ?>

                </div>
                <div class="text-muted mt-1" style="font-size:0.7rem;"><?php echo e($c['sub']); ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="d-md-none mb-4">
    <a href="<?php echo e(route('tiket.create')); ?>" class="btn btn-primary w-100 fw-semibold">
        <i class="bi bi-plus-circle me-2"></i>Laporkan Insiden Baru
    </a>
</div>


<div class="row g-3">
    
    <?php if(array_sum(array_column($grafikBulanan, 'jumlah')) > 0): ?>
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:14px !important;">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-bar-chart-line me-2 text-primary"></i>Riwayat Laporan 6 Bulan Terakhir
                </h6>
            </div>
            <div class="card-body pb-3">
                <canvas id="grafikPicOpd" height="60"></canvas>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:14px !important;">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Tiket Terbaru OPD Anda
                </h6>
                <a href="<?php echo e(route('tiket.index')); ?>" class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Tiket</th>
                                <th>Jenis Insiden</th>
                                <th>Urgensi</th>
                                <th>Status</th>
                                <th>SLA Deadline</th>
                                <th>Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $tiketTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="<?php echo e($t->is_overdue && !in_array($t->status,['resolved','closed']) ? 'overdue-row' : ''); ?>">
                                <td>
                                    <span class="fw-semibold"><?php echo e($t->nomor_tiket); ?></span>
                                    <?php if($t->is_overdue && !in_array($t->status,['resolved','closed'])): ?>
                                        <span class="badge bg-danger ms-1 overdue-badge" style="font-size:0.6rem;">OVERDUE</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small"><?php echo e($t->kategoriInsiden->nama ?? '-'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($t->slaConfig->badge_color ?? 'secondary'); ?>">
                                        <?php echo e(ucfirst($t->slaConfig->urgensi ?? '-')); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo e($t->status); ?>"><?php echo e($t->status_label); ?></span>
                                </td>
                                <td class="small <?php echo e($t->is_overdue && !in_array($t->status,['resolved','closed']) ? 'text-danger fw-bold' : 'text-muted'); ?>">
                                    <?php echo e($t->sla_deadline ? $t->sla_deadline->format('d/m/Y H:i:s') : '-'); ?>

                                </td>
                                <td class="text-muted small"><?php echo e($t->created_at->format('d/m/Y')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('tiket.show', $t)); ?>" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div style="width:64px; height:64px; background:#f1f5f9; border-radius:50%;
                                                display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                                        <i class="bi bi-inbox fs-3 opacity-50"></i>
                                    </div>
                                    <p class="fw-semibold mb-1">Belum ada laporan insiden</p>
                                    <p class="small mb-2">Buat laporan pertama OPD Anda sekarang</p>
                                    <a href="<?php echo e(route('tiket.create')); ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle me-1"></i>Laporkan Insiden
                                    </a>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
<?php if(array_sum(array_column($grafikBulanan, 'jumlah')) > 0): ?>
new Chart(document.getElementById('grafikPicOpd').getContext('2d'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_column($grafikBulanan, 'bulan')); ?>,
        datasets: [{
            label: 'Laporan',
            data: <?php echo json_encode(array_column($grafikBulanan, 'jumlah')); ?>,
            backgroundColor: 'rgba(37,99,235,0.12)',
            borderColor: '#2563eb',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false } }
        }
    }
});
<?php endif; ?>
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project New Kominfo - Copy\silantek\resources\views/dashboard/pic_opd.blade.php ENDPATH**/ ?>