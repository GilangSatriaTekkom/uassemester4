<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabelRekening;
use App\Models\TabelTransaksi;
use App\Models\TabelNasabah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    
        return view('dashboard', compact('nasabah', 'rekenings', 'saldoMasuk', 'saldoKeluar', 'tabungans', 'transaksis'));
    }


}
