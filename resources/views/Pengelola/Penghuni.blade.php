<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>

        {{-- TOP KONTEN --}}
        <section class="flex justify-between items-center mb-6">
            <div class="flex items-center justify-between px-3 py-3 rounded-lg">
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
                    <a href="#permintaanPenghuni" id="btnPermintaan" onclick="switchPage('permintaanPenghuni')"
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">Permintaan
                        Hunian</a>
                    <a href="#tambahPenghuni" id="btnTambah" onclick="switchPage('tambahPenghuni')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Tambah
                        Penghuni</a>
                    <a href="#listPenghuni" id="btnList" onclick="switchPage('listPenghuni')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Data
                        Penghuni</a>
                </nav>
            </div>

            {{-- JS --}}
            <script>
                function switchPage(page) {
                    const permintaanSection = document.getElementById('permintaanPenghuni');
                    const tambahSection = document.getElementById('tambahPenghuni');
                    const listSection = document.getElementById('listPenghuni');
                    const btnPermintaan = document.getElementById('btnPermintaan');
                    const btnTambah = document.getElementById('btnTambah');
                    const btnList = document.getElementById('btnList');

                    // Menghilangkan semua section
                    permintaanSection.classList.add('hidden');
                    tambahSection.classList.add('hidden');
                    listSection.classList.add('hidden');

                    // Menghilangkan aktifasi dari button
                    btnPermintaan.classList.remove('bg-indigo-600', 'text-white');
                    btnPermintaan.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnTambah.classList.remove('bg-indigo-600', 'text-white');
                    btnTambah.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnList.classList.remove('bg-indigo-600', 'text-white');
                    btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');


                    if (page === 'permintaanPenghuni') {
                        // Tampilkan halaman pesan dan set button aktif
                        permintaanSection.classList.remove('hidden');
                        btnPermintaan.classList.add('bg-indigo-600', 'text-white');
                        btnPermintaan.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300',
                            'hover:bg-gray-50');
                    } else if (page === 'tambahPenghuni') {
                        // Tampilkan halaman pesan dan set button aktif
                        tambahSection.classList.remove('hidden');
                        btnTambah.classList.add('bg-indigo-600', 'text-white');
                        btnTambah.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'listPenghuni') {
                        // Tampilkan halaman pengumuman dan set button aktif
                        listSection.classList.remove('hidden');
                        btnList.classList.add('bg-indigo-600', 'text-white');
                        btnList.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    }

                    // Memberikan sedikit delay sebelum scroll
                    setTimeout(function() {
                        window.scrollTo(0, 0);
                    }, 50);
                }
            </script>

            @php
                $tabelDenda = Schema::hasTable('denda');
            @endphp
        </section>

        {{-- REQUEST --}}
        <section id="permintaanPenghuni" class="block">
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">No Telp</th>
                            <th class="py-3 px-4">Kontrak</th>
                            <th class="py-3 px-4">Tanggal Masuk</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Selengkapnya</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse($permintaan as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->no_telp }}</td>
                                <td class="py-3 px-4">{{ $item->rentang }}</td>
                                <td class="py-3 px-4">{{ $item->tgl_masuk }}</td>
                                <td class="py-3 px-4">{{ $item->status }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->id }}" data-toggle="modal"
                                        data-target="#ModalPermintaan"
                                        class="lihat-detail-permintaan text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-3 px-4 text-center text-gray-500">Belum ada data penghuni
                                    untuk kos ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalPermintaan" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Data
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
                            <!-- AJAX -->
                            <div class="modal-body p-6 space-y-2">
                                <div class="flex items-center space-x-4">
                                    <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                        Nama Penyewa:</label>
                                    <input id="modal-permintaan-nama" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="telp" class="w-32 text-md font-medium text-gray-700">
                                        No Telp:</label>
                                    <input id="modal-permintaan-telp" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="email" class="w-32 text-md font-medium text-gray-700">
                                        Email:</label>
                                    <input id="modal-permintaan-email" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="rekening" class="w-32 text-md font-medium text-gray-700">
                                        Rekening:</label>
                                    <input id="modal-permintaan-rekening" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                        Kamar:</label>
                                    <input id="modal-permintaan-kamar" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="rentang" class="w-32 text-md font-medium text-gray-700">
                                        Rentang:</label>
                                    <input id="modal-permintaan-rentang" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tgl_masuk" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Masuk:</label>
                                    <input id="modal-permintaan-tgl_masuk" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                {{-- AJAX DATA DIRI --}}
                                <div id="dataDiri-permintaan-container"></div>
                                
                            </div>
                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                <form action="{{ route('penghuni.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" id="modal-tolak-idKontrak" name="idKontrak">
                                    <button type="submit"
                                        class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-600">
                                        Tolak
                                    </button>
                                </form>
                                <button type="button" data-toggle="modal" data-target="#ModalTerima"
                                    class="lihat-detail-permintaan rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                    data-dismiss="modal">
                                    Terima
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL TERIMA --}}
                <div class="modal fade p-4" id="ModalTerima" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <form action="{{ route('penghuni.store') }}" method="POST">
                                @csrf
                                {{-- header --}}
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Atur Penerimaan</h3>
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
                                    <div class="flex items-center space-x-4">
                                        <label for="kamar" class="w-32 text-md font-medium text-gray-700">Kamar:</label>
                                        <input id="modal-atur-kamar" type="text" value="" name="idKamar" 
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" 
                                            disabled>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                            Nama Penyewa:</label>
                                        <input id="modal-atur-nama" type="text" value=""
                                            name="nama"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            disabled>
                                    </div>

                                    <div class="text-center">
                                        <p class="text-gray-500 text-sm">Masukan Keterangan Kontrak</p>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="tempo" class="w-32 text-md font-medium text-gray-700">
                                            Tanggal Tagihan:</label>
                                        <input id="modal-atur-tgl_tagihan" type="date" value=""
                                            name="tgl_tagihan"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            required>
                                    </div>

                                    @if ($tabelDenda)
                                        <div class="flex items-center space-x-4">
                                            <label for="tempo" class="w-32 text-md font-medium text-gray-700">
                                                Tanggal Denda:</label>
                                            <input id="modal-atur-tgl_denda" type="date" value=""
                                                name="tgl_denda"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                        </div>
                                    @endif

                                    {{-- Bagian biaya kontrak --}}
                                    @if (!empty($biayaList))
                                        <div class="text-center mt-2">
                                            <p class="text-gray-500 text-sm">Masukan Biaya Pada Kontrak</p>
                                        </div>

                                        {{-- biaya --}}
                                        <div id="tambah-biaya-container" class="flex">
                                            <label for="biaya" class="w-32 text-md font-medium text-gray-700 mr-3">
                                            Biaya Kontrak:</label>
                                            <div id="biaya-container">
                                                @foreach ($biayaList as $biaya)
                                                    <div class="flex gap-x-2">
                                                        <!-- Checkbox untuk biaya -->
                                                        <input checked id="biaya_{{ $biaya->idBiaya }}" name="idBiaya[]"
                                                            type="checkbox" value="{{ $biaya->idBiaya }}"
                                                            class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">

                                                        <!-- Label untuk checkbox -->
                                                        <label for="biaya_{{ $biaya->idBiaya }}"
                                                            class="text-md font-medium text-gray-900 pr-4">
                                                            {{ $biaya->biaya }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- keterangan --}}
                                    <div class="flex items-center space-x-4 mt-4">
                                        <label for="keterangan"
                                            class="w-32 text-md font-medium text-gray-700">
                                            Keterangan:</label>
                                        <textarea id="modal-revisi-keterangan" type="text" value="" rows="2" name="keterangan"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"></textarea>
                                    </div>

                                    <input type="hidden" id="modal-atur-idKontrak" name="idKontrak">

                                </div>
                                {{-- SUBMIT --}}
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button type="submit" name="action" data-toggle="modal"
                                        data-target="#ModalSuksesRevisiPembayaran"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>

        <!-- PAGE TAMBAH PENGHUNI -->
        <section id="tambahPenghuni" class="hidden">
            {{-- Setting Denda --}}
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Form Pembuatan Kontrak</h1>

                <div class="detailAturanDenda relative group" data-toggle="modal" data-target="#ModalAturDenda"
                    id="detailAturanDenda" data-id="1">
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-12 w-12 text-gray-900 transition-transform transform group-hover:scale-125 group-hover:rotate-45 cursor-pointer"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                        <path
                            d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                    </svg>
                    <!-- Tooltip -->
                    <div
                        class="text-center absolute left-1/2 transform -translate-x-1/2 top-12 bg-gray-500 text-white text-sm rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        Pengaturan Denda
                    </div>
                </div>

                {{-- MODAL PENGATURAN DENDA --}}
                @if ($tabelDenda)
                    <div class="modal fade p-4" id="ModalAturDenda" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                <form action="{{ route('aturan.denda') }}" method="POST">
                                    @csrf
                                    {{-- header --}}
                                    <div class="modal-header border-b border-gray-200 py-4 px-6">
                                        <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Pengaturan
                                            Denda Penghuni</h3>
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
                                    <form action="{{ route('aturan.denda') }}" method="POST" class="mt-8">
                                        <div class="modal-body p-6 space-y-2">
                                            <!-- AJAX -->
                                            <input type="hidden" name="idDenda" value="1">

                                            <div class="flex items-center space-x-4 pb-3">
                                                <label for="jenis_denda"
                                                    class="w-32 text-md font-medium text-gray-700">
                                                    Tipe Denda:</label>
                                                <select required id="modal-buat-jenis_denda" name="jenis_denda"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                                    <option value="Nominal">Nominal</option>
                                                    <option value="Perhari">Perhari</option>
                                                    <option value="Persen">Persen</option>
                                                </select>
                                            </div>

                                            <div class="text-center">
                                                <p class="text-gray-500 text-sm">Masukan Nominal/Persen sesuai dengan
                                                    rentang kontrak</p>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="angka" class="w-32 text-md font-medium text-gray-700">
                                                    Angka Kontrak Bulan:</label>
                                                <input required id="modal-buat-angka" type="number" value=""
                                                    name="angka" placeholder="Nominal Rp atau %"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="angka_mingguan"
                                                    class="w-32 text-md font-medium text-gray-700">
                                                    Angka Kontrak Mingguan:</label>
                                                <input required id="modal-buat-angka_mingguan" type="number"
                                                    value="" name="angka_mingguan"
                                                    placeholder="Nominal Rp atau %"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="angka_harian"
                                                    class="w-32 text-md font-medium text-gray-700">
                                                    Angka Kontrak Harian:</label>
                                                <input required id="modal-buat-angka_harian" type="number"
                                                    value="" name="angka_harian"
                                                    placeholder="Nominal Rp atau %"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                            </div>

                                        </div>
                                        {{-- SUBMIT --}}
                                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                            <button type="submit"
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Buat Aturan
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
                @endif
            </div>

            {{-- FORM TAMBAH KONTRAK --}}
            <form action="{{ route('kontrak.store') }}" method="POST" class="mt-8">
                @csrf
                {{-- IMPORTANT FORM --}}
                <div class="space-y-12">
                    <!-- Bagian Akun Penghuni -->
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Akun Penghuni*</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Informasi akun yang digunakan untuk login dan
                            verifikasi penghuni.</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
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

                            <div class="sm:col-span-4">
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Kata
                                    Sandi</label>
                                <div class="mt-2">
                                    <input required type="text" name="password" id="password"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Kontak -->
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Informasi Kontrak*</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Data informasi kontrak yang dibuat dengan
                            penghuni kos.</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            {{-- kamar --}}
                            <div class="sm:col-span-4">
                                <label for="kamar" class="block font-medium mb-2">Kamar:</label>
                                <select required id="kamar" name="kamar"
                                    class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
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
                                    <input required id="email" name="email" type="email"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- bank --}}
                            <div class="sm:col-span-2 sm:col-start-1">
                                <label for="bank" class="block text-sm font-medium leading-6 text-gray-900">Bank
                                    Utama</label>
                                <div class="mt-2">
                                    <select id="bank" name="bank" required
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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

                            {{-- rentang kontrak --}}
                            <div class="sm:col-span-2 sm:col-start-1">
                                <label for="kontrak"
                                    class="block text-sm font-medium leading-6 text-gray-900">Rentang Kontrak</label>
                                <div class="mt-2">
                                    <select required name="kontrak" id="kontrak"
                                        class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option>Bulan</option>
                                        <option>Mingguan</option>
                                        <option>Harian</option>
                                    </select>
                                </div>

                                {{-- waktu rentang visible + kirim harga ke controller --}}
                                <script>
                                    document.addEventListener('DOMContentLoaded', () => {
                                        const kontrakDropdown = document.getElementById('kontrak'); // Dropdown kontrak
                                        const waktuInput = document.getElementById('waktu'); // Input waktu tinggal
                                        const waktuContainer = document.getElementById('waktu-container'); // Container waktu tinggal

                                        const waktuTagihanContainer = document.getElementById(
                                            'waktu-tagihan-container'); // Container waktu tagihan
                                        const waktuDendaContainer = document.getElementById('waktu-denda-container'); // Container waktu denda
                                        const waktuTagihanInput = document.getElementById('waktu_tagihan');
                                        const waktuDendaInput = document.getElementById('waktu_denda');

                                        const updateVisibility = () => {
                                            const selectedKontrak = kontrakDropdown.value;

                                            if (selectedKontrak === 'Bulan') {
                                                // Jika opsi Bulanan dipilih
                                                waktuContainer.classList.add('hidden'); // Sembunyikan waktu tinggal
                                                waktuInput.value = 1; // Reset nilai waktu tinggal

                                                waktuTagihanContainer.classList.remove('hidden'); // Tampilkan waktu tagihan
                                                waktuDendaContainer.classList.remove('hidden'); // Tampilkan waktu denda

                                                // nonaktifkan validasi
                                                waktuTagihanInput.required = true;
                                                waktuDendaInput.required = true;
                                            } else {
                                                // Jika opsi Mingguan atau Harian dipilih
                                                waktuContainer.classList.remove('hidden'); // Tampilkan waktu tinggal
                                                waktuTagihanInput.value = 1;
                                                waktuDendaInput.value = 1;

                                                waktuTagihanContainer.classList.add('hidden'); // Sembunyikan waktu tagihan
                                                waktuDendaContainer.classList.add('hidden'); // Sembunyikan waktu denda

                                                // nonaktifkan validasi
                                                waktuTagihanInput.required = false;
                                                waktuDendaInput.required = false;
                                            }
                                        };

                                        // Jalankan saat halaman dimuat
                                        updateVisibility();

                                        // Tambahkan event listener untuk dropdown kontrak
                                        kontrakDropdown.addEventListener('change', updateVisibility);
                                    });
                                </script>
                            </div>

                            {{-- waktu tagihan pertanggalnya --}}
                            <div id="waktu-tagihan-container" class="sm:col-span-1">
                                <label for="waktu_tagihan"
                                    class="block text-sm font-medium leading-6 text-gray-900">Pertanggal
                                    Tagihan</label>
                                <div class="mt-2">
                                    <input required type="number" name="waktu_tagihan" id="waktu_tagihan"
                                        max="31" min="1"
                                        class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- tanggal denda pertanggalnya  --}}
                            @if ($tabelDenda)
                                <div id="waktu-denda-container" class="sm:col-span-1">
                                    <label for="waktu_denda"
                                        class="block text-sm font-medium leading-6 text-gray-900">Pertanggal Denda</label>
                                    <div class="mt-2">
                                        <input type="number" name="waktu_denda" id="waktu_denda"
                                            max="31" min="1"
                                            class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <span id="error-message" class="text-red-500 text-sm hidden">Denda tidak boleh
                                            lebih kecil dari tanggal tagihan.</span>

                                        {{-- CHECK PERTANGGAL TIDAK BOLEH KURANG --}}
                                        <script>
                                            const waktuTagihan = document.getElementById('waktu_tagihan');
                                            const waktuDenda = document.getElementById('waktu_denda');
                                            const errorMessage = document.getElementById('error-message');

                                            function validateDates() {
                                                const tagihanValue = parseInt(waktuTagihan.value, 10);
                                                const dendaValue = parseInt(waktuDenda.value, 10);

                                                // Check if dendaValue is smaller than tagihanValue
                                                if (dendaValue < tagihanValue) {
                                                    errorMessage.classList.remove('hidden'); // Show error message
                                                    waktuDenda.setCustomValidity('Tanggal denda tidak boleh lebih kecil dari tanggal tagihan.');
                                                } else {
                                                    errorMessage.classList.add('hidden'); // Hide error message
                                                    waktuDenda.setCustomValidity(''); // Reset validity
                                                }
                                            }

                                            // Attach event listeners
                                            waktuTagihan.addEventListener('input', validateDates);
                                            waktuDenda.addEventListener('input', validateDates);
                                        </script>
                                    </div>
                                </div>
                            @endif

                            {{-- tinggalnya (mingguan/harian) --}}
                            <div id="waktu-container" class="sm:col-span-2">
                                <label for="waktu" class="block text-sm font-medium leading-6 text-gray-900">Waktu
                                    Tinggal (Minggu/Hari)</label>
                                <div class="mt-2">
                                    <input required id="waktu" name="waktu" type="number"
                                        placeholder="Masukkan jumlah minggu/hari"
                                        class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- tgl masuk --}}
                            <div class="sm:col-span-2 sm:col-start-1">
                                <label for="masuk"
                                    class="block text-sm font-medium leading-6 text-gray-900">Tanggal Masuk</label>
                                <div class="mt-2">
                                    <input required type="date" name="masuk" id="masuk"
                                        class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- tgl tagihan --}}
                            <div class="sm:col-span-1">
                                <label for="tagihan"
                                    class="block text-sm font-medium leading-6 text-gray-900">Tanggal Tagihan</label>
                                <div class="mt-2">
                                    <input required type="date" name="tagihan" id="tagihan"
                                        class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- tgl denda --}}
                            @if ($tabelDenda)
                                <div class="sm:col-span-1">
                                    <label for="denda"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tanggal Denda</label>
                                    <div class="mt-2">
                                        <input type="date" name="denda" id="denda"
                                            class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                            @endif

                            {{-- nominal deposit --}}
                            <div class="sm:col-span-1 sm:col-start-1">
                                <label for="deposit" class="block text-sm font-medium leading-6 text-gray-900">Nominal Deposit</label>
                                <div class="mt-2">
                                    <input id="deposit" 
                                        type="text" <!-- Ubah type="number" ke "text" 
                                        class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <input type="hidden" name="deposit" id="hidden_deposit"> 
                                </div>
                            </div>

                            {{-- total pembayaran --}}
                            <div class="sm:col-span-3">
                                <label for="pembayaran" class="block text-sm font-medium leading-6 text-gray-900">Total Nominal Pembayaran</label>
                                <div class="mt-2">
                                    <input readonly 
                                        id="pembayaran" 
                                        name="pembayaran" 
                                        type="text"
                                        class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <input type="hidden" name="pembayaran" id="hidden_pembayaran">
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Bagian biaya kontrak --}}
                    @if (!empty($biayaList))
                        <div class="border-b border-gray-900/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Biaya Fasilitas Kontrak*</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Fasilitas yang terkandung dalam kontrak
                                <i>(Nominal biaya akan ditambahan pada nota saat pembayaran).</i>
                            </p>

                            <div class="mt-3 mb-4 space-y-10">
                                {{-- biaya --}}
                                <div id="tambah-biaya-container" class="mt-8">
                                    @foreach ($biayaList as $biaya)
                                        <div class="flex gap-x-2 items-center mt-2">
                                            <!-- Checkbox untuk biaya -->
                                            <input checked id="biaya_{{ $biaya->idBiaya }}" name="idBiaya[]"
                                                type="checkbox" value="{{ $biaya->idBiaya }}"
                                                class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">

                                            <!-- Label untuk checkbox -->
                                            <label for="biaya_{{ $biaya->idBiaya }}"
                                                class="text-sm font-medium text-gray-900">
                                                {{ $biaya->biaya }}
                                                <a href="#" data-id="{{ $biaya->idBiaya }}"
                                                    class="hapus-biaya text-sm py-1 px-3"> ❌ </a>
                                            </label>

                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <a href="#" data-toggle="modal" data-target="#ModalTambahBiaya"
                                class="mt-3 text-sm leading-6 text-gray-600 mr-4">
                                <span aria-hidden="true">+</span> Tambah Biaya Baru</a>

                        </div>
                    @endif

                    {{-- Bagian data diri penghuni --}}
                    @if (!empty($dataDiriList))
                        <div class="border-b border-gray-900/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Data Diri Penghuni*</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Data Diri Penghuni yang tinggal</p>

                            <div class="mt-10 mb-3 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                {{-- data diri --}}
                                @foreach ($dataDiriList as $data)
                                    <div class="sm:col-span-3 sm:col-start-1">
                                        <label for="deskripsi_{{ $data->idListDataDiri }}"
                                            class="block text-sm font-medium leading-6 text-gray-900">{{ $data->data_diri }}</label>
                                        <div class="mt-2 flex">
                                            <input required type="text" name="deskripsi[]"
                                                id="deskripsi_{{ $data->idListDataDiri }}"
                                                class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <input required type="hidden" name="idListDataDiri[]"
                                                value="{{ $data->idListDataDiri }}">
                                            <a href="#" data-id="{{ $data->idListDataDiri }}"
                                                class="hapus-dataDiri text-red-600 text-sm py-1 px-3">Hapus</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <a href="#" data-toggle="modal" data-target="#ModalTambahDataDiri"
                                class="text-sm leading-6 text-gray-600 mr-4">
                                <span aria-hidden="true">+</span> Tambah Data Diri Baru</a>

                        </div>
                    @endif

                    <!-- Bagian Keterangan -->
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Keterangan</h2>
                        <div class="mt-2">
                            <textarea id="keterangan" name="keterangan" rows="3"
                                class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Bagian ini bersifat optional</p>
                    </div>

                    {{-- Bagian Submit --}}
                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                        <button type="submit" data-toggle="modal" data-target="#ModalSuksesBuat"
                            class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                    </div>
            </form>

            {{-- MODAL TAMBAH DATA DIRI --}}
            <div class="modal fade p-4" id="ModalTambahDataDiri" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                    <form action="{{ route('datadiri.store') }}" method="POST"
                        class="modal-content rounded-lg shadow-lg bg-white">
                        @csrf
                        {{-- Header modal --}}
                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Tambah Data Diri</h3>
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
                                <label for="tambah-dataDiri" class="w-32 text-md font-medium text-gray-700">Tambah
                                    Baru:</label>
                                <input required id="tambah-dataDiri" name="dataDiri" type="text" value=""
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                            </div>
                        </div>
                        {{-- Footer --}}
                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                            <button type="submit"
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

            {{-- MODAL TAMBAH BIAYA FASILITAS --}}
            <div class="modal fade p-4" id="ModalTambahBiaya" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                    <form action="{{ route('biaya.store') }}" method="POST"
                        class="modal-content rounded-lg shadow-lg bg-white">
                        @csrf
                        {{-- Header modal --}}
                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Tambah Biaya Fasilitas
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
                                <label for="tambah-biaya" class="w-32 text-md font-medium text-gray-700">Tambah
                                    Baru:</label>
                                <input required id="tambah-biaya" name="biaya" type="text" value=""
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                            </div>
                        </div>
                        {{-- Footer --}}
                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                            <button type="submit"
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

        </section>

        {{-- PAGE LIST PENGHUNI --}}
        <section id="listPenghuni" class="hidden">
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Penyewa</th>
                            <th class="py-3 px-4">No Telp</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse($penghuni as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->no_telp }}</td>
                                <td class="py-3 px-4">{{ $item->status }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->id }}" data-toggle="modal"
                                        data-target="#ModalPenghuni"
                                        class="lihat-detail-penghuni text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada data penghuni
                                    untuk kos ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalPenghuni" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Penghuni
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
                            <div class="modal-body p-6 space-y-2">
                                <!-- AJAX -->
                                <div class="flex items-center space-x-4">
                                    <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                        Kamar:</label>
                                    <input id="modal-kamar" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                        Nama Penyewa:</label>
                                    <input id="modal-nama" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="telp" class="w-32 text-md font-medium text-gray-700">
                                        No Telp:</label>
                                    <input id="modal-telp" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="email" class="w-32 text-md font-medium text-gray-700">
                                        Email:</label>
                                    <input id="modal-email" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="rekening" class="w-32 text-md font-medium text-gray-700">
                                        Rekening:</label>
                                    <input id="modal-rekening" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="status" class="w-32 text-md font-medium text-gray-700">
                                        Status:</label>
                                    <input id="modal-status" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                {{-- AJAX DATA DIRI --}}
                                <div id="dataDiri-container"></div>

                            </div>
                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
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
    </main>
