<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabelRekening;
use App\Models\TabelTransaksi;
use App\Models\TabelNasabah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NasabahController extends Controller
{

    public function index()
    {


        return view('dashboard');

    }

    public function dashboard($Id)
    {
        // Ambil data nasabah berdasarkan ID
        $nasabah = DB::table('users')->where('id', $Id)->first();

        // Ambil data rekening berdasarkan ID nasabah
        $tabungans = DB::table('tabel_rekening')->where('id', $Id)->get();
        $rekenings = DB::table('tabel_transaksi')->where('id', $Id)->get();

        // Ambil data transaksi hanya untuk hari ini dan sesuai ID nasabah
        $today = Carbon::today()->toDateString();
        $transaksis = DB::table('tabel_transaksi')
            ->where('id', $Id)
            ->whereDate('created_at', $today)
            ->get();

        // Filter transactions for today
        $saldoMasuk = $transaksis->filter(function ($transaksi) {
            return in_array($transaksi->tipe_transaksi, ['deposit', 'penerima_transfer']);
        })->sum('jumlah_transaksi');

        $saldoKeluar = $transaksis->filter(function ($transaksi) {
            return in_array($transaksi->tipe_transaksi, ['withdrawal', 'pengirim_transfer', 'transfer']);
        })->sum('jumlah_transaksi');

        $nasabah = DB::table('transaksi_otomatis')->where('id_user', $Id)->first();

       // Check if the interval date has passed and process transactions
       $transaksiOtomatis = DB::table('transaksi_otomatis')->where('id_user', $Id)->first();
       if ($transaksiOtomatis) {
        $rekening_pengirim = TabelRekening::where('id', Auth::id())->first();
        $rekening_penerima = TabelRekening::where('nomor_rekening', $transaksiOtomatis->nomor_rekening)->first();

        if (Carbon::parse($transaksiOtomatis->interval)->isPast()) {
            Log::info('Processing automatic transaction for user ID: ' . $Id);

            switch ($transaksiOtomatis->status) {
                case '1_minggu':
                    $transaksiOtomatis->interval = Carbon::parse($transaksiOtomatis->interval)->addWeek()->format('Y-m-d H:i:s');
                    $new_pengirim_tabungan = $rekening_pengirim->jumlah_tabungan - $transaksiOtomatis->jumlah_transfer;
                    $new_penerima_tabungan = $rekening_penerima->jumlah_tabungan + $transaksiOtomatis->jumlah_transfer;
                    DB::table('tabel_rekening')
                        ->where('id', Auth::id())
                        ->update(['jumlah_tabungan' => $new_pengirim_tabungan]);
                    DB::table('tabel_rekening')
                        ->where('nomor_rekening', $transaksiOtomatis->nomor_rekening)
                        ->update(['jumlah_tabungan' => $new_penerima_tabungan]);
                    Log::info('Weekly transaction processed for user ID: ' . $Id);
                    break;
                case '1_bulan':
                    $transaksiOtomatis->interval = Carbon::parse($transaksiOtomatis->interval)->addMonth()->format('Y-m-d H:i:s');
                    $new_pengirim_tabungan = $rekening_pengirim->jumlah_tabungan - $transaksiOtomatis->jumlah_transfer;
                    $new_penerima_tabungan = $rekening_penerima->jumlah_tabungan + $transaksiOtomatis->jumlah_transfer;
                    DB::table('tabel_rekening')
                        ->where('id', Auth::id())
                        ->update(['jumlah_tabungan' => $new_pengirim_tabungan]);
                    DB::table('tabel_rekening')
                        ->where('nomor_rekening', $transaksiOtomatis->nomor_rekening)
                        ->update(['jumlah_tabungan' => $new_penerima_tabungan]);
                    Log::info('Monthly transaction processed for user ID: ' . $Id);
                    break;
                case 'Sesuai_tanggal':
                    $transaksiOtomatis->status = 'Selesai';
                    $new_pengirim_tabungan = $rekening_pengirim->jumlah_tabungan - $transaksiOtomatis->jumlah_transfer;
                    $new_penerima_tabungan = $rekening_penerima->jumlah_tabungan + $transaksiOtomatis->jumlah_transfer;
                    DB::table('tabel_rekening')
                        ->where('id', Auth::id())
                        ->update(['jumlah_tabungan' => $new_pengirim_tabungan]);
                    DB::table('tabel_rekening')
                        ->where('nomor_rekening', $transaksiOtomatis->nomor_rekening)
                        ->update(['jumlah_tabungan' => $new_penerima_tabungan]);
                    Log::info('Scheduled transaction processed for user ID: ' . $Id);
                    break;
            }

            // Save the automatic transfer
            DB::table('transaksi_otomatis')
                ->where('id_user', $Id)
                ->update(['interval' => $transaksiOtomatis->interval, 'status' => $transaksiOtomatis->status]);
            Log::info('Automatic transaction updated for user ID: ' . $Id);
        }
    } else {
        Log::info('No automatic transaction found for user ID: ' . $Id);
    }

        return view('dashboard', compact('nasabah', 'rekenings', 'saldoMasuk', 'saldoKeluar', 'tabungans', 'transaksis',));
    }


}

