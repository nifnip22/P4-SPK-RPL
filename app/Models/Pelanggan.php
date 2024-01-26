<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'no_telp',
    ];

    public function penjualan () {
        return $this->hasMany(Penjualan::class);
    }
}
