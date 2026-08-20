<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Opd;
use App\Models\KategoriInsiden;
use App\Models\SlaConfig;

class AdminController extends Controller
{
    // ==================== OPD ====================

    public function opdIndex()
    {
        $opd = Opd::withCount('users')->latest()->paginate(10);
        return view('admin.opd.index', compact('opd'));
    }

    public function opdStore(Request $request)
    {
        $request->validate([
            'nama_opd'   => 'required|string|max:255',
            'alamat'     => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        Opd::create($request->only('nama_opd', 'alamat', 'no_telepon'));
        return back()->with('success', 'OPD berhasil ditambahkan.');
    }

    public function opdUpdate(Request $request, Opd $opd)
    {
        $request->validate([
            'nama_opd'   => 'required|string|max:255',
            'alamat'     => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $opd->update($request->only('nama_opd', 'alamat', 'no_telepon'));
        return back()->with('success', 'OPD berhasil diperbarui.');
    }

    public function opdDestroy(Opd $opd)
    {
        $opd->delete();
        return back()->with('success', 'OPD berhasil dihapus.');
    }

    // ==================== USER ====================

    public function userIndex()
    {
        $users = User::with('opd')->latest()->paginate(10);
        $opd   = Opd::all();
        return view('admin.user.index', compact('users', 'opd'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'nip'      => 'required|digits:18|unique:users,nip',
            'nama'     => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
            'jabatan'  => 'nullable|string|max:255',
            'no_hp'    => 'nullable|string|max:20',
            'role'     => 'required|in:pic_opd,csirt,kabid_aptika,admin',
            'opd_id'   => 'nullable|exists:opd,id',
        ], [
            'nip.digits'  => 'NIP harus tepat 18 digit angka.',
            'nip.unique'  => 'NIP sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'nip'      => $request->nip,
            'nama'     => $request->nama,
            'password' => Hash::make($request->password),
            'jabatan'  => $request->jabatan,
            'no_hp'    => $request->no_hp,
            'role'     => $request->role,
            'opd_id'   => $request->opd_id,
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function userUpdate(Request $request, User $user)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'jabatan'  => 'nullable|string|max:255',
            'no_hp'    => 'nullable|string|max:20',
            'role'     => 'required|in:pic_opd,csirt,kabid_aptika,admin',
            'opd_id'   => 'nullable|exists:opd,id',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only('nama', 'jabatan', 'no_hp', 'role', 'opd_id');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return back()->with('success', 'User berhasil diperbarui.');
    }

    public function userDestroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    // ==================== KATEGORI INSIDEN ====================

    public function kategoriIndex()
    {
        $kategori  = KategoriInsiden::latest()->get();
        $slaConfig = SlaConfig::orderByRaw("FIELD(urgensi, 'rendah', 'sedang', 'tinggi', 'kritis')")->get();
        return view('admin.kategori.index', compact('kategori', 'slaConfig'));
    }

    public function kategoriStore(Request $request)
    {
        $request->validate([
            'kode'      => 'required|unique:kategori_insiden,kode',
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriInsiden::create($request->only('kode', 'nama', 'deskripsi'));
        return back()->with('success', 'Kategori insiden berhasil ditambahkan.');
    }

    public function kategoriDestroy(KategoriInsiden $kategoriInsiden)
    {
        $kategoriInsiden->delete();
        return back()->with('success', 'Kategori insiden berhasil dihapus.');
    }

    // ==================== SLA CONFIG ====================

    public function slaUpdate(Request $request, SlaConfig $slaConfig)
    {
        $request->validate([
            'durasi_jam' => 'required|integer|min:1|max:720',
        ]);

        $slaConfig->update(['durasi_jam' => $request->durasi_jam]);
        return back()->with('success', 'SLA berhasil diperbarui.');
    }
}
