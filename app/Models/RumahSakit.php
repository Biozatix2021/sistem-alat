<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    use HasFactory;
    protected $table = 'rumah_sakits';
    protected $fillable = [
        'id',
        'nama_rs',
        'kabupaten_kota',
        'latitude',
        'longitude',
    ];
}
