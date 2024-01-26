<!DOCTYPE html>
<html lang="en">

<head>
    @include('lib.partials.head')
</head>
<body>
    <header>
        @include('lib.partials.navbar')
    </header>

    <main>
        <div class="mt-16 max-w-screen-2xl">
            @yield('main-content')
        </div>
    </main>
</body>

@include('lib.partials.components')

</html>
