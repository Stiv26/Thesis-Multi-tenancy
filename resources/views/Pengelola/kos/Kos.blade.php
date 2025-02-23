<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>

        {{-- TOP CONTENT --}}
        <section class="flex justify-between items-center mb-6">
            <div class="flex items-center justify-between px-3 py-3 rounded-lg">
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#kontrak" id="btnKontrak" onclick="switchPage('kontrak')"
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">
                        Kontrak Penghuni</a>
                    <a href="#kamar" id="btnKamar" onclick="switchPage('kamar')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                        Kamar</a>
                    <a href="#fasilitas" id="btnFasilitas" onclick="switchPage('fasilitas')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                        Fasilitas</a>
                    <a href="#sop" id="btnSop" onclick="switchPage('sop')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                        SOP Kos</a>
                </nav>
            </div>

            <script>
                function switchPage(page) {
                    const kontrakSection = document.getElementById('kontrak');
                    const kamarSection = document.getElementById('kamar');
                    const fasilitasSection = document.getElementById('fasilitas');
                    const sopSection = document.getElementById('sop');

                    const btnKontrak = document.getElementById('btnKontrak');
                    const btnKamar = document.getElementById('btnKamar');
                    const btnFasilitas = document.getElementById('btnFasilitas');
                    const btnSop = document.getElementById('btnSop');

                    // Menghilangkan semua section
                    kontrakSection.classList.add('hidden');
                    kamarSection.classList.add('hidden');
                    fasilitasSection.classList.add('hidden');
                    sopSection.classList.add('hidden');

                    // Menghilangkan aktifasi dari button
                    btnKontrak.classList.remove('bg-indigo-600', 'text-white');
                    btnKontrak.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnKamar.classList.remove('bg-indigo-600', 'text-white');
                    btnKamar.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnFasilitas.classList.remove('bg-indigo-600', 'text-white');
                    btnFasilitas.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnSop.classList.remove('bg-indigo-600', 'text-white');
                    btnSop.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

                    if (page === 'kontrak') {
                        kontrakSection.classList.remove('hidden');
                        btnKontrak.classList.add('bg-indigo-600', 'text-white');
                        btnKontrak.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'kamar') {
                        kamarSection.classList.remove('hidden');
                        btnKamar.classList.add('bg-indigo-600', 'text-white');
                        btnKamar.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'fasilitas') {
                        fasilitasSection.classList.remove('hidden');
                        btnFasilitas.classList.add('bg-indigo-600', 'text-white');
                        btnFasilitas.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'sop') {
                        sopSection.classList.remove('hidden');
                        btnSop.classList.add('bg-indigo-600', 'text-white');
                        btnSop.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    }

                    // Memberikan sedikit delay sebelum scroll
                    setTimeout(function() {
                        window.scrollTo(0, 0);
                    }, 50);
                }
            </script>
        </section>

        {{-- PAGE KONTRAK --}}
        <section id="kontrak" class="block">
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                {{-- LIST DATA TABEL --}}
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Penyewa</th>
                            <th class="py-3 px-4">No Telp</th>
                            <th class="py-3 px-4">Tanggal Tagihan</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($kontrak as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->no_telp }}</td>
                                <td class="py-3 px-4">{{ $item->tgl_tagihan }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idKontrak }}" data-toggle="modal"
                                        data-target="#ModalKontrak"
                                        class="lihat-detail-kontrak text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada data kontrak
                                    penghuni untuk kos ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalKontrak" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Kontrak</h3>
                                <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal"
                                    aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <!-- AJAX -->
                            <div class="modal-body p-6 space-y-2">
                                {{-- kamar --}}
                                <div class="flex items-center space-x-4">
                                    <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                        Kamar:</label>
                                    <input id="modal-kamar" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>
                                {{-- penghuni --}}
                                <div class="flex items-center space-x-4">
                                    <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                        Nama Penyewa:</label>
                                    <input id="modal-nama" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>
                                {{-- harga --}}
                                <div class="flex items-center space-x-4">
                                    <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                        Harga Kamar:</label>
                                    <input id="modal-harga" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>
                                {{-- rentang --}}
                                <div class="flex items-center space-x-4">
                                    <label for="Rentang" class="w-32 text-md font-medium text-gray-700">
                                        Rentang Sewa:</label>
                                    <input id="modal-rentang" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>
                                {{-- tgl masuk --}}
                                <div class="flex items-center space-x-4">
                                    <label for="masuk" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Masuk:</label>
                                    <input id="modal-masuk" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>
                                {{-- tgl tagihan --}}
                                <div class="flex items-center space-x-4">
                                    <label for="tagihan" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Tagihan:</label>
                                    <input id="modal-tagihan" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>
                                {{-- tgl denda --}}
                                <div class="flex items-center space-x-4">
                                    <label for="denda" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Denda:</label>
                                    <input id="modal-denda" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>
                                {{-- deposit --}}
                                <div class="flex items-center space-x-4" id="modal-show-deposit">
                                    <label for="deposit" class="w-32 text-md font-medium text-gray-700">
                                        Deposit:</label>
                                    <input id="modal-deposit" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                {{-- biaya kontrak --}}
                                <div class="flex items-center space-x-4">
                                    <label for="deposit" class="w-32 text-md font-medium text-gray-700">
                                        Biaya Kontrak:</label>
                                    {{-- AJAX --}}
                                    <div id="biaya-container"></div>
                                </div>
                                {{-- keterangan --}}
                                <div class="flex items-center space-x-4">
                                    <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                        Keterangan:</label>
                                    <textarea id="modal-keterangan" type="text" value="" rows="2"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                </div>
                            </div>
                            {{-- FOOTER MODAL --}}
                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                <a href="#" id="batalkan-kontrak-btn">
                                    <button type="button"
                                        class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-600">
                                        Batalkan Kontrak
                                    </button>
                                </a>
                                <a href="#" id="edit-kontrak-btn">
                                    <button type="button"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Ubah Kontrak
                                    </button>
                                </a>
                                <button type="button"
                                    class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                    data-dismiss="modal">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- PAGE KAMAR --}}
        <section id="kamar" class="hidden">
            <section>
                <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
                {{-- LIST --}}
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full table-auto text-center">
                        <thead class="bg-gray-100">
                            <tr class="text-sm text-gray-600">
                                <th class="py-3 px-4">Nomor Kamar</th>
                                <th class="py-3 px-4">Harga (Per-Bulan)</th>
                                <th class="py-3 px-4">Keterangan</th>
                                <th class="py-2 px-4">Lihat Detail</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse ($kamar as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">Kamar {{ $item->idKamar }}</td>
                                    <td class="py-3 px-4">{{ $item->harga }}</td>
                                    <td class="py-3 px-4">{{ $item->keterangan }}</td>
                                    <td class="py-3 px-4">
                                        <a href="#" data-id="{{ $item->idKamar }}" data-toggle="modal"
                                            data-target="#ModalKamar"
                                            class="lihat-detail-kamar text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada kamar
                                        untuk kos ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <main id="bagian-modal-kamar">
                        <!-- MODAL DATA -->
                        <div class="modal fade p-4" id="ModalKamar" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24"> <!-- Lebar lebih besar -->
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <!-- Header -->
                                    <div
                                        class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-center">
                                        <h3 class="text-2xl font-semibold text-gray-800">Detail Kamar</h3>
                                        <button type="button" class="text-gray-400 hover:text-gray-600"
                                            data-dismiss="modal" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Content -->
                                    <div class="modal-body p-6 space-y-4"> <!-- Elemen tersusun ke bawah -->

                                        <!-- Nomor Kamar -->
                                        <div>
                                            <label for="no_kamar"
                                                class="block text-sm font-medium text-gray-600">Nomor Kamar</label>
                                            <input id="modal-no_kamar" type="text"
                                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                readonly>
                                        </div>

                                        <!-- Harga Per-Bulan -->
                                        <div>
                                            <label for="harga_kamar"
                                                class="block text-sm font-medium text-gray-600">Harga
                                                (Per-Bulan)</label>
                                            <input id="modal-harga_kamar" type="text"
                                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                readonly>
                                        </div>

                                        {{-- Toggle Harga Mingguan/Harian --}}
                                        <div class="flex justify-center mt-4">
                                            <button id="toggle-mingguan-harian"
                                                class="text-indigo-600 font-medium hover:text-indigo-500 focus:outline-none hidden">
                                                Lihat Harga Lainnya &#9662;
                                            </button>
                                        </div>

                                        {{-- Container Harga --}}
                                        <div id="modal-mingguan-harian" class="hidden space-y-4 mt-2">
                                            <!-- Harga Per-Minggu -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600">Harga
                                                    (Per-Minggu)</label>
                                                <input id="modal-harga_mingguan" type="text"
                                                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100"
                                                    readonly>
                                            </div>

                                            <!-- Harga Per-Harian -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600">Harga
                                                    (Per-Harian)</label>
                                                <input id="modal-harga_harian" type="text"
                                                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100"
                                                    readonly>
                                            </div>
                                        </div>

                                        <!-- Fasilitas -->
                                        <div>
                                            <label for="fasilitas_kamar"
                                                class="block text-sm font-medium text-gray-600">Fasilitas</label>
                                            <div id="modal-fasilitas" class="flex flex-wrap gap-2 mt-2"></div>
                                        </div>

                                        <!-- Foto -->
                                        <div>
                                            <label for="modal-foto"
                                                class="block text-sm font-medium text-gray-600">Foto</label>
                                            <img src="" id="modal-foto" alt="Foto Kamar"
                                                class="mt-1 w-full h-64 object-cover border border-gray-300 rounded-md">
                                        </div>

                                        <!-- Keterangan -->
                                        <div>
                                            <label for="keterangan_kamar"
                                                class="block text-sm font-medium text-gray-600">Keterangan</label>
                                            <textarea id="modal-keterangan_kamar" rows="3"
                                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                readonly></textarea>
                                        </div>

                                    </div>

                                    <!-- Footer -->
                                    <div class="modal-footer border-t border-gray-200 py-2 flex justify-end space-x-3">
                                        <button type="button" data-toggle="modal" data-target="#ModalHapusKamar"
                                            data-dismiss="modal"
                                            class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500">
                                            Hapus
                                        </button>
                                        <button type="button" data-toggle="modal" data-target="#ModalUbahKamar"
                                            data-dismiss="modal"
                                            class="lihat-detail-kamar rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Ubah Kamar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL UBAH KAMAR --}}
                        <div class="modal fade p-4 fixed inset-0 z-50 overflow-y-auto" id="ModalUbahKamar"
                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24 max-h-[90vh] overflow-y-auto">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <form action="{{ route('kos.updateKamar') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        {{-- header --}}
                                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Ubah
                                                Data Kamar</h3>
                                            <button type="button" class="text-gray-400 hover:text-gray-600"
                                                data-dismiss="modal" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- content --}}
                                        <div class="modal-body p-6 space-y-2">
                                            <!-- AJAX -->
                                            <div>
                                                <label for="modal-kamar-nomor"
                                                    class="block text-sm font-medium text-gray-600">Nomor Kamar</label>
                                                <input id="modal-kamar-nomor" type="number" name="idKamar"
                                                    class="text-center mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            </div>

                                            <div>
                                                <label for="modal-kamar-harga"
                                                    class="block text-sm font-medium text-gray-600">Harga
                                                    (Per-Bulan)</label>
                                                <input id="modal-kamar-harga" type="text" name="harga"
                                                    class="text-center mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            </div>

                                            <div class="flex justify-center mt-4">
                                                <button type="button" id="toggle-ubah-mingguan-harian" class="text-indigo-600 font-medium hover:text-indigo-500 focus:outline-none">
                                                    Atur Harga Mingguan/Harian &#9662;
                                                </button>
                                            </div>

                                            <!-- Bagian Harga yang Ditoggle -->
                                            <div id="modal-ubah-mingguan-harian" class="hidden mt-4 space-y-4">
                                                <!-- Harga Per-Minggu -->
                                                <div>
                                                    <label for="modal-kamar-mingguan" class="block text-sm font-medium text-gray-600">Harga (Per-Minggu)</label>
                                                    <input id="modal-kamar-mingguan" type="text" name="harga_mingguan"
                                                        class="text-center mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                </div>
                                            
                                                <!-- Harga Per-Harian -->
                                                <div>
                                                    <label for="modal-kamar-harian" class="block text-sm font-medium text-gray-600">Harga (Per-Harian)</label>
                                                    <input id="modal-kamar-harian" type="text" name="harga_harian"
                                                        class="text-center mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                </div>
                                            </div>

                                            <div class="pt-2">
                                                <label for="fasilitas_kamar"
                                                    class="block text-sm font-medium text-gray-600">Fasilitas
                                                    Kamar</label>
                                                <div id="modal-kamar-fasilitas" class="flex flex-wrap gap-2 mt-2">
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-4 py-2">
                                                <label for="modal-kamar-foto"
                                                    class="block text-sm font-medium text-gray-600">Foto</label>
                                                <input required id="modal-kamar-foto" type="file" name="foto"
                                                    class="w-20 flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                            </div>

                                            <div>
                                                <label for="modal-kamar-keterangan"
                                                    class="block text-sm font-medium text-gray-600">Keterangan</label>
                                                <textarea id="modal-kamar-keterangan" type="text" value="" rows="2" name="keterangan"
                                                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                    required></textarea>
                                            </div>

                                        </div>
                                        {{-- SUBMIT --}}
                                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                            <button type="submit" data-toggle="modal"
                                                data-target="#ModalSuksesUbahKamar"
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Ubah Kamar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL HAPUS KAMAR --}}
                        <div class="modal fade p-4" id="ModalHapusKamar" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <div class="modal-body p-6 space-y-2">
                                        <form action="{{ route('kamar.destroy') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="flex items-center space-x-4">
                                                <!-- Icon Warning -->
                                                <div
                                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                                    <svg class="h-6 w-6 text-red-600" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                    </svg>
                                                </div>
                                                <!-- Modal Title -->
                                                <div class="text-left">
                                                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                                                        Konfirmasi Penghapusan Kamar</h3>
                                                    <p class="mt-2 text-sm text-gray-500">Apakah anda yakin ingin
                                                        menghapus kamar ini?</p>

                                                    <input type="hidden" id="modal-hapusKamar-idKamar"
                                                        name="idKamar">
                                                </div>
                                            </div>

                                            <!-- Footer: Tombol Aksi -->
                                            <div class="mt-6 flex justify-end space-x-4">
                                                <button type="button" data-dismiss="modal"
                                                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Batal</button>
                                                <button type="submit" data-toggle="modal"
                                                    data-target="#ModalSuksesHapusKamar"
                                                    class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>

                <div class="border-b border-gray-900/10 pb-10">
            </section>

            {{-- TAMBAH DATA --}}
            <section class="mt-10">
                <form action="{{ route('kamar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-10">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Tambah Kamar Kos*</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Semua kolom wajib diisi.</p>
                            {{-- FORM --}}
                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                {{-- Nomor Kamar --}}
                                <div class="sm:col-span-3">
                                    <label for="kamar"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nomor Kamar</label>
                                    <div class="mt-2">
                                        <input type="number" name="kamar" id="kamar"
                                            class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                    @if ($errors->has('kamar'))
                                        <div class="alert alert-danger mt-3">
                                            {{ $errors->first('kamar') }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Foto --}}
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label for="foto"
                                        class="block text-sm font-medium leading-6 text-gray-900">Foto</label>
                                    <div class="mt-2">
                                        <input type="file" name="foto" id="foto"
                                            class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                </div>

                                {{-- Harga --}}
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label for="harga"
                                        class="block text-sm font-medium leading-6 text-gray-900">Harga
                                        (Per-Bulan)</label>
                                    <div class="mt-2">
                                        <input type="number" name="harga" id="harga"
                                            class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                </div>

                                {{-- Fasilitas --}}
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">Fasilitas</label>
                                    <div class="mt-2">
                                        @foreach ($fasilitasKamar as $item)
                                            <div class="flex items-center">
                                                <input type="checkbox" checked name="fasilitas[]"
                                                    value="{{ $item->idFasilitas }}"
                                                    id="fasilitas_{{ $item->idFasilitas }}"
                                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <label for="fasilitas_{{ $item->idFasilitas }}"
                                                    class="ml-2 block text-sm text-gray-900">
                                                    {{ $item->fasilitas }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>


                                {{-- Keterangan --}}
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label for="keterangan"
                                        class="block text-sm font-medium leading-6 text-gray-900">Keterangan</label>
                                    <div class="mt-2">
                                        <textarea id="keterangan" name="keterangan" rows="2"
                                            class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required></textarea>
                                    </div>
                                </div>

                                {{-- HARGA MINGGUAN DAN HARIAN --}}
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <button type="button" id="toggle-harga"
                                        class="text-indigo-600 font-medium focus:outline-none">
                                        Tambah Harga Mingguan/Harian &#9662; <!-- Tanda panah ke bawah -->
                                    </button>
                                </div>
                                <div id="hargaContainer" class="hidden sm:col-span-3 sm:col-start-1">
                                    <!-- Harga Mingguan -->
                                    <div class="sm:col-span-3 sm:col-start-1">
                                        <p class="text-sm leading-6 text-gray-600">Bagian ini digunakan untuk harga
                                            mingguan dan harian</p>
                                        <label for="harga_mingguan"
                                            class="block text-sm font-medium leading-6 text-gray-900">Harga
                                            (Per-Minggu)</label>
                                        <div class="mt-2">
                                            <input type="number" name="harga_mingguan" id="harga_mingguan"
                                                class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    <!-- Harga Harian -->
                                    <div class="sm:col-span-3 sm:col-start-1 mt-4">
                                        <label for="harga_harian"
                                            class="block text-sm font-medium leading-6 text-gray-900">Harga
                                            (Per-Hari)</label>
                                        <div class="mt-2">
                                            <input type="number" name="harga_harian" id="harga_harian"
                                                class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById("toggle-harga").addEventListener("click", function() {
                                            var hargaContainer = document.getElementById("hargaContainer");

                                            // Toggle class hidden
                                            hargaContainer.classList.toggle("hidden");

                                            // Ganti tanda panah
                                            var button = document.getElementById("toggle-harga");
                                            if (hargaContainer.classList.contains("hidden")) {
                                                button.innerHTML = 'Tambah Harga Mingguan/Harian &#9662;';
                                            } else {
                                                button.innerHTML = 'Tutup Harga Mingguan/Harian &#9652;';
                                            }
                                        });
                                    </script>
                                </div>

                            </div>
                        </div>

                        {{-- Bagian Submit --}}
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                        </div>
                    </div>
                </form>
            </section>

        </section>

        {{-- PAGE FASILITAS --}}
        <section id="fasilitas" class="hidden">
            {{-- MAIN --}}
            <section>
                <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
                {{-- LIST --}}
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full table-auto text-center">
                        <thead class="bg-gray-100">
                            <tr class="text-sm text-gray-600">
                                <th class="py-3 px-4">Fasilitas</th>
                                <th class="py-3 px-4">Jumlah</th>
                                <th class="py-3 px-4">Jenis</th>
                                <th class="py-2 px-4">Edit Fasilitas</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse ($fasilitas as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">{{ $item->fasilitas }}</td>
                                    <td class="py-3 px-4">{{ $item->jumlah }}</td>
                                    <td class="py-3 px-4">{{ $item->jenis }}</td>
                                    <td class="py-3 px-4">
                                        <a href="#" data-id="{{ $item->idFasilitas }}" data-toggle="modal"
                                            data-target="#ModalFasilitas"
                                            class="lihat-detail-fasilitas text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada fasilitas
                                        untuk kos ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <main id="bagian-modal-fasiltias">
                        <!-- MODAL DATA -->
                        <div class="modal fade p-4" id="ModalFasilitas" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    {{-- header --}}
                                    <div class="modal-header border-b border-gray-200 py-4 px-6">
                                        <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail
                                            Kamar
                                        </h3>
                                        <button type="button" class="text-gray-400 hover:text-gray-600"
                                            data-dismiss="modal" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    {{-- content --}}
                                    <div class="modal-body p-6 space-y-2">
                                        <!-- AJAX -->
                                        <div class="flex items-center space-x-4">
                                            <label for="fasilitas" class="w-32 text-md font-medium text-gray-700">
                                                Fasilitas:</label>
                                            <input id="modal-fasilitas" type="text" value=""
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="jumlah" class="w-32 text-md font-medium text-gray-700">
                                                Jumlah:</label>
                                            <input id="modal-jumlah" type="text" value=""
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="jenis" class="w-32 text-md font-medium text-gray-700">
                                                Jenis:</label>
                                            <input id="modal-jenis" type="text" value=""
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                    </div>
                                    <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                        <button type="button" data-toggle="modal" data-target="#ModalHapusFasilitas"
                                            data-dismiss="modal"
                                            class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500">
                                            Hapus
                                        </button>
                                        <button type="button" data-toggle="modal" data-target="#ModalUbahFasilitas"
                                            data-dismiss="modal"
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Ubah Fasilitas
                                        </button>
                                        <button type="button"
                                            class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                            data-dismiss="modal">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL UBAH FASILITAS --}}
                        <div class="modal fade p-4" id="ModalUbahFasilitas" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <form action="{{ route('kos.updateFasilitas') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        {{-- header --}}
                                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Ubah
                                                Data Fasilitas</h3>
                                            <button type="button" class="text-gray-400 hover:text-gray-600"
                                                data-dismiss="modal" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- content --}}
                                        <div class="modal-body p-6 space-y-2">

                                            <div class="flex items-center space-x-4">
                                                <label for="fasilitas" class="w-32 text-md font-medium text-gray-700">
                                                    Fasilitas:</label>
                                                <input id="modal-fasilitas-fasilitas" type="text" value=""
                                                    name="fasilitas"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    required>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="jumlah" class="w-32 text-md font-medium text-gray-700">
                                                    Jumlah:</label>
                                                <input id="modal-fasilitas-jumlah" type="number" value=""
                                                    name="jumlah" min="1"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    required>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="jenis" class="w-32 text-md font-medium text-gray-700">
                                                    Jenis:</label>
                                                <select id="modal-fasilitas-jenis" name="jenis" required
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                                    <option value="umum">Umum</option>
                                                    <option value="kamar">Kamar</option>
                                                </select>
                                            </div>

                                            <input type="hidden" id="modal-fasilitas-idFasilitas"
                                                name="idFasilitas">

                                        </div>
                                        {{-- SUBMIT --}}
                                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                            <button type="button" data-dismiss="modal"
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Tutup
                                            </button>
                                            <button type="submit" data-toggle="modal"
                                                data-target="#ModalSuksesUbahFasilitas"
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Ubah Fasilitas
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL HAPUS FASILITAS --}}
                        <div class="modal fade p-4" id="ModalHapusFasilitas" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <div class="modal-body p-6 space-y-2">
                                        <form action="{{ route('fasilitas.destroy') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="flex items-center space-x-4">
                                                <!-- Icon Warning -->
                                                <div
                                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                                    <svg class="h-6 w-6 text-red-600" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                    </svg>
                                                </div>
                                                <!-- Modal Title -->
                                                <div class="text-left">
                                                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                                                        Konfirmasi Penghapusan Fasilitas</h3>
                                                    <p class="mt-2 text-sm text-gray-500">Apakah anda yakin ingin
                                                        menghapus Fasilitas ini?</p>

                                                    <input type="hidden" id="modal-hapusFasilitas-idFasilitas"
                                                        name="idFasilitas">
                                                </div>
                                            </div>

                                            <!-- Footer: Tombol Aksi -->
                                            <div class="mt-6 flex justify-end space-x-4">
                                                <button type="button" data-dismiss="modal"
                                                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Batal</button>
                                                <button type="submit" data-toggle="modal"
                                                    data-target="#ModalSuksesHapusFasilitas"
                                                    class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>

                </div>

                <div class="border-b border-gray-900/10 pb-10">
            </section>

            {{-- TAMBAH DATA --}}
            <section>
                <form action="{{ route('fasilitas.store') }}" method="POST" class="mt-10">
                    @csrf <!-- Token keamanan -->
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-10">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Tambah Fasilitas Kos*</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Semua kolom wajib di isi.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                {{-- fasilitas --}}
                                <div class="sm:col-span-3">
                                    <label for="fasilitas"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nama
                                        Fasilitas</label>
                                    <div class="mt-2">
                                        <input type="text" name="fasilitas" id="fasilitas"
                                            class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                {{-- Jenis --}}
                                <div class="sm:col-span-2 sm:col-start-1">
                                    <label for="jenis"
                                        class="block text-sm font-medium leading-6 text-gray-900">Jenis</label>
                                    <div class="mt-2">
                                        <select name="jenis" id="jenis"
                                            class="text-center block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="Kamar">Kamar</option>
                                            <option value="Umum">Umum</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Jumlah --}}
                                <div class="sm:col-span-1">
                                    <label for="jumlah"
                                        class="block text-sm font-medium leading-6 text-gray-900">Jumlah</label>
                                    <div class="mt-2">
                                        <input type="number" name="jumlah" id="jumlah"
                                            class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian Submit --}}
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                            <button type="submit" data-toggle="modal" data-target="#ModalSuksesBuatFasilitas"
                                class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                        </div>
                    </div>
                </form>
            </section>
        </section>

        {{-- PAGE SOP --}}
        <section id="sop" class="hidden">
            <h2 class="pl-4 text-xl font-semibold text-gray-800 mb-3">SOP Kos {{ tenancy()->tenant->id }}</h2>
            <ol class="list-decimal pl-5">
                @foreach ($peraturan as $item)
                    <div class="flex justify-between">
                        <li class="text-md py-1 px-3">{{ $item->aturan }}</li>
                        <a href="#" data-id="{{ $item->idPeraturan }}" data-toggle="modal"
                            data-target="#ModalDetailAturan"
                            class="lihat-detail-aturan text-red-600 text-sm py-1 px-3">Perbaruhi</a>
                    </div>
                @endforeach
            </ol>

            <a href="#" data-toggle="modal" data-target="#ModalSop"
                class="mt-3 text-sm leading-6 text-gray-600 ml-4">
                <span aria-hidden="true">+</span> Tambah Aturan Baru</a>

            <main id="bagian-modal-sop">
                {{-- MODAL TAMBAH ATURAN --}}
                <div class="modal fade p-4" id="ModalSop" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <form action="{{ route('aturan.store') }}" method="POST"
                            class="modal-content rounded-lg shadow-lg bg-white">
                            @csrf
                            {{-- Header modal --}}
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Tambah Aturan Kos
                                </h3>
                                <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal"
                                    aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            {{-- Content modal --}}
                            <div class="modal-body p-6 space-y-2">
                                <div class="flex items-center space-x-4">
                                    <label for="tambah-aturan"
                                        class="w-32 text-md font-medium text-gray-700">Aturan:</label>
                                    <input required id="tambah-aturan" name="aturan" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                </div>
                            </div>
                            {{-- Footer --}}
                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                <button type="submit" data-toggle="modal" data-target="#ModalSuksesBuatSop"
                                    class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                    Tambah
                                </button>
                                <button type="button"
                                    class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                    data-dismiss="modal">
                                    Tutup
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- MODAL UBAH DATA -->
                <div class="modal fade p-4" id="ModalDetailAturan" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            {{-- header --}}
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Kamar
                                </h3>
                                <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal"
                                    aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            {{-- content --}}
                            <form action="{{ route('kos.updateAturan') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body p-6 space-y-2">
                                    <!-- AJAX -->
                                    <div class="flex items-center space-x-4">
                                        <label for="fasilitas" class="w-32 text-md font-medium text-gray-700">
                                            Aturan:</label>
                                        <input id="modal-aturan-aturan" type="text" value="" name="aturan"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            required>
                                    </div>

                                    <input type="hidden" id="modal-aturan-idPeraturan" name="idPeraturan">

                                </div>
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button type="button" data-toggle="modal" data-target="#ModalHapusSop"
                                        data-dismiss="modal"
                                        class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500">
                                        Hapus
                                    </button>
                                    <button type="submit" data-toggle="modal" data-target="#ModalSuksesUbahAturan"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Ubah Aturan
                                    </button>
                                    <button type="button"
                                        class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                        data-dismiss="modal">
                                        Tutup
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- MODAL HAPUS SOP --}}
                <div class="modal fade p-4" id="ModalHapusSop" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <div class="modal-body p-6 space-y-2">
                                <form action="{{ route('aturan.destroy') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex items-center space-x-4">
                                        <!-- Icon Warning -->
                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                            </svg>
                                        </div>
                                        <!-- Modal Title -->
                                        <div class="text-left">
                                            <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                                                Konfirmasi Penghapusan Aturan</h3>
                                            <p class="mt-2 text-sm text-gray-500">Apakah anda yakin ingin menghapus
                                                Aturan ini?</p>

                                            <input type="hidden" id="modal-hapusAturan-idPengaturan"
                                                name="idPengaturan">
                                        </div>
                                    </div>

                                    <!-- Footer: Tombol Aksi -->
                                    <div class="mt-6 flex justify-end space-x-4">
                                        <button type="button" data-dismiss="modal"
                                            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Batal</button>
                                        <button type="submit" data-toggle="modal"
                                            data-target="#ModalSuksesHapusAturan"
                                            class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </section>

    </main>
