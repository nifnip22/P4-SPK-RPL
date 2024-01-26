@extends('lib.layouts.main')

@section('main-content')
    <div class="grid grid-cols-3 gap-3">
        <div class="col-span-2">
            <div class="flex flex-col">
                <div class="rounded-tr-2xl bg-green-600 border-b-4 border-yellow-500 p-4">
                    <p class="text-gray-100 text-lg font-semibold">Data Petugas</p>
                </div>
                <div class="bg-slate-200 p-4">
                    <form action="{{ route('data-petugas.search') }}" method="POST" class="sticky top-16 z-30">
                        @csrf
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="search" name="name" required
                                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-b-2xl bg-gray-50 focus:ring-green-600 focus:border-green-600 duration-300"
                                placeholder="Cari Nama Petugas"
                                value="{{ old('name') ?? ($searchInput['name'] ?? '') }}">
                            <button type="submit"
                                class="text-white absolute end-2.5 bottom-2.5 bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 duration-300">Cari</button>
                        </div>
                    </form>
                    <div class="mt-4 bg-gray-100 w-full rounded-2xl p-4">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr class="text-center">
                                        <th scope="col" class="px-6 py-3">
                                            Username
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <i class="fa-solid fa-gear"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $u)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $u->name }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $u->email }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <form action="{{ route('data-petugas.destroy', ['petugas' => $u->id]) }}" method="POST" id="delete-form-{{ $u->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="delete-button bg-red-500 hover:bg-red-700 duration-300 rounded-2xl px-3 py-2 text-white" data-id="{{ $u->id }}"><i
                                                            class="fa fa-trash"></i> Hapus</button>
                                                </form>
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
                    <p class="text-gray-100 text-lg font-semibold">Register Petugas</p>
                </div>
                <div class="rounded-bl-2xl bg-slate-200 p-4">
                    <form action="{{ route('data-petugas.store') }}" method="POST">
                        @csrf
                        <label class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                        <div class="mb-6">
                            <input type="text" name="name" maxlength="255"
                                class="@error('name') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror rounded-2xl bg-gray-50 border text-gray-900 focus:ring-green-600 focus:border-green-600 duration-300 block flex-1 min-w-0 w-full border-gray-300 p-2.5"
                                required placeholder="Masukkan Username Petugas">
                            @error('name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <div class="mb-6">
                            <input type="email" name="email"
                                class="@error('email') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror rounded-2xl bg-gray-50 border text-gray-900 focus:ring-green-600 focus:border-green-600 duration-300 block flex-1 min-w-0 w-full border-gray-300 p-2.5"
                                required placeholder="Masukkan Email Petugas">
                            @error('email')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <div class="mb-6">
                            <input type="password" name="password" maxlength="30"
                                class="@error('password') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror rounded-2xl bg-gray-50 border text-gray-900 focus:ring-green-600 focus:border-green-600 duration-300 block flex-1 min-w-0 w-full border-gray-300 p-2.5"
                                required placeholder="Masukkan Password Petugas">
                            @error('password')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password</label>
                        <div class="mb-6">
                            <input type="password" name="password_confirmation" maxlength="30"
                                class="@error('password_confirmation') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror rounded-2xl bg-gray-50 border text-gray-900 focus:ring-green-600 focus:border-green-600 duration-300 block flex-1 min-w-0 w-full border-gray-300 p-2.5"
                                required placeholder="Konfirmasi Password Petugas">
                            @error('password_confirmation')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-6 hidden">
                            <input type="text" name="level"
                                class="rounded-2xl bg-gray-50 border text-gray-900 focus:ring-green-600 focus:border-green-600 duration-300 block flex-1 min-w-0 w-full border-gray-300 p-2.5"
                                required value="Petugas">
                        </div>
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-800 duration-300 p-3 rounded-2xl text-gray-100 w-full">Register Petugas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
