<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_harga',
        'jenis_pembayaran',
        'pelanggan_id',
    ];

    public function pelanggan () {
        return $this->belongsTo(Pelanggan::class);
    }

    public function detailPenjualan () {
        return $this->hasMany(DetailPenjualan::class);
    }
}
