<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SuperKos</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Figtree, sans-serif;font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::-webkit-backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.relative{position:relative}.mx-auto{margin-left:auto;margin-right:auto}.mx-6{margin-left:1.5rem;margin-right:1.5rem}.ml-4{margin-left:1rem}.mt-16{margin-top:4rem}.mt-6{margin-top:1.5rem}.mt-4{margin-top:1rem}.-mt-px{margin-top:-1px}.mr-1{margin-right:0.25rem}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.h-16{height:4rem}.h-7{height:1.75rem}.h-6{height:1.5rem}.h-5{height:1.25rem}.min-h-screen{min-height:100vh}.w-auto{width:auto}.w-16{width:4rem}.w-7{width:1.75rem}.w-6{width:1.5rem}.w-5{width:1.25rem}.max-w-7xl{max-width:80rem}.shrink-0{flex-shrink:0}.scale-100{--tw-scale-x:1;--tw-scale-y:1;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.items-center{align-items:center}.justify-center{justify-content:center}.gap-6{gap:1.5rem}.gap-4{gap:1rem}.self-center{align-self:center}.rounded-lg{border-radius:0.5rem}.rounded-full{border-radius:9999px}.bg-gray-100{--tw-bg-opacity:1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-red-50{--tw-bg-opacity:1;background-color:rgb(254 242 242 / var(--tw-bg-opacity))}.bg-dots-darker{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")}.from-gray-700\/50{--tw-gradient-from:rgb(55 65 81 / 0.5);--tw-gradient-to:rgb(55 65 81 / 0);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.via-transparent{--tw-gradient-to:rgb(0 0 0 / 0);--tw-gradient-stops:var(--tw-gradient-from), transparent, var(--tw-gradient-to)}.bg-center{background-position:center}.stroke-red-500{stroke:#ef4444}.stroke-gray-400{stroke:#9ca3af}.p-6{padding:1.5rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.text-center{text-align:center}.text-right{text-align:right}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.font-semibold{font-weight:600}.leading-relaxed{line-height:1.625}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity))}.underline{-webkit-text-decoration-line:underline;text-decoration-line:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-gray-500\/20{--tw-shadow-color:rgb(107 114 128 / 0.2);--tw-shadow:var(--tw-shadow-colored)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.selection\:bg-red-500 *::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white *::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.selection\:bg-red-500::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.hover\:text-gray-900:hover{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.hover\:text-gray-700:hover{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity))}.focus\:rounded-sm:focus{border-radius:0.125rem}.focus\:outline:focus{outline-style:solid}.focus\:outline-2:focus{outline-width:2px}.focus\:outline-red-500:focus{outline-color:#ef4444}.group:hover .group-hover\:stroke-gray-600{stroke:#4b5563}@media (prefers-reduced-motion: no-preference){.motion-safe\:hover\:scale-\[1\.01\]:hover{--tw-scale-x:1.01;--tw-scale-y:1.01;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}}@media (prefers-color-scheme: dark){.dark\:bg-gray-900{--tw-bg-opacity:1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:bg-gray-800\/50{background-color:rgb(31 41 55 / 0.5)}.dark\:bg-red-800\/20{background-color:rgb(153 27 27 / 0.2)}.dark\:bg-dots-lighter{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E")}.dark\:bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.dark\:stroke-gray-600{stroke:#4b5563}.dark\:text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:shadow-none{--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.dark\:ring-1{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)}.dark\:ring-inset{--tw-ring-inset:inset}.dark\:ring-white\/5{--tw-ring-color:rgb(255 255 255 / 0.05)}.dark\:hover\:text-white:hover{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.group:hover .dark\:group-hover\:stroke-gray-400{stroke:#9ca3af}}@media (min-width: 640px){.sm\:fixed{position:fixed}.sm\:top-0{top:0px}.sm\:right-0{right:0px}.sm\:ml-0{margin-left:0px}.sm\:flex{display:flex}.sm\:items-center{align-items:center}.sm\:justify-center{justify-content:center}.sm\:justify-between{justify-content:space-between}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width: 768px){.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}}@media (min-width: 1024px){.lg\:gap-8{gap:2rem}.lg\:p-8{padding:2rem}}
        </style>

        {{-- PANGGIL TAILWIND + FONT INTER --}}
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        <link rel="icon" type="img/x-icon" href="img/logo.png">
        {{-- ALPHINE UNTUK JS INTERACTIVE --}}
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> 
        <!-- Bootstrap CSS --> 
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    </head>
    <body class="antialiased">
        <div class="bg-white">
            <header class="absolute inset-x-0 top-0 z-50">
              <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <div class="flex-shrink-0">
                        <img class="h-12 w-12" src="img/logo-black.png" alt="Your Company">
                    </div>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <p class="text-xl font-semibold leading-6 text-gray-900">SuperKos</p>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                  <a href="/login" class="text-sm font-semibold leading-6 text-gray-900">Masuk <span aria-hidden="true">&rarr;</span></a>
                </div>
              </nav> 
            </header>
          
            <div class="relative isolate px-6 lg:px-8">
                <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                </div>
                <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                    <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                </div>
                <div class="text-center">
                    <h1 class="text-balance text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Temukan Kos Sesuai Kebutuhan Anda</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">Nikmati hunian dengan akses yang mudah. Dapatkan kenyamanan tinggal dengan sistem pembayaran yang fleksibel serta layanan kos yang responsif untuk pengalaman yang lebih tenang dan menyenangkan.</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="#lihat-kamar" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Lihat Kamar</a>
                    <a href="/login" class="text-sm font-semibold leading-6 text-gray-900">Masuk <span aria-hidden="true">→</span></a>
                    </div>
                </div>
                </div>
                <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
                    <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                </div>

                {{-- list kamar --}}
                <div class="px-6 sm:py-32 lg:px-8" id="lihat-kamar">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Daftar Kamar Tersedia</h2>
                        <p class="mt-2 text-lg leading-8 text-gray-600">Pilih kamar yang sesuai dengan kebutuhan Anda</p>
                    </div>
                    
                    <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                        @if($listKamar->isNotEmpty())
                            @foreach($listKamar as $kamar)
                                <div class="flex flex-col items-start justify-between shadow-lg rounded-lg p-6">
                                    {{-- Tampilkan data kamar --}}
                                    <a data-id="{{ $kamar->idKamar }}" data-toggle="modal" data-target="#ModalKamar" class="lihat-detail-kamar w-full h-48 mb-4 overflow-hidden rounded-lg">
                                        @if($kamar->foto)
                                            <img src="{{ route('foto.file', ['filename' => $kamar->foto]) }}" 
                                                 alt="Foto Kamar"
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                Tidak ada foto
                                            </div>
                                        @endif
                                    </a>

                                    <h3 class="text-lg font-semibold">Kamar {{ $kamar->idKamar }}</h3>

                                    <p class="text-gray-600">Harga: Rp {{ number_format($kamar->harga, 0, ',', '.') }}/bulan</p>
                                    <div>
                                        <button data-id="{{ $kamar->idKamar }}" data-toggle="modal" data-target="#ModalKamar" class="lihat-detail-kamar mr-1 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Lihat Detail</button>
                                        <a href="{{ route('pengelola.pendaftaran') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Pesan</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-3 text-center py-8">
                                <p class="text-gray-500">Tidak ada kamar tersedia saat ini</p>
                            </div>
                        @endif 
                    </div>
                </div>
                
            </div>
        </div>
          
    </body>
</html>

<!-- MODAL DATA -->
<div class="modal fade p-4" id="ModalKamar" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog max-w-4xl mx-auto mt-24">
        <div class="modal-content rounded-lg shadow-lg bg-white">
            {{-- Header --}}
            <div class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-center">
                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Kamar</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600"
                    data-dismiss="modal" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Content --}}
            <div class="modal-body p-6 space-y-4">
                <!-- Gambar Kamar -->
                <div class="w-full h-64 overflow-hidden rounded-lg">
                    <img src="" id="modal-foto" alt="Foto Kamar" 
                        class="w-full h-full object-cover border border-gray-300 rounded-lg">
                </div>

                <!-- Nama Kamar -->
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Kamar <span id="modal-kamar" class="text-indigo-600"></span>
                    </h3>
                </div>

                <!-- Daftar Fasilitas -->
                <div id="daftar-fasilitas" class="space-y-2 hidden">
                    <label class="block text-md font-medium text-gray-700">Fasilitas Kamar:</label>
                    <div class="grid grid-cols-2 gap-2 text-center" id="fasilitas-list"></div>
                </div>

                <!-- Toggle Harga -->
                <div class="flex justify-center">
                    <button id="toggle-harga" class="text-indigo-600 font-medium hover:text-indigo-500 focus:outline-none">
                        Lihat Harga &#9662; <!-- Tanda panah ke bawah -->
                    </button>
                </div>

                <!-- Daftar Harga -->
                <div id="daftar-harga" class="space-y-2 hidden">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Harga Bulanan:</span>
                        <span id="modal-harga" class="text-gray-700"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Harga Mingguan:</span>
                        <span id="modal-harga_mingguan" class="text-gray-700"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Harga Harian:</span>
                        <span id="modal-harga_harian" class="text-gray-700"></span>
                    </div>
                </div>

                <!-- Keterangan Kamar -->
                <div class="space-y-2 mt-4">
                    <hr>
                    <label class="block text-md font-medium text-gray-700">Keterangan:</label>
                    <textarea id="modal-keterangan" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0 resize-none" readonly></textarea>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-t border-gray-200 py-4 flex justify-end ">
                <a href="{{ route('pengelola.pendaftaran') }}"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    Pesan Kamar
                </a>
                <button type="button"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                    data-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

