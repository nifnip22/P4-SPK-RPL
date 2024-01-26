<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>{{ $title }}</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('{{ asset('assets/png/bg1.png') }}');
        }
    </style>
</head>

<body class="bg-cover">
    <div class="px-8 sm:px-16 lg:px-44 py-16 md:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 place-content-around items-center">
            <div class="title">
                <a class="flex items-center space-x-3 rtl:space-x-reverse mb-12">
                    <div class="bg-white p-4 rounded-2xl flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="{{ asset('assets/png/shopping-cart.png') }}" class="h-8" />
                        <span class="self-center text-2xl text-green-600 font-semibold whitespace-nowrap">Pico<span
                                class="text-yellow-500">Pick</span></span>
                    </div>
                </a>
                <h1 class="text-3xl font-bold text-gray-100 mb-2">Daftarkan Diri Anda Sebagai <span
                        class="text-yellow-500">Member PicoPick</span></h1>
                <h1 class="text-xl font-semibold text-gray-100">Nikmati keuntungan <span
                        class="text-yellow-500">eksklusif</span> dan <span class="text-yellow-500">penawaran
                        istimewa!</span>
                    Daftarkan diri Anda sebagai Member PicoPick sekarang untuk mendapatkan akses ke <span
                        class="text-yellow-500">diskon eksklusif</span> dan
                    <span class="text-yellow-500">bonus belanja!</span>
                </h1>
            </div>
            <div class="bg-gray-100 p-4 rounded-2xl">
                <form action="{{ route('daftar-pelanggan.store') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900">Nama
                            Pelanggan <span class="text-red-500">*</span></label>
                        <input type="text" id="default-input" name="nama_pelanggan" maxlength="255"
                            class="@error('nama_pelanggan') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 outline-none block w-full p-2.5 duration-300"
                            placeholder="Ketikkan Nama Pelanggan" required>
                        @error('nama_pelanggan')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Alamat <span
                                class="text-red-500">*</span></label>
                        <textarea id="message" rows="4" name="alamat" required
                            class="@error('alamat') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-yellow-500 outline-none focus:border-yellow-500 duration-300"
                            placeholder="Ketikkan Alamat Pelanggan"></textarea>
                        @error('alamat')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-10">
                        <label for="phone-input" class="block mb-2 text-sm font-medium text-gray-900">No
                            Telepon <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18">
                                    <path
                                        d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z" />
                                </svg>
                            </div>
                            <input type="text" id="phone-input" aria-describedby="helper-text-explanation"
                                onkeypress='validate(event)' name="no_telp"
                                class="@error('no_telp') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 outline-none duration-300 block w-full ps-10 p-2.5"
                                maxlength="15" placeholder="0812345678901" required>
                            @error('no_telp')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-800 duration-300 p-4 w-full text-gray-100 text-center rounded-2xl">Daftar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
