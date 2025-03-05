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
        /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        ::after,
        ::before {
            --tw-content: ''
        }

        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: Figtree, sans-serif;
            font-feature-settings: normal
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b,
        strong {
            font-weight: bolder
        }

        code,
        kbd,
        pre,
        samp {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button,
        select {
            text-transform: none
        }

        [type=button],
        [type=reset],
        [type=submit],
        button {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote,
        dd,
        dl,
        figure,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        p,
        pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        menu,
        ol,
        ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        [role=button],
        button {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        audio,
        canvas,
        embed,
        iframe,
        img,
        object,
        svg,
        video {
            display: block;
            vertical-align: middle
        }

        img,
        video {
            max-width: 100%;
            height: auto
        }

        [hidden] {
            display: none
        }

        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        ::-webkit-backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        .relative {
            position: relative
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .mx-6 {
            margin-left: 1.5rem;
            margin-right: 1.5rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-16 {
            margin-top: 4rem
        }

        .mt-6 {
            margin-top: 1.5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .mr-1 {
            margin-right: 0.25rem
        }

        .flex {
            display: flex
        }

        .inline-flex {
            display: inline-flex
        }

        .grid {
            display: grid
        }

        .h-16 {
            height: 4rem
        }

        .h-7 {
            height: 1.75rem
        }

        .h-6 {
            height: 1.5rem
        }

        .h-5 {
            height: 1.25rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .w-auto {
            width: auto
        }

        .w-16 {
            width: 4rem
        }

        .w-7 {
            width: 1.75rem
        }

        .w-6 {
            width: 1.5rem
        }

        .w-5 {
            width: 1.25rem
        }

        .max-w-7xl {
            max-width: 80rem
        }

        .shrink-0 {
            flex-shrink: 0
        }

        .scale-100 {
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .gap-6 {
            gap: 1.5rem
        }

        .gap-4 {
            gap: 1rem
        }

        .self-center {
            align-self: center
        }

        .rounded-lg {
            border-radius: 0.5rem
        }

        .rounded-full {
            border-radius: 9999px
        }

        .bg-gray-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(243 244 246 / var(--tw-bg-opacity))
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity))
        }

        .bg-red-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 242 242 / var(--tw-bg-opacity))
        }

        .bg-dots-darker {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")
        }

        .from-gray-700\/50 {
            --tw-gradient-from: rgb(55 65 81 / 0.5);
            --tw-gradient-to: rgb(55 65 81 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .via-transparent {
            --tw-gradient-to: rgb(0 0 0 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), transparent, var(--tw-gradient-to)
        }

        .bg-center {
            background-position: center
        }

        .stroke-red-500 {
            stroke: #ef4444
        }

        .stroke-gray-400 {
            stroke: #9ca3af
        }

        .p-6 {
            padding: 1.5rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem
        }

        .font-semibold {
            font-weight: 600
        }

        .leading-relaxed {
            line-height: 1.625
        }

        .text-gray-600 {
            --tw-text-opacity: 1;
            color: rgb(75 85 99 / var(--tw-text-opacity))
        }

        .text-gray-900 {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity))
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        .underline {
            -webkit-text-decoration-line: underline;
            text-decoration-line: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .shadow-2xl {
            --tw-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            --tw-shadow-colored: 0 25px 50px -12px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .shadow-gray-500\/20 {
            --tw-shadow-color: rgb(107 114 128 / 0.2);
            --tw-shadow: var(--tw-shadow-colored)
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .selection\:bg-red-500 *::selection {
            --tw-bg-opacity: 1;
            background-color: rgb(239 68 68 / var(--tw-bg-opacity))
        }

        .selection\:text-white *::selection {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .selection\:bg-red-500::selection {
            --tw-bg-opacity: 1;
            background-color: rgb(239 68 68 / var(--tw-bg-opacity))
        }

        .selection\:text-white::selection {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .hover\:text-gray-900:hover {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity))
        }

        .hover\:text-gray-700:hover {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity))
        }

        .focus\:rounded-sm:focus {
            border-radius: 0.125rem
        }

        .focus\:outline:focus {
            outline-style: solid
        }

        .focus\:outline-2:focus {
            outline-width: 2px
        }

        .focus\:outline-red-500:focus {
            outline-color: #ef4444
        }

        .group:hover .group-hover\:stroke-gray-600 {
            stroke: #4b5563
        }

        @media (prefers-reduced-motion: no-preference) {
            .motion-safe\:hover\:scale-\[1\.01\]:hover {
                --tw-scale-x: 1.01;
                --tw-scale-y: 1.01;
                transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
            }
        }

        @media (prefers-color-scheme: dark) {
            .dark\:bg-gray-900 {
                --tw-bg-opacity: 1;
                background-color: rgb(17 24 39 / var(--tw-bg-opacity))
            }

            .dark\:bg-gray-800\/50 {
                background-color: rgb(31 41 55 / 0.5)
            }

            .dark\:bg-red-800\/20 {
                background-color: rgb(153 27 27 / 0.2)
            }

            .dark\:bg-dots-lighter {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E")
            }

            .dark\:bg-gradient-to-bl {
                background-image: linear-gradient(to bottom left, var(--tw-gradient-stops))
            }

            .dark\:stroke-gray-600 {
                stroke: #4b5563
            }

            .dark\:text-gray-400 {
                --tw-text-opacity: 1;
                color: rgb(156 163 175 / var(--tw-text-opacity))
            }

            .dark\:text-white {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity))
            }

            .dark\:shadow-none {
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;
                box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
            }

            .dark\:ring-1 {
                --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
                --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
                box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
            }

            .dark\:ring-inset {
                --tw-ring-inset: inset
            }

            .dark\:ring-white\/5 {
                --tw-ring-color: rgb(255 255 255 / 0.05)
            }

            .dark\:hover\:text-white:hover {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity))
            }

            .group:hover .dark\:group-hover\:stroke-gray-400 {
                stroke: #9ca3af
            }
        }

        @media (min-width: 640px) {
            .sm\:fixed {
                position: fixed
            }

            .sm\:top-0 {
                top: 0px
            }

            .sm\:right-0 {
                right: 0px
            }

            .sm\:ml-0 {
                margin-left: 0px
            }

            .sm\:flex {
                display: flex
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-center {
                justify-content: center
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width: 1024px) {
            .lg\:gap-8 {
                gap: 2rem
            }

            .lg\:p-8 {
                padding: 2rem
            }
        }
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

        <div class="relative isolate px-6 lg:px-8">
            {{-- DESIGN BG --}}
            <main>
                <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                    aria-hidden="true">
                    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                        style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                    </div>
                </div>
                <div class="mx-auto max-w-2xl sm:py-3 lg:py-9">
                    <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                    </div>
                </div>
                <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                </div>
            </main>

            {{-- FORM STARTS HERE --}}
            <main class="px-5 py-8 bg-gray-50 bg-opacity-50 rounded-xl">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <form action="{{ route('pendaftaran.store') }}" method="POST" class="mt-8">
                        @csrf
                        {{-- IMPORTANT FORM --}}
                        <div class="space-y-12">

                            <!-- Bagian Akun Penghuni -->
                            <div class="border-b border-gray-900/10 pb-12">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Akun Penghuni*</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Informasi akun yang digunakan untuk login dan verifikasi penghuni.</p>

                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    {{-- NO TELP --}}
                                    <div class="sm:col-span-4">
                                        <label for="telpon" class="block text-sm font-medium leading-6 text-gray-900">Nomor
                                            Telepon</label>
                                        <div class="mt-2">
                                            <input required type="text" name="telpon" id="telpon"
                                                class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                        @if ($errors->has('users'))
                                            <div class="alert alert-danger mt-3">
                                                {{ $errors->first('users') }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- SANDI --}}
                                    <div class="sm:col-span-4">
                                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Kata
                                            Sandi</label>
                                        <div class="mt-2">
                                            <input required type="password" name="password" id="password"
                                                class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    {{-- KONFIRMASI KATA SANDI --}}
                                    <div class="sm:col-span-4">
                                        <label for="confirm" class="block text-sm font-medium leading-6 text-gray-900">
                                            Konfirmasi Sandi</label>
                                        <div class="mt-2">
                                            <input required type="password" name="confirm" id="confirm"
                                                class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian Kontrak -->
                            <div class="border-b border-gray-900/10 pb-12">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Informasi Kontrak*</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Data informasi kontrak yang dibuat dengan penghuni kos.</p>

                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                    {{-- nama lengkap --}}
                                    <div class="sm:col-span-4">
                                        <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama
                                            Lengkap</label>
                                        <div class="mt-2">
                                            <input required type="text" name="nama" id="nama"
                                                class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    {{-- email --}}
                                    <div class="sm:col-span-4">
                                        <label for="email"
                                            class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                        <div class="mt-2">
                                            <input required id="email" name="email" type="text"
                                                class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    {{-- bank --}}
                                    <div class="sm:col-span-2 sm:col-start-1">
                                        <label for="bank" class="block text-sm font-medium leading-6 text-gray-900">Bank
                                            Utama</label>
                                        <div class="mt-2">
                                            <select id="bank" name="bank" required
                                                class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                <option value="BCA">BCA (BANK CENTRAL ASIA)</option>
                                                <option value="BRI">BRI (BANK RAKYAT INDONESIA)</option>
                                                <option value="Mandiri">Bank Mandiri</option>
                                                <option value="BNI">BNI (BANK NEGARA INDONESIA)</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- rekening --}}
                                    <div class="sm:col-span-2">
                                        <label for="rekening" class="block text-sm font-medium leading-6 text-gray-900">Nomor
                                            Rekening</label>
                                        <div class="mt-2">
                                            <input required id="rekening" name="rekening" type="text"
                                                class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    {{-- kamar --}}
                                    <div class="sm:col-span-2 sm:col-start-1">
                                        <label for="kamar" class="block font-medium mb-2">Kamar:</label>
                                        <select required id="kamar" name="kamar"
                                            class="tex border border-gray-300 rounded-lg py-2 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                            @if ($listKamar && $listKamar->isNotEmpty())
                                                @foreach ($listKamar as $kamarId)
                                                    <option value="{{ $kamarId->idKamar }}" 
                                                        data-harga="{{ $kamarId->harga }}" 
                                                        data-mingguan="{{ $kamarId->harga_mingguan }}" 
                                                        data-harian="{{ $kamarId->harga_harian }}">
                                                        Kamar {{ $kamarId->idKamar }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="" disabled>Tidak ada kamar tersedia</option>
                                            @endif
                                        </select>

                                        <!-- Input hidden untuk harga -->
                                        <input type="hidden" id="harga" name="harga" value="">

                                        {{-- UPDATE HARGA KANAR --}}
                                        <script>
                                            document.addEventListener('DOMContentLoaded', () => {
                                                const kamarDropdown = document.getElementById('kamar'); // Dropdown kamar
                                                const kontrakDropdown = document.getElementById('kontrak'); // Dropdown kontrak
                                                const hargaInput = document.getElementById('harga'); // Input hidden harga

                                                const updateHarga = () => {
                                                    const selectedKamar = kamarDropdown.options[kamarDropdown.selectedIndex]; // Opsi kamar terpilih
                                                    const kontrakType = kontrakDropdown.value; // Tipe kontrak (Bulan, Mingguan, Harian)

                                                    // Ambil harga berdasarkan tipe kontrak
                                                    let harga = parseFloat(selectedKamar.getAttribute('data-harga')) || 0;
                                                    if (kontrakType === 'Mingguan') {
                                                        harga = parseFloat(selectedKamar.getAttribute('data-mingguan')) || 0;
                                                    } else if (kontrakType === 'Harian') {
                                                        harga = parseFloat(selectedKamar.getAttribute('data-harian')) || 0;
                                                    }

                                                    // Masukkan nilai harga ke input hidden
                                                    hargaInput.value = Math.max(harga, 0); // Pastikan nilai terisi atau kosong jika tidak ada data
                                                };

                                                // Event listener untuk perubahan pada dropdown kamar dan kontrak
                                                kamarDropdown.addEventListener('change', updateHarga);
                                                kontrakDropdown.addEventListener('change', updateHarga);

                                                // Jalankan saat halaman dimuat untuk inisialisasi nilai harga
                                                updateHarga();
                                            });
                                        </script>

                                        {{-- UPDATE RENTANG --}}
                                        <script>
                                            document.getElementById('kamar').addEventListener('change', function() {
                                                var selectedOption = this.options[this.selectedIndex];
                                                var hargaMingguan = selectedOption.getAttribute('data-mingguan');
                                                var hargaHarian = selectedOption.getAttribute('data-harian');
                                                var kontrakDropdown = document.getElementById('kontrak');
                                        
                                                // Reset dropdown kontrak
                                                kontrakDropdown.innerHTML = `
                                                    <option value="Bulan">Bulan</option>
                                                    <option value="Mingguan">Mingguan</option>
                                                    <option value="Harian">Harian</option>
                                                `;
                                        
                                                // Hilangkan opsi "Mingguan" jika harga_mingguan null
                                                if (hargaMingguan === null || hargaMingguan === '') {
                                                    var mingguanOption = kontrakDropdown.querySelector('option[value="Mingguan"]');
                                                    if (mingguanOption) {
                                                        mingguanOption.remove();
                                                    }
                                                }
                                        
                                                // Hilangkan opsi "Harian" jika harga_harian null
                                                if (hargaHarian === null || hargaHarian === '') {
                                                    var harianOption = kontrakDropdown.querySelector('option[value="Harian"]');
                                                    if (harianOption) {
                                                        harianOption.remove();
                                                    }
                                                }
                                            });
                                        </script>

                                    </div>

                                    {{-- tgl masuk --}}
                                    <div class="sm:col-span-2">
                                        <label for="masuk"
                                            class="block text-sm font-medium leading-6 text-gray-900">Tanggal Masuk</label>
                                        <div class="mt-2">
                                            <input required type="date" name="masuk" id="masuk"
                                                class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                const today = new Date().toISOString().split("T")[0]; // Format YYYY-MM-DD
                                                document.getElementById("masuk").setAttribute("min", today);
                                            });
                                        </script>
                                        
                                    </div>

                                    {{-- rentang kontrak --}}
                                    <div class="sm:col-span-2 sm:col-start-1">
                                        <label for="kontrak"
                                            class="block text-sm font-medium leading-6 text-gray-900">Rentang Kontrak</label>
                                        <div class="mt-2">
                                            <select required name="kontrak" id="kontrak"
                                                class="text-center block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                <option>Bulan</option>
                                                <option>Mingguan</option>
                                                <option>Harian</option>
                                            </select>
                                        </div>

                                    </div>
                                    
                                    {{-- waktu tinggalnya --}}
                                    <div id="waktu-container" class="sm:col-span-2">
                                        <label for="waktu" class="block text-sm font-medium leading-6 text-gray-900">Waktu Tinggal</label>
                                        <div class="mt-2">
                                            <input required id="waktu" name="waktu" type="number" value="1"
                                                class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    {{-- nominal deposit --}}
                                    <div class="sm:col-span-1 sm:col-start-1">
                                        <label for="deposit"
                                            class="block text-sm font-medium leading-6 text-gray-900">Nominal Deposit</label>
                                        <div class="mt-2">
                                            <input id="deposit" name="deposit" type="number" value="{{ $default->nominal_deposit ?? 0 }}" disabled
                                                class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    {{-- total pembayaran --}}
                                    <div class="sm:col-span-3">
                                        <label for="pembayaran"
                                            class="block text-sm font-medium leading-6 text-gray-900">Total Nominal Pembayaran Perdana</label>
                                        <div class="mt-2">
                                            <input disabled id="pembayaran" value="" name="pembayaran" type="number"
                                                class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Bagian data diri penghuni --}}
                            @if (!empty($dataDiriList))
                                <div class="border-b border-gray-900/10 pb-12">
                                    <h2 class="text-base font-semibold leading-7 text-gray-900">Data Diri Penghuni*</h2>
                                    <p class="mt-1 text-sm leading-6 text-gray-600">Data Diri Penghuni yang tinggal</p>

                                    <div class="mt-10 mb-3 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        {{-- data diri --}}
                                        @foreach ($dataDiriList as $data)
                                            <div class="sm:col-span-4 sm:col-start-1">
                                                <label for="deskripsi_{{ $data->idListDataDiri }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">{{ $data->data_diri }}</label>
                                                <div class="mt-2 flex">
                                                    <input required type="text" name="deskripsi[]"
                                                        id="deskripsi_{{ $data->idListDataDiri }}"
                                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    <input required type="hidden" name="idListDataDiri[]"
                                                        value="{{ $data->idListDataDiri }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <input type="hidden" name="deposit" value="{{ $default->nominal_deposit ?? 0 }}">
                            <input type="hidden" name="pertanggal_tagihan" value="{{ $default->pertanggal_tagihan_bulan ?? 1 }}">
                            <input type="hidden" name="pertanggal_denda" value="{{ $default->pertanggal_denda_bulan ?? 1 }}">

                            {{-- Bagian Submit --}}
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                                <button type="submit" data-toggle="modal" data-target="#ModalSuksesBuat"
                                    class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                            </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

