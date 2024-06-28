<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TabelRekening;
use Illuminate\Support\Facades\DB;

class authLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Get the authenticated user
            $user = Auth::user();

            // Redirect based on user's role
            switch ($user->level) {
                case 'admin':
                    return redirect()->route('admin.dashboard' , ['id' => $user->id]);
                case 'pegawai':
                    return redirect()->route('pegawai.dashboard' , ['id' => $user->id]);
                case 'nasabah':
                    return redirect()->route('nasabah.dashboard', ['id' => $user->id]);
                default:
                    return redirect('/login'); // Redirect to default path if user's role is not recognized
            }
        }

        // If login attempt fails, redirect back with error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Membuat user baru
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']),
    ]);

    // Generate nomor rekening unik
    $nomor_rekening = $this->generateUniqueAccountNumber();

    // Menggunakan transaksi untuk memastikan konsistensi data
    DB::transaction(function () use ($user, $nomor_rekening) {
        // Membuat rekening baru untuk user
        TabelRekening::create([
            'nomor_rekening' => $nomor_rekening,
            'jumlah_tabungan' => 0,
            'id' => $user->id, // Pastikan id_user tersedia
        ]);
    });

    // Login user setelah registrasi
    Auth::login($user);

    // Redirect ke halaman login setelah registrasi berhasil
    return redirect('/login');
}

    protected function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function createAccount(User $user)
    {
        // Generate a unique 10-digit account number
        $nomor_rekening = $this->generateUniqueAccountNumber();

        // Create a new rekening
        TabelRekening::create([
            'nomor_rekening' => $nomor_rekening,
            'jumlah_tabungan' => 0,
            'id_user' => $user->id,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function generateUniqueAccountNumber()
    {
        do {
            $nomor_rekening = mt_rand(1000000000, 9999999999);
        } while (TabelRekening::where('nomor_rekening', $nomor_rekening)->exists());

        return (string) $nomor_rekening;
    }
}
