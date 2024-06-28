<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelRekening extends Model
{
    use HasFactory;

    protected $table = 'tabel_rekening';

    protected $fillable = [
        'nomor_rekening',
        'jumlah_tabungan',
        'tanggal_buat',
        'tanggal_update',
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
