<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toggle extends Model
{
    use HasFactory;
    protected $table = 'toggle';
    protected $fillable = ['value'];
}
