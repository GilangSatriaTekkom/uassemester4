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
        // Example: Fetching records based on $id
        $laporan = TabelLaporan::where('id_laporan', $id)->get();

        // Process $laporan as needed
        return view('pegawai.dashboardPegawai', compact('laporan'));
    }
}
