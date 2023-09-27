<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualBook extends Model
{
    use HasFactory;
    protected $table = 'manual_books';
    protected $fillable = [
        'alat_id',
        'nama_file'
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id', 'id');
    }
}
