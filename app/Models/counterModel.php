<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class counterModel extends Model
{
    use HasFactory;

    protected $table = 'counter';
    protected $fillable = ['jenis_koin', 'tanggal_jam'];
    public $timestamps = false; // Jika tidak ada kolom timestamps (created_at, updated_at)
}
