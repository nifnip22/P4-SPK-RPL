{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h1 class="text-2xl font-bold text-center mb-4">Login Form</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Login | PicoPick</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('{{ asset('assets/png/bg1.png') }}');
        }
    </style>
</head>

<body class="bg-cover">
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="px-8 sm:px-16 lg:px-44 py-6 md:py-16">
        <div class="grid grid-cols-1 gap-y-10 items-center">
            <div class="title">
                <a class="flex items-center justify-center space-x-3 rtl:space-x-reverse mb-12">
                    <div class="bg-white p-4 rounded-2xl flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="{{ asset('assets/png/shopping-cart.png') }}" class="h-8" />
                        <span class="self-center text-2xl text-green-600 font-semibold whitespace-nowrap">Pico<span
                                class="text-yellow-500">Pick</span> <span class="text-gray-900">| Login Page</span></span>
                    </div>
                </a>
            </div>
            <div class="bg-gray-100 p-4 rounded-2xl">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" id="default-input" name="email"
                            class="@error('email') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 outline-none block w-full p-2.5 duration-300"
                            placeholder="Masukkan Email" required>
                        @error('email')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <input type="password" id="default-input" name="password"
                            class="@error('password') invalid:border-red-500 invalid:text-red-600 focus:invalid:border-red-500 focus:invalid:ring-red-500 @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 outline-none block w-full p-2.5 duration-300"
                            placeholder="Masukkan Password" required>
                        @error('password')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-800 duration-300 p-4 w-full text-gray-100 text-center rounded-2xl">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
