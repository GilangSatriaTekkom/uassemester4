<?php

namespace App\Http\Controllers;
use App\Models\TabelLaporan;
use App\Models\CounterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Http;

class SensorController extends Controller
{
    function counter($coinType) {
        DB::table('counter')->insert([
            'jenis_koin' => $coinType,
            'tanggal_jam' => now()
        ]);
    }

    public function log()
    {
        DB::table('log_garasi')->insert(['id_garasi'=>1,'status'=>request()->status,'created_at' => now(),'updated_at' => now()]);
    }

    function getSuhu() {
        $suhu = DB::table('data_sensor')->value('suhu');
        return response()->json($suhu);
    }

    function getLog() {
        $log = DB::table('log_garasi')
        ->orderBy('created_at', 'desc') // Replace 'created_at' with the appropriate timestamp column
        ->value('status');
        return response()->json($log);
    }
}
