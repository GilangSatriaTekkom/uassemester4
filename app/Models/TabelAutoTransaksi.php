<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelAutoTransaksi extends Model
{

    use HasFactory;

    protected $table = 'transaksi_otomatis';

    protected $fillable = [
        'id_user',
        'nama_penerima',
        'nomor_rekening',
        'jumlah_transfer',
        'interval',
        'tanggal',
        'status',
    ];

    public function rekening()
    {
        return $this->belongsTo(TabelRekening::class, 'Id_rekening');
    }

    public function penerima()
    {
        return $this->belongsTo(TabelRekening::class, 'penerima_transaksi');
    }
}
