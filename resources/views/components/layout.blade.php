<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- PANGGIL TAILWIND + FONT INTER --}}
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    {{-- ALPHINE UNTUK JS INTERACTIVE --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> 
    {{-- BOOTSTRAP + JQUERY UNTUK MODAL --}}
    <!-- Bootstrap CSS --> 
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="img/x-icon" href="img/logo.png">
    <title>
        @if(tenancy()->initialized)
        {{-- Navbar untuk tenant --}}
            {{ tenancy()->tenant->id }} | SuperKos
        @else
        {{-- Navbar untuk central --}}
            Admin SuperKos
        @endif
    </title>
</head>
<body class="h-full bg-gray-100">

    <div class="min-h-full">
        {{-- NAVBAR + HEADER -> COMPONENETS --}}
        @if(tenancy()->initialized)
            {{-- Navbar untuk tenant --}}
            @include('Pengelola.components.nav-bar')
        @else
            {{-- Navbar untuk central --}}
            @include('components.nav-bar')
        @endif
        
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-xl font-bold tracking-tight text-gray-900">
                    @if(tenancy()->initialized)
                    {{-- Navbar untuk tenant --}}
                        {{ tenancy()->tenant->id }}
                    @else
                    {{-- Navbar untuk central --}}
                        Admin SuperKos
                    @endif
                </h1>
            </div>
        </header>

        {{-- CONTENT --}}
        <main>
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>  

</body>
</html>