</x-layout>


{{-- HARGA --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Inisialisasi Cleave untuk format currency
        const cleaveDeposit = new Cleave('#deposit', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalMark: ',',
            delimiter: '.',
            onValueChanged: function(e) {
                document.getElementById('hidden_deposit').value = e.target.rawValue;
            }
        });

        const cleavePembayaran = new Cleave('#pembayaran', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalMark: ',',
            delimiter: '.'
        });

        // Set nilai awal dari PHP
        cleaveDeposit.setRawValue("{{ $default->nominal_deposit ?? 0 }}");
        document.getElementById('hidden_deposit').value = cleaveDeposit.getRawValue();
        
        const kontrakDropdown = document.getElementById('kontrak');
        const kamarDropdown = document.getElementById('kamar');
        const waktuInput = document.getElementById('waktu');

        const updateHarga = () => {
            const selectedKamar = kamarDropdown.options[kamarDropdown.selectedIndex];
            const selectedKontrak = kontrakDropdown.value;

            // Ambil nilai numerik dari atribut data
            const hargaBulan = parseFloat(selectedKamar.getAttribute('data-harga')) || 0;
            const hargaMingguan = parseFloat(selectedKamar.getAttribute('data-mingguan')) || 0;
            const hargaHarian = parseFloat(selectedKamar.getAttribute('data-harian')) || 0;

            // Tentukan harga sesuai kontrak
            let harga = hargaBulan;
            if (selectedKontrak === 'Mingguan') harga = hargaMingguan;
            if (selectedKontrak === 'Harian') harga = hargaHarian;

            // Ambil nilai waktu dan deposit
            const deposit = parseInt(document.getElementById('hidden_deposit').value) || 0;
            const waktu = parseInt(waktuInput.value) || 1;

            const totalHarga = (harga * waktu) + deposit;

            // Update dengan format currency
            cleavePembayaran.setRawValue(totalHarga.toString());
            
            // Untuk kebutuhan form submission
            document.getElementById('pembayaran').dataset.rawValue = totalHarga;
            document.getElementById('hidden_pembayaran').value = totalHarga;
        };

        // Event listeners
        [kontrakDropdown, kamarDropdown, waktuInput].forEach(element => {
            element.addEventListener('change', updateHarga);
        });

        document.getElementById('deposit').addEventListener('input', updateHarga);
        
        // Inisialisasi pertama kali
        updateHarga();
    });
