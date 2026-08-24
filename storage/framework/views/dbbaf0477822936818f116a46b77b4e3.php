<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'SILANTEK'); ?> — Diskominfo Kab. Jombang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-w: 260px;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --sidebar-bg: #0f172a;
            --sidebar-hover: rgba(255,255,255,0.06);
            --sidebar-active: rgba(37,99,235,0.18);
            --topbar-h: 60px;
            --radius: 12px;
            --shadow: 0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.04);
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            font-size: 0.875rem;
        }

        /* ─── SIDEBAR ──────────────────────────────── */
        #sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }

        .sidebar-brand .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }

        .sidebar-brand h6 {
            color: #f1f5f9;
            font-weight: 700;
            font-size: 0.95rem;
            margin: 0;
            letter-spacing: 0.3px;
        }

        .sidebar-brand small {
            color: #64748b;
            font-size: 0.67rem;
            line-height: 1.3;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 0.75rem 0;
            scrollbar-width: none;
        }
        .sidebar-nav::-webkit-scrollbar { display: none; }

        .nav-section-label {
            color: #475569;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 0.75rem 1.5rem 0.3rem;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.55rem 1.5rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.825rem;
            font-weight: 450;
            border-left: 3px solid transparent;
            transition: all 0.15s ease;
            margin: 1px 0;
        }

        .nav-item-link:hover {
            color: #e2e8f0;
            background: var(--sidebar-hover);
        }

        .nav-item-link.active {
            color: #93c5fd;
            background: var(--sidebar-active);
            border-left-color: #2563eb;
            font-weight: 600;
        }

        .nav-item-link .nav-icon {
            width: 18px;
            text-align: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        /* User info bawah sidebar */
        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }

        .sidebar-footer .user-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar-footer .user-name {
            color: #e2e8f0;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-footer .user-role {
            color: #64748b;
            font-size: 0.67rem;
        }

        /* ─── MAIN CONTENT ─────────────────────────── */
        #main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: transparent;
        }

        /* ─── TOPBAR ───────────────────────────────── */
        #topbar {
            height: var(--topbar-h);
            background: linear-gradient(135deg, #0f172a 0%, #1e2a3a 60%, #1e3a5f 100%);
            border-bottom: none;
            box-shadow: 0 2px 16px rgba(15,23,42,0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
            gap: 1rem;
        }

        .topbar-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #e2e8f0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Jam WIB realtime */
        .topbar-clock {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            padding: 0.3rem 0.8rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: #e2e8f0;
            font-variant-numeric: tabular-nums;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .topbar-clock i.bi-clock { color: #60a5fa !important; }

        /* Notifikasi bell */
        .notif-btn {
            position: relative;
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.15s;
        }
        .notif-btn:hover { background: rgba(255,255,255,0.18); color: #fff; }
        .notif-badge {
            position: absolute;
            top: -4px; right: -4px;
            background: #ef4444;
            color: #fff;
            font-size: 0.6rem;
            font-weight: 700;
            min-width: 16px; height: 16px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid #0f172a;
            padding: 0 3px;
        }

        /* User dropdown topbar */
        .topbar-user-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            padding: 0.3rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: #e2e8f0;
            cursor: pointer;
            transition: all 0.15s;
        }
        .topbar-user-btn:hover { background: rgba(255,255,255,0.18); }
        .topbar-user-avatar {
            width: 26px; height: 26px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.65rem;
            font-weight: 700;
            color: #fff;
        }

        /* ─── CARDS ────────────────────────────────── */
        .card {
            border: 1px solid #e2e8f0 !important;
            border-radius: var(--radius) !important;
            box-shadow: var(--shadow) !important;
        }

        .card-header {
            background: #fff !important;
            border-bottom: 1px solid #f1f5f9 !important;
            border-radius: var(--radius) var(--radius) 0 0 !important;
            padding: 1rem 1.25rem !important;
        }

        .stat-card {
            border-radius: var(--radius) !important;
            transition: transform 0.15s, box-shadow 0.15s;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.09) !important;
        }

        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        /* ─── STATUS BADGES ────────────────────────── */
        .badge { border-radius: 6px !important; font-weight: 500 !important; }
        .badge-open        { background: #dbeafe; color: #1d4ed8; }
        .badge-triase      { background: #fef3c7; color: #92400e; }
        .badge-in_progress { background: #cffafe; color: #0e7490; }
        .badge-resolved    { background: #dcfce7; color: #15803d; }
        .badge-reopen      { background: #fee2e2; color: #b91c1c; }
        .badge-closed      { background: #f1f5f9; color: #475569; }

        /* ─── TABLES ───────────────────────────────── */
        .table { font-size: 0.825rem; }
        .table thead th {
            background: #f8fafc !important;
            color: #64748b !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 0.75rem 1rem !important;
        }
        .table tbody td {
            padding: 0.8rem 1rem !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #334155;
        }
        .table tbody tr:last-child td { border-bottom: none !important; }
        .table tbody tr:hover td { background: #f8fafc !important; }
        .overdue-row td { background: #fff1f2 !important; }
        .overdue-row:hover td { background: #ffe4e6 !important; }

        @keyframes pulse-red {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .overdue-badge { animation: pulse-red 1.5s infinite; }

        /* ─── ALERTS ───────────────────────────────── */
        .alert { border-radius: 10px !important; border: none !important; font-size: 0.825rem; }
        .alert-success { background: #dcfce7; color: #15803d; }
        .alert-danger  { background: #fee2e2; color: #b91c1c; }
        .alert-info    { background: #dbeafe; color: #1d4ed8; }

        /* ─── PAGE LAYOUT ──────────────────────────── */
        .page-content {
            padding: 1.5rem;
            flex: 1;
            background: transparent !important;
        }

        /* Area utama konten — gradient subtle */
        #main-content {
            background: linear-gradient(135deg,
                #dbeafe 0%,
                #e0e7ff 25%,
                #ede9fe 50%,
                #e0f2fe 75%,
                #dbeafe 100%
            ) !important;
            background-attachment: fixed !important;
        }

        .page-header { margin-bottom: 1.5rem; }
        .page-header h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }

        /* Pastikan card kontras dengan background */
        .card {
            background: #fff !important;
        }

        /* ─── BUTTONS ──────────────────────────────── */
        .btn {
            border-radius: 8px !important;
            font-weight: 500 !important;
            font-size: 0.825rem !important;
            transition: all 0.15s !important;
        }
        .btn-primary { background: var(--primary) !important; border-color: var(--primary) !important; }
        .btn-primary:hover { background: var(--primary-dark) !important; border-color: var(--primary-dark) !important; }

        /* ─── TIMELINE ─────────────────────────────── */
        .timeline { position: relative; padding-left: 2rem; }
        .timeline::before {
            content: '';
            position: absolute;
            left: 0.65rem;
            top: 0; bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #e2e8f0, transparent);
        }
        .timeline-item { position: relative; margin-bottom: 1.25rem; }
        .timeline-dot {
            position: absolute;
            left: -2.05rem;
            top: 0.15rem;
            width: 1.3rem; height: 1.3rem;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.55rem;
        }

        /* ─── FORM CONTROLS ────────────────────────── */
        .form-control, .form-select {
            border-radius: 8px !important;
            border-color: #e2e8f0 !important;
            font-size: 0.825rem !important;
            transition: border-color 0.15s, box-shadow 0.15s !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1) !important;
        }

        /* ─── DROPDOWN ─────────────────────────────── */
        .dropdown-menu {
            border-radius: 10px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12) !important;
            font-size: 0.825rem !important;
            padding: 0.4rem !important;
        }
        .dropdown-item {
            border-radius: 6px !important;
            padding: 0.45rem 0.75rem !important;
            font-size: 0.825rem !important;
        }
        .dropdown-item:hover { background: #f1f5f9 !important; }

        /* ─── MODAL ────────────────────────────────── */
        .modal-content {
            border-radius: 14px !important;
            border: none !important;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important;
        }
        .modal-header {
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1.25rem 1.5rem !important;
        }
        .modal-footer {
            border-top: 1px solid #f1f5f9 !important;
            padding: 1rem 1.5rem !important;
        }
        .modal-body { padding: 1.25rem 1.5rem !important; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>


<aside id="sidebar">
    
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2 mb-1">
            <div class="brand-icon">
                <i class="bi bi-shield-lock-fill text-white"></i>
            </div>
            <div>
                <h6>SILANTEK</h6>
                <small>Insiden Keamanan TIK</small>
            </div>
        </div>
    </div>

    
    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu</div>

        <a href="<?php echo e(route('dashboard')); ?>"
           class="nav-item-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
            <span class="nav-icon"><i class="bi bi-grid-1x2"></i></span>
            Dashboard
        </a>

        <?php if(auth()->user()->isPicOpd()): ?>
        <a href="<?php echo e(route('tiket.create')); ?>"
           class="nav-item-link <?php echo e(request()->routeIs('tiket.create') ? 'active' : ''); ?>">
            <span class="nav-icon"><i class="bi bi-plus-circle"></i></span>
            Laporkan Insiden
        </a>
        <?php endif; ?>

        <a href="<?php echo e(route('tiket.index')); ?>"
           class="nav-item-link <?php echo e(request()->routeIs('tiket.index','tiket.show') ? 'active' : ''); ?>">
            <span class="nav-icon"><i class="bi bi-ticket-perforated"></i></span>
            <?php echo e(auth()->user()->isPicOpd() ? 'Tiket Saya' : 'Kelola Tiket'); ?>

        </a>

        <?php if(!auth()->user()->isPicOpd()): ?>
        <a href="<?php echo e(route('laporan.index')); ?>"
           class="nav-item-link <?php echo e(request()->routeIs('laporan.*') ? 'active' : ''); ?>">
            <span class="nav-icon"><i class="bi bi-bar-chart-line"></i></span>
            Laporan
        </a>
        <?php endif; ?>

        <?php if(auth()->user()->isAdmin()): ?>
        <div class="nav-section-label mt-2">Administrasi</div>
        <a href="<?php echo e(route('admin.opd.index')); ?>"
           class="nav-item-link <?php echo e(request()->routeIs('admin.opd.*') ? 'active' : ''); ?>">
            <span class="nav-icon"><i class="bi bi-buildings"></i></span>
            Kelola OPD
        </a>
        <a href="<?php echo e(route('admin.user.index')); ?>"
           class="nav-item-link <?php echo e(request()->routeIs('admin.user.*') ? 'active' : ''); ?>">
            <span class="nav-icon"><i class="bi bi-people"></i></span>
            Kelola User
        </a>
        <a href="<?php echo e(route('admin.kategori.index')); ?>"
           class="nav-item-link <?php echo e(request()->routeIs('admin.kategori.*') ? 'active' : ''); ?>">
            <span class="nav-icon"><i class="bi bi-tags"></i></span>
            Kategori &amp; SLA
        </a>
        <?php endif; ?>
    </nav>

    
    <div class="sidebar-footer">
        <a href="<?php echo e(route('profil')); ?>" class="d-flex align-items-center gap-2 text-decoration-none"
           style="transition:opacity 0.15s;" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">
            <div class="user-avatar">
                <?php echo e(strtoupper(substr(auth()->user()->nama, 0, 1))); ?>

            </div>
            <div style="overflow:hidden; flex:1;">
                <div class="user-name"><?php echo e(auth()->user()->nama); ?></div>
                <div class="user-role d-flex align-items-center gap-1">
                    <?php
                        echo match(auth()->user()->role) {
                            'admin'        => 'Administrator',
                            'csirt'        => 'Tim CSIRT',
                            'kabid_aptika' => 'Kabid APTIKA',
                            'pic_opd'      => 'PIC OPD',
                            default        => auth()->user()->role,
                        };
                    ?>
                    <i class="bi bi-pencil-square" style="font-size:0.6rem; opacity:0.5;"></i>
                </div>
            </div>
        </a>
    </div>
</aside>


<div id="main-content" style="min-height:100vh;">

    
    <header id="topbar">
        <div class="d-flex align-items-center gap-2">
            <div class="topbar-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></div>
        </div>

        <div class="topbar-right">
            
            <div class="topbar-clock" id="clockWIB">
                <i class="bi bi-clock me-1 text-primary"></i>
                <span id="clockText">--:--:--</span>
                <span class="text-muted ms-1" style="font-size:0.7rem; font-weight:400;">WIB</span>
            </div>

            
            <a href="<?php echo e(route('notifikasi')); ?>" class="notif-btn">
                <i class="bi bi-bell fs-6"></i>
                <?php $unread = auth()->user()->notifikasiUnread()->count(); ?>
                <?php if($unread > 0): ?>
                    <span class="notif-badge"><?php echo e($unread > 9 ? '9+' : $unread); ?></span>
                <?php endif; ?>
            </a>

            
            <div class="dropdown">
                <div class="topbar-user-btn" data-bs-toggle="dropdown" role="button">
                    <div class="topbar-user-avatar">
                        <?php echo e(strtoupper(substr(auth()->user()->nama, 0, 1))); ?>

                    </div>
                    <span class="d-none d-md-inline"><?php echo e(Str::limit(auth()->user()->nama, 18)); ?></span>
                    <i class="bi bi-chevron-down ms-1" style="font-size:0.65rem; opacity:0.6;"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    
                    <li class="px-3 py-2">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <div style="width:32px; height:32px; border-radius:50%;
                                        background:linear-gradient(135deg,#2563eb,#7c3aed);
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:0.75rem; font-weight:700; color:#fff; flex-shrink:0;">
                                <?php echo e(strtoupper(substr(auth()->user()->nama, 0, 1))); ?>

                            </div>
                            <div>
                                <div class="fw-semibold" style="font-size:0.82rem;"><?php echo e(auth()->user()->nama); ?></div>
                                <div class="text-muted" style="font-size:0.7rem;">NIP: <?php echo e(auth()->user()->nip); ?></div>
                            </div>
                        </div>
                        <span class="badge bg-secondary mt-1" style="font-size:0.68rem;">
                            <?php echo e(match(auth()->user()->role) {
                                'admin'        => 'Administrator',
                                'csirt'        => 'Tim CSIRT',
                                'kabid_aptika' => 'Kabid APTIKA',
                                'pic_opd'      => 'PIC OPD',
                                default        => auth()->user()->role,
                            }); ?>

                        </span>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a href="<?php echo e(route('profil')); ?>" class="dropdown-item d-flex align-items-center gap-2">
                            <i class="bi bi-person-circle text-primary"></i> Profil Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="dropdown-item text-danger d-flex align-items-center gap-2">
                                <i class="bi bi-box-arrow-right"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    
    <?php if(session('success') || session('error')): ?>
    <div class="px-4 pt-3">
        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 py-2" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <span><?php echo e(session('success')); ?></span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size:0.7rem;"></button>
        </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 py-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span><?php echo e(session('error')); ?></span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size:0.7rem;"></button>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    
    <main class="page-content">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<script>
// ─── JAM WIB REALTIME ───────────────────────────
function updateClock() {
    const now = new Date();
    // Konversi ke WIB (UTC+7)
    const wib = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));

    const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][wib.getDay()];
    const tgl  = String(wib.getDate()).padStart(2,'0');
    const bln  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][wib.getMonth()];
    const thn  = wib.getFullYear();
    const hh   = String(wib.getHours()).padStart(2,'0');
    const mm   = String(wib.getMinutes()).padStart(2,'0');
    const ss   = String(wib.getSeconds()).padStart(2,'0');

    document.getElementById('clockText').textContent = `${hari}, ${tgl} ${bln} ${thn}  ${hh}:${mm}:${ss}`;
}

updateClock();
setInterval(updateClock, 1000);
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Project New Kominfo - Copy\silantek\resources\views/layouts/app.blade.php ENDPATH**/ ?>