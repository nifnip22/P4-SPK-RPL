<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriProduks = [
            ['kategori_produk' => 'Makanan & Minuman'],
            ['kategori_produk' => 'Produk Segar'],
            ['kategori_produk' => 'Barang Pokok'],
            ['kategori_produk' => 'Kesehatan & Kecantikan'],
            ['kategori_produk' => 'Produk Pembersih'],
            ['kategori_produk' => 'Produk Rumah Tangga'],
            ['kategori_produk' => 'Makanan Beku'],
            ['kategori_produk' => 'Alat Tulis dan Peralatan Kantor Kecil'],
            ['kategori_produk' => 'Produk Elektronik Kecil'],
        ];

        DB::table('kategori_produks')->insert($kategoriProduks);
    }
}
