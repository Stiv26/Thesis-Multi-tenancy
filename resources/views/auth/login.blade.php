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
    <title>SuperKos</title>
</head>

<body class="h-full bg-gray-100">

    <div class="min-h-full">

        <header>
            <nav class="flex items-center justify-center p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="/" class="text-sm font-semibold leading-6 text-gray-900"><span aria-hidden="true">&larr;</span> Kembali</a>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <p class="text-xl font-semibold leading-6 text-gray-900">SuperKos</p>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <div class="flex-shrink-0">
                        <img class="h-12 w-12" src="img/logo-black.png" alt="Your Company">
                    </div>
                </div>
            </nav>
        </header>

        {{-- CONTENT --}}
        <main>
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                        <img class="mx-auto h-20 w-auto"
                            src="img/logo-black.png"
                            alt="Your Company">
                        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Login Akun</h2>
                    </div>

                    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                        <form class="space-y-6" action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div>
                                <label for="no_telp" class="block text-sm/6 font-medium text-gray-900">Nomor
                                    Ponsel</label>
                                <div class="mt-2">
                                    <input id="no_telp" name="no_telp" type="text" required
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="password"
                                        class="block text-sm/6 font-medium text-gray-900">Password</label>
                                    <div class="text-sm">
                                        <a href="/lupa-password"
                                            class="font-semibold text-indigo-600 hover:text-indigo-500">Lupa
                                            password?</a>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input id="password" name="password" type="password"
                                        autocomplete="current-password" required
                                        class="block w-full rounded-md border-0 py-1.5  px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Masuk</button>
                            </div>
                            @error('no_telp')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                </div>




            </div>
        </main>
    </div>

</body>

</html>
