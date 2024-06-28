<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabelPegawai;
use App\Models\TabelLaporan;
use App\Models\counterModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class KoinController extends Controller
{
    public function index($id)
{
    $user = Auth::user();

    if ($user->level == 'pegawai') {
        // Jika user adalah pegawai, hanya ambil laporan hari ini
        $laporan = DB::table('tabel_laporan')
            ->join('users as nasabah', 'tabel_laporan.nama_nasabah', '=', 'nasabah.id')
            ->join('users as pegawai', 'tabel_laporan.nama_pegawai', '=', 'pegawai.id')
            ->select('tabel_laporan.id_laporan',
                    'tabel_laporan.jumlah_koin_100', 'tabel_laporan.jumlah_koin_200',
                    'tabel_laporan.jumlah_koin_500', 'tabel_laporan.jumlah_koin_1000',
                    'tabel_laporan.jumlah_rupiah', 'nasabah.name as nama_nasabah',
                    'pegawai.name as nama_pegawai')
            ->whereDate('tabel_laporan.created_at', Carbon::today()) // Filter untuk hari ini saja
            ->get();
    } else {
        // Jika user adalah admin, ambil semua laporan
        $laporan = DB::table('tabel_laporan')
            ->join('users as nasabah', 'tabel_laporan.nama_nasabah', '=', 'nasabah.id')
            ->join('users as pegawai', 'tabel_laporan.nama_pegawai', '=', 'pegawai.id')
            ->select('tabel_laporan.id_laporan',
                    'tabel_laporan.jumlah_koin_100', 'tabel_laporan.jumlah_koin_200',
                    'tabel_laporan.jumlah_koin_500', 'tabel_laporan.jumlah_koin_1000',
                    'tabel_laporan.jumlah_rupiah', 'nasabah.name as nama_nasabah',
                    'pegawai.name as nama_pegawai')
            ->get();
    }

    // Ambil semua nasabah untuk dropdown
    $users = User::where('level', 'nasabah')->get();

    $data = [
        'laporan' => $laporan,
        'judul' => 'Menampilkan Semua Data Laporan',
        'user' => $user,
        'users' => $users, // Sertakan data $users dalam array data
    ];

    return view('pegawai.koinCounter', $data);
}
    public function startMachine(Request $request)
    {
        // Kirim data ke NodeMCU
        $response = Http::post('http://192.168.1.10/start-machine', [
            'employeeName' => $request->employeeName,
            'limitInput' => $request->limitInput,
            'limitCheckbox' => $request->limitCheckbox,
        ]);

        return $response->json();
    }

    public function coinCounts()
    {
        // Ambil data dari NodeMCU
        $response = Http::get('http://192.168.1.10');
        return $response->json();
    }

    public function getCurrentUser()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function getCoinCounts()
    {
        $coinCounts = counterModel::selectRaw('jenis_koin, COUNT(*) as count')
            ->groupBy('jenis_koin')
            ->get();

        $data = [
            'coin100' => 0,
            'coin200' => 0,
            'coin500' => 0,
            'coin1000' => 0,
            'totalAmount' => 'Rp.0,00',
            
        ];

        foreach ($coinCounts as $coin) {
            switch ($coin->jenis_koin) {
                case 'koin100':
                    $data['coin100'] += $coin->count;
                    break;
                case 'koin200':
                    $data['coin200'] += $coin->count;
                    break;
                case 'koin500':
                    $data['coin500'] += $coin->count;
                    break;
                case 'koin1000':
                    $data['coin1000'] += $coin->count;
                    break;
            }
             // Menghitung totalAmount berdasarkan nilai koin yang telah diakumulasi
            $totalAmount = $data['coin100'] * 100 + $data['coin200'] * 200 + $data['coin500'] * 500 + $data['coin1000'] * 1000;

            // Mengubah totalAmount ke format mata uang rupiah
            $data['totalAmount'] = 'Rp.' . number_format($totalAmount, 0, ',', '.') . ',00';
        }

        return response()->json($data);
    }

    public function resetCounter(Request $request)
{
    try {
        // Hapus semua data dari tabel counter
        DB::table('counter')->truncate(); // Menghapus semua baris dalam tabel

         // Mendapatkan ID pengguna dari request
         $userId = $request->user()->id; // Contoh mendapatkan ID pengguna saat ini


        // Redirect ke halaman koincounter dengan pesan sukses
        return redirect()->route('koin.counter', ['id' => $userId])->with('message', 'Counter berhasil direset.');
    } catch (\Exception $e) {
        // Redirect ke halaman koincounter dengan pesan error
        return redirect()->route('koin.counter', ['id' => $userId])->with('message', 'Gagal reset counter.');
    }
}

    

    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'nama_nasabah' => 'required|string',
        
    ]);

    // Cari ID nasabah berdasarkan nama
    $nasabah = User::where('name', $request->input('nama_nasabah'))->first();

    $namaNasabahExists = User::where('name', $request->input('nama_nasabah'))->exists();
    if (!$namaNasabahExists) {
        return redirect()->back()->with('error', 'Nama nasabah tidak ditemukan.');
    }

    // Ambil data jumlah koin dari tabel counter
    $jumlah_koin_100 = counterModel::where('jenis_koin', 'koin100')->sum('jenis_koin');
    $jumlah_koin_200 = counterModel::where('jenis_koin', 'koin200')->sum('jenis_koin');
    $jumlah_koin_500 = counterModel::where('jenis_koin', 'koin500')->sum('jenis_koin');

    // Hitung jumlah rupiah
    $jumlah_rupiah = (100 * $jumlah_koin_100) + (200 * $jumlah_koin_200) + (500 * $jumlah_koin_500);

    // Debug menggunakan Log
    Log::info('Debug data:', [
        'jumlah_koin_100' => $jumlah_koin_100,
        'jumlah_koin_200' => $jumlah_koin_200,
        'jumlah_koin_500' => $jumlah_koin_500,
        'jumlah_rupiah' => $jumlah_rupiah,
        'nama_nasabah' => $request->input('nama_nasabah'),
        'nama_pegawai' => auth()->user()->name, // Mengambil nama pegawai dari user yang sedang login
    ]);

    // Buat entri baru di tabel laporan
    $laporan = new TabelLaporan();
    $laporan->tanggal = Carbon::today()->toDateString();
    $laporan->jam = Carbon::now()->toTimeString();
    $laporan->jumlah_koin_100 = $jumlah_koin_100;
    $laporan->jumlah_koin_200 = $jumlah_koin_200;
    $laporan->jumlah_koin_500 = $jumlah_koin_500;
    $laporan->jumlah_koin_1000 = 0;
    $laporan->jumlah_rupiah = $jumlah_rupiah;
    $laporan->nama_nasabah = $nasabah->id; // Simpan ID nasabah, bukan nama
    $laporan->nama_pegawai = auth()->user()->id; // Mengambil nama pegawai dari user yang sedang login

    // Simpan entri baru ke dalam database
    $laporan->save();

    return redirect()->back()->with('success', 'Laporan baru berhasil dibuat.');
}


}
