<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TabelRekening;
use Carbon\Carbon;


class TabelRekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'Id_nasabah' => 1,
                'nomor_akun' => '1234567890',
                'jumlah_tabungan' => 500000,
                'tanggal_buat' => Carbon::now(),
                'tanggal_update' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 2,
                'nomor_akun' => '2345678901',
                'jumlah_tabungan' => 750000,
                'tanggal_buat' => Carbon::now(),
                'tanggal_update' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 3,
                'nomor_akun' => '3456789012',
                'jumlah_tabungan' => 300000,
                'tanggal_buat' => Carbon::now(),
                'tanggal_update' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 4,
                'nomor_akun' => '4567890123',
                'jumlah_tabungan' => 450000,
                'tanggal_buat' => Carbon::now(),
                'tanggal_update' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 5,
                'nomor_akun' => '5678901234',
                'jumlah_tabungan' => 1000000,
                'tanggal_buat' => Carbon::now(),
                'tanggal_update' => Carbon::now(),
            ],
        ];

        foreach ($data as $rekening) {
            TabelRekening::create($rekening);
        }
    }
}
