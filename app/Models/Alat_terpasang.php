<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat_terpasang extends Model
{
    use HasFactory;
    protected $table = 'alat_terpasangs';
    protected $fillable = [
        'rs_id',
        'nama_teknisi_lab',
        'alat_id',
        'nomor_seri',
        'tanggal_pemasangan',
        'status_pemasangan',
        'tanggal_pengiriman',
        'tanggal_diterima',
        'garansi_id',
        'tanggal_mulai_garansi',
        'tanggal_selesai_garansi',
        'is_delete',
        'tgl_penghapusan'
    ];

    public function rumah_sakit()
    {
        return $this->hasOne(RumahSakit::class, 'id', 'rs_id');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id', 'id');
    }

    public function garansi()
    {
        return $this->belongsTo(Garansi::class, 'garansi_id', 'id');
    }
}
