<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TabelRekening;


class ProfileController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        // Mendapatkan data rekening berdasarkan ID
        $rekening = TabelRekening::where('id', $id)->first();

        // Mengambil saldo dan nomor rekening dari $rekening jika ditemukan
        if ($rekening) {
            $saldo = $rekening->jumlah_tabungan;
            $nomorRekening = $rekening->nomor_rekening;
        } else {
            // Handle jika rekening tidak ditemukan
            $saldo = null;
            $nomorRekening = null;
        }

        // Kemudian lempar ke view dengan compact
        return view('profile', compact('saldo', 'nomorRekening', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'gender' => 'required|string|in:Laki-Laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->no_hp = $request->no_hp;
        $user->gender = $request->gender;
        $user->alamat = $request->alamat;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route(
            Auth::user()->level == 'admin' ? 'admin.profile.show' : 
            (Auth::user()->level == 'pegawai' ? 'pegawai.profile.show' : 'profile.show'), 
            ['id' => $user->id]
        )->with('success', 'Profile updated successfully.');
        
    }
}
