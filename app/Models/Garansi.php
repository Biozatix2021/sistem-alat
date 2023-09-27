<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garansi extends Model
{
    use HasFactory;
    protected $table = 'garansis';
    protected $fillable = [
        'nama',
        'periode_garansi',
        'keterangan',
    ];
}
