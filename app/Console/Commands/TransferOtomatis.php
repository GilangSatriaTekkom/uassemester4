<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TransferOtomatis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transfer-otomatis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memeriksa dan mengeksekusi transfer otomatis...');

        // Ambil semua data transaksi otomatis yang memenuhi syarat waktu intervalnya
        $transactions = TransaksiOtomatis::where('waktu_interval', '<=', now())->get();

        foreach ($transactions as $transaction) {
            // Lakukan transfer sesuai dengan data yang ada
            $this->executeTransfer($transaction);
        }

        $this->info('Transfer otomatis berhasil dieksekusi.');
    }

    private function executeTransfer($transaction)
    {
        // Ambil informasi akun dari database
        $fromAccount = Rekening::find($transaction->id_rekening);

        if (!$fromAccount) {
            $this->error('Akun sumber tidak ditemukan: ' . $transaction->id_rekening);
            return;
        }

        $toAccount = Rekening::find($transaction->id_tujuan_rekening);

        if (!$toAccount) {
            $this->error('Akun tujuan tidak ditemukan: ' . $transaction->id_tujuan_rekening);
            return;
        }

        // Validasi saldo mencukupi untuk transfer
        if ($fromAccount->jumlah_tabungan < $transaction->jumlah_tabungan) {
            $this->error('Saldo tidak mencukupi untuk transfer: ' . $fromAccount->jumlah_tabungan);
            return;
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Kurangi saldo dari akun sumber
            $fromAccount->jumlah_tabungan -= $transaction->jumlah_tabungan;
            $fromAccount->save();

            // Tambahkan saldo ke akun tujuan
            $toAccount->jumlah_tabungan += $transaction->jumlah_tabungan;
            $toAccount->save();

            // Buat log transaksi jika diperlukan
            // Misalnya, Transaksi::create([...]);

            // Commit transaksi database
            DB::commit();

            $this->info('Transfer berhasil dari ' . $fromAccount->id . ' ke ' . $toAccount->id . ': ' . $transaction->jumlah_tabungan);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();
            $this->error('Gagal melakukan transfer: ' . $e->getMessage());
        }
    }
}
