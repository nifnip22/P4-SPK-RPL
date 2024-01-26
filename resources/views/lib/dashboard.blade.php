@extends('lib.layouts.main')

@section('main-content')
<div class="px-6 py-20">
    <h1 id="greeting" class="text-center text-5xl font-bold text-green-600 mb-4">Selamat <span class="text-yellow-500">Pagi</span></h1>
    <p class="text-center text-xl mb-20">Anda Login dengan Level <span class="font-bold text-green-600">{{ Auth::user()->level }}</span></p>
    <p class="text-center text-xl mb-4">Apa yang akan Anda Lakukan Hari ini?</p>
    <div class="flex flex-col md:flex-row gap-6 items-center justify-center">
        <button class="bg-green-600 hover:bg-yellow-500 hover:scale-110 duration-300 rounded-xl p-4 text-white font-semibold" onclick="redirectToKasir()"><i class="fa-solid fa-cash-register"></i> Kasir</button>
        <button class="bg-green-600 hover:bg-yellow-500 hover:scale-110 duration-300 rounded-xl p-4 text-white font-semibold" onclick="redirectToProduk()"><i class="fa-solid fa-boxes-stacked"></i> Cek Produk & Stok Barang</button>
        <button class="bg-green-600 hover:bg-yellow-500 hover:scale-110 duration-300 rounded-xl p-4 text-white font-semibold" onclick="redirectToPelanggan()"><i class="fa-solid fa-user-check"></i> Register Member Pelanggan</button>
        @if (Auth::user()->level == 'Admin')
        <button class="bg-green-600 hover:bg-yellow-500 hover:scale-110 duration-300 rounded-xl p-4 text-white font-semibold" onclick="redirectToPetugas()"><i class="fa-regular fa-id-card"></i> Register Petugas/Kasir</button>
        @endif
    </div>
</div>
@endsection
