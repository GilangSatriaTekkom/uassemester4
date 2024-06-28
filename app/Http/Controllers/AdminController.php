<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TabelPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TabelLaporan;

class AdminController extends Controller
{
    public function dashboard(Request $request)
{
    // Ambil data tanggal dari request
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalSelesai = $request->input('tanggal_selesai');

    // Ambil data laporan sesuai filter tanggal
    $laporanQuery = DB::table('tabel_laporan')
        ->join('users as nasabah', 'tabel_laporan.nama_nasabah', '=', 'nasabah.id')
        ->join('users as pegawai', 'tabel_laporan.nama_pegawai', '=', 'pegawai.id')
        ->select('tabel_laporan.*', 'nasabah.name as nama_nasabah', 'pegawai.name as nama_pegawai');

    // Filter data berdasarkan tanggal jika ada
    if ($tanggalMulai && $tanggalSelesai) {
        $laporanQuery->whereBetween('tabel_laporan.tanggal', [$tanggalMulai, $tanggalSelesai]);
    }

    $laporan = $laporanQuery->get();

    $data = [
        'laporan' => $laporan,
        'judul' => 'Menampilkan Data Laporan'
    ];

    return view('admin.dashboardAdmin', $data);
}
}
