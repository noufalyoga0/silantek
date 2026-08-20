<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILANTEK — Sistem Pelaporan Insiden Keamanan TIK Kabupaten Jombang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #fff; color: #0f172a; overflow-x: hidden; }

        /* ─── NAVBAR ─── */
        .navbar-silantek {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #f1f5f9;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand-text { font-weight: 800; font-size: 1.2rem; color: #0f172a; }
        .brand-dot { color: #2563eb; }

        /* ─── HERO ─── */
        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(37,99,235,0.2) 0%, transparent 70%);
            top: -100px; right: -100px;
            border-radius: 50%;
        }
        .hero::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(124,58,237,0.15) 0%, transparent 70%);
            bottom: -50px; left: -50px;
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(37,99,235,0.15);
            border: 1px solid rgba(37,99,235,0.3);
            border-radius: 20px;
            padding: 0.4rem 1rem;
            font-size: 0.78rem;
            color: #93c5fd;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #f8fafc;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 1.5rem;
        }
        .hero-title .highlight {
            background: linear-gradient(135deg, #60a5fa, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 1.05rem;
            color: #94a3b8;
            line-height: 1.7;
            max-width: 520px;
            margin-bottom: 2.5rem;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff !important;
            border: none;
            border-radius: 10px;
            padding: 0.85rem 2rem;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 20px rgba(37,99,235,0.35);
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(37,99,235,0.45);
        }

        .hero-stats {
            display: flex;
            gap: 2.5rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .hero-stat-num {
            font-size: 1.75rem;
            font-weight: 800;
            color: #f8fafc;
        }
        .hero-stat-label {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.15rem;
        }

        /* Dashboard mockup */
        .hero-mockup {
            background: #1e293b;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 30px 80px rgba(0,0,0,0.5);
            position: relative;
            z-index: 1;
        }
        .mockup-topbar {
            background: #0f172a;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .mockup-dot { width: 10px; height: 10px; border-radius: 50%; }
        .mockup-body { padding: 1.25rem; }
        .mockup-stat-row { display: flex; gap: 0.75rem; margin-bottom: 0.75rem; }
        .mockup-stat {
            flex: 1; background: #1a2744; border-radius: 8px;
            padding: 0.75rem; text-align: center;
        }
        .mockup-stat .num { font-size: 1.25rem; font-weight: 700; }
        .mockup-stat .lbl { font-size: 0.62rem; color: #64748b; margin-top: 2px; }
        .mockup-table { background: #1a2744; border-radius: 8px; overflow: hidden; }
        .mockup-row { display: flex; align-items: center; gap: 0.5rem; padding: 0.6rem 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.04); font-size: 0.68rem; }
        .mockup-row:last-child { border-bottom: none; }
        .mockup-badge { border-radius: 4px; padding: 2px 6px; font-size: 0.6rem; font-weight: 600; }

        /* ─── FEATURES ─── */
        .section-features { padding: 6rem 0; background: #f8fafc; }
        .feature-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
            border-color: #bfdbfe;
        }
        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1.25rem;
        }
        .feature-title { font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; color: #0f172a; }
        .feature-desc { font-size: 0.85rem; color: #64748b; line-height: 1.6; }

        /* ─── HOW IT WORKS ─── */
        .section-how { padding: 6rem 0; }
        .step-num {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.9rem;
            color: #fff;
            flex-shrink: 0;
        }
        .step-connector {
            width: 2px;
            background: linear-gradient(to bottom, #2563eb, transparent);
            flex: 1;
            margin: 0.5rem 0;
            min-height: 40px;
        }

        /* ─── INSTANSI ─── */
        .section-instansi { padding: 5rem 0; background: #f8fafc; }
        .instansi-badge {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1.25rem;
            font-size: 0.78rem;
            font-weight: 500;
            color: #475569;
            white-space: nowrap;
        }

        /* ─── CTA ─── */
        .section-cta {
            background: linear-gradient(135deg, #1e3a5f, #0f172a);
            padding: 5rem 0;
            text-align: center;
        }

        /* ─── FOOTER ─── */
        .footer {
            background: #0f172a;
            color: #475569;
            padding: 2rem 0;
            text-align: center;
            font-size: 0.78rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        /* Section headings */
        .section-label {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #2563eb;
            margin-bottom: 0.75rem;
        }
        .section-title {
            font-size: clamp(1.75rem, 3vw, 2.25rem);
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
            margin-bottom: 1rem;
        }
        .section-desc {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.7;
            max-width: 560px;
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar-silantek">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <div style="width:32px; height:32px; background:linear-gradient(135deg,#2563eb,#7c3aed); border-radius:8px; display:flex; align-items:center; justify-content:center;">
                <i class="bi bi-shield-lock-fill text-white" style="font-size:0.85rem;"></i>
            </div>
            <span class="navbar-brand-text">SILAN<span class="brand-dot">TEK</span></span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted d-none d-md-inline" style="font-size:0.8rem;">Diskominfo Kab. Jombang</span>
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3">
                <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
            </a>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-badge">
                    <i class="bi bi-patch-check-fill"></i>
                    Sistem Resmi Diskominfo Kabupaten Jombang
                </div>
                <h1 class="hero-title">
                    Lapor Insiden Siber<br>
                    <span class="highlight">Lebih Cepat,</span><br>
                    Lebih Terstruktur
                </h1>
                <p class="hero-desc">
                    SILANTEK adalah platform digital pelaporan insiden keamanan TIK
                    untuk seluruh OPD di lingkungan Pemerintah Kabupaten Jombang.
                    Dari laporan masuk hingga penyelesaian, semua terlacak secara real-time.
                </p>
                <a href="{{ route('login') }}" class="btn-hero-primary">
                    <i class="bi bi-shield-lock me-2"></i>Masuk ke Sistem
                </a>

                <div class="hero-stats">
                    <div>
                        <div class="hero-stat-num">55+</div>
                        <div class="hero-stat-label">OPD Terdaftar</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">4</div>
                        <div class="hero-stat-label">Level Urgensi</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">SLA</div>
                        <div class="hero-stat-label">Terjamin &amp; Terukur</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="hero-mockup">
                    <div class="mockup-topbar">
                        <div class="mockup-dot" style="background:#ef4444;"></div>
                        <div class="mockup-dot" style="background:#f59e0b;"></div>
                        <div class="mockup-dot" style="background:#22c55e;"></div>
                        <span style="font-size:0.7rem; color:#64748b; margin-left:0.5rem;">SILANTEK — Dashboard Tim CSIRT</span>
                    </div>
                    <div class="mockup-body">
                        <div class="mockup-stat-row">
                            <div class="mockup-stat">
                                <div class="num" style="color:#60a5fa;">12</div>
                                <div class="lbl">Total Bulan Ini</div>
                            </div>
                            <div class="mockup-stat">
                                <div class="num" style="color:#f59e0b;">4</div>
                                <div class="lbl">Open</div>
                            </div>
                            <div class="mockup-stat">
                                <div class="num" style="color:#ef4444;">2</div>
                                <div class="lbl">Overdue</div>
                            </div>
                            <div class="mockup-stat">
                                <div class="num" style="color:#22c55e;">6</div>
                                <div class="lbl">Resolved</div>
                            </div>
                        </div>
                        <div class="mockup-table">
                            <div class="mockup-row" style="background:rgba(255,255,255,0.03);">
                                <span style="color:#94a3b8; font-size:0.62rem; width:90px;">TIK-2026-012</span>
                                <span style="color:#e2e8f0; flex:1;">Dinas Kesehatan</span>
                                <span class="mockup-badge" style="background:#fee2e2; color:#dc2626;">Kritis</span>
                                <span class="mockup-badge" style="background:#cffafe; color:#0e7490;">In Progress</span>
                            </div>
                            <div class="mockup-row">
                                <span style="color:#94a3b8; font-size:0.62rem; width:90px;">TIK-2026-011</span>
                                <span style="color:#e2e8f0; flex:1;">Dinas Pendidikan</span>
                                <span class="mockup-badge" style="background:#fef3c7; color:#92400e;">Tinggi</span>
                                <span class="mockup-badge" style="background:#fef3c7; color:#92400e;">Triase</span>
                            </div>
                            <div class="mockup-row">
                                <span style="color:#94a3b8; font-size:0.62rem; width:90px;">TIK-2026-010</span>
                                <span style="color:#e2e8f0; flex:1;">BPKAD</span>
                                <span class="mockup-badge" style="background:#dbeafe; color:#1d4ed8;">Sedang</span>
                                <span class="mockup-badge" style="background:#dcfce7; color:#15803d;">Resolved</span>
                            </div>
                            <div class="mockup-row">
                                <span style="color:#94a3b8; font-size:0.62rem; width:90px;">TIK-2026-009</span>
                                <span style="color:#e2e8f0; flex:1;">Kec. Jombang</span>
                                <span class="mockup-badge" style="background:#dcfce7; color:#15803d;">Rendah</span>
                                <span class="mockup-badge" style="background:#f1f5f9; color:#475569;">Closed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURES --}}
<section class="section-features">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label">Fitur Unggulan</div>
            <h2 class="section-title">Semua yang Dibutuhkan<br>untuk Penanganan Insiden Siber</h2>
            <p class="section-desc mx-auto">
                Dirancang khusus untuk kebutuhan operasional tim CSIRT dan OPD
                di lingkungan Pemerintah Kabupaten Jombang.
            </p>
        </div>
        <div class="row g-3">
            @foreach([
                ['bi-ticket-perforated-fill', '#dbeafe', '#2563eb', 'Sistem Tiket Terstruktur', 'Setiap laporan dibuatkan nomor tiket otomatis dengan tracking status lengkap dari Open hingga Closed.'],
                ['bi-clock-fill', '#dcfce7', '#16a34a', 'SLA Otomatis', 'Batas waktu penanganan dihitung otomatis berdasarkan tingkat urgensi. Sistem menandai dan mengirim notifikasi saat SLA terlewati.'],
                ['bi-bell-fill', '#fef3c7', '#d97706', 'Notifikasi Real-time', 'PIC IT OPD, Tim CSIRT, dan Kabid APTIKA langsung mendapat notifikasi saat ada perubahan status tiket atau eskalasi overdue.'],
                ['bi-bar-chart-fill', '#f3e8ff', '#7c3aed', 'Dashboard Analitik', 'Visualisasi data insiden per bulan, per kategori, dan per OPD untuk mendukung evaluasi dan perencanaan keamanan TIK.'],
                ['bi-people-fill', '#fce7f3', '#db2777', 'Multi-Role Access', 'Empat level akses: PIC IT OPD, Tim CSIRT, Kabid APTIKA, dan Admin — masing-masing dengan dashboard dan hak akses tersendiri.'],
                ['bi-file-earmark-pdf-fill', '#fee2e2', '#dc2626', 'Laporan PDF Resmi', 'Export laporan bulanan dalam format PDF siap cetak dengan kop dan format dokumen resmi pemerintah.'],
            ] as [$icon, $bg, $color, $title, $desc])
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:{{ $bg }};">
                        <i class="bi {{ $icon }}" style="color:{{ $color }};"></i>
                    </div>
                    <div class="feature-title">{{ $title }}</div>
                    <div class="feature-desc">{{ $desc }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section class="section-how">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="section-label">Cara Kerja</div>
                <h2 class="section-title">Proses Pelaporan<br>yang Simpel &amp; Jelas</h2>
                <p class="section-desc">
                    Dari insiden dilaporkan hingga selesai ditangani,
                    semua proses terdokumentasi dengan rapi dan transparan.
                </p>
            </div>
            <div class="col-lg-7">
                <div class="d-flex flex-column gap-0">
                    @foreach([
                        ['1', '#dbeafe', '#2563eb', 'PIC IT OPD Melaporkan', 'Login menggunakan NIP, isi form insiden dengan jenis kejadian, urgensi, deskripsi, dan lampiran. Nomor tiket dibuat otomatis.'],
                        ['2', '#f3e8ff', '#7c3aed', 'Tim CSIRT Menerima', 'Tim CSIRT mendapat notifikasi instan. Tiket masuk ke antrian dengan SLA countdown yang langsung berjalan.'],
                        ['3', '#fef3c7', '#d97706', 'Penanganan Berjalan', 'CSIRT memperbarui status secara berkala. PIC OPD bisa memantau progress real-time tanpa perlu telepon.'],
                        ['4', '#dcfce7', '#16a34a', 'Konfirmasi &amp; Selesai', 'Setelah CSIRT resolve, PIC OPD mengkonfirmasi. Tiket ditutup dan masuk rekap laporan bulanan.'],
                    ] as [$num, $bg, $color, $title, $desc])
                    <div class="d-flex gap-3 align-items-start mb-4">
                        <div class="d-flex flex-column align-items-center">
                            <div style="width:40px; height:40px; background:{{ $bg }}; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem; color:{{ $color }}; flex-shrink:0;">
                                {{ $num }}
                            </div>
                            @if($num !== '4')
                            <div style="width:2px; height:40px; background:linear-gradient(to bottom, {{ $color }}40, transparent); margin-top:4px;"></div>
                            @endif
                        </div>
                        <div class="pt-1">
                            <div class="fw-semibold mb-1" style="font-size:0.95rem;">{!! $title !!}</div>
                            <div class="text-muted" style="font-size:0.83rem; line-height:1.6;">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- INSTANSI --}}
<section class="section-instansi">
    <div class="container text-center">
        <div class="section-label mb-3">OPD yang Dilayani</div>
        <h2 class="section-title mb-2">Melayani Seluruh OPD<br>Kabupaten Jombang</h2>
        <p class="section-desc mx-auto mb-5">
            SILANTEK dirancang untuk melayani seluruh Organisasi Perangkat Daerah
            di lingkungan Pemerintah Kabupaten Jombang.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            @foreach([
                'Sekretariat Daerah','Dinas Komunikasi dan Informatika',
                'Dinas Kesehatan','Dinas Pendidikan','BPKAD',
                'Dinas Dukcapil','Dinas Perhubungan','Bappeda',
                'RSUD Jombang','Dinas Sosial','Satpol PP',
                'Dinas PM dan PTSP','Bapenda','21 Kecamatan','+ dan lainnya',
            ] as $nama)
            <span class="instansi-badge">{{ $nama }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="section-cta">
    <div class="container">
        <div style="max-width:560px; margin:0 auto;">
            <div class="hero-badge justify-content-center mb-3" style="display:inline-flex;">
                <i class="bi bi-shield-check-fill"></i>
                Sistem Keamanan Terenkripsi
            </div>
            <h2 style="font-size:2.25rem; font-weight:800; color:#f8fafc; margin-bottom:1rem; line-height:1.2;">
                Siap Melindungi Aset Digital Pemerintah Jombang
            </h2>
            <p style="color:#94a3b8; font-size:0.95rem; line-height:1.7; margin-bottom:2rem;">
                Hubungi Admin Diskominfo untuk mendapatkan akun dan mulai menggunakan SILANTEK
                di instansi Anda.
            </p>
            <a href="{{ route('login') }}" class="btn-hero-primary" style="display:inline-block;">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke SILANTEK
            </a>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
            <div>
                <strong style="color:#94a3b8;">SILANTEK</strong>
                <span class="mx-2" style="color:#334155;">—</span>
                Sistem Pelaporan Insiden Keamanan TIK
            </div>
            <div>
                &copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kabupaten Jombang
            </div>
        </div>
    </div>
</footer>

</body>
</html>