{{-- AJAX DETAIL --}}
<script>
    $(document).ready(function(){
        $('#toggle-harga').on('click', function() {
            $('#daftar-harga').toggleClass('hidden'); // Show/hide daftar harga
            
            // Ubah ikon panah sesuai kondisi (naik/turun)
            if ($('#daftar-harga').hasClass('hidden')) {
                $(this).html('Lihat Harga &#9662;'); // Panah ke bawah
            } else {
                $(this).html('Lihat Harga &#9652;'); // Panah ke atas
            }
        });

        $('.lihat-detail-kamar').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); 

            $.ajax({
                url: '/lihat/detail-kamar/' + id,
                type: 'GET',
                success: function(data) {
                    // Perbarui gambar
                    $('#modal-foto').attr('src', data.gambar_url); 
                    $('#modal-kamar').text(data.data.idKamar); 

                    // Tampilkan data ke dalam label
                    $('#modal-harga').text('Rp. ' + (data.data.harga || 0).toLocaleString('id-ID'));

                    // Harga Mingguan
                    if (data.data.harga_mingguan !== null) {
                        $('#modal-harga_mingguan').text('Rp. ' + data.data.harga_mingguan.toLocaleString('id-ID')).parent().show();
                    } else {
                        $('#modal-harga_mingguan').parent().hide();
                    }

                    // Harga Harian
                    if (data.data.harga_harian !== null) {
                        $('#modal-harga_harian').text('Rp. ' + data.data.harga_harian.toLocaleString('id-ID')).parent().show();
                    } else {
                        $('#modal-harga_harian').parent().hide();
                    }

                    $('#modal-keterangan').text(data.data.keterangan || 'Tidak ada keterangan.');  
                    
                    // Tampilkan fasilitas kamar
                    var fasilitasContainer = $('#daftar-fasilitas');
                    var fasilitasList = $('#fasilitas-list');
                    fasilitasList.empty(); // Kosongkan konten sebelumnya

                    if (data.fasilitas && data.fasilitas.length > 0) {
                        data.fasilitas.forEach(function(fasilitas) {
                            fasilitasList.append(
                                '<div class="text-gray-700 bg-gray-100 px-3 py-2 rounded-md">' + fasilitas.fasilitas + '</div>'
                            );
                        });
                        fasilitasContainer.removeClass('hidden'); // Tampilkan container
                    } else {
                        fasilitasList.append(
                            '<div class="text-gray-500">Pengelola belum menambahkan fasilitas kamar.</div>'
                        );
                        fasilitasContainer.removeClass('hidden');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
    });
</script>