</script>

{{-- Format Currency untuk Input Lain --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Format untuk input dinamis biaya
        $(document).on('DOMNodeInserted', '.biaya-input', function() {
            new Cleave(this, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                numeralDecimalMark: ',',
                delimiter: '.'
            });
        });

        // Format untuk input lainnya
        const cleaveConfig = {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalMark: ',',
            delimiter: '.'
        };
        
        new Cleave('#modal-kamar-harga', cleaveConfig);
        new Cleave('#modal-kamar-mingguan', cleaveConfig);
        new Cleave('#modal-kamar-harian', cleaveConfig);
    });
</script>

{{-- EDIT TANGGAL --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tanggalMasukInput = document.getElementById('masuk');
        const tanggalTagihanInput = document.getElementById('tagihan');
        const tanggalDendaInput = document.getElementById('denda');

        // Fungsi untuk mendapatkan tanggal hari ini dalam format yyyy-mm-dd
        const getTodayDate = () => {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        // Set nilai default untuk tanggal masuk ke hari ini
        const today = getTodayDate();
        tanggalMasukInput.value = today;

        // Set tanggal minimal untuk semua input tanggal
        tanggalMasukInput.setAttribute('min', today);
        tanggalTagihanInput.setAttribute('min', today);
        tanggalDendaInput.setAttribute('min', today);

        // Event listener untuk memastikan tanggal denda tidak kurang dari tanggal tagihan
        tanggalTagihanInput.addEventListener('change', () => {
            const tanggalTagihan = tanggalTagihanInput.value;
            if (tanggalTagihan) {
                tanggalDendaInput.setAttribute('min', tanggalTagihan);
            }
        });

        // Event listener untuk validasi manual tanggal denda
        tanggalDendaInput.addEventListener('change', () => {
            const tanggalTagihan = tanggalTagihanInput.value;
            const tanggalDenda = tanggalDendaInput.value;

            if (tanggalDenda < tanggalTagihan) {
                alert('Tanggal denda tidak boleh kurang dari tanggal tagihan.');
                tanggalDendaInput.value = tanggalTagihan; // Reset ke nilai valid
            }
        });
    });
</script>

{{-- HAPUS DATA DIRI + BIAYA  --}}
<script>
    $('.hapus-biaya').on('click', function() {
        var idBiaya = $(this).data('id'); // Ambil ID peraturan dari data-id

        if (confirm('Apakah Anda yakin ingin menghapus Biaya ini?')) {
            $.ajax({
                url: '/penghuni/hapus-biaya/' + idBiaya, // Sesuaikan URL untuk menghapus peraturan
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' // Token CSRF untuk keamanan
                },
                success: function(response) {
                    alert(response.message); // Menampilkan pesan sukses
                    location.reload(); // Reload halaman untuk memperbarui data
                },
                error: function(xhr) {
                    alert('Gagal menghapus Biaya. Silakan coba lagi.'); // Menampilkan pesan error
                }
            });
        }
    });

    $('.hapus-dataDiri').on('click', function() {
        var idListDataDiri = $(this).data('id'); // Ambil ID peraturan dari data-id

        if (confirm('Apakah Anda yakin ingin menghapus Data ini?')) {
            $.ajax({
                url: '/penghuni/hapus-dataDiri/' +
                    idListDataDiri, // Sesuaikan URL untuk menghapus peraturan
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' // Token CSRF untuk keamanan
                },
                success: function(response) {
                    alert(response.message); // Menampilkan pesan sukses
                    location.reload(); // Reload halaman untuk memperbarui data
                },
                error: function(xhr) {
                    alert('Gagal menghapus Data. Silakan coba lagi.'); // Menampilkan pesan error
                }
            });
        }
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

{{-- AJAX DETAIL --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-permintaan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/penghuni/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-permintaan-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-permintaan-nama').val(data.data.nama);
                    $('#modal-permintaan-telp').val(data.data.no_telp);
                    $('#modal-permintaan-email').val(data.data.email);
                    $('#modal-permintaan-rekening').val(data.data.metode + ' - ' + data.data.nomor_tujuan);
                    $('#modal-permintaan-rentang').val((data.data.waktu ? data.data.waktu : '') + ' ' + data.data.rentang);
                    $('#modal-permintaan-tgl_masuk').val(data.data.tgl_masuk);

                    // menambahkan data diri kedalaam modal
                    $('#dataDiri-permintaan-container').empty();

                    $.each(data.dataDiriList, function(index, dataDiri) {
                        $('#dataDiri-permintaan-container').append(`
                            <div class="mb-2 flex items-center space-x-4">
                            <label for="${dataDiri.data_diri}" class="w-32 text-md font-medium text-gray-700">${dataDiri.data_diri}:</label>
                                <input required type="text" id="${dataDiri.data_diri}" name="${dataDiri.data_diri}" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" 
                                value="${dataDiri.deskripsi}">
                            </div>
                        `);
                    });

                    $('#modal-atur-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-atur-nama').val(data.data.nama);
                    $('#modal-atur-tgl_masuk').val(data.data.tgl_masuk);
                    $('#modal-atur-idKontrak').val(data.data.idKontrak);
                    $('#modal-tolak-idKontrak').val(data.data.idKontrak);
                }
            });
        });

        $('.lihat-detail-penghuni').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // AJAX untuk mengambil data penghuni
            $.ajax({
                url: '/penghuni/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-nama').val(data.data.nama);
                    $('#modal-telp').val(data.data.no_telp);
                    $('#modal-email').val(data.data.email);
                    $('#modal-rekening').val(data.data.metode + ' - ' + data.data.nomor_tujuan);
                    $('#modal-status').val(data.data.status);

                    // menambahkan data diri kedalaam modal
                    $('#dataDiri-container').empty();

                    $.each(data.dataDiriList, function(index, dataDiri) {
                        $('#dataDiri-container').append(`
                            <div class="mb-2 flex items-center space-x-4">
                            <label for="${dataDiri.data_diri}" class="w-32 text-md font-medium text-gray-700">${dataDiri.data_diri}:</label>
                                <input required type="text" id="${dataDiri.data_diri}" name="${dataDiri.data_diri}" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" 
                                value="${dataDiri.deskripsi}">
                            </div>
                        `);
                    });
                }
            });
        });

        $('.detailAturanDenda').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // AJAX untuk mengambil data penghuni
            $.ajax({
                url: '/penghuni/detailAturanDenda/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-buat-jenis_denda').val(data.data.jenis_denda || '');
                    $('#modal-buat-angka').val(data.data.angka || '');
                    $('#modal-buat-angka_mingguan').val(data.data.angka_mingguan || '');
                    $('#modal-buat-angka_harian').val(data.data.angka_harian || '');

                }
            });
        });
    });
