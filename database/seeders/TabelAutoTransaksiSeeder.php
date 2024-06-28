<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TabelAutoTransaksi;
use Carbon\Carbon;


class TabelAutoTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'Id_rekening' => 1,
                'tipe_transaksi' => 'Deposit',
                'penerima_transaksi' => 2,
                'jumlah_transaksi' => 150000,
                'tanggal_transaksi' => Carbon::now(),
                'status_transaksi' => 'Completed',
            ],
            [
                'Id_rekening' => 2,
                'tipe_transaksi' => 'Withdrawal',
                'penerima_transaksi' => 3,
                'jumlah_transaksi' => 50000,
                'tanggal_transaksi' => Carbon::now(),
                'status_transaksi' => 'Pending',
            ],
            [
                'Id_rekening' => 3,
                'tipe_transaksi' => 'Deposit',
                'penerima_transaksi' => 4,
                'jumlah_transaksi' => 200000,
                'tanggal_transaksi' => Carbon::now(),
                'status_transaksi' => 'Completed',
            ],
            [
                'Id_rekening' => 4,
                'tipe_transaksi' => 'Withdrawal',
                'penerima_transaksi' => 5,
                'jumlah_transaksi' => 100000,
                'tanggal_transaksi' => Carbon::now(),
                'status_transaksi' => 'Failed',
            ],
            [
                'Id_rekening' => 5,
                'tipe_transaksi' => 'Deposit',
                'penerima_transaksi' => 1,
                'jumlah_transaksi' => 300000,
                'tanggal_transaksi' => Carbon::now(),
                'status_transaksi' => 'Completed',
            ],
        ];

        foreach ($data as $autoTransaksi) {
            TabelAutoTransaksi::create($autoTransaksi);
        }
    }
}
