<?php

namespace App\Http\Controllers;

use App\Models\TabelNasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TabelLaporan;


class TabelLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporan = TabelLaporan::all();
        return response()->json($laporan);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $laporan = new TabelLaporan;
        $laporan->tanggal = $request->tanggal;
        $laporan->jam = $request->jam;
        $laporan->nama_pegawai = $request->nama_pegawai;
        $laporan->nama_nasabah = $request->nama_nasabah;
        $laporan->jumlah_koin_100 = $request->jumlah_koin_100;
        $laporan->jumlah_koin_200 = $request->jumlah_koin_200;
        $laporan->jumlah_koin_500 = $request->jumlah_koin_500;
        $laporan->jumlah_koin_1000 = $request->jumlah_koin_1000;
        $laporan->jumlah_rupiah = $request->jumlah_rupiah;
        $laporan->save();

        return response()->json($laporan);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function dashboard()
    {
        // $laporan = TabelLaporan::all();
        // return view('dashboard', compact('laporan'));

        $laporan = DB::table('tabel_laporan')
        ->join('tabel_nasabah', 'tabel_laporan.nama_nasabah', '=', 'tabel_nasabah.Id_nasabah')
        ->join('tabel_pegawai', 'tabel_laporan.nama_pegawai', '=', 'tabel_pegawai.Id_pegawai')
        ->select('tabel_laporan.*', 'tabel_nasabah.nama_nasabah', 'tabel_pegawai.nama_pegawai')
        ->get();

        // $laporan = TabelLaporan::all();

        $data=array(
            'laporan' => $laporan,
            'judul' => 'Menampilkan Semua Data Mahasiswa' 
        );

    return view('admin.dashboardAdmin', $data);
    }
}