</x-layout>

{{-- AJAX KONTRAK --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-kontrak').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/kontrak/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-nama').val(data.data.nama);
                    $('#modal-harga').val(data.data.harga);
                    $('#modal-rentang').val(data.data.rentang);
                    $('#modal-masuk').val(data.data.tgl_masuk);
                    $('#modal-tagihan').val(data.data.tgl_tagihan);
                    $('#modal-denda').val(data.data.tgl_denda);
                    $('#modal-deposit').val(data.data.deposit);
                    $('#modal-waktu').val(data.data.waktu);

                    $('#modal-tanggal-tagihan').val(data.pengaturan.waktu_tagihan);
                    $('#modal-tanggal-denda').val(data.pengaturan.waktu_denda);

                    $('#biaya-container').empty();

                    $.each(data.biayaList, function(index, biaya) {
                        $('#biaya-container').append(`
                            <div class="mb-2 flex items-center space-x-4">
                                <input disabled checked id="${biaya.idBiaya}" name="idBiaya[]" type="checkbox" value="${biaya.idBiaya}" class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                <label for="${biaya.biaya}" class="w-32 text-md font-medium text-gray-700">${biaya.biaya}</label>
                            </div>
                        `);
                    });

                    $('#modal-keterangan').val(data.data.keterangan);

                    if (data.data.deposit !== null) {
                        $('#modal-show-deposit').show();
                        $('#modal-deposit').val(data.data.deposit);
                    } else {
                        $('#modal-show-deposit').hide();
                    }

                    $('#edit-kontrak-btn').attr('href', '/kos/edit-kontrak/' + id);
                    $('#batalkan-kontrak-btn').attr('href', '/kos/batal-kontrak/' + id);
                }
            });
        });
    });
