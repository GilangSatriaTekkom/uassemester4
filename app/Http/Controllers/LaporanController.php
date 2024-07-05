<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TabelPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TabelLaporan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function show()
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
                    'pegawai.name as nama_pegawai',
                    'tabel_laporan.tanggal', 'tabel_laporan.jam') // Tambahkan tanggal dan jam
            ->whereDate('tabel_laporan.tanggal', Carbon::today()) // Filter untuk hari ini saja
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
                     'pegawai.name as nama_pegawai',
                     'tabel_laporan.tanggal', 'tabel_laporan.jam', // Tambahkan tanggal dan jam
                     'tabel_laporan.created_at', 'tabel_laporan.updated_at') // Ambil created_at dan updated_at
            ->get();
    }


    // Data yang akan dikirimkan ke view
    $data = [
        'laporan' => $laporan,
        'judul' => $user->level == 'pegawai' ? 'Menampilkan Laporan Hari Ini' : 'Menampilkan Semua Data Laporan',
        'user' => $user
    ];

    // Mengirimkan data ke view 'laporan.blade.php'
    return view('laporan', $data);
}


    public function store(Request $request)
    {
        $request->validate([
            'nama_nasabah' => 'required|exists:users,id',
            'nama_pegawai' => 'required|exists:users,id',
            'jenis_transaksi' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
        ]);

        TabelLaporan::create([
            'nama_nasabah' => $request->nama_nasabah,
            'nama_pegawai' => $request->nama_pegawai,
            'jenis_transaksi' => $request->jenis_transaksi,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil ditambahkan');
    }

    public function edit($id, $id_laporan)
{
    $laporan = TabelLaporan::where('id_laporan', $id_laporan)->first();
    $users = User::all();
    $user = Auth::user(); // Mendapatkan user yang sedang login

    return view('editLaporan', compact('laporan', 'users', 'id', 'user'));
}

public function update(Request $request, $id, $id_laporan)
{
    $laporan = TabelLaporan::where('Id_laporan', $id_laporan)->first();

    if (!$laporan) {
        // Handle error or return a response indicating the laporan was not found
        return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
    }

    // Log the incoming request data
    \Log::debug('Request data: ', $request->all());

    // Validasi input
    $request->validate([
        'nama_pegawai' => 'required|exists:users,id',
        'nama_nasabah' => 'required|exists:users,id',
        'jumlah_koin_100' => 'required|numeric',
        'jumlah_koin_200' => 'required|numeric',
        'jumlah_koin_500' => 'required|numeric',
        'jumlah_koin_1000' => 'required|numeric',
    ]);

    // Hitung jumlah rupiah
    $jumlah_rupiah = ($request->jumlah_koin_100 * 100) +
                     ($request->jumlah_koin_200 * 200) +
                     ($request->jumlah_koin_500 * 500) +
                     ($request->jumlah_koin_1000 * 1000);

    // Update fields using raw SQL
    $updated = DB::update('UPDATE tabel_laporan SET nama_pegawai = ?, nama_nasabah = ?, jumlah_koin_100 = ?, jumlah_koin_200 = ?, jumlah_koin_500 = ?, jumlah_koin_1000 = ?, jumlah_rupiah = ? WHERE id_laporan = ?', [
        $request->nama_pegawai,
        $request->nama_nasabah,
        $request->jumlah_koin_100,
        $request->jumlah_koin_200,
        $request->jumlah_koin_500,
        $request->jumlah_koin_1000,
        $jumlah_rupiah,
        $id_laporan
    ]);

    // Log the updated laporan data
    \Log::debug('Updated laporan data: ', [
        'nama_pegawai' => $request->nama_pegawai,
        'nama_nasabah' => $request->nama_nasabah,
        'jumlah_koin_100' => $request->jumlah_koin_100,
        'jumlah_koin_200' => $request->jumlah_koin_200,
        'jumlah_koin_500' => $request->jumlah_koin_500,
        'jumlah_koin_1000' => $request->jumlah_koin_1000,
        'jumlah_rupiah' => $jumlah_rupiah
    ]);

    if ($updated) {
        \Log::info('Laporan updated: ' . json_encode([
            'id_laporan' => $id_laporan,
            'nama_pegawai' => $request->nama_pegawai,
            'nama_nasabah' => $request->nama_nasabah,
            'jumlah_koin_100' => $request->jumlah_koin_100,
            'jumlah_koin_200' => $request->jumlah_koin_200,
            'jumlah_koin_500' => $request->jumlah_koin_500,
            'jumlah_koin_1000' => $request->jumlah_koin_1000,
            'jumlah_rupiah' => $jumlah_rupiah
        ]));
    } else {
        \Log::error('Failed to update laporan: ' . $id_laporan);
    }

    return redirect()->route('admin.laporan.edit', ['id' => $id, 'id_laporan' => $id_laporan])
                     ->with('success', 'Laporan berhasil diupdate.');
}

    public function destroy($id, $id_laporan)
    {
        $deleted = DB::table('tabel_laporan')->where('id_laporan', $id_laporan)->delete();

        if ($deleted) {
            return redirect()->route('admin.laporan.show', ['id' => $id])->with('success', 'Laporan berhasil dihapus');
        } else {
            return redirect()->route('admin.laporan.show', ['id' => $id])->with('error', 'Laporan tidak ditemukan');
        }
    }

    public function filter(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $laporan = TabelLaporan::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])->get();

        return view('laporan', compact('laporan'));
    }


}
