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
                </nav>
            </div>

            <script>
                function switchPage(page) {
                    const kontrakSection = document.getElementById('kontrak');
                    const kamarSection = document.getElementById('kamar');
                    const fasilitasSection = document.getElementById('fasilitas');
                    const btnKontrak = document.getElementById('btnKontrak');
                    const btnKamar = document.getElementById('btnKamar');
                    const btnFasilitas = document.getElementById('btnFasilitas');

                    // Menghilangkan semua section
                    kontrakSection.classList.add('hidden');
                    kamarSection.classList.add('hidden');
                    fasilitasSection.classList.add('hidden');

                    // Menghilangkan aktifasi dari button
                    btnKontrak.classList.remove('bg-indigo-600', 'text-white');
                    btnKontrak.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnKamar.classList.remove('bg-indigo-600', 'text-white');
                    btnKamar.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnFasilitas.classList.remove('bg-indigo-600', 'text-white');
                    btnFasilitas.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

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
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada data kontrak penghuni untuk kos ini.</td>
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
                                {{-- tgl keluar --}}
                                <div class="flex items-center space-x-4">
                                    <label for="keluar" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Keluar:</label>
                                    <input id="modal-keluar" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>
                                {{-- deposit --}}
                                <div class="flex items-center space-x-4">
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
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada kamar untuk kos ini.</td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>

                    <!-- MODAL DATA -->
                    <div class="modal fade p-4" id="ModalKamar" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Kamar
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
                                <div class="modal-body p-6 space-y-2">
                                    <!-- AJAX -->
                                    <div class="flex items-center space-x-4">
                                        <label for="no_kamar" class="w-32 text-md font-medium text-gray-700">
                                            Nomor Kamar:</label>
                                        <input id="modal-no_kamar" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="harga_kamar" class="w-32 text-md font-medium text-gray-700">
                                            Harga (Per-Bulan):</label>
                                        <input id="modal-harga_kamar" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="keterangan_kamar" class="w-32 text-md font-medium text-gray-700">
                                            Keterangan:</label>
                                        <textarea id="modal-keterangan_kamar" type="text" value="" rows="2"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                    </div>

                                </div>
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    @if(!empty($item->idKamar))
                                        <button type="button" id="hapus-kamar-btn" data-id="{{ $item->idKamar }}"
                                            class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500">
                                            Hapus
                                        </button>
                                    @endif
                                    <a href="#" id="edit-kamar-btn">
                                        <button type="button"
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Ubah Kamar
                                        </button>
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
                </div>
                <div class="border-b border-gray-900/10 pb-10">
            </section>

            {{-- TAMBAH DATA --}}
            <section>
                <form action="{{ route('kamar.store') }}" method="POST" class="mt-10">
                    @csrf
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-10">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Tambah Kamar Kos*</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Semua kolom wajib diisi.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                {{-- Nomor Kamar --}}
                                <div class="sm:col-span-1">
                                    <label for="kamar"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nomor Kamar</label>
                                    <div class="mt-2">
                                        <input type="number" name="kamar" id="kamar"
                                            class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                </div>
                                {{-- Harga --}}
                                <div class="sm:col-span-2">
                                    <label for="harga"
                                        class="block text-sm font-medium leading-6 text-gray-900">Harga</label>
                                    <div class="mt-2">
                                        <input type="number" name="harga" id="harga"
                                            class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
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
                                    <p class="mt-3 text-sm leading-6 text-gray-600">Bagian ini bersifat optional</p>
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
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada fasilitas untuk kos ini.</td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>

                    <!-- MODAL DATA -->
                    <div class="modal fade p-4" id="ModalFasilitas" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Kamar
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
                                    @if(!empty($item->idFasilitas))
                                        <button type="button" id="hapus-fasilitas-btn"
                                            data-id="{{ $item->idFasilitas }}"
                                            class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500">
                                            Hapus
                                        </button>
                                    @endif
                                    <a href="#" id="edit-fasilitas-btn">
                                        <button type="button"
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Ubah Fasilitas
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
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                        </div>
                    </div>
                </form>
            </section>
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
                    $('#modal-rentang').val(data.data.waktu + ' ' + data.data.rentang);
                    $('#modal-masuk').val(data.data.tgl_masuk);
                    $('#modal-tagihan').val(data.data.tgl_tagihan);
                    $('#modal-denda').val(data.data.tgl_denda);
                    $('#modal-keluar').val(data.data.tgl_keluar);
                    $('#modal-deposit').val(data.data.deposit);

                    $('#biaya-container').empty();

                    $.each(data.biayaList, function(index, biaya) {
                        $('#biaya-container').append(`
                            <div class="mb-2 flex items-center space-x-4">
                                <input disabled checked id="${biaya.idBiaya}" name="idBiaya[]" type="checkbox" value="${biaya.idBiaya}" class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                <label for="${biaya.biaya}" class="w-32 text-md font-medium text-gray-700">${biaya.biaya}</label>
                            </div>
                        `);
                    });

                    $('#modal-keterangan').val(data.keterangan);

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
                    $('#modal-no_kamar').val('Kamar ' + data.idKamar);
                    $('#modal-harga_kamar').val(data.harga);
                    $('#modal-keterangan_kamar').val(data.keterangan);

                    $('#edit-kamar-btn').attr('href', '/kos/edit-kamar/' + id);
                }
            });
        });

        $('#hapus-kamar-btn').on('click', function() {
            var idKamar = $(this).data('id');

            if (confirm('Apakah Anda yakin ingin menghapus kamar ini?')) {
                $.ajax({
                    url: '{{ route('kamar.destroy', ':id') }}'.replace(':id', idKamar),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus kamar. Silakan coba lagi.');
                    }
                });
            }
        });
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

                    $('#edit-fasilitas-btn').attr('href', '/kos/edit-fasilitas/' + id);
                }
            });
        });

        $('#hapus-fasilitas-btn').on('click', function() {
            var idFasilitas = $(this).data('id');

            if (confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')) {
                $.ajax({
                    url: '{{ route('fasilitas.destroy', ':id') }}'.replace(':id', idFasilitas),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus fasilitas. Silakan coba lagi.');
                    }
                });
            }
        });
    });
</script>
