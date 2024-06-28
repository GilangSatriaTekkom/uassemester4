<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelLaporan extends Model
{
    use HasFactory;

    protected $table = 'tabel_laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'tanggal',
        'jam',
        'nama_pegawai',
        'nama_nasabah',
        'jumlah_koin_100',
        'jumlah_koin_200',
        'jumlah_koin_500',
        'jumlah_koin_1000',
        'jumlah_rupiah',
    ];

    public function pegawai()
    {
        return $this->belongsTo(TabelPegawai::class, 'nama_pegawai');
    }

    public function nasabah()
    {
        return $this->belongsTo(TabelNasabah::class, 'nama_nasabah');
    }
}
