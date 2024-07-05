<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TabelAutoTransaksi;
use App\Models\TabelRekening;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcessAutomaticTransfers extends Command
{
    protected $signature = 'transfers:process';
    protected $description = 'Process automatic transfers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the current date and time
        $now = Carbon::now();

        // Get all active transfers that need to be processed
        $transfers = TabelAutoTransaksi::where('status', 'Aktif')
            ->where('interval', '<=', $now)
            ->get();

        foreach ($transfers as $transfer) {
            DB::transaction(function () use ($transfer, $now) {
                $rekening_pengirim = TabelRekening::where('id', $transfer->id_user)->first();

                if ($rekening_pengirim->jumlah_tabungan >= $transfer->jumlah_transfer) {
                    // Deduct the transfer amount from the sender's account
                    $rekening_pengirim->jumlah_tabungan -= $transfer->jumlah_transfer;
                    $rekening_pengirim->save();

                    // Add the transfer amount to the receiver's account
                    $rekening_penerima = TabelRekening::where('nomor_rekening', $transfer->nomor_rekening)->first();
                    $rekening_penerima->jumlah_tabungan += $transfer->jumlah_transfer;
                    $rekening_penerima->save();

                    // Determine the next interval
                    if ($transfer->interval_type == 'mingguan') {
                        $transfer->interval = $now->addWeek();
                    } elseif ($transfer->interval_type == 'bulanan') {
                        $transfer->interval = $now->addMonth();
                    } elseif ($transfer->interval_type == 'sesuai_tanggal') {
                        $transfer->status = 'Selesai';
                    }

                    $transfer->save();

                    // Notify both sender and receiver (implement your notification logic)
                    // $sender->notify(new TransferProcessedNotification($transfer));
                    // $receiver->notify(new TransferProcessedNotification($transfer));
                } else {
                    // Handle insufficient funds
                    $transfer->status = 'Gagal';
                    $transfer->save();
                }
            });
        }

        return 0;
    }
}