{{-- HARGA --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const kontrakDropdown = document.getElementById('kontrak');
        const kamarDropdown = document.getElementById('kamar');
        const waktuInput = document.getElementById('waktu');
        const depositInput = document.getElementById('deposit');
        const pembayaranInput = document.getElementById('pembayaran');

        const updateHarga = () => {
            const selectedKamar = kamarDropdown.options[kamarDropdown.selectedIndex];
            const selectedKontrak = kontrakDropdown.value;

            // Ambil nilai harga dari atribut data
            const hargaBulan = parseFloat(selectedKamar.getAttribute('data-harga')) || 0;
            const hargaMingguan = parseFloat(selectedKamar.getAttribute('data-mingguan')) || 0;
            const hargaHarian = parseFloat(selectedKamar.getAttribute('data-harian')) || 0;

            // Tentukan harga sesuai pilihan kontrak
            let harga;
            if (selectedKontrak === 'Mingguan') {
                harga = hargaMingguan;
            } else if (selectedKontrak === 'Harian') {
                harga = hargaHarian;
            } else {
                harga = hargaBulan;
            }

            // Ambil nilai waktu dan deposit
            const waktu = Math.max(parseFloat(waktuInput.value) || 1, 1); // Default waktu 1 jika kosong
            const deposit = Math.max(parseFloat(depositInput.value) || 0, 0);

            // Hitung total harga
            const totalHarga = (harga * waktu) + deposit;

            // Perbarui input pembayaran
            pembayaranInput.value = totalHarga;
        };

        // Event listener untuk dropdown kontrak, kamar, waktu, dan deposit
        kontrakDropdown.addEventListener('change', updateHarga);
        kamarDropdown.addEventListener('change', updateHarga);
        waktuInput.addEventListener('input', updateHarga);
        depositInput.addEventListener('input', updateHarga);

        // Perbarui harga saat halaman dimuat
        updateHarga();
    });
</script>

{{-- SET TELP + REKENING TIDAK BOLEH NOMOR --}}
<script>
    function allowOnlyNumbers(event) {
        const input = event.target;
        const value = input.value;

        // Replace non-numeric characters
        input.value = value.replace(/[^0-9]/g, '');
    }

    const rekeningInput = document.getElementById('rekening');
    const telponInput = document.getElementById('telpon');

    // Attach the event listener
    rekeningInput.addEventListener('input', allowOnlyNumbers);
    telponInput.addEventListener('input', allowOnlyNumbers);
</script>
