<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SILANTEK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Animated background blobs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
        }
        body::before {
            width: 500px; height: 500px;
            background: #2563eb;
            top: -100px; left: -100px;
        }
        body::after {
            width: 400px; height: 400px;
            background: #7c3aed;
            bottom: -80px; right: -80px;
            animation-delay: -4s;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, 20px) scale(1.05); }
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 10;
        }

        /* Card */
        .login-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }

        /* Brand */
        .brand-logo {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 24px rgba(37,99,235,0.35);
        }

        .brand-title {
            color: #f1f5f9;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.25rem;
            letter-spacing: -0.3px;
        }

        .brand-subtitle {
            color: #64748b;
            font-size: 0.78rem;
            text-align: center;
            margin-bottom: 1.75rem;
            line-height: 1.5;
        }

        /* Divider with badge */
        .login-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .login-divider::before, .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.08);
        }
        .login-divider span {
            color: #475569;
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Form label */
        label.form-label {
            color: #94a3b8;
            font-size: 0.775rem;
            font-weight: 500;
            margin-bottom: 0.4rem;
        }

        /* Input */
        .input-group-text {
            background: rgba(255,255,255,0.04) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            border-right: none !important;
            color: #64748b !important;
        }

        .form-control {
            background: rgba(255,255,255,0.04) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            border-left: none !important;
            color: #f1f5f9 !important;
            font-size: 0.85rem !important;
            border-radius: 0 8px 8px 0 !important;
        }
        .form-control::placeholder { color: #475569 !important; }
        .form-control:focus {
            background: rgba(255,255,255,0.06) !important;
            border-color: rgba(37,99,235,0.5) !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15) !important;
            color: #f1f5f9 !important;
        }
        .input-group-text:first-child {
            border-radius: 8px 0 0 8px !important;
        }

        /* Toggle password btn */
        .btn-toggle-pw {
            background: rgba(255,255,255,0.04) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            border-left: none !important;
            color: #64748b !important;
            border-radius: 0 8px 8px 0 !important;
            padding: 0 0.75rem !important;
        }
        .btn-toggle-pw:hover { color: #94a3b8 !important; }

        /* Remember me */
        .form-check-input {
            background-color: rgba(255,255,255,0.08) !important;
            border-color: rgba(255,255,255,0.2) !important;
        }
        .form-check-input:checked {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }
        .form-check-label { color: #64748b; font-size: 0.78rem; }

        /* Submit btn */
        .btn-login {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            border: none !important;
            color: #fff !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            padding: 0.7rem !important;
            border-radius: 10px !important;
            letter-spacing: 0.2px;
            box-shadow: 0 4px 16px rgba(37,99,235,0.35) !important;
            transition: all 0.2s !important;
        }
        .btn-login:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 20px rgba(37,99,235,0.45) !important;
        }
        .btn-login:active { transform: translateY(0) !important; }

        /* Alert */
        .alert-login {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.25);
            color: #fca5a5;
            border-radius: 10px;
            font-size: 0.8rem;
            padding: 0.65rem 1rem;
        }
        .alert-success-login {
            background: rgba(34,197,94,0.12);
            border: 1px solid rgba(34,197,94,0.25);
            color: #86efac;
            border-radius: 10px;
            font-size: 0.8rem;
            padding: 0.65rem 1rem;
        }

        /* Hint NIP */
        .form-hint {
            color: #475569;
            font-size: 0.7rem;
            margin-top: 0.3rem;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            color: #334155;
            font-size: 0.7rem;
            margin-top: 1.5rem;
        }

        /* Secure badge */
        .secure-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.2);
            border-radius: 20px;
            padding: 0.25rem 0.75rem;
            font-size: 0.7rem;
            color: #86efac;
            margin-bottom: 0.5rem;
        }

        /* Clock on login */
        .login-clock {
            color: #475569;
            font-size: 0.72rem;
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>
<body>
<div class="login-wrapper">

    <div class="login-card">

        
        <div class="brand-logo">
            <i class="bi bi-shield-lock-fill text-white"></i>
        </div>
        <div class="brand-title">SILANTEK</div>
        <p class="brand-subtitle">
            Sistem Pelaporan Insiden Keamanan TIK<br>
            Diskominfo Kabupaten Jombang
        </p>

        
        <div class="text-center mb-3">
            <span class="secure-badge">
                <i class="bi bi-shield-check"></i> Akses Terenkripsi
            </span>
        </div>

        <div class="login-divider"><span>Masuk dengan NIP</span></div>

        
        <?php if($errors->any()): ?>
        <div class="alert-login mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-circle-fill"></i>
            <?php echo e($errors->first()); ?>

        </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
        <div class="alert-success-login mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        
        <form action="<?php echo e(route('login.post')); ?>" method="POST" autocomplete="off">
            <?php echo csrf_field(); ?>

            
            <div class="mb-3">
                <label class="form-label">NIP <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                    <input type="text"
                           name="nip"
                           class="form-control <?php $__errorArgs = ['nip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="Masukkan NIP 18 digit"
                           value="<?php echo e(old('nip')); ?>"
                           maxlength="18"
                           inputmode="numeric"
                           required
                           autofocus>
                </div>
                <p class="form-hint"><i class="bi bi-info-circle me-1"></i>Gunakan NIP ASN Anda (18 digit angka)</p>
            </div>

            
            <div class="mb-4">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password"
                           name="password"
                           id="pw"
                           class="form-control"
                           placeholder="Masukkan password"
                           required>
                    <button type="button" class="btn-toggle-pw" onclick="togglePw()">
                        <i class="bi bi-eye" id="pwIcon"></i>
                    </button>
                </div>
            </div>

            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
            </button>
        </form>
    </div>

    <div class="login-footer">
        &copy; <?php echo e(date('Y')); ?> SILANTEK &mdash; Dinas Komunikasi dan Informatika Kabupaten Jombang
    </div>
</div>

<script>
function togglePw() {
    const input = document.getElementById('pw');
    const icon  = document.getElementById('pwIcon');
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}

// Hanya angka di NIP
document.querySelector('input[name="nip"]').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g,'').slice(0,18);
});


</script>
</body>
</html>
<?php /**PATH D:\Project New Kominfo - Copy\silantek\resources\views/auth/login.blade.php ENDPATH**/ ?>