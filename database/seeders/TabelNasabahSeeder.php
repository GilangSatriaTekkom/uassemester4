<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TabelNasabah;
use Carbon\Carbon;


class TabelNasabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_nasabah' => 'Mira',
                'alamat' => 'Jl. Sakura No. 11',
                'gender' => 'P',
                'no_hp' => '081234567890',
            ],
            [
                'nama_nasabah' => 'Gita',
                'alamat' => 'Jl. Kenanga No. 77',
                'gender' => 'P',
                'no_hp' => '081234567891',
            ],
            [
                'nama_nasabah' => 'Hadi',
                'alamat' => 'Jl. Teratai No. 88',
                'gender' => 'L',
                'no_hp' => '087654321097',
            ],
            [
                'nama_nasabah' => 'Ika',
                'alamat' => 'Jl. Dahlia No. 55',
                'gender' => 'P',
                'no_hp' => '081999888777',
            ],
            [
                'nama_nasabah' => 'Joko',
                'alamat' => 'Jl. Melati No. 66',
                'gender' => 'L',
                'no_hp' => '087777666555',
            ],
        ];

        foreach ($data as $nasabah) {
            TabelNasabah::create($nasabah);
        }
    }
}
