<?php

use App\Console\Commands\ProcessAutomaticTransfers;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;
use App\Models\TabelAutoTransaksi;
use App\Models\TabelRekening;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

$user_id = Auth::id(); // Mengambil ID pengguna yang sedang login

Schedule::command('transfers:process')->everySecond();
