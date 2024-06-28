<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TabelTransaksi;
use App\Models\TabelRekening;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\TransactionNotification;

class TransaksiController extends Controller
{
    public function create($type, $id)
    {
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

        return view('nasabah.transaksi', compact('type', 'id', 'formattedSaldo'));
    }

    public function store(Request $request, $type, $id)
    {
        $request->validate([
            'nomor_rekening' => 'required|exists:tabel_rekening,nomor_rekening',
            'jumlah_transaksi' => 'required|numeric|min:1',
        ]);

        // Retrieve sender's account based on logged-in user's ID
        $rekening_pengirim = TabelRekening::where('id', Auth::id())->first();

        if (!$rekening_pengirim) {
            return redirect()->back()->withErrors(['error' => 'Rekening pengirim tidak ditemukan.']);
        }

        // Retrieve recipient's account based on inputted account number
        $rekening_penerima = TabelRekening::where('nomor_rekening', $request->nomor_rekening)->first();

        if (!$rekening_penerima && $type != 'deposit') {
            return redirect()->back()->withErrors(['nomor_rekening' => 'Rekening penerima tidak ditemukan.']);
        }

        // Check if recipient's account number is the same as sender's for withdrawals and transfers
        if (($type == 'transfer') && $rekening_pengirim->nomor_rekening == $request->nomor_rekening) {
            return redirect()->back()->withErrors(['nomor_rekening' => 'Nomor rekening penerima tidak boleh sama dengan nomor rekening pengirim.']);
        }

        // Ensure sufficient balance for withdrawals/transfers
        if (($type == 'withdrawal' || $type == 'transfer') && $rekening_pengirim->jumlah_tabungan < $request->jumlah_transaksi) {
            return redirect()->back()->withErrors(['jumlah_transaksi' => 'Jumlah tabungan tidak mencukupi.']);
        }

        DB::beginTransaction();

        try {
            // Log values before transaction
            Log::info('Before Transaction: ', [
                'pengirim_jumlah_tabungan' => $rekening_pengirim->jumlah_tabungan,
                'penerima_jumlah_tabungan' => $rekening_penerima ? $rekening_penerima->jumlah_tabungan : null,
            ]);

            // Process transaction based on its type
            switch ($type) {
                case 'withdrawal':
                    $new_pengirim_tabungan = $rekening_pengirim->jumlah_tabungan - $request->jumlah_transaksi;
                    DB::table('tabel_rekening')
                        ->where('id', Auth::id())
                        ->update(['jumlah_tabungan' => $new_pengirim_tabungan]);
                    break;
                case 'deposit':
                    $new_penerima_tabungan = $rekening_penerima->jumlah_tabungan + $request->jumlah_transaksi;
                    DB::table('tabel_rekening')
                        ->where('nomor_rekening', $request->nomor_rekening)
                        ->update(['jumlah_tabungan' => $new_penerima_tabungan]);
                    break;
                case 'transfer':
                    $new_pengirim_tabungan = $rekening_pengirim->jumlah_tabungan - $request->jumlah_transaksi;
                    $new_penerima_tabungan = $rekening_penerima->jumlah_tabungan + $request->jumlah_transaksi;
                    DB::table('tabel_rekening')
                        ->where('id', Auth::id())
                        ->update(['jumlah_tabungan' => $new_pengirim_tabungan]);
                    DB::table('tabel_rekening')
                        ->where('nomor_rekening', $request->nomor_rekening)
                        ->update(['jumlah_tabungan' => $new_penerima_tabungan]);
                    break;
                default:
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => 'Jenis transaksi tidak valid.']);
            }

            // Log values after transaction
            Log::info('After Transaction: ', [
                'pengirim_jumlah_tabungan' => $new_pengirim_tabungan ?? $rekening_pengirim->jumlah_tabungan,
                'penerima_jumlah_tabungan' => $new_penerima_tabungan ?? ($rekening_penerima ? $rekening_penerima->jumlah_tabungan : null),
            ]);

            // Create transaction entry
            TabelTransaksi::create([
                'tipe_transaksi' => $type,
                'jumlah_transaksi' => $request->jumlah_transaksi,
                'id' => Auth::id(), // ID of the user performing the transaction
            ]);

            // Commit the transaction
            DB::commit();

            // Trigger the notification
        $rekening_penerima->notify(new TransactionNotification($type, $request->jumlah_transaksi));

        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
            Log::error('Transaction Failed: ', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memproses transaksi.']);
        }

        return redirect()->route('transactions.create', ['type' => $type, 'id' => $id])->with('success', ucfirst($type) . ' saldo berhasil.');
    }

    public function history($id)
    {
        // Ensure authenticated user matches requested ID
        if (Auth::id() != $id) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized access.']);
        }

        // Fetch all transactions for the logged-in user
        $transactions = TabelTransaksi::where('id', $id)->orderBy('created_at', 'desc')->get();

        return view('nasabah.history', compact('transactions'));
    }

    public function suggest(Request $request)
    {
        $term = $request->get('term');
        $users = User::where('name', 'LIKE', '%' . $term . '%')->get();
    
        $results = [];
        foreach ($users as $user) {
            $rekening = TabelRekening::where('id', $user->id)->first();
            if ($rekening) {
                $results[] = [
                    'nama' => $user->name,
                    'nomor_rekening' => $rekening->nomor_rekening
                ];
            }
        }
    
        if ($request->has('nama')) {
            $user = User::where('name', $request->get('nama'))->first();
            if ($user) {
                $rekening = TabelRekening::where('id', $user->id)->first();
                if ($rekening) {
                    return response()->json(['nomor_rekening' => $rekening->nomor_rekening]);
                }
            }
        }
    
        return response()->json($results);
    }
}
