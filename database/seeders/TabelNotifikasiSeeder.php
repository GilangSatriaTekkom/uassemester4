<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TabelNotifikasi;
use Carbon\Carbon;


class TabelNotifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'Id_nasabah' => 1,
                'pesan' => 'Transaksi berhasil',
                'is_read' => 0,
                'tanggal_buat' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 2,
                'pesan' => 'Transaksi gagal',
                'is_read' => 0,
                'tanggal_buat' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 3,
                'pesan' => 'Saldo tidak mencukupi',
                'is_read' => 0,
                'tanggal_buat' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 4,
                'pesan' => 'Transaksi pending',
                'is_read' => 0,
                'tanggal_buat' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 5,
                'pesan' => 'Transaksi selesai',
                'is_read' => 1,
                'tanggal_buat' => Carbon::now(),
            ],
        ];

        foreach ($data as $notifikasi) {
            TabelNotifikasi::create($notifikasi);
        }
    }
}