</script>

{{-- batas tgl --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const tglTagihanInput = document.getElementById('modal-atur-tgl_tagihan');
        const tglDendaInput = document.getElementById('modal-atur-tgl_denda');

        // Set minimum date for tanggal tagihan to today
        tglTagihanInput.setAttribute('min', today);

        tglTagihanInput.addEventListener('change', function() {
            const selectedTglTagihan = tglTagihanInput.value;

            // Set minimum date for tanggal denda to selected tanggal tagihan
            tglDendaInput.setAttribute('min', selectedTglTagihan);
        });

        tglDendaInput.addEventListener('change', function() {
            const selectedTglDenda = tglDendaInput.value;
            const selectedTglTagihan = tglTagihanInput.value;

            if (selectedTglDenda < selectedTglTagihan) {
                alert('Tanggal denda tidak boleh kurang dari tanggal tagihan.');
                tglDendaInput.value = ''; // Clear the input
            }
        });
    });
</script>

{{-- SETTING HARGA DROPDOWN RENTANG --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const kamarDropdown = document.getElementById('kamar'); // Dropdown kamar
        const kontrakDropdown = document.getElementById('kontrak'); // Dropdown kontrak

        // Fungsi untuk memperbarui opsi rentang kontrak berdasarkan kamar yang dipilih
        const updateRentangKontrak = () => {
            const selectedKamar = kamarDropdown.options[kamarDropdown.selectedIndex]; // Opsi kamar terpilih
            const hargaMingguan = selectedKamar.getAttribute('data-mingguan'); // Ambil harga mingguan
            const hargaHarian = selectedKamar.getAttribute('data-harian'); // Ambil harga harian

            // Reset dropdown kontrak ke opsi default
            kontrakDropdown.innerHTML = `
                <option value="Bulan">Bulan</option>
                ${hargaMingguan ? '<option value="Mingguan">Mingguan</option>' : ''}
                ${hargaHarian ? '<option value="Harian">Harian</option>' : ''}
            `;
        };

        // Jalankan fungsi saat dropdown kamar berubah
        kamarDropdown.addEventListener('change', updateRentangKontrak);

        // Jalankan fungsi saat halaman dimuat untuk inisialisasi
        updateRentangKontrak();
    });
</script>

<script>
    const cleaveDeposit = new Cleave('#deposit', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        numeralDecimalMark: ',',
        delimiter: '.'
    });
    const cleavePembayaran = new Cleave('#pembayaran', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        numeralDecimalMark: ',',
        delimiter: '.'
    });
</script>