<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Akun default
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'password' => Hash::make('secret'),
                'status' => 'active'
            ],
        ]);

        // Load data dari file JSON
        $filePath = public_path('wilayah.json');
        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        $processedKecamatan = [];
        $processedKelurahan = [];

        foreach ($data as $row) {
            $kecamatan = $row['KECAMATAN'];
            $kelurahan = $row['KELURAHAN'];
            $slugKecamatan = Str::slug($kecamatan);
            $slugKelurahan = Str::slug($kelurahan);

            // Buat akun untuk kecamatan jika belum ada
            if (!in_array($kecamatan, $processedKecamatan)) {
                $userId = DB::table('users')->insert([
                    'name' => $kecamatan,
                    'username' => $slugKecamatan,
                    'password' => Hash::make('password'),
                    'status' => 'active'
                ]);

                DB::table('user_groups')->insert([
                    'user_id' => $userId,
                    'group_id' => 2, // Sesuaikan group_id dengan kebutuhan Anda
                ]);

                $processedKecamatan[] = $kecamatan;
            }

            // Buat akun untuk kelurahan jika belum ada
            $kelurahanIdentifier = "{$kelurahan}-{$kecamatan}";
            if (!in_array($kelurahanIdentifier, $processedKelurahan)) {
                $userId = DB::table('users')->insert([
                    'name' => $kelurahan,
                    'username' => "{$slugKelurahan}-{$slugKecamatan}",
                    'password' => Hash::make('password'),
                    'status' => 'active'
                ]);

                DB::table('user_groups')->insert([
                    'user_id' => $userId,
                    'group_id' => 3, // Sesuaikan group_id dengan kebutuhan Anda
                ]);

                $processedKelurahan[] = $kelurahanIdentifier;
            }

            // Buat akun TPS per kelurahan dengan nomor TPS dari JUMLAH
            for ($i = 1; $i <= $row['JUMLAH']; $i++) {
                $tps = DB::table('users')->insert([
                    'name' => "TPS {$i} {$kelurahan} {$kecamatan}",
                    'username' => "tps-{$i}-{$slugKelurahan}-{$slugKecamatan}",
                    'password' => Hash::make('password'),
                    'status' => 'active'
                ]);

                DB::table('user_groups')->insert([
                    'user_id' => $tps,
                    'group_id' => 4, // Sesuaikan group_id dengan kebutuhan Anda
                ]);
            }
        }
    }
}
