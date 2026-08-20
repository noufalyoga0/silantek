<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Opd;
use App\Models\SlaConfig;
use App\Models\KategoriInsiden;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== SLA CONFIG ====================
        $slaData = [
            ['urgensi' => 'rendah',  'durasi_jam' => 168],
            ['urgensi' => 'sedang',  'durasi_jam' => 72],
            ['urgensi' => 'tinggi',  'durasi_jam' => 24],
            ['urgensi' => 'kritis',  'durasi_jam' => 4],
        ];
        foreach ($slaData as $sla) {
            SlaConfig::firstOrCreate(['urgensi' => $sla['urgensi']], $sla);
        }

        // ==================== KATEGORI INSIDEN ====================
        $kategori = [
            ['kode' => 'I-01', 'nama' => 'Web Defacing',   'deskripsi' => 'Tampilan website OPD diubah oleh pihak tidak bertanggung jawab'],
            ['kode' => 'I-02', 'nama' => 'Phishing',       'deskripsi' => 'Email atau pesan palsu mengatasnamakan instansi pemerintah'],
            ['kode' => 'I-03', 'nama' => 'Malware',        'deskripsi' => 'Perangkat terinfeksi virus, ransomware, atau spyware'],
            ['kode' => 'I-04', 'nama' => 'Gangguan Akses', 'deskripsi' => 'Website atau aplikasi OPD tidak dapat diakses'],
            ['kode' => 'I-05', 'nama' => 'Kebocoran Data', 'deskripsi' => 'Data internal OPD diduga diakses pihak tidak berwenang'],
            ['kode' => 'I-06', 'nama' => 'Brute Force',    'deskripsi' => 'Percobaan login berulang ke sistem milik OPD'],
            ['kode' => 'I-07', 'nama' => 'Lainnya',        'deskripsi' => 'Insiden keamanan TIK di luar kategori di atas'],
        ];
        foreach ($kategori as $k) {
            KategoriInsiden::firstOrCreate(['kode' => $k['kode']], $k);
        }

        // ==================== OPD REAL KABUPATEN JOMBANG ====================
        $opdData = [
            // Sekretariat
            ['nama_opd' => 'Sekretariat Daerah Kabupaten Jombang',           'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861365'],
            ['nama_opd' => 'Sekretariat DPRD Kabupaten Jombang',             'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861463'],

            // Inspektorat
            ['nama_opd' => 'Inspektorat Kabupaten Jombang',                  'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861558'],

            // Dinas
            ['nama_opd' => 'Dinas Komunikasi dan Informatika',               'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861555'],
            ['nama_opd' => 'Dinas Pendidikan dan Kebudayaan',                'alamat' => 'Jl. Pattimura No.5, Jombang',           'no_telepon' => '(0321) 861877'],
            ['nama_opd' => 'Dinas Kesehatan',                                'alamat' => 'Jl. Dr. Soetomo No.14, Jombang',        'no_telepon' => '(0321) 861354'],
            ['nama_opd' => 'Dinas Pekerjaan Umum dan Penataan Ruang',        'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861444'],
            ['nama_opd' => 'Dinas Perumahan Rakyat dan Kawasan Permukiman',  'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861777'],
            ['nama_opd' => 'Dinas Sosial',                                   'alamat' => 'Jl. Ahmad Yani No.1, Jombang',          'no_telepon' => '(0321) 861622'],
            ['nama_opd' => 'Dinas Tenaga Kerja',                             'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861755'],
            ['nama_opd' => 'Dinas Pemberdayaan Perempuan dan Perlindungan Anak', 'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861560'],
            ['nama_opd' => 'Dinas Ketahanan Pangan dan Pertanian',           'alamat' => 'Jl. Wahid Hasyim No.141, Jombang',     'no_telepon' => '(0321) 861570'],
            ['nama_opd' => 'Dinas Lingkungan Hidup',                         'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861590'],
            ['nama_opd' => 'Dinas Kependudukan dan Pencatatan Sipil',        'alamat' => 'Jl. KH. Wahid Hasyim No.135, Jombang', 'no_telepon' => '(0321) 861086'],
            ['nama_opd' => 'Dinas Pemberdayaan Masyarakat dan Desa',         'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861688'],
            ['nama_opd' => 'Dinas Pengendalian Penduduk dan KB',             'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861699'],
            ['nama_opd' => 'Dinas Perhubungan',                              'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861800'],
            ['nama_opd' => 'Dinas Koperasi dan Usaha Mikro',                 'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861900'],
            ['nama_opd' => 'Dinas Penanaman Modal dan PTSP',                 'alamat' => 'Jl. Merdeka No.1, Jombang',            'no_telepon' => '(0321) 866615'],
            ['nama_opd' => 'Dinas Kepemudaan dan Olahraga',                  'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861920'],
            ['nama_opd' => 'Dinas Pariwisata dan Kebudayaan',                'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861930'],
            ['nama_opd' => 'Dinas Perpustakaan dan Kearsipan',               'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861940'],
            ['nama_opd' => 'Dinas Perikanan',                                'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861950'],
            ['nama_opd' => 'Dinas Perdagangan dan Perindustrian',            'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861960'],

            // Badan
            ['nama_opd' => 'Badan Perencanaan Pembangunan Daerah',           'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861448'],
            ['nama_opd' => 'Badan Kepegawaian Daerah',                       'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861470'],
            ['nama_opd' => 'Badan Pengelola Keuangan dan Aset Daerah',       'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861480'],
            ['nama_opd' => 'Badan Pendapatan Daerah',                        'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861490'],
            ['nama_opd' => 'Badan Penanggulangan Bencana Daerah',            'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861500'],
            ['nama_opd' => 'Badan Kesatuan Bangsa dan Politik',              'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861510'],
            ['nama_opd' => 'Badan Riset dan Inovasi Daerah',                 'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861520'],

            // Rumah Sakit
            ['nama_opd' => 'RSUD Jombang',                                   'alamat' => 'Jl. KH. Wahid Hasyim No.52, Jombang',  'no_telepon' => '(0321) 871744'],
            ['nama_opd' => 'RSUD Ploso',                                     'alamat' => 'Jl. Darmo Sugondo No.83, Ploso',        'no_telepon' => '(0321) 888026'],

            // Satuan Polisi Pamong Praja
            ['nama_opd' => 'Satuan Polisi Pamong Praja',                     'alamat' => 'Jl. KH. Wahid Hasyim No.141, Jombang', 'no_telepon' => '(0321) 861530'],

            // Kecamatan
            ['nama_opd' => 'Kecamatan Jombang',       'alamat' => 'Jl. Veteran No.1, Jombang',         'no_telepon' => '(0321) 861000'],
            ['nama_opd' => 'Kecamatan Diwek',         'alamat' => 'Jl. Raya Diwek, Jombang',           'no_telepon' => '(0321) 861001'],
            ['nama_opd' => 'Kecamatan Ploso',         'alamat' => 'Jl. Raya Ploso, Jombang',           'no_telepon' => '(0321) 861002'],
            ['nama_opd' => 'Kecamatan Peterongan',    'alamat' => 'Jl. Raya Peterongan, Jombang',      'no_telepon' => '(0321) 861003'],
            ['nama_opd' => 'Kecamatan Perak',         'alamat' => 'Jl. Raya Perak, Jombang',           'no_telepon' => '(0321) 861004'],
            ['nama_opd' => 'Kecamatan Mojowarno',     'alamat' => 'Jl. Raya Mojowarno, Jombang',       'no_telepon' => '(0321) 861005'],
            ['nama_opd' => 'Kecamatan Mojoagung',     'alamat' => 'Jl. Raya Mojoagung, Jombang',       'no_telepon' => '(0321) 861006'],
            ['nama_opd' => 'Kecamatan Sumobito',      'alamat' => 'Jl. Raya Sumobito, Jombang',        'no_telepon' => '(0321) 861007'],
            ['nama_opd' => 'Kecamatan Jogoroto',      'alamat' => 'Jl. Raya Jogoroto, Jombang',        'no_telepon' => '(0321) 861008'],
            ['nama_opd' => 'Kecamatan Ngusikan',      'alamat' => 'Jl. Raya Ngusikan, Jombang',        'no_telepon' => '(0321) 861009'],
            ['nama_opd' => 'Kecamatan Kabuh',         'alamat' => 'Jl. Raya Kabuh, Jombang',           'no_telepon' => '(0321) 861010'],
            ['nama_opd' => 'Kecamatan Kudu',          'alamat' => 'Jl. Raya Kudu, Jombang',            'no_telepon' => '(0321) 861011'],
            ['nama_opd' => 'Kecamatan Wonosalam',     'alamat' => 'Jl. Raya Wonosalam, Jombang',       'no_telepon' => '(0321) 861012'],
            ['nama_opd' => 'Kecamatan Bareng',        'alamat' => 'Jl. Raya Bareng, Jombang',          'no_telepon' => '(0321) 861013'],
            ['nama_opd' => 'Kecamatan Ngoro',         'alamat' => 'Jl. Raya Ngoro, Jombang',           'no_telepon' => '(0321) 861014'],
            ['nama_opd' => 'Kecamatan Gudo',          'alamat' => 'Jl. Raya Gudo, Jombang',            'no_telepon' => '(0321) 861015'],
            ['nama_opd' => 'Kecamatan Kesamben',      'alamat' => 'Jl. Raya Kesamben, Jombang',        'no_telepon' => '(0321) 861016'],
            ['nama_opd' => 'Kecamatan Tembelang',     'alamat' => 'Jl. Raya Tembelang, Jombang',       'no_telepon' => '(0321) 861017'],
            ['nama_opd' => 'Kecamatan Megaluh',       'alamat' => 'Jl. Raya Megaluh, Jombang',         'no_telepon' => '(0321) 861018'],
            ['nama_opd' => 'Kecamatan Bandarkedungmulyo', 'alamat' => 'Jl. Raya Bandarkedungmulyo',    'no_telepon' => '(0321) 861019'],
            ['nama_opd' => 'Kecamatan Plandaan',      'alamat' => 'Jl. Raya Plandaan, Jombang',        'no_telepon' => '(0321) 861020'],
            ['nama_opd' => 'Kecamatan Panggungpejo',  'alamat' => 'Jl. Raya Panggungpejo, Jombang',    'no_telepon' => '(0321) 861021'],
        ];

        $opdMap = [];
        foreach ($opdData as $o) {
            $opd = Opd::firstOrCreate(['nama_opd' => $o['nama_opd']], $o);
            $opdMap[$o['nama_opd']] = $opd->id;
        }

        $opdDiskominfo = $opdMap['Dinas Komunikasi dan Informatika'];

        // ==================== USERS ====================

        // Admin
        User::firstOrCreate(['nip' => '196501011990031001'], [
            'nama'     => 'Administrator SILANTEK',
            'password' => Hash::make('password123'),
            'jabatan'  => 'Administrator Sistem',
            'no_hp'    => '081234567890',
            'role'     => 'admin',
            'opd_id'   => $opdDiskominfo,
        ]);

        // Kabid APTIKA
        User::firstOrCreate(['nip' => '197001011995031002'], [
            'nama'     => 'Kepala Bidang APTIKA',
            'password' => Hash::make('password123'),
            'jabatan'  => 'Kepala Bidang Aplikasi Telekomunikasi dan Informatika',
            'no_hp'    => '081234567891',
            'role'     => 'kabid_aptika',
            'opd_id'   => $opdDiskominfo,
        ]);

        // Tim CSIRT
        User::firstOrCreate(['nip' => '198001012005031003'], [
            'nama'     => 'Petugas CSIRT 1',
            'password' => Hash::make('password123'),
            'jabatan'  => 'Analis Keamanan Siber',
            'no_hp'    => '081234567892',
            'role'     => 'csirt',
            'opd_id'   => $opdDiskominfo,
        ]);

        User::firstOrCreate(['nip' => '198501012010031004'], [
            'nama'     => 'Petugas CSIRT 2',
            'password' => Hash::make('password123'),
            'jabatan'  => 'Teknisi Jaringan dan Keamanan',
            'no_hp'    => '081234567893',
            'role'     => 'csirt',
            'opd_id'   => $opdDiskominfo,
        ]);

        // PIC IT OPD — satu per OPD utama
        $picOpdData = [
            ['nip' => '199001012015031005', 'nama' => 'PIC IT Dinas Kesehatan',         'opd' => 'Dinas Kesehatan'],
            ['nip' => '199101012016031006', 'nama' => 'PIC IT Dinas Pendidikan',        'opd' => 'Dinas Pendidikan dan Kebudayaan'],
            ['nip' => '199201012017031007', 'nama' => 'PIC IT Dinas Dukcapil',          'opd' => 'Dinas Kependudukan dan Pencatatan Sipil'],
            ['nip' => '199301012018031008', 'nama' => 'PIC IT Bappeda',                 'opd' => 'Badan Perencanaan Pembangunan Daerah'],
            ['nip' => '199401012019031009', 'nama' => 'PIC IT Dinas PM dan PTSP',       'opd' => 'Dinas Penanaman Modal dan PTSP'],
            ['nip' => '199501012020031010', 'nama' => 'PIC IT BPKAD',                   'opd' => 'Badan Pengelola Keuangan dan Aset Daerah'],
            ['nip' => '199601012021031011', 'nama' => 'PIC IT RSUD Jombang',            'opd' => 'RSUD Jombang'],
            ['nip' => '199701012022031012', 'nama' => 'PIC IT Dinas Perhubungan',       'opd' => 'Dinas Perhubungan'],
            ['nip' => '199801012023031013', 'nama' => 'PIC IT Dinas Sosial',            'opd' => 'Dinas Sosial'],
            ['nip' => '199901012024031014', 'nama' => 'PIC IT Bappenda',                'opd' => 'Badan Pendapatan Daerah'],
        ];

        foreach ($picOpdData as $p) {
            User::firstOrCreate(['nip' => $p['nip']], [
                'nama'     => $p['nama'],
                'password' => Hash::make('password123'),
                'jabatan'  => 'Pengelola Teknologi Informasi',
                'no_hp'    => '0812345678' . substr($p['nip'], -2),
                'role'     => 'pic_opd',
                'opd_id'   => $opdMap[$p['opd']] ?? $opdDiskominfo,
            ]);
        }

        $this->command->info('');
        $this->command->info('✅ Seeding selesai!');
        $this->command->info('');
        $this->command->info('=== DATA SILANTEK ===');
        $this->command->info('OPD      : ' . Opd::count() . ' OPD');
        $this->command->info('Users    : ' . User::count() . ' akun');
        $this->command->info('');
        $this->command->info('=== AKUN LOGIN ===');
        $this->command->info('Admin        NIP: 196501011990031001 | Pass: password123');
        $this->command->info('Kabid APTIKA NIP: 197001011995031002 | Pass: password123');
        $this->command->info('CSIRT 1      NIP: 198001012005031003 | Pass: password123');
        $this->command->info('PIC Dinkes   NIP: 199001012015031005 | Pass: password123');
        $this->command->info('');
    }
}
