<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TabelLaporan;
use Carbon\Carbon;


class TabelLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tanggal' => Carbon::today(),
                'jam' => '08:00',
                'nama_pegawai' => 1,
                'nama_nasabah' => 1,
                'jumlah_koin_100' => 50,
                'jumlah_koin_200' => 30,
                'jumlah_koin_500' => 20,
                'jumlah_koin_1000' => 10,
                'jumlah_rupiah' => 30000,
            ],
            [
                'tanggal' => Carbon::today(),
                'jam' => '09:00',
                'nama_pegawai' => 2,
                'nama_nasabah' => 2,
                'jumlah_koin_100' => 60,
                'jumlah_koin_200' => 40,
                'jumlah_koin_500' => 25,
                'jumlah_koin_1000' => 15,
                'jumlah_rupiah' => 40000,
            ],
            [
                'tanggal' => Carbon::today(),
                'jam' => '10:00',
                'nama_pegawai' => 3,
                'nama_nasabah' => 3,
                'jumlah_koin_100' => 70,
                'jumlah_koin_200' => 50,
                'jumlah_koin_500' => 30,
                'jumlah_koin_1000' => 20,
                'jumlah_rupiah' => 50000,
            ],
            [
                'tanggal' => Carbon::today(),
                'jam' => '11:00',
                'nama_pegawai' => 4,
                'nama_nasabah' => 4,
                'jumlah_koin_100' => 80,
                'jumlah_koin_200' => 60,
                'jumlah_koin_500' => 35,
                'jumlah_koin_1000' => 25,
                'jumlah_rupiah' => 60000,
            ],
            [
                'tanggal' => Carbon::today(),
                'jam' => '12:00',
                'nama_pegawai' => 5,
                'nama_nasabah' => 5,
                'jumlah_koin_100' => 90,
                'jumlah_koin_200' => 70,
                'jumlah_koin_500' => 40,
                'jumlah_koin_1000' => 30,
                'jumlah_rupiah' => 70000,
            ],
        ];

        foreach ($data as $laporan) {
            TabelLaporan::create($laporan);
        }
    }
}
