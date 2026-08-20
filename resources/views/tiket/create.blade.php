@extends('layouts.app')

@section('title', 'Laporkan Insiden')
@section('page-title', 'Laporkan Insiden Baru')

@section('content')

{{-- ── HERO BANNER ── --}}
<div class="mb-4" style="border-radius:16px; overflow:hidden; position:relative;
     background:linear-gradient(135deg,#0f172a 0%,#7f1d1d 50%,#dc2626 100%);
     padding:1.75rem 2rem;">
    <div style="position:absolute; top:-20px; right:-20px; width:160px; height:160px;
                border-radius:50%; background:rgba(255,255,255,0.05);"></div>
    <div style="position:absolute; bottom:-30px; left:40%; width:100px; height:100px;
                border-radius:50%; background:rgba(255,255,255,0.04);"></div>
    <div style="position:relative; z-index:1;">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div style="width:36px; height:36px; border-radius:10px;
                        background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.2);
                        display:flex; align-items:center; justify-content:center;">
                <i class="bi bi-shield-exclamation text-white" style="font-size:1rem;"></i>
            </div>
            <span class="text-white" style="font-size:0.78rem; opacity:0.7;">
                Pelaporan Insiden Resmi · SILANTEK
            </span>
        </div>
        <h4 class="text-white fw-bold mb-1" style="font-size:1.3rem;">
            Laporkan Insiden Keamanan TIK
        </h4>
        <p class="mb-0" style="color:rgba(255,255,255,.6); font-size:0.82rem;">
            Isi formulir dengan lengkap agar Tim CSIRT dapat menangani lebih cepat
        </p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <form action="{{ route('tiket.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ── STEP 1: IDENTITAS ── --}}
            <div class="card border-0 shadow-sm mb-4" style="overflow:hidden;">
                <div style="background:linear-gradient(135deg,#1e3a5f,#2563eb); padding:1rem 1.25rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-semibold text-white d-flex align-items-center gap-2">
                            <i class="bi bi-person-badge-fill"></i>Identitas Pelapor
                        </h6>
                        <span class="badge" style="background:rgba(255,255,255,0.2);
                                   color:#fff; font-size:0.68rem; border-radius:6px;">
                            <i class="bi bi-lock-fill me-1" style="font-size:0.6rem;"></i>Otomatis terisi
                        </span>
                    </div>
                    <p class="mb-0 mt-1 text-white" style="font-size:0.72rem; opacity:0.65;">
                        Data diambil dari akun Anda — tidak perlu diisi ulang
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div style="background:#f8fafc; border-radius:10px; padding:0.7rem 1rem;
                                        border:1px solid #f1f5f9; border-left:3px solid #2563eb;">
                                <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.25rem;">
                                    <i class="bi bi-person me-1"></i>Nama Lengkap
                                </div>
                                <div class="fw-semibold" style="font-size:0.875rem; color:#0f172a;">{{ $user->nama }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="background:#f8fafc; border-radius:10px; padding:0.7rem 1rem;
                                        border:1px solid #f1f5f9; border-left:3px solid #7c3aed;">
                                <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.25rem;">
                                    <i class="bi bi-credit-card me-1"></i>NIP
                                </div>
                                <div class="fw-semibold" style="font-size:0.875rem; color:#0f172a; font-variant-numeric:tabular-nums;">{{ $user->nip }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="background:#f8fafc; border-radius:10px; padding:0.7rem 1rem;
                                        border:1px solid #f1f5f9; border-left:3px solid #0891b2;">
                                <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.25rem;">
                                    <i class="bi bi-briefcase me-1"></i>Jabatan
                                </div>
                                <div class="fw-semibold" style="font-size:0.875rem; color:#0f172a;">{{ $user->jabatan ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="background:#f8fafc; border-radius:10px; padding:0.7rem 1rem;
                                        border:1px solid #f1f5f9; border-left:3px solid #16a34a;">
                                <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.6px; color:#94a3b8; margin-bottom:0.25rem;">
                                    <i class="bi bi-telephone me-1"></i>No. HP
                                </div>
                                <div class="fw-semibold" style="font-size:0.875rem; color:#0f172a;">{{ $user->no_hp ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div style="background:linear-gradient(135deg,#eff6ff,#f0f9ff); border-radius:10px;
                                        padding:0.75rem 1rem; border:1px solid #bfdbfe; border-left:3px solid #2563eb;">
                                <div style="font-size:0.62rem; text-transform:uppercase; letter-spacing:0.6px; color:#60a5fa; margin-bottom:0.25rem;">
                                    <i class="bi bi-buildings me-1"></i>Organisasi Perangkat Daerah
                                </div>
                                <div class="fw-bold" style="font-size:0.95rem; color:#1e40af;">{{ $user->opd->nama_opd ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── STEP 2: DETAIL INSIDEN ── --}}
            <div class="card border-0 shadow-sm mb-4" style="overflow:hidden;">
                <div style="background:linear-gradient(135deg,#7f1d1d,#dc2626); padding:1rem 1.25rem;">
                    <h6 class="mb-0 fw-semibold text-white d-flex align-items-center gap-2">
                        <i class="bi bi-shield-exclamation-fill"></i>Detail Insiden
                    </h6>
                    <p class="mb-0 mt-1 text-white" style="font-size:0.72rem; opacity:0.65;">
                        Isi semua informasi insiden dengan lengkap dan akurat
                    </p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">

                        {{-- Tanggal Kejadian --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">
                                Tanggal Kejadian <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="tanggal_kejadian"
                                   class="form-control @error('tanggal_kejadian') is-invalid @enderror"
                                   value="{{ old('tanggal_kejadian', date('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}"
                                   required>
                            @error('tanggal_kejadian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text small">Kapan insiden ini pertama kali terjadi?</div>
                        </div>

                        {{-- Jenis Insiden --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">
                                Jenis Insiden <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_insiden"
                                    id="selectJenisInsiden"
                                    class="form-select @error('jenis_insiden') is-invalid @enderror"
                                    required
                                    onchange="toggleLainnya(this)">
                                <option value="">-- Pilih Jenis Insiden --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}"
                                            data-lainnya="{{ $k->kode === 'I-07' ? '1' : '0' }}"
                                            {{ old('jenis_insiden') == $k->id ? 'selected' : '' }}>
                                        {{ $k->kode }} — {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_insiden')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="inputLainnya" class="mt-2" style="display:none;">
                                <input type="text"
                                       name="keterangan_lainnya"
                                       id="keteranganLainnya"
                                       class="form-control @error('keterangan_lainnya') is-invalid @enderror"
                                       placeholder="Jelaskan jenis insiden singkat..."
                                       value="{{ old('keterangan_lainnya') }}"
                                       maxlength="100">
                                <div class="form-text small">Contoh: Spoofing email, Man-in-the-middle, dll.</div>
                                @error('keterangan_lainnya')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tingkat Urgensi --}}
                        <div class="col-12">
                            <label class="form-label small fw-semibold">
                                Tingkat Urgensi <span class="text-danger">*</span>
                            </label>
                            @php
                                $urgensiConfig = [
                                    'rendah' => ['#f0fdf4','#dcfce7','#16a34a','✅'],
                                    'sedang' => ['#ecfeff','#cffafe','#0891b2','⚠️'],
                                    'tinggi' => ['#fefce8','#fef3c7','#d97706','🔴'],
                                    'kritis' => ['#fff1f2','#fee2e2','#dc2626','🚨'],
                                ];
                            @endphp
                            <div class="row g-2">
                                @foreach($slaConfigs as $sla)
                                @php [$bgLight,$bg,$tc,$em] = $urgensiConfig[$sla->urgensi] ?? ['#f8fafc','#f1f5f9','#475569','•']; @endphp
                                <div class="col-6 col-md-3">
                                    <input type="radio" class="btn-check"
                                           name="sla_config_id"
                                           id="sla_{{ $sla->id }}"
                                           value="{{ $sla->id }}"
                                           {{ old('sla_config_id') == $sla->id ? 'checked' : '' }}
                                           required>
                                    <label class="d-block text-center p-3 rounded-3 h-100"
                                           for="sla_{{ $sla->id }}"
                                           style="border:2px solid {{ $bg }}; background:{{ $bgLight }};
                                                  cursor:pointer; transition:all .15s;">
                                        <div style="font-size:1.3rem; margin-bottom:0.3rem;">{{ $em }}</div>
                                        <div class="fw-bold" style="color:{{ $tc }}; font-size:0.88rem;">
                                            {{ $sla->label_urgensi }}
                                        </div>
                                        <div style="font-size:0.68rem; color:{{ $tc }}; opacity:0.75; margin-top:2px;">
                                            SLA: {{ $sla->durasi_jam }} jam
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('sla_config_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="mt-2 p-2 rounded-3" style="background:#f8fafc; border:1px solid #f1f5f9; font-size:0.72rem; color:#64748b;">
                                <strong style="color:#374151;">Panduan:</strong>
                                ✅ <strong>Rendah</strong> — tidak mengganggu layanan &nbsp;·&nbsp;
                                ⚠️ <strong>Sedang</strong> — gangguan sebagian &nbsp;·&nbsp;
                                🔴 <strong>Tinggi</strong> — tidak bisa diakses &nbsp;·&nbsp;
                                🚨 <strong>Kritis</strong> — sistem lumpuh / data bocor
                            </div>
                        </div>

                        {{-- Deskripsi Kejadian --}}
                        <div class="col-12">
                            <label class="form-label small fw-semibold">
                                Deskripsi Kejadian <span class="text-danger">*</span>
                            </label>
                            <textarea name="deskripsi"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="5"
                                      placeholder="Jelaskan insiden secara detail: apa yang terjadi, kapan pertama kali terdeteksi, dampak yang dirasakan, langkah yang sudah dilakukan, dsb."
                                      required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text small">Minimal 20 karakter. Semakin detail, semakin cepat ditangani.</div>
                        </div>

                        {{-- Lampiran --}}
                        <div class="col-12">
                            <label class="form-label small fw-semibold">
                                Lampiran / Screenshot
                                <span class="badge ms-1" style="background:#f1f5f9; color:#64748b; font-size:0.65rem; font-weight:500;">Opsional</span>
                            </label>
                            <div id="dropZone"
                                 style="border:2px dashed #e2e8f0; border-radius:12px; padding:2rem; text-align:center;
                                        background:#f8fafc; cursor:pointer; transition:all .2s;"
                                 onclick="document.getElementById('lampiranPicker').click()"
                                 ondragover="event.preventDefault(); this.style.borderColor='#2563eb'; this.style.background='#eff6ff';"
                                 ondragleave="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';"
                                 ondrop="handleDrop(event)">
                                <div style="width:52px; height:52px; background:#eff6ff; border-radius:12px;
                                            display:flex; align-items:center; justify-content:center; margin:0 auto .75rem;">
                                    <i class="bi bi-cloud-arrow-up" style="font-size:1.5rem; color:#2563eb;"></i>
                                </div>
                                <p class="mb-1 small fw-semibold" style="color:#374151;">
                                    <span style="color:#2563eb; text-decoration:underline;">Klik untuk pilih file</span>
                                    &nbsp;atau drag &amp; drop
                                </p>
                                <p class="mb-0" style="font-size:0.72rem; color:#94a3b8;">
                                    JPG, PNG, PDF &nbsp;·&nbsp; Maks. 5MB/file &nbsp;·&nbsp; Bisa pilih beberapa file
                                </p>
                            </div>
                            <input type="file" id="lampiranPicker" class="d-none" multiple accept=".jpg,.jpeg,.png,.pdf">
                            <div id="lampiranInputs"></div>
                            <div id="filePreview" class="mt-3" style="display:none;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="small fw-semibold" style="color:#374151;">
                                        <i class="bi bi-paperclip me-1 text-primary"></i>
                                        File terpilih: <span id="fileCount">0</span> file
                                    </span>
                                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2"
                                            onclick="clearAllFiles()" style="font-size:0.72rem;">
                                        <i class="bi bi-trash me-1"></i>Hapus semua
                                    </button>
                                </div>
                                <div id="fileGrid" class="row g-2"></div>
                            </div>
                            <div class="form-text small mt-1">
                                <i class="bi bi-info-circle me-1 text-primary"></i>
                                Boleh dikosongkan. Lampiran membantu Tim CSIRT memahami insiden lebih cepat.
                            </div>
                            @error('lampiran.*')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── TOMBOL SUBMIT ── --}}
            <div class="d-flex align-items-center justify-content-between gap-3 mb-4
                         p-3 rounded-3"
                 style="background:linear-gradient(135deg,#0f172a,#1e3a5f); border-radius:14px !important;">
                <div class="text-white d-none d-md-block" style="font-size:0.82rem; opacity:0.7;">
                    <i class="bi bi-info-circle me-1"></i>
                    Pastikan semua informasi sudah benar sebelum mengirim
                </div>
                <div class="d-flex gap-2 ms-auto">
                    {{-- Tombol Batal -- dibuat kontras --}}
                    <a href="{{ route('dashboard') }}"
                       style="display:inline-flex; align-items:center; gap:0.35rem;
                              background:#fff; color:#374151; font-weight:600;
                              border-radius:8px; padding:0.5rem 1.25rem;
                              font-size:0.82rem; text-decoration:none;
                              border:none; white-space:nowrap;
                              transition:all .15s;"
                       onmouseover="this.style.background='#f1f5f9'"
                       onmouseout="this.style.background='#fff'">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                    {{-- Tombol Kirim --}}
                    <button type="submit"
                            style="display:inline-flex; align-items:center; gap:0.35rem;
                                   background:linear-gradient(135deg,#dc2626,#b91c1c);
                                   color:#fff; font-weight:600; border:none;
                                   border-radius:8px; padding:0.5rem 1.5rem;
                                   font-size:0.82rem; cursor:pointer; white-space:nowrap;
                                   box-shadow:0 4px 12px rgba(220,38,38,.3);"
                            onmouseover="this.style.background='linear-gradient(135deg,#b91c1c,#991b1b)'"
                            onmouseout="this.style.background='linear-gradient(135deg,#dc2626,#b91c1c)'">
                        <i class="bi bi-send-fill"></i> Kirim Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleLainnya(select) {
    const opt = select.options[select.selectedIndex];
    const isLainnya = opt && opt.dataset.lainnya === '1';
    const box   = document.getElementById('inputLainnya');
    const input = document.getElementById('keteranganLainnya');
    if (isLainnya) { box.style.display = 'block'; input.required = true; }
    else { box.style.display = 'none'; input.required = false; input.value = ''; }
}

document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('selectJenisInsiden');
    if (select) toggleLainnya(select);

    // Highlight radio urgensi saat dipilih
    document.querySelectorAll('input[name="sla_config_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('input[name="sla_config_id"]').forEach(r => {
                const lbl = r.nextElementSibling;
                if (lbl) { lbl.style.transform = 'scale(1)'; lbl.style.boxShadow = ''; }
            });
            const lbl = this.nextElementSibling;
            if (lbl) {
                lbl.style.transform    = 'scale(1.03)';
                lbl.style.boxShadow    = '0 4px 16px rgba(0,0,0,0.12)';
                lbl.style.borderWidth  = '2.5px';
            }
        });
    });
});

// ── LAMPIRAN ────────────────────────────────────────────────────
let allFiles = [];

function renderPreview() {
    const grid    = document.getElementById('fileGrid');
    const preview = document.getElementById('filePreview');
    const count   = document.getElementById('fileCount');
    const inputs  = document.getElementById('lampiranInputs');
    count.textContent = allFiles.length;
    preview.style.display = allFiles.length > 0 ? 'block' : 'none';
    grid.innerHTML = '';
    allFiles.forEach((file, index) => {
        const isImage = file.type.startsWith('image/');
        const isPdf   = file.type === 'application/pdf';
        const sizeMB  = (file.size / 1024 / 1024).toFixed(2);
        const terlalu = file.size > 5 * 1024 * 1024;
        const col = document.createElement('div');
        col.className = 'col-6 col-md-4 col-lg-3';
        col.innerHTML = `
            <div style="border:1px solid ${terlalu ? '#fecaca' : '#e2e8f0'};
                        border-radius:10px; overflow:hidden;
                        background:${terlalu ? '#fff1f2' : '#fff'};
                        position:relative;">
                ${isImage ? `
                    <div style="height:80px; overflow:hidden; background:#f1f5f9;">
                        <img src="${URL.createObjectURL(file)}" style="width:100%; height:100%; object-fit:cover;">
                    </div>` : `
                    <div style="height:80px; background:${isPdf ? '#fff1f0' : '#f0f9ff'};
                                display:flex; align-items:center; justify-content:center;">
                        <i class="bi ${isPdf ? 'bi-file-earmark-pdf-fill' : 'bi-file-earmark-fill'}"
                           style="font-size:2rem; color:${isPdf ? '#ef4444' : '#3b82f6'};"></i>
                    </div>`}
                <div style="padding:0.5rem 0.6rem; border-top:1px solid #f1f5f9;">
                    <div style="font-size:0.72rem; font-weight:600; color:#374151;
                                white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"
                         title="${file.name}">${file.name}</div>
                    <div style="font-size:0.65rem; color:${terlalu ? '#dc2626' : '#94a3b8'}; margin-top:1px;">
                        ${terlalu ? '⚠ Melebihi 5MB' : sizeMB + ' MB'}
                    </div>
                </div>
                <button type="button" onclick="removeFile(${index})"
                        style="position:absolute; top:4px; right:4px; width:20px; height:20px;
                               border-radius:50%; background:rgba(0,0,0,.5); border:none; color:#fff;
                               font-size:0.6rem; display:flex; align-items:center;
                               justify-content:center; cursor:pointer;">✕</button>
            </div>`;
        grid.appendChild(col);
    });
    inputs.innerHTML = '';
    const dt = new DataTransfer();
    allFiles.forEach(f => dt.items.add(f));
    const inp = document.createElement('input');
    inp.type = 'file'; inp.name = 'lampiran[]'; inp.multiple = true; inp.style.display = 'none';
    inp.files = dt.files;
    inputs.appendChild(inp);
}

function addFiles(files) {
    Array.from(files).forEach(file => {
        const dup = allFiles.some(f => f.name === file.name && f.size === file.size);
        if (!dup) allFiles.push(file);
    });
    renderPreview();
}
function removeFile(i)  { allFiles.splice(i, 1); renderPreview(); }
function clearAllFiles() { allFiles = []; renderPreview(); }
function handleDrop(e)  {
    e.preventDefault();
    document.getElementById('dropZone').style.borderColor = '#e2e8f0';
    document.getElementById('dropZone').style.background  = '#f8fafc';
    addFiles(e.dataTransfer.files);
}
document.getElementById('lampiranPicker').addEventListener('change', function() {
    addFiles(this.files); this.value = '';
});
</script>
@endpush
