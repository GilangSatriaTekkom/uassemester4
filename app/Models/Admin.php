<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'tabel_admin';

    protected $fillable = [
        'nama_admin', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
