<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabelAutoTransaksi;
use App\Models\TabelRekening;
use App\Notifications\TransactionNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransaksiOtomatisController extends Controller
{
    public function index()
{
    $autoTransactions = TabelAutoTransaksi::where('id_user', Auth::user()->id)->get();

    // Mengambil jumlah tabungan pengguna
    $user = Auth::user();
    $rekening = TabelRekening::where('id', $user->id)->first(); // Ambil satu rekaman

    if (!$rekening) {
        abort(404, 'Rekening tidak ditemukan untuk pengguna ini.');
    }

    $saldo = $rekening->jumlah_tabungan;

    // Format uang
    $formattedSaldo = $saldo ? 'Rp.' . number_format($saldo, 0, ',', '.') . ',00' : 'Tidak ada saldo';

    // Mengambil ID untuk form action
    $id = $user->id;

    return view('nasabah.transfer_otomatis', compact('autoTransactions', 'formattedSaldo', 'id'));
}

    public function store(Request $request, $id)
    {
        // Validation rules
        $request->validate([
            'nama' => 'required|exists:users,name',
            'nomor_rekening' => 'required|exists:tabel_rekening,nomor_rekening',
            'jumlah_transfer' => 'required|numeric|min:1',
            'interval' => 'required|in:mingguan,bulanan,rubah',
            'tanggal' => 'required_if:interval,rubah|nullable|date_format:Y-m-d',
            'waktu' => 'required_if:interval,rubah|nullable|date_format:H:i',
        ]);
    
        // Find the sender's account
        $rekening_pengirim = TabelRekening::where('id', Auth::user()->id)->first();
    
        // Check if the sender's account exists
        if (!$rekening_pengirim) {
            return redirect()->back()->withErrors(['error' => 'Rekening pengirim tidak ditemukan.']);
        }
    
        // Check if the sender's balance is sufficient
        if ($rekening_pengirim->jumlah_tabungan < $request->jumlah_transfer) {
            return redirect()->back()->withErrors(['jumlah_transfer' => 'Jumlah tabungan tidak mencukupi.']);
        }
    
        // Prevent the sender from transferring to their own account
        if ($rekening_pengirim->nomor_rekening == $request->nomor_rekening) {
            return redirect()->back()->withErrors(['nomor_rekening' => 'Nomor rekening penerima tidak boleh sama dengan nomor rekening pengirim.']);
        }

         // Mengambil data rekening berdasarkan nomor rekening
        $rekening = TabelRekening::where('nomor_rekening', $request)->first();

        // Mengambil user yang memiliki rekening (penerima)
        $penerima = $request->nama;

        if (!$penerima) {
            // Tambahkan logika untuk jika user tidak ditemukan
            return redirect()->back()->withErrors(['nomor_rekening' => 'Penerima tidak ditemukan.']);
        }
    
        // Create a new automatic transfer
        $transfer = new TabelAutoTransaksi();
        $transfer->id_user = Auth::id();
        $transfer->nomor_rekening = $request->nomor_rekening;
        $transfer->nama_penerima = $request->nama; 
        $transfer->jumlah_transfer = $request->jumlah_transfer;
        if ($request->interval === 'mingguan') {
            // Interval mingguan
            $transfer->interval = now()->addWeek()->format('Y-m-d H:i');
        } elseif ($request->interval === 'bulanan') {
            // Interval bulanan
            $transfer->interval = now()->addMonth()->format('Y-m-d H:i');
        } elseif ($request->interval === 'rubah') {
            // Interval rubah
            $request->validate([
                'tanggal' => 'required|date_format:Y-m-d',
                'waktu' => 'required|date_format:H:i',
            ]);
        
            $transfer->interval = $request->tanggal . ' ' . $request->waktu;
        } else {
            // Default jika interval tidak dikenali (opsional)
            $transfer->interval = null;
        }
        $transfer->status = 'Aktif'; // Default status is active when added

        // Calculate remaining time until the next transaction (this is a placeholder)
        // $transfer->remaining_time = '...'; // Implement actual calculation here
        $transfer->save();

        // After saving the transfer
        // $recipient = TabelRekening::where('nomor_rekening', $request->nomor_rekening)->first()->user;
        // $recipient->notify(new TransferNotification($request->jumlah_transfer));
    
        return redirect()->route('transactions.auto', ['id' => $id])->with('success', 'Transfer otomatis berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $transfer = TabelAutoTransaksi::find($id);

        if ($transfer) {
            $transfer->delete();
            return redirect()->route('transactions.auto', ['id' => $id])->with('success', 'Transfer otomatis berhasil dihapus.');
        } else {
            return redirect()->route('transactions.auto', ['id' => $id])->withErrors(['error' => 'Transfer otomatis tidak ditemukan.']);
        }
    }
    

}
