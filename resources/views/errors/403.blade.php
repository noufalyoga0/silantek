<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak | SILANTEK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family:'Inter',sans-serif; background:#f1f5f9; min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .error-card { background:#fff; border-radius:20px; padding:3rem 2.5rem; text-align:center; max-width:480px; width:100%; box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .error-icon { width:80px; height:80px; background:#fee2e2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1.5rem; font-size:2rem; color:#dc2626; }
        .error-code { font-size:4rem; font-weight:700; color:#f1f5f9; text-shadow:0 2px 8px rgba(0,0,0,.05); line-height:1; margin-bottom:0.5rem; }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon"><i class="bi bi-shield-x-fill"></i></div>
        <div class="error-code">403</div>
        <h4 class="fw-bold mb-2" style="color:#0f172a;">Akses Ditolak</h4>
        <p class="text-muted mb-4" style="font-size:0.9rem; line-height:1.6;">
            Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            Pastikan Anda login dengan akun yang sesuai dengan hak akses yang dibutuhkan.
        </p>
        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
            @auth
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-house me-1"></i>Dashboard
            </a>
            @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-box-arrow-in-right me-1"></i>Login
            </a>
            @endauth
        </div>
        <div class="mt-4 pt-3 border-top" style="font-size:0.72rem; color:#94a3b8;">
            SILANTEK &mdash; Diskominfo Kabupaten Jombang
        </div>
    </div>
</body>
</html>