</script>

{{-- AJAX KAMAR --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-kamar').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/kamar/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-no_kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-harga_kamar').val(data.data.harga);
                    $('#modal-harga_mingguan').val(data.data.harga_mingguan);
                    $('#modal-harga_harian').val(data.data.harga_harian);
                    $('#modal-keterangan_kamar').val(data.data.keterangan);
                    $('#modal-foto').attr('src', data.gambar_url);

                    $('#modal-hapusKamar-idKamar').val(data.data.idKamar);

                    $('#modal-fasilitas').empty();
                    if (data.fasilitas.length === 0) {
                        $('#modal-fasilitas').append(`
                            <div class="text-gray-400 text-sm">Anda belum mengatur fasilitas kamar ini</div>`);
                    } else {
                        $.each(data.fasilitas, function(index, fasilitas) {
                            $('#modal-fasilitas').append(`
                                <div class="text-gray-700 bg-gray-100 px-3 py-2 rounded-md">
                                    ${fasilitas.fasilitas}
                                </div>`);
                        });
                    }

                    $('#toggle-mingguan-harian').removeClass('hidden').removeAttr('style');
                    $('#modal-mingguan-harian').removeClass('hidden').removeAttr('style');
                    $('#modal-harga_mingguan').parent().removeClass('hidden').removeAttr(
                        'style');
                    $('#modal-harga_harian').parent().removeClass('hidden').removeAttr(
                        'style');

                    const hasMingguan = data.data.harga_mingguan !== null;
                    const hasHarian = data.data.harga_harian !== null;

                    if (hasMingguan || hasHarian) {
                        // Tampilkan tombol toggle
                        $('#toggle-mingguan-harian').removeClass('hidden');
                        // Sembunyikan container harga dengan class hidden
                        $('#modal-mingguan-harian').addClass('hidden');

                        // Tampilkan/menyembunyikan field sesuai data
                        if (hasMingguan) {
                            $('#modal-harga_mingguan')
                                .val('Rp ' + data.data.harga_mingguan.toLocaleString(
                                    'id-ID'))
                                .parent().removeClass('hidden');
                        } else {
                            $('#modal-harga_mingguan').parent().addClass('hidden');
                        }

                        if (hasHarian) {
                            $('#modal-harga_harian')
                                .val('Rp ' + data.data.harga_harian.toLocaleString('id-ID'))
                                .parent().removeClass('hidden');
                        } else {
                            $('#modal-harga_harian').parent().addClass('hidden');
                        }
                    } else {
                        // Sembunyikan toggle dan container
                        $('#toggle-mingguan-harian').addClass('hidden');
                        $('#modal-mingguan-harian').addClass('hidden');
                    }



                    // UBAH KAMAR
                    $('#modal-kamar-nomor').val(data.data.idKamar);
                    $('#modal-kamar-harga').val(data.data.harga);
                    $('#modal-kamar-keterangan').val(data.data.keterangan);
                    $('#modal-kamar-mingguan').val(data.data.harga_mingguan);
                    $('#modal-kamar-harian').val(data.data.harga_harian);

                    var existingFasilitasIds = data.fasilitas.map(function(f) {
                        return f.idFasilitas;
                    });
                    $('#modal-kamar-fasilitas').empty();
                    $.each(data.pilihFasilitas, function(index, fasilitas) {
                        // Cek apakah fasilitas ini sudah terpilih
                        var isChecked = existingFasilitasIds.includes(fasilitas
                            .idFasilitas) ? 'checked' : '';

                        // Bangun elemen checkbox dengan kondisi checked
                        $('#modal-kamar-fasilitas').append(`
                            <label class="flex items-center space-x-2 bg-gray-100 px-3 py-1 rounded-md cursor-pointer hover:bg-gray-200">
                                <input type="checkbox" name="fasilitas[${fasilitas.idFasilitas}]" value="${fasilitas.idFasilitas}" 
                                    class="form-checkbox h-4 w-4 text-indigo-600 rounded focus:ring-indigo-500"
                                    ${isChecked}>
                                <span class="text-gray-700">${fasilitas.fasilitas}</span>
                            </label>
                        `);
                    });
                }
            });
        });
    });

    // TOOGLE SELENGKAPNYA HARGA
    $(document).on('click', '#toggle-mingguan-harian', function() {
        const container = $('#modal-mingguan-harian');
        container.toggleClass('hidden');

        // Update ikon panah
        if (container.hasClass('hidden')) {
            $(this).html('Lihat Harga Lainnya &#9662;');
        } else {
            $(this).html('Tutup Harga Lainnya &#9652;');
        }
    });

    $('#toggle-ubah-mingguan-harian').on('click', function() {
        $('#modal-ubah-mingguan-harian').toggleClass('hidden');
        
        // Update ikon panah
        if ($('#modal-ubah-mingguan-harian').hasClass('hidden')) {
            $(this).html('Atur Harga Mingguan/Harian &#9662;');
        } else {
            $(this).html('Atur Harga Mingguan/Harian &#9652;');
        }
    });
</script>

{{-- AJAX FASILITAS --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-fasilitas').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/fasilitas/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-fasilitas').val(data.fasilitas);
                    $('#modal-jumlah').val(data.jumlah);
                    $('#modal-jenis').val(data.jenis);

                    $('#modal-fasilitas-fasilitas').val(data.fasilitas);
                    $('#modal-fasilitas-jumlah').val(data.jumlah);
                    $('#modal-fasilitas-jenis').val(data.jenis).change();
                    $('#modal-fasilitas-idFasilitas').val(data.idFasilitas);

                    $('#modal-hapusFasilitas-idFasilitas').val(data.idFasilitas);
                }
            });
        });
    });
</script>

{{-- AJAX SOP --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-aturan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/aturan/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-aturan-idPeraturan').val(data.idPeraturan);
                    $('#modal-aturan-aturan').val(data.aturan);

                    $('#modal-hapusAturan-idPengaturan').val(data.idPeraturan);
                }
            });
        });
    });
</script>
