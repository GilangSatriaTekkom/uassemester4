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
    $rekening_pengirim = TabelRekening::where('id', Auth::id())->first();

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

    // Find the recipient's account based on the provided name
    $penerima = User::where('name', $request->nama)->first();

    if (!$penerima) {
        return redirect()->back()->withErrors(['nama' => 'Penerima tidak ditemukan.']);
    }

    // Create a new automatic transfer
    $transfer = new TabelAutoTransaksi();
    $transfer->id_user = Auth::id();
    $transfer->nomor_rekening = $request->nomor_rekening;
    $transfer->nama_penerima = $request->nama;
    $transfer->jumlah_transfer = $request->jumlah_transfer;

    // Set interval based on the selected option
    switch ($request->interval) {
        case 'mingguan':
            $transfer->interval = now()->addWeek()->format('Y-m-d H:i:s');
            $transfer->status = '1_minggu';
            break;
        case 'bulanan':
            $transfer->interval = now()->addMonth()->format('Y-m-d H:i:s');
            $transfer->status = '1_bulan';
            break;
        case 'rubah':
            $request->validate([
                'tanggal' => 'required|date_format:Y-m-d',
                'waktu' => 'required|date_format:H:i',
            ]);

            $transfer->interval = $request->tanggal . ' ' . $request->waktu;
            $transfer->status = 'Sesuai_tanggal';
            break;
        default:
            // Default if interval is not recognized (optional)
            $transfer->interval = null;
            $transfer->status = null;
    }

    // Save the automatic transfer
    $transfer->save();

    // Redirect with success message
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
