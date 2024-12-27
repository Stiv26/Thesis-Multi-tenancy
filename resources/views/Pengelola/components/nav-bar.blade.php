        {{-- Check database untuk navbar --}}
        @php
            $hasKaryawanTable = \Illuminate\Support\Facades\Schema::hasTable('tugas');
            $hasPemeliharaanTable = \Illuminate\Support\Facades\Schema::hasTable('pemeliharaan');
            $hasLayananTambahanTable = \Illuminate\Support\Facades\Schema::hasTable('layanantambahan');
        @endphp
        {{-- NAVBAR --}}
        <nav class="bg-gray-800" x-data="{ isOpen: false }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if (Auth::check() && Auth::user()->idRole == 1)
                                <img class="h-12 w-12" src="img/logo.png" alt="Your Company">
                            @endif
                            @if (Auth::check() && Auth::user()->idRole == 2 || Auth::user()->idRole == 3)
                                <img class="h-12 w-12" src="../img/logo.png" alt="Your Company">
                            @endif
                        </div>
                        <div class="hidden md:block">
                            {{-- Mengirim data ke nav-link + request untuk mengcheck apakah sedang pada halaman --}}
                            <div class="ml-10 flex items-baseline space-x-4">
                                {{-- AKSES PENGELOLA --}}
                                @if (Auth::check() && Auth::user()->idRole == 1)
                                    <x-nav-link href="/kos" :active="request()->is('kos')">Kos Anda</x-nav-link>
                                    <x-nav-link href="/penghuni" :active="request()->is('penghuni')">Penghuni</x-nav-link>
                                    <x-nav-link href="/pembayaran" :active="request()->is('pembayaran')">Pembayaran</x-nav-link>
                                    <x-nav-link href="/pesan" :active="request()->is('pesan')">Pesan</x-nav-link>

                                    @if ($hasKaryawanTable)
                                        <x-nav-link href="/karyawan" :active="request()->is('karyawan')">Karyawan</x-nav-link>
                                    @endif

                                    @if ($hasPemeliharaanTable)
                                        <x-nav-link href="/pemeliharaan" :active="request()->is('pemeliharaan')">Pemeliharaan</x-nav-link>
                                    @endif

                                    @if ($hasLayananTambahanTable)
                                        <x-nav-link href="/layanan-tambahan" :active="request()->is('layanan-tambahan')">Layanan Tambahan</x-nav-link>
                                    @endif
                                @endif

                                {{-- AKSES PENGHUNI --}}
                                @if (Auth::check() && Auth::user()->idRole == 2)
                                    <x-nav-link href="/info/kamar" :active="request()->is('info/kamar')">Kamar</x-nav-link>
                                    <x-nav-link href="/info/tagihan" :active="request()->is('info/tagihan')">Tagihan</x-nav-link>
                                    <x-nav-link href="/info/pelaporan" :active="request()->is('info/pelaporan')">Pelaporan</x-nav-link>

                                    @if ($hasPemeliharaanTable)
                                        <x-nav-link href="/info/perbaikan" :active="request()->is('info/perbaikan')">Perbaikan Fasilitas</x-nav-link>
                                    @endif

                                    @if ($hasLayananTambahanTable)
                                        <x-nav-link href="/info/pembelian-layanan" :active="request()->is('info/pembelian-layanan')">Pembelian Layanan</x-nav-link>
                                    @endif
                                @endif

                                {{-- AKSES ART --}}
                                @if (Auth::check() && Auth::user()->idRole == 3)
                                    <x-nav-link href="/akses/kamar" :active="request()->is('akses/kamar')">Kamar Penghuni</x-nav-link>
                                    <x-nav-link href="/akses/laporan" :active="request()->is('akses/laporan')">Laporan Tugas</x-nav-link>
                                    <x-nav-link href="/akses/pesan" :active="request()->is('akses/pesan')">Pesan</x-nav-link>

                                    @if ($hasPemeliharaanTable)
                                        <x-nav-link href="/akses/pemeliharaan" :active="request()->is('akses/pemeliharan')">Pemeliharaan</x-nav-link>
                                    @endif

                                    @if ($hasLayananTambahanTable)
                                        <x-nav-link href="/akses/pengantaran" :active="request()->is('akses/pengantaran')">Antar Barang</x-nav-link>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- WEB --}}
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">

                            <!-- Profile dropdown -->
                            <div class="relative ml-3">
                                <div>
                                    <button type="button" @click="isOpen = !isOpen"
                                        class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 border border-white"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="absolute -inset-1.5"></span>
                                        <span class="sr-only">Open user menu</span>
                                        <div class="hover:bg-gray-700 hover:text-white"></div>

                                        <div class="text-gray-300 px-3 py-2 text-sm font-medium">
                                            {{ Auth::user()->nama }}</div>
                                    </button>
                                </div>
                                <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75 transform"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                    tabindex="-1">
                                    <!-- Active: "bg-gray-100", Not Active: "" -->
                                    @if (Auth::check() && Auth::user()->idRole == 1)
                                        <a href="/profil" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                            tabindex="-1" id="user-menu-item-0">Profil</a>
                                    @elseif (Auth::check() && Auth::user()->idRole == 2)
                                        <a href="/info/profil" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                            tabindex="-1" id="user-menu-item-0">Profil</a>
                                    @elseif (Auth::check() && Auth::user()->idRole == 3)
                                        <a href="/akses/profil" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                            tabindex="-1" id="user-menu-item-0">Profil</a>
                                    @endif
                                    
                                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                        @csrf
                                        <button type="submit" class="block px-4 py-2 text-sm text-gray-700"
                                            role="menuitem" tabindex="-1" id="user-menu-item-2">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- MOBILE --}}
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button"
                            @click="isOpen = !isOpen"class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <!-- Menu open: "hidden", Menu closed: "block" -->
                            <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!-- Menu open: "block", Menu closed: "hidden" -->
                            <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div x-show="isOpen" class="md:hidden" id="mobile-menu">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    {{-- AKSES PENGELOLA --}}
                    @if (Auth::check() && Auth::user()->idRole == 1)
                        <a href="/kos"
                            class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white"
                            aria-current="page">Kos Anda</a>
                        <a href="/penghuni"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Penghuni</a>
                        <a href="/tagihan"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Pembayaran</a>
                        <a href="/pesan"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Pesan</a>
                        
                        @if ($hasKaryawanTable)
                        <a href="/karyawan"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Karyawan</a>
                        @endif

                        @if ($hasPemeliharaanTable)  
                        <a href="/pemeliharaan"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Pemeliharaan</a>
                        @endif

                        @if ($hasLayananTambahanTable)
                            <a href="/layanan-tambahan"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Layanan
                                Tambahan</a>
                        @endif
                    @endif

                    {{-- AKSES PENGHUNI --}}
                    @if (Auth::check() && Auth::user()->idRole == 2)
                        <a href="/info/kamar" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white"
                            aria-current="page">Kamar Anda</a>
                        <a href="/info/tagihan"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Tagihan</a>
                        <a href="/info/pelaporan"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Pelaporan</a>
                        
                        @if ($hasPemeliharaanTable)  
                            <a href="/info/perbaikan"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Perbaikan</a>
                        @endif

                        @if ($hasLayananTambahanTable)
                            <a href="/info/pembelian-layanan"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Pembelian Layanan</a>
                        @endif
                    @endif

                    {{-- AKSES ART --}}
                    @if (Auth::check() && Auth::user()->idRole == 3)
                        <a href="/akses/kamar" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white"
                            aria-current="page">Kamar Penghuni</a>
                        <a href="/akses/laporan"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Laporan Tugas</a>
                        <a href="/akses/pesan"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Pesan</a>
                        
                        @if ($hasPemeliharaanTable)  
                            <a href="/akses/pemeliharaan"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Pemeliharaan</a>
                        @endif

                        @if ($hasLayananTambahanTable)
                            <a href="/akses/pengantaran"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Antar Barang</a>
                        @endif
                    @endif
                </div>
                <div class="border-t border-gray-700 pb-3 pt-4">
                    <div class="flex items-center px-5">
                        <div class="ml-2">
                            <div class="text-base font-medium leading-none text-gray-300">{{ Auth::user()->nama }}</div>
                            <div class="text-sm font-medium leading-none text-gray-500 py-1">{{ Auth::user()->no_telp }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <a href="#"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Profil</a>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-2">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
