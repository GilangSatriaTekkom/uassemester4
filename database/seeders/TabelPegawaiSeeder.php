<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TabelPegawai;
use Carbon\Carbon;


class TabelPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_pegawai' => 'Gilang',
                'alamat' => 'Jalan Rambay, Sukabumi',
                'gender' => 'L',
                'no_hp' => '089712345',
            ],
            [
                'nama_pegawai' => 'Andi',
                'alamat' => 'Jl. Raya No. 123',
                'gender' => 'L',
                'no_hp' => '081234567890',
            ],
            [
                'nama_pegawai' => 'Deni',
                'alamat' => 'Jl. Anggrek No. 11',
                'gender' => 'L',
                'no_hp' => '081999888777',
            ],
            [
                'nama_pegawai' => 'Gina',
                'alamat' => 'Jl. Kamboja No. 44',
                'gender' => 'P',
                'no_hp' => '081234567890',
            ],
            [
                'nama_pegawai' => 'Joko',
                'alamat' => 'Jl. Teratai No. 77',
                'gender' => 'L',
                'no_hp' => '081999888777',
            ],
        ];

        foreach ($data as $pegawai) {
            TabelPegawai::create($pegawai);
        }

    }
}
