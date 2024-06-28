<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelTransaksi extends Model
{
    use HasFactory;

    protected $table = 'tabel_transaksi';

    protected $fillable = [
        'tipe_transaksi',
        'jumlah_transaksi',
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
