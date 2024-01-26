@extends('lib.layouts.main')

@section('main-content')
    <div class="grid grid-cols-3 gap-3">
        <div class="col-span-2">
            <div class="flex flex-col">
                <div class="rounded-tr-2xl bg-green-600 border-b-4 border-yellow-500 p-4">
                    <p class="text-gray-100 text-lg font-semibold">Pilih Produk</p>
                </div>
                <div class="bg-slate-200 p-4">
                    <form action="{{ route('kasir-penjualan.search') }}" method="GET" class="sticky top-16 z-30">
                        @csrf
                        <div class="grid grid-cols-3">
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-bl-2xl focus:ring-green-600 focus:border-green-600 block w-full p-2.5 duration-300"
                                name="kategori_produk_id">
                                <option value=""
                                    {{ old('kategori_produk_id') == '' || !old('kategori_produk_id') ? 'selected' : '' }}>
                                    Semua Produk
                                </option>
                                @foreach ($kategoriProduks as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('kategori_produk_id') == $k->id || (isset($searchInput['kategori_produk_id']) && $searchInput['kategori_produk_id'] == $k->id) ? 'selected' : '' }}>
                                        {{ $k->kategori_produk }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="relative col-span-2">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="search" id="search" name="nama_produk"
                                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-br-2xl bg-gray-50 focus:ring-green-600 focus:border-green-600 duration-300"
                                    placeholder="Cari Produk Barang"
                                    value="{{ old('nama_produk') ?? ($searchInput['nama_produk'] ?? '') }}">
                                <button type="submit"
                                    class="text-white absolute end-2.5 bottom-2.5 bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 duration-300">Cari</button>
                            </div>
                        </div>
                    </form>
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-2 gap-y-6 mt-4">
                        @foreach ($produks as $p)
                            <div
                                class="relative bg-gray-100 w-40 h-40 xl:w-52 xl:h-52 overflow-hidden rounded-2xl p-2 group hover:ring-4 hover:ring-yellow-500 hover:bg-yellow-100 hover:scale-105 duration-300">
                                <img src="{{ asset('assets/gambar_produk/' . $p->gambar) }}"
                                    class="object-cover w-full h-full group-hover:scale-125 duration-300">
                                <button
                                    onclick="addToTransaction('{{ $p->nama_produk }}', {{ $p->harga_produk }}, {{ $p->id }})"
                                    class="absolute top-2 end-2 flex items-center justify-center w-8 h-8 {{ $p->stok_produk <= 0 ? 'bg-red-500' : 'bg-green-500' }}  border-2 border-gray-100 rounded-full text-white font-bold"
                                    {{ $p->stok_produk <= 0 ? 'disabled' : '' }}>
                                    @if ($p->stok_produk <= 0)
                                        !
                                    @else
                                        +<span class="product-indicator" data-product-name="{{ $p->nama_produk }}"
                                            style="{{ $p->stok_produk <= 0 ? 'display: none;' : '' }}"></span>
                                    @endif
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-1">
            <div class="flex flex-col sticky top-16">
                <div class="rounded-tl-2xl bg-yellow-500 border-b-4 border-green-500 p-4">
                    <p class="text-gray-100 text-lg font-semibold">Detail Transaksi</p>
                </div>
                <div class="bg-slate-200 p-4">
                    <form action="{{ route('kasir-penjualan.proses') }}" method="POST">
                        @csrf
                        <label class="block mb-2 text-sm font-medium text-gray-900">Total Harga</label>
                        <div class="flex mb-6">
                            <span
                                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md">
                                Rp.
                            </span>
                            <input type="text" id="total-price" name="total_harga"
                                class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-green-600 focus:border-green-600 block flex-1 min-w-0 w-full text-2xl border-gray-300 p-3"
                                readonly placeholder="0.00">
                        </div>

                        <label class="block mb-2 text-sm font-medium text-gray-900">Produk yang di Beli</label>
                        <div class="bg-gray-100 rounded-2xl p-4 mb-6" id="transaction-details">
                            {{-- Product --}}
                        </div>

                        <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Pembayaran</label>
                        <select name="jenis_pembayaran" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5 duration-300 mb-6">
                            <option selected value="Tunai">Tunai</option>
                            <option value="Kartu Kredit">Kartu Kredit</option>
                            <option value="M-Banking">M-Banking</option>
                        </select>

                        <label class="block mb-2 text-sm font-medium text-gray-900">Member Pelanggan</label>
                        <select name="pelanggan_id" id="pelanggan_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5 duration-300 mb-4">
                            <option value="" selected>Pilih Pelanggan (Jika Ada)</option>
                            @foreach ($pelanggans as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_pelanggan }} ({{ $p->no_telp }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-red-500 mb-8">* Jika Pelanggan Memiliki Akun Member, maka Pelanggan akan
                            Mendapatkan Diskon sebesar 30% dari Total Harga</p>

                        <button
                            class="bg-green-500 hover:bg-green-800 duration-300 p-3 rounded-2xl text-gray-100 w-full">Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
