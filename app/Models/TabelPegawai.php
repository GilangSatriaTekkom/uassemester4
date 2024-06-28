<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelPegawai extends Model
{
    use HasFactory;

    protected $table = 'tabel_pegawai';

    protected $fillable = [
        'nama_pegawai',
        'alamat',
        'gender',
        'no_hp',
    ];
}
