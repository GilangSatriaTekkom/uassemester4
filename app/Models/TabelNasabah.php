<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelNasabah extends Model
{
    use HasFactory;

    protected $table = 'tabel_nasabah';

    protected $fillable = [
        'nama_nasabah',
        'alamat',
        'gender',
        'no_hp',
    ];
}
