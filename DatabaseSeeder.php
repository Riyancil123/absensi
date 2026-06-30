<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Presensi;
use App\Models\Setting;
use App\Models\KelasKuliah;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $defaultPassword = Hash::make('password');

        // 1. Seed Admin
        User::create([
            'name' => 'Administrator Presensi',
            'username' => 'admin',
            'email' => 'admin@kampus.ac.id',
            'password' => $defaultPassword,
            'role' => 'admin'
        ]);

        // 2. Seed Dosen
        $dosen1 = User::create([
            'name' => 'Drs. H. Bambang Subagyo, M.Kom.',
            'username' => '123456', // NPP
            'email' => 'bambang@kampus.ac.id',
            'password' => $defaultPassword,
            'role' => 'dosen'
        ]);

        $dosen2 = User::create([
            'name' => 'Dr. Indah Permatasari, M.T.',
            'username' => '654321', // NPP
            'email' => 'indah@kampus.ac.id',
            'password' => $defaultPassword,
            'role' => 'dosen'
        ]);

        // 3. Seed Kelas Kuliah
        $kelas1 = KelasKuliah::create([
            'nama_mata_kuliah' => 'Pemrograman Web',
            'dosen_id' => $dosen1->id,
            'ruangan' => 'Lab Komputer 3',
            'status_absen' => 1 // Open
        ]);

        $kelas2 = KelasKuliah::create([
            'nama_mata_kuliah' => 'Struktur Data',
            'dosen_id' => $dosen1->id,
            'ruangan' => 'Lab Komputer 1',
            'status_absen' => 0 // Closed
        ]);

        $kelas3 = KelasKuliah::create([
            'nama_mata_kuliah' => 'Rekayasa Perangkat Lunak',
            'dosen_id' => $dosen2->id,
            'ruangan' => 'Ruang 402',
            'status_absen' => 0 // Closed
        ]);

        // 4. Seed Settings for GPS & Session
        Setting::setValue('location_latitude', '-6.175392'); // Default: Monas Jakarta
        Setting::setValue('location_longitude', '106.827153');
        Setting::setValue('allowed_radius', '50'); // Default: 50 meters

        // 5. Seed Mahasiswa
        $mahasiswaData = [
            ['nim' => '220101001', 'nama' => 'Ahmad Fauzi', 'kelas' => 'TI-3A', 'jurusan' => 'Teknik Informatika', 'email' => 'ahmad.fauzi@mhs.ac.id', 'no_hp' => '081234567890'],
            ['nim' => '220101002', 'nama' => 'Budi Santoso', 'kelas' => 'TI-3A', 'jurusan' => 'Teknik Informatika', 'email' => 'budi.santoso@mhs.ac.id', 'no_hp' => '081234567891'],
            ['nim' => '220101003', 'nama' => 'Citra Lestari', 'kelas' => 'TI-3A', 'jurusan' => 'Teknik Informatika', 'email' => 'citra.lestari@mhs.ac.id', 'no_hp' => '081234567892'],
            ['nim' => '220101004', 'nama' => 'Dwi Cahyo', 'kelas' => 'TI-3B', 'jurusan' => 'Teknik Informatika', 'email' => 'dwi.cahyo@mhs.ac.id', 'no_hp' => '081234567893'],
            ['nim' => '220101005', 'nama' => 'Eka Saputra', 'kelas' => 'TI-3B', 'jurusan' => 'Teknik Informatika', 'email' => 'eka.saputra@mhs.ac.id', 'no_hp' => '081234567894'],
            ['nim' => '220202001', 'nama' => 'Fitriani', 'kelas' => 'SI-3A', 'jurusan' => 'Sistem Informasi', 'email' => 'fitriani@mhs.ac.id', 'no_hp' => '082134567895'],
            ['nim' => '220202002', 'nama' => 'Gede Satria', 'kelas' => 'SI-3A', 'jurusan' => 'Sistem Informasi', 'email' => 'gede.satria@mhs.ac.id', 'no_hp' => '082134567896'],
            ['nim' => '220202003', 'nama' => 'Hesti Wulandari', 'kelas' => 'SI-3B', 'jurusan' => 'Sistem Informasi', 'email' => 'hesti.wulandari@mhs.ac.id', 'no_hp' => '082134567897'],
            ['nim' => '220303001', 'nama' => 'Indra Wijaya', 'kelas' => 'TE-3A', 'jurusan' => 'Teknik Elektro', 'email' => 'indra.wijaya@mhs.ac.id', 'no_hp' => '083134567898'],
            ['nim' => '220303002', 'nama' => 'Joko Susilo', 'kelas' => 'TE-3A', 'jurusan' => 'Teknik Elektro', 'email' => 'joko.susilo@mhs.ac.id', 'no_hp' => '083134567899'],
            ['nim' => '220404001', 'nama' => 'Kartika Putri', 'kelas' => 'MI-3A', 'jurusan' => 'Manajemen Informatika', 'email' => 'kartika.putri@mhs.ac.id', 'no_hp' => '085234567800'],
            ['nim' => '220404002', 'nama' => 'Lukman Hakim', 'kelas' => 'MI-3A', 'jurusan' => 'Manajemen Informatika', 'email' => 'lukman.hakim@mhs.ac.id', 'no_hp' => '085234567801'],
            ['nim' => '220101006', 'nama' => 'Maria Ulfa', 'kelas' => 'TI-3A', 'jurusan' => 'Teknik Informatika', 'email' => 'maria.ulfa@mhs.ac.id', 'no_hp' => '081234567802'],
            ['nim' => '220101007', 'nama' => 'Nurul Hidayah', 'kelas' => 'TI-3B', 'jurusan' => 'Teknik Informatika', 'email' => 'nurul.hidayah@mhs.ac.id', 'no_hp' => '081234567803'],
            ['nim' => '220202004', 'nama' => 'Rian Hidayat', 'kelas' => 'SI-3B', 'jurusan' => 'Sistem Informasi', 'email' => 'rian.hidayat@mhs.ac.id', 'no_hp' => '082134567804'],
            ['nim' => '220202005', 'nama' => 'Sri Wahyuni', 'kelas' => 'SI-3B', 'jurusan' => 'Sistem Informasi', 'email' => 'sri.wahyuni@mhs.ac.id', 'no_hp' => '082134567805'],
            ['nim' => '220303003', 'nama' => 'Taufik Hidayat', 'kelas' => 'TE-3A', 'jurusan' => 'Teknik Elektro', 'email' => 'taufik.hidayat@mhs.ac.id', 'no_hp' => '083134567806'],
            ['nim' => '220303004', 'nama' => 'Yanto', 'kelas' => 'TE-3A', 'jurusan' => 'Teknik Elektro', 'email' => 'yanto@mhs.ac.id', 'no_hp' => '083134567807'],
            ['nim' => '220404003', 'nama' => 'Zulkifli', 'kelas' => 'MI-3A', 'jurusan' => 'Manajemen Informatika', 'email' => 'zulkifli@mhs.ac.id', 'no_hp' => '085234567808'],
        ];

        $studentInstances = [];
        foreach ($mahasiswaData as $data) {
            $studentInstances[] = User::create([
                'name' => $data['nama'],
                'username' => $data['nim'],
                'email' => $data['email'],
                'password' => $defaultPassword,
                'kelas' => $data['kelas'],
                'jurusan' => $data['jurusan'],
                'no_hp' => $data['no_hp'],
                'role' => 'mahasiswa'
            ]);
        }

        // 6. Seed Presensi for the past 7 days (attaching to user_id and kelas_kuliah_id)
        $sakitReasons = ['Demam tinggi', 'Flu dan sakit kepala', 'Sakit gigi', 'Diare'];
        $izinReasons = ['Acara keluarga di luar kota', 'Mengurus SIM', 'Ada kepentingan keluarga mendesak', 'Mengikuti lomba'];
        $classes = [$kelas1, $kelas2, $kelas3];

        for ($i = 7; $i >= 1; $i--) {
            $date = Carbon::today()->subDays($i);
            
            // Skip weekends
            if ($date->isWeekend()) {
                continue;
            }

            foreach ($studentInstances as $student) {
                // For each student, seed presensi for each of the three classes
                foreach ($classes as $kelas) {
                    $rand = rand(1, 100);
                    
                    // Coordinates offset slightly to simulate distance
                    $latOffset = (rand(-20, 20) / 100000); // approx +/- 2 meters
                    $lonOffset = (rand(-20, 20) / 100000);
                    
                    $lat = -6.175392 + $latOffset;
                    $lon = 106.827153 + $lonOffset;
                    $jarak = rand(1, 12); // distance under 12 meters

                    if ($rand <= 88) {
                        $status = 'Hadir';
                        $keterangan = null;
                    } elseif ($rand <= 92) {
                        $status = 'Sakit';
                        $keterangan = $sakitReasons[array_rand($sakitReasons)];
                        $lat = null;
                        $lon = null;
                        $jarak = null;
                    } elseif ($rand <= 96) {
                        $status = 'Izin';
                        $keterangan = $izinReasons[array_rand($izinReasons)];
                        $lat = null;
                        $lon = null;
                        $jarak = null;
                    } else {
                        $status = 'Alpa';
                        $keterangan = 'Tanpa keterangan';
                        $lat = null;
                        $lon = null;
                        $jarak = null;
                    }

                    Presensi::create([
                        'user_id' => $student->id,
                        'kelas_kuliah_id' => $kelas->id,
                        'tanggal' => $date->format('Y-m-d'),
                        'status' => $status,
                        'keterangan' => $keterangan,
                        'latitude' => $lat,
                        'longitude' => $lon,
                        'jarak' => $jarak
                    ]);
                }
            }
        }
    }
}
