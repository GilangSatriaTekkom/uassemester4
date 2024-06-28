<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TabelRekening;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Create a new rekening for the user
        $this->createRekening($user);

        return $user;
    }

    /**
     * Create a new rekening for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createRekening(User $user)
    {
        // Generate a unique 10-digit account number
        $nomor_rekening = $this->generateUniqueAccountNumber();

        // Create a new rekening
        TabelRekening::create([
            'nomor_rekening' => $nomor_rekening,
            'jumlah_tabungan' => 0,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Generate a unique 10-digit account number.
     *
     * @return string
     */
    protected function generateUniqueAccountNumber()
    {
        do {
            $nomor_rekening = mt_rand(1000000000, 9999999999);
        } while (TabelRekening::where('nomor_rekening', $nomor_rekening)->exists());

        return (string) $nomor_rekening;
    }
}
