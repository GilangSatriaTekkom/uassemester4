<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TabelPegawaiController;
use Illuminate\Support\Facades\DB;
use App\Models\TabelLaporan;
use App\Models\User;


class PegawaiController extends Controller
{
    public function dashboard($id)
    {
        // Fetching records created today
        $laporan = TabelLaporan::whereDate('tanggal', Carbon::today())->get();

        // Process $laporan as needed
        return view('pegawai.dashboardPegawai', compact('laporan'));
    }
}
