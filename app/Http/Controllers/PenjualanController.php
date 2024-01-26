<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\KategoriProduk;
use App\Models\DetailPenjualan;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::all();
        $kategoriProduks = KategoriProduk::all();
        $pelanggans = Pelanggan::all();

        return view('lib.kasir', [
            'title' => 'Kasir Penjualan | PicoPick',
            'produks' => $produks,
            'kategoriProduks' => $kategoriProduks,
            'pelanggans' => $pelanggans,
        ]);
    }

    public function prosesPenjualan(Request $request)
    {
        $request->validate([
            'total_harga' => 'required|numeric',
            'jenis_pembayaran' => 'required|string',
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
        ]);

        // Simpan informasi penjualan
        $penjualan = Penjualan::create([
            'total_harga' => $request->input('total_harga'),
            'jenis_pembayaran' => $request->input('jenis_pembayaran'),
            'pelanggan_id' => $request->input('pelanggan_id'),
        ]);

        // Simpan setiap produk yang dibeli ke dalam tabel Detail Penjualan
        foreach ($request->input('produk_id') as $index => $produkId) {
            // Mengurangkan stok produk
            $produk = Produk::find($produkId);
            $jumlahProduk = $request->input('jumlah_produk')[$index];
            $produk->stok_produk -= $jumlahProduk;
            $produk->save();

            // Simpan ke dalam tabel Detail Penjualan
            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $produkId,
                'jumlah_produk' => $jumlahProduk,
                'subtotal' => $request->input('subtotal')[$index],
            ]);
        }

        return redirect()->route('kasir-penjualan.index')->with('penjualan_success', 'Transaksi Berhasil!');
    }

    public function search(Request $request)
    {
        $kategoriProduk = KategoriProduk::all();
        $pelanggans = Pelanggan::all(); // Tambahkan ini

        // Ambil input dari form
        $kategoriId = $request->input('kategori_produk_id');
        $namaProduk = $request->input('nama_produk');

        // Query untuk pencarian produk
        $query = Produk::query();

        // Filter berdasarkan kategori produk jika dipilih
        if ($kategoriId && $kategoriId !== 'Semua Produk') {
            $query->where('kategori_produk_id', $kategoriId);
        }

        // Filter berdasarkan nama produk
        if ($namaProduk) {
            $query->where('nama_produk', 'LIKE', '%' . $namaProduk . '%');
        }

        // Ambil data produk yang sesuai dengan filter
        $produks = $query->paginate(10);

        return view('lib.kasir', [
            'title' => 'Kasir Penjualan | PicoPick',
            'produks' => $produks,
            'kategoriProduks' => $kategoriProduk,
            'pelanggans' => $pelanggans, 
        ])->with('searchInput', $request->all());
    }
}
