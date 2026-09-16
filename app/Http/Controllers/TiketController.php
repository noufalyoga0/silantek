<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tiket;
use App\Models\KategoriInsiden;
use App\Models\SlaConfig;
use App\Models\LogStatus;
use App\Models\LampiranTiket;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;

class TiketController extends Controller
{
    // ==================== INDEX ====================

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Tiket::with(['opd', 'kategoriInsiden', 'slaConfig', 'pelapor']);

        // PIC OPD hanya lihat tiket OPD-nya sendiri
        if ($user->isPicOpd()) {
            $query->where('opd_id', $user->opd_id);
        }

        // Filter
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->urgensi) {
            $query->whereHas('slaConfig', fn($q) => $q->where('urgensi', $request->urgensi));
        }
        if ($request->opd_id) {
            $query->where('opd_id', $request->opd_id);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_tiket', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pelapor', 'like', '%' . $request->search . '%');
            });
        }

        $tiket = $query->latest()->paginate(10)->withQueryString();
        $slaConfigs = SlaConfig::all();

        return view('tiket.index', compact('tiket', 'slaConfigs', 'user'));
    }

    // ==================== CREATE ====================

    public function create()
    {
        $user = Auth::user();
        $kategori = KategoriInsiden::all();
        $slaConfigs = SlaConfig::orderByRaw("FIELD(urgensi, 'rendah', 'sedang', 'tinggi', 'kritis')")->get();

        return view('tiket.create', compact('kategori', 'slaConfigs', 'user'));
    }

    public function store(Request $request)
    {
        // Cek apakah pilih "Lainnya" (I-07)
        $isLainnya = false;
        if ($request->jenis_insiden) {
            $kat = \App\Models\KategoriInsiden::find($request->jenis_insiden);
            $isLainnya = $kat && $kat->kode === 'I-07';
        }

        $rules = [
            'tanggal_kejadian'  => 'required|date|before_or_equal:today',
            'jenis_insiden'     => 'required|exists:kategori_insiden,id',
            'sla_config_id'     => 'required|exists:sla_config,id',
            'deskripsi'         => 'required',
            'lampiran.*'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        if ($isLainnya) {
            $rules['keterangan_lainnya'] = 'required|string|max:100';
        }

        $request->validate($rules, [
            'tanggal_kejadian.required'       => 'Tanggal kejadian wajib diisi.',
            'tanggal_kejadian.before_or_equal' => 'Tanggal kejadian tidak boleh lebih dari hari ini.',
            'jenis_insiden.required'          => 'Jenis insiden wajib dipilih.',
            'sla_config_id.required'          => 'Tingkat urgensi wajib dipilih.',
            'deskripsi.required'              => 'Deskripsi kejadian wajib diisi.',
            'keterangan_lainnya.required'     => 'Keterangan jenis insiden wajib diisi.',
            'lampiran.*.mimes'                => 'Format file harus JPG, PNG, atau PDF.',
            'lampiran.*.max'                  => 'Ukuran file maksimal 2MB.',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($request, $user, $isLainnya) {
            $slaConfig = SlaConfig::findOrFail($request->sla_config_id);

            // Buat tiket
            $tiket = Tiket::create([
                'nomor_tiket'     => Tiket::generateNomorTiket(),
                'opd_id'          => $user->opd_id,
                'pelapor_id'      => $user->id,
                // Snapshot identitas pelapor
                'nama_pelapor'    => $user->nama,
                'nip_pelapor'     => $user->nip,
                'jabatan_pelapor' => $user->jabatan,
                'no_hp_pelapor'   => $user->no_hp,
                // Detail insiden
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'jenis_insiden'   => $request->jenis_insiden,
                'sla_config_id'   => $request->sla_config_id,
                'deskripsi'       => $request->deskripsi .
                    ($isLainnya && $request->keterangan_lainnya
                        ? "\n\n[Keterangan jenis insiden: " . $request->keterangan_lainnya . "]"
                        : ''),
                'status'          => 'open',
                'sla_deadline'    => Carbon::now()->addHours($slaConfig->durasi_jam),
                'is_overdue'      => false,
            ]);

            // Simpan lampiran
            if ($request->hasFile('lampiran')) {
                foreach ($request->file('lampiran') as $file) {
                    $path = $file->store('lampiran/' . $tiket->id, 'public');
                    LampiranTiket::create([
                        'tiket_id'    => $tiket->id,
                        'file_path'   => $path,
                        'file_name'   => $file->getClientOriginalName(),
                        'file_type'   => $file->getClientMimeType(),
                        'uploaded_at' => now(),
                    ]);
                }
            }

            // Log status awal
            LogStatus::create([
                'tiket_id'    => $tiket->id,
                'status_lama' => null,
                'status_baru' => 'open',
                'catatan'     => 'Tiket dibuat oleh ' . $user->nama,
                'diubah_oleh' => $user->id,
            ]);

            // Kirim notifikasi ke semua tim CSIRT
            $csirtUsers = User::where('role', 'csirt')->pluck('id')->toArray();
            Notifikasi::kirim(
                $tiket->id,
                $csirtUsers,
                'tiket_masuk',
                'Tiket baru masuk: ' . $tiket->nomor_tiket . ' dari ' . $user->opd->nama_opd
            );
        });

        return redirect()->route('tiket.index')
            ->with('success', 'Laporan insiden berhasil dikirim!');
    }

    // ==================== SHOW ====================

    public function show(Tiket $tiket)
    {
        $user = Auth::user();

        if ($user->isPicOpd() && $tiket->opd_id !== $user->opd_id) {
            abort(403);
        }

        $tiket->load(['opd', 'kategoriInsiden', 'slaConfig', 'slaConfigOverride', 'pelapor', 'lampiranTiket', 'logStatus.pengubah']);

        $user->notifikasi()->where('tiket_id', $tiket->id)->update(['is_read' => true]);

        return view('tiket.show', compact('tiket', 'user'));
    }

    // ==================== UPDATE STATUS (CSIRT) ====================

    public function updateStatus(Request $request, Tiket $tiket)
    {
        $user = Auth::user();

        if (!$user->isCsirt()) {
            abort(403);
        }

        $request->validate([
            'status'                 => 'required|in:triase,in_progress,resolved',
            'catatan'                => 'required',
            'sla_config_override_id' => 'nullable|exists:sla_config,id',
            'catatan_triase'         => 'nullable|string|max:500',
        ], [
            'status.required'  => 'Status wajib dipilih.',
            'catatan.required' => 'Catatan teknis wajib diisi.',
            'catatan.min'      => 'Catatan minimal 10 karakter.',
        ]);

        // Validasi catatan_triase wajib kalau ada override
        if ($request->filled('sla_config_override_id') && !$request->filled('catatan_triase')) {
            return back()->withErrors(['catatan_triase' => 'Alasan perubahan urgensi wajib diisi.']);
        }

        $transisiValid = [
            'open'        => ['triase'],
            'triase'      => ['in_progress'],
            'in_progress' => ['resolved'],
            'reopen'      => ['in_progress', 'resolved'],
        ];

        if (!in_array($request->status, $transisiValid[$tiket->status] ?? [])) {
            return back()->withErrors(['status' => 'Transisi status tidak valid.']);
        }

        DB::transaction(function () use ($request, $tiket, $user) {
            $statusLama = $tiket->status;
            $statusBaru = $request->status;
            $updateData = ['status' => $statusBaru];
            $catatanLog = $request->catatan;

            // ── OVERRIDE URGENSI saat Triase ───────────────────────────────
            if ($statusBaru === 'triase' && $request->filled('sla_config_override_id')) {
                $slaOverride = SlaConfig::find($request->sla_config_override_id);

                if ($slaOverride && $slaOverride->id !== $tiket->sla_config_id) {
                    // Simpan override dan hitung ulang SLA deadline
                    $updateData['sla_config_override_id'] = $slaOverride->id;
                    $updateData['sla_deadline']            = Carbon::now()->addHours($slaOverride->durasi_jam);
                    $updateData['catatan_triase']          = $request->catatan_triase;

                    // Tambahkan info override ke catatan log
                    $urgensiAsal  = ucfirst($tiket->slaConfig->urgensi ?? '-');
                    $urgensiBaru  = ucfirst($slaOverride->urgensi);
                    $catatanLog   = '[OVERRIDE: ' . $urgensiAsal . ' → ' . $urgensiBaru . '] ' . $request->catatan;
                }
            }

            if ($statusBaru === 'resolved') {
                $updateData['resolved_at'] = now();
            }

            $tiket->update($updateData);

            LogStatus::create([
                'tiket_id'    => $tiket->id,
                'status_lama' => $statusLama,
                'status_baru' => $statusBaru,
                'catatan'     => $catatanLog,
                'diubah_oleh' => $user->id,
            ]);

            // Notifikasi ke PIC OPD
            $pesan = 'Status tiket ' . $tiket->nomor_tiket . ' diperbarui menjadi: ' . strtoupper($statusBaru);
            if (isset($slaOverride) && $slaOverride->id !== $tiket->sla_config_id) {
                $pesan .= '. Urgensi diverifikasi CSIRT: '
                    . ucfirst($tiket->slaConfig->urgensi) . ' → ' . ucfirst($slaOverride->urgensi);
            }

            Notifikasi::kirim($tiket->id, [$tiket->pelapor_id], 'update_status', $pesan);

            // Notifikasi overdue ke Kabid jika ada override ke kritis
            if (isset($slaOverride) && $slaOverride->urgensi === 'kritis') {
                $kabidIds = User::where('role', 'kabid_aptika')->pluck('id')->toArray();
                if (!empty($kabidIds)) {
                    Notifikasi::kirim(
                        $tiket->id, $kabidIds, 'update_status',
                        'Perhatian: Tiket ' . $tiket->nomor_tiket . ' diverifikasi CSIRT sebagai KRITIS. Pantau penanganan.'
                    );
                }
            }
        });

        return back()->with('success', 'Status tiket berhasil diperbarui.');
    }

    // ==================== KONFIRMASI SELESAI (PIC OPD) ====================

    public function konfirmasiSelesai(Request $request, Tiket $tiket)
    {
        $user = Auth::user();

        if (!$user->isPicOpd() || $tiket->opd_id !== $user->opd_id) {
            abort(403);
        }

        if ($tiket->status !== 'resolved') {
            return back()->with('error', 'Tiket belum berstatus Resolved.');
        }

        $request->validate([
            'keputusan' => 'required|in:setuju,tolak',
            'catatan'   => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $tiket, $user) {
            if ($request->keputusan === 'setuju') {
                // Tutup tiket
                $tiket->update([
                    'status'    => 'closed',
                    'closed_at' => now(),
                ]);

                LogStatus::create([
                    'tiket_id'    => $tiket->id,
                    'status_lama' => 'resolved',
                    'status_baru' => 'closed',
                    'catatan'     => $request->catatan ?? 'PIC OPD mengkonfirmasi insiden telah selesai.',
                    'diubah_oleh' => $user->id,
                ]);

                // Notifikasi ke CSIRT
                $csirtUsers = User::where('role', 'csirt')->pluck('id')->toArray();
                Notifikasi::kirim(
                    $tiket->id,
                    $csirtUsers,
                    'selesai',
                    'Tiket ' . $tiket->nomor_tiket . ' telah dikonfirmasi selesai oleh PIC OPD.'
                );
            } else {
                // Reopen tiket
                $tiket->update(['status' => 'reopen']);

                LogStatus::create([
                    'tiket_id'    => $tiket->id,
                    'status_lama' => 'resolved',
                    'status_baru' => 'reopen',
                    'catatan'     => $request->catatan ?? 'PIC OPD menolak penyelesaian, insiden belum benar-benar selesai.',
                    'diubah_oleh' => $user->id,
                ]);

                // Notifikasi ke CSIRT
                $csirtUsers = User::where('role', 'csirt')->pluck('id')->toArray();
                Notifikasi::kirim(
                    $tiket->id,
                    $csirtUsers,
                    'reopen',
                    'Tiket ' . $tiket->nomor_tiket . ' di-reopen oleh PIC OPD. Insiden perlu ditangani ulang.'
                );
            }
        });

        $pesan = $request->keputusan === 'setuju'
            ? 'Tiket berhasil ditutup. Terima kasih!'
            : 'Tiket berhasil di-reopen. Tim CSIRT akan menindaklanjuti.';

        return back()->with('success', $pesan);
    }

    // ==================== NOTIFIKASI ====================

    public function notifikasi()
    {
        $user = Auth::user();
        $notifikasi = $user->notifikasi()
            ->with('tiket')
            ->latest()
            ->paginate(15);

        // Tandai semua sebagai dibaca
        $user->notifikasi()->where('is_read', false)->update(['is_read' => true]);

        return view('tiket.notifikasi', compact('notifikasi', 'user'));
    }
}
