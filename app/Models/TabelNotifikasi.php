<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelNotifikasi extends Model
{
    use HasFactory;

    protected $table = 'tabel_notifikasi';

    protected $fillable = [
        'Id_nasabah',
        'pesan',
        'is_read',
        'tanggal_buat',
    ];

    public function nasabah()
    {
        return $this->belongsTo(TabelNasabah::class, 'Id_nasabah');
    }
}
