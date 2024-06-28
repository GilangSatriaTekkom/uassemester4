<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TabelPegawaiController;
use App\Http\Controllers\TabelNasabahController;
use App\Http\Controllers\TabelRekeningController;
use App\Http\Controllers\TabelLaporanController;
use App\Http\Controllers\TabelTransaksiController;
use App\Http\Controllers\TabelNotifikasiController;
use App\Http\Controllers\TabelAutoTransaksiController;
use App\Http\Controllers\KoinController;
use App\Http\Controllers\authLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\EmployeeLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\AuthenticateAdmin;
use App\Http\Middleware\AuthenticatePegawai;
use App\Http\Middleware\AuthenticateNasabah;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransaksiOtomatisController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ToggleController;
use App\Http\Controllers\SensorController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('pegawai', TabelPegawaiController::class);
Route::resource('nasabah', TabelNasabahController::class);
Route::resource('rekening', TabelRekeningController::class);
Route::resource('laporan', TabelLaporanController::class);
Route::resource('transaksi', TabelTransaksiController::class);
Route::resource('notifikasi', TabelNotifikasiController::class);
Route::resource('auto-transaksi', TabelAutoTransaksiController::class);

Route::get('/sensor-koin/{cointype}',[SensorController::class,'counter']);
Route::get('/sensor-pintu/{status}',[SensorController::class,'log']);
Route::get('/suhu',[SensorController::class,'getSuhu']);
Route::get('/log',[SensorController::class,'getLog']);
    
    // Routes for Admin
    Route::middleware([AuthenticateAdmin::class])->group(function () {
        Route::get('/admin/dashboard/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');  
        Route::get('/admin/profile/{id}', [ProfileController::class, 'show'])->name('admin.profile.show');
        Route::post('/admin/profile/update/{id}', [ProfileController::class, 'update'])->name('admin.profile.update');

        // Laporan Routes
        Route::get('/admin/laporan/{id}', [LaporanController::class, 'show'])->name('admin.laporan.show');
        Route::post('/admin/laporan/{id}', [LaporanController::class, 'store'])->name('admin.laporan.store');
        Route::get('/admin/laporan/{id}/edit/{id_laporan}', [LaporanController::class, 'edit'])->name('admin.laporan.edit');
        Route::put('/admin/laporan/{id}/update/{id_laporan}', [LaporanController::class, 'update'])->name('admin.laporan.update');
        Route::delete('/admin/laporan/{id}', [LaporanController::class, 'destroy'])->name('admin.laporan.destroy');
        Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index'); // Ubah route ini
        Route::get('/admin/laporan/filter', [LaporanController::class, 'filter'])->name('admin.laporan.filter'); // Sesuaikan route ini dengan yang digunakan di form filter
        Route::get('/admin/laporan/search', 'App\Http\Controllers\LaporanController@search')->name('admin.laporan.search');
        
        
    });

    // Routes for Pegawai
    Route::middleware([AuthenticatePegawai::class])->group(function () {
        Route::get('/pegawai/dashboard/{id}', [PegawaiController::class, 'dashboard'])->name('pegawai.dashboard');
        Route::get('/pegawai/koin-counter/{id}', [KoinController::class, 'index', 'getCurrentUser'])->name('koin.counter');
        Route::post('/pegawai/koin-counter/update/{id}', [KoinController::class, 'update'])->name('updateReport');
        Route::get('/pegawai/notifications/{id}', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/pegawai/profile/{id}', [ProfileController::class, 'show'])->name('pegawai.profile.show');
        Route::post('/pegawai/profile/update/{id}', [ProfileController::class, 'update'])->name('pegawai.profile.update');
        Route::get('/coin-counts', [KoinController::class, 'getCoinCounts']);
        Route::get('/employees', [KoinController::class, 'getEmployees']);
        Route::post('/reset-counter', [KoinController::class, 'resetCounter'])->name('resetCounter');
        Route::get('/pegawai/laporan/{id}', [LaporanController::class, 'show'])->name('pegawai.laporan.show');
        Route::get('/pegawai/notifications/{id}', [NotificationController::class, 'index'])->name('pegawai.notifications.index');
        Route::post('/pegawai/koin-counter/controlRelay/', [ToggleController::class, 'controlRelay'])->name('controlRelay');
        Route::get('/getStatus', [ToggleController::class, 'getStatus']);
        Route::get('/api/koin-counter/suggest', [KoinController::class, 'suggestNasabah'])->name('api.koin-counter.suggest');
        Route::post('/koinCounter/update/{id}', [KoinController::class, 'update'])->name('koinCounter.update');


        
        


    });

    // Routes for Nasabah
    Route::middleware([AuthenticateNasabah::class])->group(function () {
        Route::get('/nasabah/dashboard/{id}', [NasabahController::class, 'dashboard'])->name('nasabah.dashboard');
        Route::get('/transactions/create/{type}/{id}', [TransaksiController::class, 'create'])->name('transactions.create');
        Route::post('/transactions/store/{type}/{id}', [TransaksiController::class, 'store'])->name('transactions.store'); 
        Route::get('/transactions/history/{id}', [TransaksiController::class, 'history'])->name('transactions.history');  
        Route::get('/nasabah/notifications/{id}', [NotificationController::class, 'index'])->name('notifications.index');
        
        
        Route::get('/nasabah/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('/nasabah/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/transactions/auto/{id}', [TransaksiOtomatisController::class, 'index'])->name('transactions.auto');
        Route::post('/transactions/auto/store/{id}', [TransaksiOtomatisController::class, 'store'])->name('transactions.auto.store');
        Route::delete('/transactions/auto/{id}', [TransaksiOtomatisController::class, 'destroy'])->name('transactions.auto.destroy');
        Route::get('/api/rekening/suggest', [TransaksiController::class, 'suggest'])->name('api.rekening.suggest');


        Route::get('/nomor-rekening/{nomor_rekening}', function($nomor_rekening) {
            $rekening = TabelRekening::where('nomor_rekening', $nomor_rekening)->first();
        
            if ($rekening) {
                return response()->json([
                    'success' => true,
                    'nama_penerima' => $rekening->user->nama,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                ]);
            }
        });

        // Add more routes for Nasabah as needed
    });

// Authentication Routes
Route::get('login', [authLoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [authLoginController::class, 'login']);
Route::post('logout', [authLoginController::class, 'logout'])->name('logout');
Route::get('register', [authLoginController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [authLoginController::class, 'register']);