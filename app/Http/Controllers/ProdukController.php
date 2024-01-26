<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KategoriProduk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::paginate(10);
        $kategoriProduk = KategoriProduk::all();

        return view('lib.produk', [
            'title' => 'Data Produk | PicoPick',
            'produks' => $produks,
            'kategoriProduk' => $kategoriProduk,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukRequest $request)
    {
        $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'kategori_produk_id' => ['required', 'exists:kategori_produks,id'],
            'harga_produk' => ['required', 'numeric', 'min:0'],
            'stok_produk' => ['required', 'numeric', 'integer', 'min:0'],
            'gambar' => ['required', 'image', 'mimes:jpeg,png', 'max:5120'],
        ]);

        $file = $request->file('gambar');
        $fileName = Str::random(16) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/gambar_produk'), $fileName);

        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'kategori_produk_id' => $request->kategori_produk_id,
            'harga_produk' => $request->harga_produk,
            'stok_produk' => $request->stok_produk,
            'gambar' => $fileName,
        ]);

        if ($produk) {
            return redirect()->route('data-produk.index')->with('tambahProduk_success', 'Produk Berhasil di Tambah!');
        } else {
            return redirect()->route('data-produk.index')->with('tambahProduk_error', 'Terjadi Kesalahan!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, $id)
    {
        $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'kategori_produk_id' => ['required', 'exists:kategori_produks,id'],
            'harga_produk' => ['required', 'numeric', 'min:0'],
            'stok_produk' => ['required', 'numeric', 'integer', 'min:0'],
        ]);

        $produk = Produk::findOrFail($id);

        // Update data produk
        $process = $produk->update([
            'nama_produk' => $request->input('nama_produk'),
            'kategori_produk_id' => $request->input('kategori_produk_id'),
            'harga_produk' => $request->input('harga_produk'),
            'stok_produk' => $request->input('stok_produk'),
        ]);

        if ($process) {
            return redirect()->route('data-produk.index')->with('updateProduk_success', 'Produk Berhasil diperbarui!');
        }

        return back()->withInput()->with('updateProduk_error', 'Terjadi Kesalahan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        $filePath = public_path('assets/gambar_produk/' . $produk->gambar);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if ($produk->delete()) {
            return redirect()->route('data-produk.index')->with('deleteProduk_success', 'Produk Berhasil di Hapus!');
        } else {
            return redirect()->route('data-produk.index')->with('deleteProduk_error', 'Terjadi Kesalahan!');
        }
    }

    public function search(Request $request)
    {
        $kategoriProduk = KategoriProduk::all();

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

        return view('lib.produk', [
            'title' => 'Data Produk | PicoPick',
            'produks' => $produks,
            'kategoriProduk' => $kategoriProduk,
        ])->with('searchInput', $request->all());
    }
}
