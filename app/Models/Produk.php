<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'kategori_produk_id',
        'harga_produk',
        'stok_produk',
        'gambar',
    ];

    public function kategoriProduk () {
        return $this->belongsTo(KategoriProduk::class);
    }

    public function detailPenjualan () {
        return $this->hasMany(DetailPenjualan::class);
    }
}
