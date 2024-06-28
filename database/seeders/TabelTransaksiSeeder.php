<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TabelTransaksi;
use Carbon\Carbon;


class TabelTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'Id_nasabah' => 1,
                'tipe_transaksi' => 'Deposit',
                'jumlah_transaksi' => 100000,
                'tanggal_transaksi' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 2,
                'tipe_transaksi' => 'Withdrawal',
                'jumlah_transaksi' => 50000,
                'tanggal_transaksi' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 3,
                'tipe_transaksi' => 'Deposit',
                'jumlah_transaksi' => 200000,
                'tanggal_transaksi' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 4,
                'tipe_transaksi' => 'Withdrawal',
                'jumlah_transaksi' => 100000,
                'tanggal_transaksi' => Carbon::now(),
            ],
            [
                'Id_nasabah' => 5,
                'tipe_transaksi' => 'Deposit',
                'jumlah_transaksi' => 300000,
                'tanggal_transaksi' => Carbon::now(),
            ],
        ];

        foreach ($data as $transaksi) {
            TabelTransaksi::create($transaksi);
        }
    }
}
