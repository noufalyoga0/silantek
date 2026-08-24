<?php $__env->startSection('title', 'Profil Saya'); ?>
<?php $__env->startSection('page-title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h4><i class="bi bi-person-circle me-2 text-primary"></i>Profil Saya</h4>
    <p class="text-muted mb-0">Informasi akun dan pengaturan keamanan</p>
</div>

<div class="row g-3">

    
    <div class="col-lg-4">

        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body text-center py-4">
                
                <div class="mx-auto mb-3" style="width:72px; height:72px; border-radius:50%;
                     background:linear-gradient(135deg,#2563eb,#7c3aed);
                     display:flex; align-items:center; justify-content:center;
                     font-size:1.75rem; font-weight:700; color:#fff;">
                    <?php echo e(strtoupper(substr($user->nama, 0, 1))); ?>

                </div>
                <h5 class="fw-bold mb-1"><?php echo e($user->nama); ?></h5>
                <div class="mb-2">
                    <?php
                        $roleLabel = match($user->role) {
                            'admin'        => ['Admin',          'dark'],
                            'csirt'        => ['Tim CSIRT',      'primary'],
                            'kabid_aptika' => ['Kabid APTIKA',   'info'],
                            'pic_opd'      => ['PIC OPD',     'success'],
                            default        => [ucfirst($user->role), 'secondary'],
                        };
                    ?>
                    <span class="badge bg-<?php echo e($roleLabel[1]); ?>"><?php echo e($roleLabel[0]); ?></span>
                </div>
                <p class="text-muted small mb-0"><?php echo e($user->opd->nama_opd ?? 'Tanpa OPD'); ?></p>
            </div>
            <div class="card-body border-top pt-3 pb-3">
                <div class="row g-2 small">
                    <div class="col-12">
                        <span class="text-muted d-block" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">NIP</span>
                        <span class="fw-semibold"><?php echo e($user->nip); ?></span>
                    </div>
                    <div class="col-12">
                        <span class="text-muted d-block" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">Jabatan</span>
                        <span class="fw-semibold"><?php echo e($user->jabatan ?? '-'); ?></span>
                    </div>
                    <div class="col-12">
                        <span class="text-muted d-block" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">No. HP</span>
                        <span class="fw-semibold"><?php echo e($user->no_hp ?? '-'); ?></span>
                    </div>
                    <div class="col-12">
                        <span class="text-muted d-block" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">Bergabung</span>
                        <span class="fw-semibold"><?php echo e($user->created_at->format('d/m/Y')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        
        <?php if(!empty($stats)): ?>
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-bar-chart me-2 text-primary"></i>Statistik Tiket</h6>
            </div>
            <div class="card-body p-0">
                <div class="row g-0 text-center">
                    <div class="col-6 p-3 border-bottom border-end">
                        <div class="fw-bold fs-4 text-primary"><?php echo e($stats['total']); ?></div>
                        <div class="text-muted" style="font-size:0.72rem;">Total</div>
                    </div>
                    <div class="col-6 p-3 border-bottom">
                        <div class="fw-bold fs-4 text-warning"><?php echo e($stats['open']); ?></div>
                        <div class="text-muted" style="font-size:0.72rem;">Aktif</div>
                    </div>
                    <div class="col-6 p-3 border-end">
                        <div class="fw-bold fs-4 text-success"><?php echo e($stats['resolved']); ?></div>
                        <div class="text-muted" style="font-size:0.72rem;">Selesai</div>
                    </div>
                    <div class="col-6 p-3">
                        <div class="fw-bold fs-4 text-danger"><?php echo e($stats['overdue']); ?></div>
                        <div class="text-muted" style="font-size:0.72rem;">Overdue</div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if($aktivitasTerakhir->count() > 0): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-clock-history me-2 text-primary"></i>Aktivitas Terakhir</h6>
            </div>
            <div class="card-body p-0">
                <?php $__currentLoopData = $aktivitasTerakhir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex align-items-start gap-2 p-3 border-bottom">
                    <div class="flex-shrink-0 mt-1">
                        <?php
                            $ic = match($notif->jenis_notifikasi) {
                                'tiket_masuk'   => 'bi-ticket-perforated-fill text-primary',
                                'update_status' => 'bi-arrow-repeat text-info',
                                'overdue'       => 'bi-exclamation-triangle-fill text-danger',
                                'reopen'        => 'bi-arrow-counterclockwise text-warning',
                                'selesai'       => 'bi-check-circle-fill text-success',
                                default         => 'bi-bell-fill text-secondary',
                            };
                        ?>
                        <i class="bi <?php echo e($ic); ?>" style="font-size:0.85rem;"></i>
                    </div>
                    <div class="flex-grow-1" style="overflow:hidden;">
                        <p class="mb-0 small text-truncate" style="max-width:100%;"><?php echo e($notif->pesan); ?></p>
                        <span class="text-muted" style="font-size:0.68rem;"><?php echo e($notif->created_at->diffForHumans()); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="col-lg-8">

        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi Akun</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">Nama Lengkap</label>
                        <div class="form-control bg-light"><?php echo e($user->nama); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">NIP</label>
                        <div class="form-control bg-light"><?php echo e($user->nip); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">Jabatan</label>
                        <div class="form-control bg-light"><?php echo e($user->jabatan ?? '-'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">No. HP</label>
                        <div class="form-control bg-light"><?php echo e($user->no_hp ?? '-'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold text-muted" style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.5px;">OPD</label>
                        <div class="form-control bg-light"><?php echo e($user->opd->nama_opd ?? '-'); ?></div>
                    </div>
                </div>
                <div class="alert alert-info py-2 mt-3 mb-0 small d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill flex-shrink-0"></i>
                    <span>Perubahan data profil (nama, jabatan, NIP) hanya dapat dilakukan oleh Administrator. Hubungi Admin Diskominfo jika ada perubahan data.</span>
                </div>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-lock me-2 text-warning"></i>Ganti Password</h6>
            </div>
            <div class="card-body">

                <?php if($errors->any()): ?>
                <div class="alert alert-danger py-2 small d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                    <span><?php echo e($errors->first()); ?></span>
                </div>
                <?php endif; ?>

                <form action="<?php echo e(route('profil.ganti-password')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label small fw-semibold">
                                Password Lama <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       name="password_lama"
                                       id="pwLama"
                                       class="form-control <?php $__errorArgs = ['password_lama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="Masukkan password saat ini"
                                       required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pwLama','iconLama')">
                                    <i class="bi bi-eye" id="iconLama"></i>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password_lama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">
                                Password Baru <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       name="password_baru"
                                       id="pwBaru"
                                       class="form-control <?php $__errorArgs = ['password_baru'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="Min. 8 karakter"
                                       minlength="8"
                                       required
                                       oninput="checkStrength(this.value)">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pwBaru','iconBaru')">
                                    <i class="bi bi-eye" id="iconBaru"></i>
                                </button>
                            </div>
                            
                            <div class="mt-2" style="height:4px; background:#f1f5f9; border-radius:4px; overflow:hidden;">
                                <div id="strengthBar" style="height:100%; width:0%; border-radius:4px; transition:all 0.3s;"></div>
                            </div>
                            <div id="strengthText" class="form-text small" style="font-size:0.7rem;"></div>
                            <?php $__errorArgs = ['password_baru'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">
                                Konfirmasi Password Baru <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       name="password_baru_confirmation"
                                       id="pwKonfirmasi"
                                       class="form-control"
                                       placeholder="Ulangi password baru"
                                       required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePw('pwKonfirmasi','iconKonfirmasi')">
                                    <i class="bi bi-eye" id="iconKonfirmasi"></i>
                                </button>
                            </div>
                            <div class="form-text small">Harus sama persis dengan password baru di atas.</div>
                        </div>

                        <div class="col-12">
                            <div class="alert py-2 mb-0 small d-flex align-items-start gap-2"
                                 style="background:#fef3c7; border:1px solid #fde68a; color:#92400e;">
                                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-1"></i>
                                <span>Setelah password berhasil diubah, Anda akan diminta login ulang dengan password baru.</span>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning px-4" style="color:#fff;">
                                <i class="bi bi-lock me-1"></i>Ubah Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}

function checkStrength(val) {
    const bar  = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    let score  = 0;
    if (val.length >= 8)  score++;
    if (val.length >= 12) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { label: '',             color: '',        pct: 0   },
        { label: 'Sangat Lemah', color: '#ef4444', pct: 20  },
        { label: 'Lemah',        color: '#f97316', pct: 40  },
        { label: 'Cukup',        color: '#eab308', pct: 60  },
        { label: 'Kuat',         color: '#22c55e', pct: 80  },
        { label: 'Sangat Kuat',  color: '#16a34a', pct: 100 },
    ];
    const lv = levels[score] || levels[0];
    bar.style.width      = lv.pct + '%';
    bar.style.background = lv.color;
    text.textContent     = val.length > 0 ? 'Kekuatan: ' + lv.label : '';
    text.style.color     = lv.color;
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project New Kominfo - Copy\silantek\resources\views/profil/index.blade.php ENDPATH**/ ?>