@extends('lib.layouts.main')

@section('main-content')
    <div class="grid grid-cols-3 gap-3">
        <div class="col-span-2">
            <div class="flex flex-col">
                <div class="rounded-tr-2xl bg-green-600 border-b-4 border-yellow-500 p-4">
                    <p class="text-gray-100 text-lg font-semibold">Data Seluruh Produk</p>
                </div>
                <div class="bg-slate-200 p-4">
                    <form action="{{ route('data-produk.search') }}" method="GET" class="sticky top-16 z-30">
                        @csrf
                        <div class="grid grid-cols-3">
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-bl-2xl focus:ring-green-600 focus:border-green-600 block w-full p-2.5 duration-300"
                                name="kategori_produk_id">
                                <option value=""
                                    {{ old('kategori_produk_id') == '' || !old('kategori_produk_id') ? 'selected' : '' }}>
                                    Semua Produk
                                </option>
                                @foreach ($kategoriProduk as $k)
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
                    <div class="mt-4 bg-gray-100 w-full rounded-2xl p-4">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr class="text-center">
                                        <th scope="col" class="px-6 py-3">
                                            No
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Nama Produk
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Kategori Produk
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Harga Produk
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Stok Produk
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Gambar Produk
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <i class="fa-solid fa-gear"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produks as $p)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                                                {{ $loop->iteration }}
                                            </th>
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $p->nama_produk }}
                                            </th>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $p->kategoriProduk->kategori_produk }}
                                            </td>
                                            <td class="px-6 py-4">
                                                Rp.{{ $p->harga_produk }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $p->stok_produk }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="relative w-52 h-52 overflow-hidden rounded-2xl p-2">
                                                    <img src="{{ asset('assets/gambar_produk/' . $p->gambar) }}"
                                                        class="object-cover w-full h-full group-hover:scale-125 duration-300 rounded-2xl">
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex gap-x-2 items-center justify-center">
                                                    <button type="button" data-modal-target="editModal{{ $p->id }}"
                                                        data-modal-toggle="editModal{{ $p->id }}"
                                                        class="bg-yellow-500 hover:bg-yellow-700 hover:text-white duration-300 rounded-2xl px-3 py-2"><i
                                                            class="fa fa-edit"></i></button>
                                                    <form action="{{ route('data-produk.destroy', ['produk' => $p->id]) }}"
                                                        method="POST" id="delete-form-2-{{ $p->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="delete-button-2 bg-red-500 hover:bg-red-700 duration-300 rounded-2xl px-3 py-2 text-white"
                                                            data-id-2="{{ $p->id }}"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                                <div id="editModal{{ $p->id }}" tabindex="-1" aria-hidden="true"
                                                    data-modal-backdrop="static"
                                                    class="modal hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                                        <!-- Modal content -->
                                                        <div class="relative bg-white rounded-lg shadow">
                                                            <!-- Modal header -->
                                                            <div
                                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                                                <h3 class="text-lg font-semibold text-yellow-500">
                                                                    Edit Produk
                                                                </h3>
                                                                <button type="button"
                                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                                    data-modal-toggle="editModal{{ $p->id }}">
                                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 14 14">
                                                                        <path stroke="currentColor" stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                    </svg>
                                                                    <span class="sr-only">Close modal</span>
                                                                </button>
                                                            </div>
                                                            <!-- Modal body -->
                                                            <form class="p-4 md:p-5"
                                                                action="{{ route('data-produk.update', ['produk' => $p->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="grid gap-4 mb-4 grid-cols-2">
                                                                    <div class="col-span-2 sm:col-span-1">
                                                                        <label for="nama_produk"
                                                                            class="block mb-2 text-sm font-medium text-gray-900">Nama
                                                                            Produk</label>
                                                                        <input type="text" name="nama_produk"
                                                                            id="nama_produk"
                                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-2xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5"
                                                                            placeholder="Masukkan Nama Produk"
                                                                            required="" value="{{ $p->nama_produk }}">
                                                                    </div>
                                                                    <div class="col-span-2 sm:col-span-1">
                                                                        <label for="category"
                                                                            class="block mb-2 text-sm font-medium text-gray-900">Kategori
                                                                            Produk</label>
                                                                        <select id="category" name="kategori_produk_id"
                                                                            required
                                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-2xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                                                                            <option selected=""
                                                                                value="{{ $p->kategoriProduk->id }}">
                                                                                Di Pilih Sebelumnya:
                                                                                {{ $p->kategoriProduk->kategori_produk }}
                                                                            </option>
                                                                            <option disabled>================</option>
                                                                            @foreach ($kategoriProduk as $k)
                                                                                <option value="{{ $k->id }}">
                                                                                    {{ $k->kategori_produk }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-span-2 sm:col-span-1">
                                                                        <label for="harga_produk"
                                                                            class="block mb-2 text-sm font-medium text-gray-900">Harga
                                                                            Produk</label>
                                                                        <input type="number" name="harga_produk"
                                                                            step="0.01" min="0"
                                                                            onKeyPress="if(this.value.length==9) return false;"
                                                                            id="harga_produk"
                                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-2xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5"
                                                                            placeholder="000000" required=""
                                                                            value="{{ $p->harga_produk }}">
                                                                    </div>
                                                                    <div class="col-span-2 sm:col-span-1">
                                                                        <label for="stok_produk"
                                                                            class="block mb-2 text-sm font-medium text-gray-900">Stok
                                                                            Produk</label>
                                                                        <input type="number" name="stok_produk"
                                                                            min="0"
                                                                            onKeyPress="if(this.value.length==9) return false;"
                                                                            id="stok_produk"
                                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-2xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5"
                                                                            placeholder="Masukkan Stok Produk"
                                                                            required="" value="{{ $p->stok_produk }}">
                                                                    </div>
                                                                </div>
                                                                <button type="submit"
                                                                    class="mt-3 text-white inline-flex items-center bg-yellow-600 hover:bg-yellow-800 duration-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                                    Edit Produk
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-1">
            <div class="flex flex-col sticky top-16">
                <div class="rounded-tl-2xl bg-yellow-500 border-b-4 border-green-500 p-4">
                    <p class="text-gray-100 text-lg font-semibold">Form Tambah Produk</p>
                </div>
                <div class="bg-slate-200 rounded-bl-2xl p-4">
                    <form action="{{ route('data-produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nama Produk</label>
                        <div class="mb-6">
                            <input type="text" name="nama_produk" maxlength="255"
                                class="@error('nama_produk') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror rounded-2xl bg-gray-50 border text-gray-900 focus:ring-green-600 focus:border-green-600 duration-300 block flex-1 min-w-0 w-full border-gray-300 p-2.5"
                                required placeholder="Masukkan Nama Produk">
                            @error('nama_produk')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Kategori Produk</label>
                        <div class="mb-6">
                            <select name="kategori_produk_id"
                                class="@error('kategori_produk_id') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror bg-gray-50 border border-gray-300 text-gray-900 rounded-2xl focus:ring-green-600 focus:border-green-600 block w-full p-2.5 duration-300">
                                @foreach ($kategoriProduk as $k)
                                    <option value="{{ $k->id }}">{{ $k->kategori_produk }}</option>
                                @endforeach
                            </select>
                            @error('kategori_produk_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Harga Produk</label>
                        <div class="mb-6">
                            <input type="number" step="0.01" min="0" name="harga_produk"
                                onKeyPress="if(this.value.length==9) return false;"
                                class="@error('harga_produk') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror rounded-2xl bg-gray-50 border text-gray-900 focus:ring-green-600 focus:border-green-600 duration-300 block flex-1 min-w-0 w-full border-gray-300 p-2.5"
                                required placeholder="0000000">
                            @error('harga_produk')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Stok Produk</label>
                        <div class="mb-6">
                            <input type="number" min="0" name="stok_produk"
                                onKeyPress="if(this.value.length==9) return false;"
                                class="@error('stok_produk') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror rounded-2xl bg-gray-50 border text-gray-900 focus:ring-green-600 focus:border-green-600 duration-300 block flex-1 min-w-0 w-full border-gray-300 p-2.5"
                                required placeholder="Masukkan Stok Produk">
                            @error('stok_produk')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Gambar Produk</label>
                        <div class="mb-6">
                            <input
                                class="@error('gambar') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror block w-full rounded-2xl text-gray-900 border border-gray-300 cursor-pointer bg-gray-50"
                                aria-describedby="file_input_help" id="file_input" type="file" name="gambar"
                                required accept="image/png, image/jpeg">
                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG atau JPG.</p>
                            @error('gambar')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-green-500 hover:bg-green-800 duration-300 p-3 rounded-2xl text-gray-100 w-full">Tambah
                            Produk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
