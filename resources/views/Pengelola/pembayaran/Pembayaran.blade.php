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
                    <a href="#list" id="btnList" onclick="switchPage('list')"
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">
                        Pembayaran</a>
                    <a href="#riwayat" id="btnRiwayat" onclick="switchPage('riwayat')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                        Riwayat Pembayaran</a>
                </nav>
            </div>

            @php
                $tabelDenda = Schema::hasTable('denda');
            @endphp

            {{-- JS --}}
            <script>
                function switchPage(page) {
                    const listSection = document.getElementById('list');
                    const riwayatSection = document.getElementById('riwayat');

                    // Buttons
                    const btnList = document.getElementById('btnList');
                    const btnRiwayat = document.getElementById('btnRiwayat');

                    // Sembunyikan semua section
                    listSection.classList.add('hidden');
                    riwayatSection.classList.add('hidden');

                    // Nonaktifkan semua tombol
                    btnList.classList.remove('bg-indigo-600', 'text-white');
                    btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

                    btnRiwayat.classList.remove('bg-indigo-600', 'text-white');
                    btnRiwayat.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

                    // Tampilkan section dan aktifkan tombol sesuai halaman
                    if (page === 'list') {
                        listSection.classList.remove('hidden');
                        btnList.classList.add('bg-indigo-600', 'text-white');
                        btnList.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'riwayat') {
                        riwayatSection.classList.remove('hidden');
                        btnRiwayat.classList.add('bg-indigo-600', 'text-white');
                        btnRiwayat.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    }

                    // Memberikan sedikit delay sebelum scroll
                    setTimeout(function() {
                        window.scrollTo(0, 0);
                    }, 50);
                }
            </script>
        </section>

        <!-- PAGE PEMBAYARAN -->
        <section id="list" class="block">
            {{-- BUAT TAGIHAN --}}
            @if ($tagihanBulanan->isNotEmpty() || $tagihanNonBulanan->isNotEmpty())
                <div>
                    <p class="text-sm text-gray-500 mb-3 px-3">Buat tagihan pembayaran kos</p>
                    <table class="min-w-full table-auto bg-white rounded-lg shadow-md mb-5">
                        <thead class="bg-gray-100">
                            <tr class="text-left text-sm text-gray-600">
                                <th class="py-3 px-4">Kamar</th>
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">Tanggal Tagihan</th>
                                <th class="py-3 px-4">Rentang Waktu</th>
                                <th class="py-2 px-4">Tagihan</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @foreach ($tagihanBulanan as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                    <td class="py-3 px-4">{{ $item->nama }}</td>
                                    <td class="py-3 px-4">{{ $item->tgl_tagihan }}</td>
                                    <td class="py-3 px-4">{{ $item->waktu . ' ' . $item->rentang }}</td>
                                    <td class="py-3 px-4">
                                        <a href="#" data-id="{{ $item->idKontrak }}" data-toggle="modal"
                                            data-target="#ModalBuatTagihan"
                                            class="buat-pembayaran text-indigo-500 hover:text-indigo-700 transition">
                                            Buat Pembayaran <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($tagihanNonBulanan as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                    <td class="py-3 px-4">{{ $item->nama }}</td>
                                    <td class="py-3 px-4">{{ $item->tgl_tagihan }}</td>
                                    <td class="py-3 px-4">{{ $item->waktu . ' ' . $item->rentang }}</td>
                                    <td class="py-3 px-4">
                                        <a href="#" data-id="{{ $item->idKontrak }}" data-toggle="modal"
                                            data-target="#ModalBuatTagihan"
                                            class="buat-pembayaran text-indigo-500 hover:text-indigo-700 transition">
                                            Buat Pembayaran <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- MODAL DATA --}}
                    <div class="modal fade p-4" id="ModalBuatTagihan" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                <form action="{{ route('tagihan.store') }}" method="POST">
                                    @csrf
                                    {{-- header --}}
                                    <div class="modal-header border-b border-gray-200 py-4 px-6">
                                        <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">BUAT TAGIHAN
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
                                            <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                                Kamar:</label>
                                            <input id="modal-buat-kamar" type="text" value="" name="idKamar"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                disabled>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                                Nama Penyewa:</label>
                                            <input id="modal-buat-nama" type="text" value="" name="nama"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                disabled>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="tagihan" class="w-32 text-md font-medium text-gray-700">
                                                Tanggal Tagihan:</label>
                                            <input id="modal-buat-tagihan" type="date" value=""
                                                name="buatTagihan"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        @if ($tabelDenda)
                                            <div class="flex items-center space-x-4">
                                                <label for="tempo" class="w-32 text-md font-medium text-gray-700">
                                                    Tanggal Denda:</label>
                                                <input id="modal-buat-denda" type="date" value=""
                                                    name="buatDenda"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    readonly>
                                            </div>
                                        @endif

                                        <div class="text-center">
                                            <p class="text-gray-500 text-sm">Nominal Pembayaran</p>
                                        </div>

                                        {{-- rentang --}}
                                        <div class="flex items-center space-x-4 mt-4">
                                            <label for="rentang" class="w-32 text-md font-medium text-gray-700">
                                                Rentang:</label>
                                            <input id="modal-buat-rentang" type="text" value=""
                                                name="buatRentang"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        {{-- harga --}}
                                        <div class="flex items-center space-x-4">
                                            <label for="harga" class="w-32 text-md font-medium text-gray-700">Harga Kamar:</label>
                                            <input id="modal-buat-total" type="text" 
                                                   name="total"
                                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                   readonly>
                                        </div>

                                        {{-- deposit --}}
                                        <div class="flex items-center space-x-4" id="deposit-container">
                                            <label for="deposit" class="w-32 text-md font-medium text-gray-700">Deposit:</label>
                                            <input id="modal-buat-deposit" type="text" 
                                                   name="deposit"
                                                   class="flex-1 px-4 py-2 border border-gray-500 rounded-md focus:outline-none focus:ring-0"
                                                   readonly>
                                        </div>

                                        <!-- Container untuk biayaList yang akan diisi melalui AJAX -->
                                        <div id="buat-biaya-container"></div>

                                        {{-- total bayar --}}
                                        <div class="flex items-center space-x-4 mt-4">
                                            <label for="total_bayar" class="w-32 text-md font-medium text-gray-700">Total Bayar:</label>
                                            <input id="total_bayar" type="text" 
                                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                   readonly>
                                            <input id="hidden_total_bayar" type="hidden" name="total_bayar">
                                        </div>

                                        {{-- Input Hidden idkontrak insert db + waktu buat update harga --}}
                                        <input id="modal-buat-kontrak" type="hidden" name="idKontrak"
                                            value="">
                                        <input id="modal-buat-waktu" type="hidden" name="waktu" value="">

                                        <input id="modal-buat-rentang" type="hidden" name="rentang" value="">

                                        {{-- keterangan --}}
                                        <div class="flex items-center space-x-4 mt-4">
                                            <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                                Keterangan:</label>
                                            <textarea id="modal-buat-keterangan" type="text" value="" rows="2" name="keterangan"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"></textarea>
                                        </div>

                                        {{-- TAGIHAN NEW --}}
                                        <div id="waktu_tagihan_denda_update">
                                            <div class="text-center">
                                                <p class="text-gray-500 text-sm">Tanggal tagihan dan denda untuk
                                                    periode berikutnya</p>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                                    Tagihan Berikutnya:</label>
                                                <input id="modal-buat-tagihanBerikutnya" type="date"
                                                    value="" name="tagihanBerikutnya"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    required readonly>
                                            </div>

                                            @if ($tabelDenda)
                                                <div class="flex items-center space-x-4">
                                                    <label for="tanggal"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Denda Berikutnya:</label>
                                                    <input id="modal-buat-dendaBerikutnya" type="date"
                                                        value="" name="dendaBerikutnya"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- SUBMIT --}}
                                    <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                        <button type="button"
                                            class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                            data-dismiss="modal">
                                            Tutup
                                        </button>
                                        <button type="submit" data-toggle="modal"
                                            data-target="#ModalSuksesBuatTagihan"
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Buat Pembayaran
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- VERIFIKASI TAGIHAN --}}
            @if ($verifikasi->isNotEmpty())
                <div>
                    <p class="text-sm text-gray-500 mb-3 px-3">Lihat bukti pembayaran penghuni kos</p>
                    <table class="min-w-full table-auto bg-white rounded-lg shadow-md mb-5">
                        <thead class="bg-gray-100">
                            <tr class="text-left text-sm text-gray-600">
                                <th class="py-3 px-4">Kamar</th>
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Rentang Waktu</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-2 px-4">Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @foreach ($verifikasi as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                    <td class="py-3 px-4">{{ $item->nama }}</td>
                                    <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                    <td class="py-3 px-4">{{ $item->waktu . ' ' . $item->rentang }}</td>
                                    <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                    <td class="py-3 px-4">
                                        <a href="#" data-id="{{ $item->idPembayaran }}" data-toggle="modal"
                                            data-target="#ModalVerifikasiPembayaran"
                                            class="verifikasi-pembayaran text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Bukti <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <main id="modal-bagian-verifikasi">
                        {{-- MODAL DATA --}}
                        <div class="modal fade p-4" id="ModalVerifikasiPembayaran" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <form action="{{ route('pembayaran.verifikasiPembayaran') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        {{-- header --}}
                                        <div
                                            class="modal-header border-b border-gray-200 py-4 px-6 flex justify-items-start">
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-800">VERIFIKASI PEMBAYARAN</h3>
                                            </div>
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
                                        <div class="modal-body p-6">
                                            <!-- Informasi Utama -->
                                            <div class="flex flex-col gap-4 mb-6">
                                                <div class="flex justify-between items-center border-b pb-2">
                                                    <span class="font-medium text-gray-600">Kamar</span>
                                                    <input id="modal-bukti-kamar" type="text" name="idKamar"
                                                        class="w-1/2 text-right font-medium text-gray-800 bg-transparent border-none"
                                                        disabled>
                                                </div>

                                                <div class="flex justify-between items-center border-b pb-2">
                                                    <span class="font-medium text-gray-600">Nama Penyewa</span>
                                                    <input id="modal-bukti-nama" type="text" name="nama"
                                                        class="w-1/2 text-right text-gray-700 bg-transparent border-none"
                                                        disabled>
                                                </div>
                                            </div>

                                            <!-- Detail Waktu -->
                                            <div class="flex flex-col gap-4 mb-6">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-medium text-gray-600">Tanggal Tagihan</span>
                                                    <input id="modal-bukti-tagihanPembayaran" type="date"
                                                        name="tgl_tagihan"
                                                        class="w-1/2 text-right bg-transparent border-none" readonly>
                                                </div>

                                                @if ($tabelDenda)
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-medium text-gray-600">Tanggal Denda</span>
                                                        <input id="modal-bukti-dendaPembayaran" type="date"
                                                            name="tgl_denda"
                                                            class="w-1/2 text-right bg-transparent border-none"
                                                            readonly>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Rentang Waktu -->
                                            <div
                                                class="flex justify-between items-center mb-6 px-4 py-2 bg-blue-50 rounded-lg">
                                                <span class="font-medium text-blue-600">Rentang Pembayaran</span>
                                                <input id="modal-bukti-rentang" type="text" name="rentang"
                                                    class="text-right font-semibold text-blue-700 bg-transparent border-none"
                                                    readonly>
                                            </div>

                                            <!-- Detail Pembayaran -->
                                            <div class="border rounded-lg p-4 mb-6">
                                                <h4 class="text-lg font-bold mb-4">Rincian Pembayaran</h4>

                                                <div class="space-y-3">
                                                    <div class="flex justify-between" id="bukti-harga">
                                                        <span class="font-medium">Harga Sewa:</span>
                                                        <input id="modal-bukti-harga" type="text" name="harga"
                                                            class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                    </div>

                                                    <div class="flex justify-between" id="bukti-deposit">
                                                        <span class="font-medium">Deposit:</span>
                                                        <input id="modal-bukti-deposit" type="text" name="deposit"
                                                            class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                    </div>

                                                    <div id="bukti-biaya-container" class="space-y-3"></div>

                                                    <div class="flex justify-between" id="bukti-denda">
                                                        <span class="font-medium">Denda:</span>
                                                        <input id="modal-bukti-denda" type="text" name="denda"
                                                            class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                    </div>

                                                    <div class="flex justify-between border-t pt-3">
                                                        <span class="font-bold">Total Pembayaran:</span>
                                                        <input id="modal-bukti-total" type="text"
                                                            name="total_bayar"
                                                            class="w-1/3 text-right px-2 font-bold bg-transparent"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Bukti Pembayaran -->
                                            <div class="mb-6">
                                                <div class="flex flex-col items-center space-y-2">
                                                    <span class="font-medium text-gray-600">Bukti Pembayaran</span>
                                                    <img src="" id="modal-bukti-foto" alt="Bukti Pembayaran"
                                                        class="h-72 object-contain border border-gray-200 rounded-lg p-2">
                                                </div>
                                            </div>

                                            <!-- Detail Tambahan -->
                                            <div class="space-y-4">
                                                <div class="flex justify-between items-center border-b pb-2">
                                                    <span class="font-medium text-gray-600">Metode Pembayaran</span>
                                                    <input id="modal-bukti-metode" type="text" name="metode"
                                                        class="w-1/2 text-right bg-transparent border-none" readonly>
                                                </div>

                                                <div class="flex justify-between items-center border-b pb-2">
                                                    <span class="font-medium text-gray-600">Keterangan</span>
                                                    <textarea id="modal-bukti-keterangan" rows="2" name="keterangan"
                                                        class="w-1/2 text-right bg-transparent border-none resize-none" readonly></textarea>
                                                </div>
                                            </div>

                                            <input type="hidden" id="modal-bukti-idPembayaran" name="idPembayaran">
                                            <input type="hidden" id="modal-bukti-idKontrak" name="idKontrak">
                                        </div>

                                        {{-- SUBMIT --}}
                                        <div
                                            class="modal-footer border-t border-gray-200 py-4 px-6 flex justify-end space-x-3">
                                            <button type="button" name="action" value="tolak" data-toggle="modal"
                                                data-target="#ModalTolakPembayaran" data-dismiss="modal"
                                                class="verifikasi-pembayaran px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                                Pembayaran Salah
                                            </button>
                                            <button type="submit" name="action" value="verifikasi"
                                                data-toggle="modal" data-target="#ModalSuksesVerifikasiBukti"
                                                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                                Verifikasi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL REVISI --}}
                        <div class="modal fade p-4" id="ModalTolakPembayaran" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <form action="{{ route('pembayaran.verifikasiPembayaran') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        {{-- header --}}
                                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Revisi
                                                Pembayaran</h3>
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
                                                <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                                    Kamar:</label>
                                                <input id="modal-revisi-kamar" type="text" value=""
                                                    name="idKamar"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    disabled>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                                    Nama Penyewa:</label>
                                                <input id="modal-revisi-nama" type="text" value=""
                                                    name="nama"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    disabled>
                                            </div>

                                            <div class="text-center">
                                                <p class="text-gray-500 text-sm">Masukan Nominal Pembayaran Yang Harus
                                                    dibayar</p>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                                    Nominal Pembayaran:</label>
                                                <input id="modal-revisi-total_bayar" type="text" value=""
                                                       name="total_bayar" data-original-value=""
                                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                       required>
                                            </div>

                                            @if ($tabelDenda)
                                                <div class="flex items-center space-x-4">
                                                    <label for="tempo"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Tanggal Denda:</label>
                                                    <input id="modal-revisi-tgl_denda" type="date" value=""
                                                        name="tgl_denda"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                                </div>
                                            @endif

                                            {{-- ATUR TANGGAL --}}
                                            <script>
                                                const inputTanggal = document.getElementById("modal-revisi-tgl_denda");
                                                const today = new Date();
                                                const tomorrow = new Date(today);
                                                tomorrow.setDate(today.getDate() + 1); // Tambahkan 1 hari ke tanggal sekarang
                                                const yyyy = tomorrow.getFullYear();
                                                const mm = String(tomorrow.getMonth() + 1).padStart(2, '0'); // Bulan dalam format 2 digit
                                                const dd = String(tomorrow.getDate()).padStart(2, '0'); // Tanggal dalam format 2 digit

                                                inputTanggal.min = `${yyyy}-${mm}-${dd}`; // Set atribut min pada input
                                            </script>

                                            {{-- keterangan --}}
                                            <div class="flex items-center space-x-4 mt-4">
                                                <label for="keterangan"
                                                    class="w-32 text-md font-medium text-gray-700">
                                                    Keterangan:</label>
                                                <textarea id="modal-revisi-keterangan" type="text" value="" rows="2" name="keterangan"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"></textarea>
                                            </div>

                                            <input type="hidden" id="modal-revisi-idPembayaran" name="idPembayaran">
                                            <input type="hidden" id="modal-revisi-idKontrak" name="idKontrak">
                                            <input type="hidden" id="modal-revisi-tgl_tagihan" name="tgl_tagihan">

                                        </div>
                                        {{-- SUBMIT --}}
                                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                            <button type="button" data-dismiss="modal"
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Tutup
                                            </button>
                                            <button type="submit" name="action" value="tolak" data-toggle="modal"
                                                data-target="#ModalSuksesRevisiPembayaran"
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Revisi Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            @endif

            {{-- LIST PEMBAYARAN --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail Tagihan Penghuni</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Penyewa</th>
                            <th class="py-3 px-4">Total Bayar</th>
                            <th class="py-3 px-4">Rentang Waktu</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($pembayaran as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">{{ $item->waktu . ' ' . $item->rentang }}</td>
                                <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idPembayaran }}" data-toggle="modal"
                                        data-target="#ModalPembayaran"
                                        class="lihat-detail-pembayaran text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada data
                                    pembayaran yang tersedia untuk periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalPembayaran" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            {{-- header --}}
                            <div
                                class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-start">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">INVOICE TAGIHAN</h3>
                                </div>
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
                            <div class="modal-body p-6">
                                <!-- Informasi Utama -->
                                <div class="flex flex-col gap-4 mb-6">
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Kamar</span>
                                        <input id="modal-kamar" type="text"
                                            class="w-1/2 text-right font-medium text-gray-800 bg-transparent border-none"
                                            readonly>
                                    </div>

                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Nama Penyewa</span>
                                        <input id="modal-nama" type="text"
                                            class="w-1/2 text-right text-gray-700 bg-transparent border-none" readonly>
                                    </div>
                                </div>

                                <!-- Detail Status -->
                                <div class="flex flex-col gap-4 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-600">Status</span>
                                        <input id="modal-status" type="text"
                                            class="w-1/2 text-right px-2 py-1 bg-gray-100 rounded-md border-none"
                                            readonly>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-600">Tanggal Tagihan</span>
                                        <input id="modal-tagihan" type="text"
                                            class="w-1/2 text-right text-gray-700 bg-transparent border-none" readonly>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-600">Tanggal Denda</span>
                                        <input id="modal-tempo" type="text"
                                            class="w-1/2 text-right text-gray-700 bg-transparent border-none" readonly>
                                    </div>
                                </div>

                                <!-- Rentang Waktu -->
                                <div class="flex justify-between items-center mb-6 px-4 py-2 bg-blue-50 rounded-lg">
                                    <span class="font-medium text-blue-600">Rentang Pembayaran</span>
                                    <input id="modal-rentang" type="text"
                                        class="text-right font-semibold text-blue-700 bg-transparent border-none"
                                        readonly>
                                </div>

                                <!-- Detail Pembayaran -->
                                <div class="border rounded-lg p-4 mb-6">
                                    <h4 class="text-lg font-bold mb-4">Rincian Pembayaran</h4>

                                    <div class="space-y-3">
                                        <div class="flex justify-between" id="harga-kontrak">
                                            <span class="font-medium">Harga Sewa:</span>
                                            <input id="modal-harga" type="text" value=""
                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                        </div>

                                        <div class="flex justify-between" id="deposit-kontrak">
                                            <span class="font-medium">Deposit:</span>
                                            <input id="modal-deposit" type="text" value=""
                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                        </div>

                                        <div id="biaya-container" class="space-y-3"></div>

                                        <div class="flex justify-between" id="denda-kontrak">
                                            <span class="font-medium">Denda:</span>
                                            <input id="modal-denda" type="text" value=""
                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                        </div>

                                        <div class="flex justify-between border-t pt-3">
                                            <span class="font-bold">Total Pembayaran:</span>
                                            <input id="modal-total" type="text" value=""
                                                class="w-1/3 text-right px-2 font-bold bg-transparent" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="mb-4">
                                    <p class="font-medium text-gray-700">Keterangan:</p>
                                    <textarea id="modal-keterangan" rows="2" class="w-full px-3 py-2 border rounded-md focus:outline-none"
                                        readonly></textarea>
                                </div>
                            </div>

                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex justify-end space-x-3">
                                {{-- <button type="button" data-toggle="modal" data-target="#ModalUbahPembayaran"
                                    data-dismiss="modal"
                                    class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                    Ubah Pembayaran
                                </button> --}}
                                <button type="button"
                                    class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors"
                                    data-dismiss="modal">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL UBAH TAGIHAN --}}
                <div class="modal fade p-4" id="ModalUbahPembayaran" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <form action="{{ route('pembayaran.updatePembayaran') }}" method="POST">
                                @csrf
                                @method('PUT')
                                {{-- header --}}
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Ubah Tagihan
                                        Pembayaran</h3>
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

                                    <div class="flex items-center space-x-4">
                                        <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                            Kamar:</label>
                                        <input id="modal-ubahTagihan-kamar" type="text" value=""
                                            name="kamar"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            disabled>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                            Nama Penyewa:</label>
                                        <input id="modal-ubahTagihan-nama" type="text" value=""
                                            name="nama" min="1"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            disabled>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="tgl_tagihan" class="w-32 text-md font-medium text-gray-700">
                                            Tanggal Tagihan:</label>
                                        <input id="modal-ubahTagihan-tgl_tagihan" type="date" value=""
                                            name="tgl_tagihan" min="1"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            required>
                                    </div>

                                    @if ($tabelDenda)
                                        <div class="flex items-center space-x-4">
                                            <label for="tgl_denda" class="w-32 text-md font-medium text-gray-700">
                                                Tanggal Denda:</label>
                                            <input id="modal-ubahTagihan-tgl_denda" type="date" value=""
                                                name="tgl_denda" min="1"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                required>
                                        </div>
                                    @endif

                                    <!-- Container untuk biayaList yang akan diisi melalui AJAX -->
                                    <div id="ubah-biaya-container"></div>

                                    <div class="flex items-center space-x-4">
                                        <label for="tgl_denda" class="w-32 text-md font-medium text-gray-700">
                                            Total Pembayaran:</label>
                                        <input id="modal-ubahTagihan-total" type="text" value=""
                                            name="total" min="0"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            required>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                            Keterangan:</label>
                                        <textarea id="modal-ubahTagihan-keterangan" type="text" value="" rows="2" name="keterangan"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" required></textarea>
                                    </div>

                                    <input type="hidden" id="modal-ubahTagihan-idPembayaran" name="idPembayaran">

                                </div>
                                {{-- SUBMIT --}}
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button type="button" data-dismiss="modal"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Tutup
                                    </button>
                                    <button type="submit" data-toggle="modal" data-target="#ModalSuksesUbahTagihan"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- PAGE RIWAYAT --}}
        <section id="riwayat" class="hidden">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Penyewa</th>
                            <th class="py-3 px-4">Nominal</th>
                            <th class="py-3 px-4">Rentang Waktu</th>
                            <th class="py-3 px-4">Tanggal Pembayaran</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($riwayatPembayaran as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ number_format($item->dibayar, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">{{ $item->waktu . ' ' . $item->rentang }}</td>
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idPembayaran }}" data-toggle="modal"
                                        data-target="#ModalRiwayat"
                                        class="lihat-detail-riwayat text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada riwayat
                                    pembayaran untuk kos ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalRiwayat" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            {{-- Header --}}
                            <div
                                class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-start">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">DETAIL RIWAYAT PEMBAYARAN</h3>
                                </div>
                                <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal"
                                    aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Content --}}
                            <div class="modal-body p-6">
                                <!-- Informasi Utama -->
                                <div class="flex flex-col gap-4 mb-6">
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Kamar</span>
                                        <input id="modal-riwayat-kamar" type="text"
                                            class="w-1/2 text-right font-medium text-gray-800 bg-transparent border-none"
                                            readonly>
                                    </div>

                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Nama Penyewa</span>
                                        <input id="modal-riwayat-nama" type="text"
                                            class="w-1/2 text-right text-gray-700 bg-transparent border-none" readonly>
                                    </div>
                                </div>

                                <!-- Detail Waktu -->
                                <div class="flex flex-col gap-4 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-600">Tanggal Tagihan</span>
                                        <input id="modal-riwayat-tgl_tagihan" type="text"
                                            class="w-1/2 text-right bg-transparent border-none" readonly>
                                    </div>

                                    @if ($tabelDenda)
                                        <div class="flex justify-between items-center">
                                            <span class="font-medium text-gray-600">Tanggal Denda</span>
                                            <input id="modal-riwayat-tgl_denda" type="text"
                                                class="w-1/2 text-right bg-transparent border-none" readonly>
                                        </div>
                                    @endif
                                </div>

                                <!-- Rentang Waktu -->
                                <div class="flex justify-between items-center mb-6 px-4 py-2 bg-blue-50 rounded-lg">
                                    <span class="font-medium text-blue-600">Rentang Pembayaran</span>
                                    <input id="modal-riwayat-rentang" type="text"
                                        class="text-right font-semibold text-blue-700 bg-transparent border-none"
                                        readonly>
                                </div>

                                <!-- Detail Pembayaran -->
                                <div class="border rounded-lg p-4 mb-6">
                                    <h4 class="text-lg font-bold mb-4">Rincian Pembayaran</h4>

                                    <div class="space-y-3">
                                        <div class="flex justify-between" id="riwayat-harga">
                                            <span class="font-medium">Harga Sewa:</span>
                                            <input id="modal-riwayat-harga" type="text"
                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                        </div>

                                        <div class="flex justify-between" id="riwayat-deposit">
                                            <span class="font-medium">Deposit:</span>
                                            <input id="modal-riwayat-deposit" type="text"
                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                        </div>

                                        <div id="riwayat-container" class="space-y-3"></div>

                                        <div class="flex justify-between" id="riwayat-denda">
                                            <span class="font-medium">Denda:</span>
                                            <input id="modal-riwayat-denda" type="text"
                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                        </div>

                                        <div class="flex justify-between border-t pt-3">
                                            <span class="font-bold">Total Pembayaran:</span>
                                            <input id="modal-riwayat-total" type="text"
                                                class="w-1/3 text-right px-2 font-bold bg-transparent" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bukti Pembayaran -->
                                <div class="mb-6">
                                    <div class="flex flex-col items-center space-y-2">
                                        <span class="font-medium text-gray-600">Bukti Pembayaran</span>
                                        <img src="" id="modal-riwayat-foto" alt="Bukti Pembayaran"
                                            class="h-72 object-contain border border-gray-200 rounded-lg p-2">
                                    </div>
                                </div>

                                <!-- Detail Tambahan -->
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Metode Pembayaran</span>
                                        <input id="modal-riwayat-metode" type="text"
                                            class="w-1/2 text-right bg-transparent border-none" readonly>
                                    </div>

                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Tanggal Pembayaran</span>
                                        <input id="modal-riwayat-tanggal" type="text"
                                            class="w-1/2 text-right bg-transparent border-none" readonly>
                                    </div>

                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Status</span>
                                        <input id="modal-riwayat-status" type="text"
                                            class="w-1/2 text-right bg-transparent border-none" readonly>
                                    </div>

                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Keterangan</span>
                                        <textarea id="modal-riwayat-keterangan" rows="2"
                                            class="w-1/2 text-right bg-transparent border-none resize-none" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="modal-footer border-t border-gray-200 py-4 px-6 flex justify-end">
                                <button type="button"
                                    class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors"
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

{{-- BUAT PEMBAYARAN --}}
<script>
    $(document).ready(function() {
        const cleaveConfig = {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalMark: ',',
            delimiter: '.'
        };

        const cleaveTotalBayar = new Cleave('#total_bayar', cleaveConfig);
        const cleaveDeposit = new Cleave('#modal-buat-deposit', cleaveConfig);
        const cleaveHargaKamar = new Cleave('#modal-buat-total', cleaveConfig);

        $('.buat-pembayaran').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/tagihan/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-buat-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-buat-nama').val(data.data.nama);
                    $('#modal-buat-tagihan').val(data.data.tgl_tagihan);
                    $('#modal-buat-denda').val(data.data.tgl_denda);
                    // $('#modal-buat-total').val(data.data.harga);
                    cleaveHargaKamar.setRawValue(data.data.harga.toString());
                    $('#modal-buat-rentang').val(data.data.waktu + " " + data.data.rentang);
                    // hidden
                    $('#modal-buat-kontrak').val(data.data.idKontrak);
                    $('#modal-buat-waktu').val(data.data.waktu);

                    // CEK RENTANG BUAT SELANJUTNYA
                    const rentang = data.data.rentang;
                    const modulDenda = data.data.tgl_denda;

                    if (rentang === 'Bulan') {
                        $('#waktu_tagihan_denda_update').show();

                        /// Hitung tanggal tagihan berikutnya
                        const tglTagihan = new Date(data.data.tgl_tagihan); // Konversi ke objek Date
                        const waktuTagihan = parseInt(data.pengaturan.waktu_tagihan) || tglTagihan.getDate(); // Ambil waktu_tagihan atau default tanggal tagihan saat ini

                        tglTagihan.setMonth(tglTagihan.getMonth() + 1); // Tambahkan 1 bulan
                        const lastDayOfNextMonth = new Date(tglTagihan.getFullYear(),tglTagihan.getMonth() + 1, 0).getDate();tglTagihan.setDate(Math.min(waktuTagihan,lastDayOfNextMonth)); // Atur tanggal sesuai waktu_tagihan
                        const nextTagihan = tglTagihan.toISOString().split('T')[0]; // Format YYYY-MM-DD

                        $('#modal-buat-tagihanBerikutnya').val(nextTagihan);

                        // Hitung denda berikutnya
                        const tglDenda = new Date(data.data
                            .tgl_denda); // Konversi ke objek Date
                        const waktuDenda = parseInt(data.pengaturan.waktu_denda) || tglDenda
                            .getDate(); // Ambil waktu_denda atau default tanggal denda saat ini

                        tglDenda.setMonth(tglDenda.getMonth() + 1); // Tambahkan 1 bulan
                        const lastDayOfNextMonthDenda = new Date(tglDenda.getFullYear(),
                            tglDenda.getMonth() + 1, 0).getDate();
                        tglDenda.setDate(Math.min(waktuDenda,
                            lastDayOfNextMonthDenda)); // Atur tanggal sesuai waktu_denda
                        const nextDenda = tglDenda.toISOString().split('T')[
                            0]; // Format YYYY-MM-DD

                        $('#modal-buat-dendaBerikutnya').val(nextDenda);
                    } else {
                        $('#waktu_tagihan_denda_update').hide();

                        $('#modal-buat-tagihanBerikutnya').val(data.data.tgl_tagihan);
                        $('#modal-buat-dendaBerikutnya').val(data.data.tgl_denda);

                    }

                    // CEK SHOW DEPOSIT/BIAYA
                    if (data.data.status_kontrak === 'Pembayaran Perdana' && data.data
                        .deposit !== null) {
                        $('#buat-biaya-container').hide(); // Sembunyikan biaya tambahan

                        $('#deposit-container').show(); // Tampilkan deposit
                        // $('#modal-buat-deposit').val(data.data.deposit);
                        cleaveDeposit.setRawValue(data.data.deposit?.toString() || '0');
                    } else {
                        $('#deposit-container').hide(); // Sembunyikan deposit jika null
                    }

                    // Tambahkan biaya tambahan jika tidak "Pembayaran Perdana"
                    if (data.data.status_kontrak !== 'Pembayaran Perdana') {
                        $('#buat-biaya-container').empty(); // Kosongkan biaya sebelumnya

                        $.each(data.biayaKontrak, function(index, biaya) {
                            const inputId = `biaya-${index}`;
                            $('#buat-biaya-container').append(`
                                <div class="mb-2 flex items-center space-x-4">
                                    <label class="w-32 text-md font-medium text-gray-700">${biaya.biaya}:</label>
                                    <input id="${inputId}" 
                                        type="text" 
                                        class="biaya-input flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        value="0">
                                    <input type="hidden" name="harga_biaya[]" id="hidden-${inputId}" value="0">
                                    <input type="hidden" name="idBiaya[]" value="${biaya.idBiaya}">
                                </div>
                            `);

                            // Buat instance Cleave dengan callback untuk update hidden field
                            const cleaveInstance = new Cleave(`#${inputId}`, {
                                ...cleaveConfig,
                                onValueChanged: function(e) {
                                    // Update hidden input dengan raw value (tanpa formatting)
                                    $(`#hidden-${inputId}`).val(e.target.rawValue);
                                }
                            });
                        });
                    }
                    updateTotalBayar();
                }
            });
        });

        // method untuk update total bayar
        const updateTotalBayar = () => {
            let total = 0;
            
            // Hitung harga kamar
            const hargaKamar = parseFloat(cleaveHargaKamar.getRawValue()) || 0;
            const waktu = parseFloat($('#modal-buat-waktu').val()) || 1;
            total += hargaKamar * waktu;

            // Tambahkan deposit
            total += parseFloat(cleaveDeposit.getRawValue()) || 0;

            // Hitung biaya tambahan (gunakan nilai dari hidden input)
            $('input[name="harga_biaya[]"]').each(function() {
                total += parseFloat($(this).val()) || 0;
            });

            // Update total
            cleaveTotalBayar.setRawValue(total.toString());
            $('#hidden_total_bayar').val(total);
        };

        // Event listener untuk update realtime
        $('#buat-biaya-container').on('input', '.biaya-input', updateTotalBayar);
        $('#modal-buat-deposit').on('input', updateTotalBayar);
        $('#modal-buat-waktu').on('input', updateTotalBayar);

        // Tambahkan event listener pada input deposit
        $('#modal-buat-deposit').on('input', function() {
            updateTotalBayar();
        });

        // Tambahkan event listener pada input harga kamar dan biaya lainnya
        $('#modal-buat-total').on('input', function() {
            updateTotalBayar();
        });

        // Tambahkan event listener pada biaya lainnya (delegasi)
        $('#buat-biaya-container').on('input', 'input[name="harga_biaya[]"]', function() {
            updateTotalBayar();
        });

        // Trigger perhitungan setiap kali elemen biaya ditambahkan
        const observer = new MutationObserver(() => {
            updateTotalBayar();
        });

    });
</script>

{{-- VERIFIKASI PEMBAYARAN --}}
<script>
    $(document).ready(function() {
        $('.verifikasi-pembayaran').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/verifikasi/' + id,
                type: 'GET',
                success: function(data) {
                    function formatRupiah(angka) {
                        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                            ".");
                    }

                    $('#modal-bukti-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-bukti-nama').val(data.data.nama);
                    $('#modal-bukti-tagihanPembayaran').val(data.data.tagihanPembayaran);
                    $('#modal-bukti-dendaPembayaran').val(data.data.dendaPembayaran);
                    $('#modal-bukti-rentang').val(data.data.waktu + " " + data.data
                        .rentang);
                    $('#modal-bukti-total').val(formatRupiah(data.data.dibayar));
                    $('#modal-bukti-metode').val(data.data.metode + " - " + data.data
                        .nomor_tujuan);
                    $('#modal-bukti-keterangan').val(data.data.keterangan_pembayaran);
                    $('#modal-bukti-idPembayaran').val(data.data.idPembayaran);
                    $('#modal-bukti-idKontrak').val(data.data.idKontrak);

                    $('#modal-bukti-foto').attr('src', data.gambar_url)

                    // menambahkan biaya lainnya kedalaam modal
                    $('#bukti-biaya-container').empty();
                    $.each(data.biayaList, function(index, biaya) {
                        $('#bukti-biaya-container').append(`
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">${biaya.biaya}:</span>
                                <input type="text" 
                                    id="${biaya.biaya}" 
                                    name="${biaya.biaya}" 
                                    class="w-1/3 text-right px-2 bg-transparent"
                                    value="${formatRupiah(biaya.harga)}" 
                                    readonly>
                            </div>
                        `);
                    });

                    // DENDA KONTRAK
                    if (!data.denda || data.denda.nominal_denda === null) {
                        $('#bukti-denda').addClass('hidden');
                    } else {
                        $('#bukti-denda').removeClass('hidden');
                        $('#modal-bukti-denda').val(formatRupiah(data.denda.nominal_denda));
                    }

                    // DEPOSIT KONTRAK
                    if (data.data.deposit === null || data.data.status_kontrak ===
                        'Revisi' || data.data.status_kontrak === 'Aktif') {
                        $('#bukti-deposit').addClass('hidden');
                    } else {
                        $('#bukti-deposit').removeClass('hidden');
                        $('#modal-bukti-deposit').val(formatRupiah(data.data.deposit));
                    }

                    // DISPLAY REVISI
                    if (data.data.status_kontrak === 'Revisi') {
                        $('#bukti-harga').addClass('hidden');
                    } else {
                        $('#bukti-harga').removeClass('hidden');
                        $('#modal-bukti-harga').val(formatRupiah(data.data.harga * data.data
                            .waktu));
                    }

                    $('#modal-revisi-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-revisi-nama').val(data.data.nama);
                    $('#modal-revisi-idKontrak').val(data.data.idKontrak);
                    $('#modal-revisi-tgl_tagihan').val(data.data.tagihanPembayaran);
                    $('#modal-revisi-idPembayaran').val(data.data.idPembayaran);
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
    const nominalInput = document.getElementById('modal-revisi-total_bayar');
    
    // Format angka ketika input mendapatkan fokus
    nominalInput.addEventListener('focus', function(e) {
        // Hapus semua titik dari nilai saat ini
        this.value = this.value.replace(/\./g, '');
    });
    
    // Format angka saat user mengetik
    nominalInput.addEventListener('input', function(e) {
        // Hapus semua karakter kecuali angka
        let value = this.value.replace(/\D/g, '');
        
        // Format dengan titik sebagai pemisah ribuan
        if (value) {
            this.value = Number(value).toLocaleString('id-ID').replace(/,/g, '.');
        }
    });
    
    // Pastikan saat form disubmit, nilai yang dikirim adalah angka tanpa formatting
    if (nominalInput.form) {
        nominalInput.form.addEventListener('submit', function() {
            nominalInput.value = nominalInput.value.replace(/\./g, '');
        });
    }
});
</script>

{{-- LIHAT PEMBAYARAN --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-pembayaran').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/list/' + id,
                type: 'GET',
                success: function(data) {
                    function formatRupiah(angka) {
                        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                            ".");
                    }

                    $('#modal-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-nama').val(data.data.nama);
                    $('#modal-status').val(data.data.status_pembayaran);
                    $('#modal-total').val(formatRupiah(data.data.total_bayar));
                    $('#modal-tagihan').val(data.data.tagihanPembayaran);
                    $('#modal-tempo').val(data.data.dendaPembayaran);
                    $('#modal-rentang').val(data.data.waktu + " " + data.data.rentang);
                    $('#modal-harga').val(formatRupiah(data.data.harga * data.data.waktu));
                    // $('#modal-deposit').val(formatRupiah(data.data.deposit));
                    $('#modal-keterangan').val(data.data.keterangan_pembayaran);

                    // ubah pembayaran
                    $('#modal-ubahTagihan-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-ubahTagihan-nama').val(data.data.nama);
                    $('#modal-ubahTagihan-tgl_tagihan').val(data.data.tagihanPembayaran);
                    $('#modal-ubahTagihan-tgl_denda').val(data.data.dendaPembayaran);
                    $('#modal-ubahTagihan-total').val(formatRupiah(data.data.total_bayar));
                    $('#modal-ubahTagihan-keterangan').val(data.data.keterangan_pembayaran);
                    $('#modal-ubahTagihan-idPembayaran').val(data.data.idPembayaran);

                    // menambahkan biaya lainnya kedalaam modal
                    $('#biaya-container').empty();
                    $.each(data.biayaList, function(index, biaya) {
                        $('#biaya-container').append(`
                            <div class="flex justify-between">
                                <span class="font-medium">${biaya.biaya}:</span>
                                <input type="text" id="${biaya.biaya}" name="${biaya.biaya}" 
                                    class="w-1/3 text-right px-2 bg-transparent" 
                                    value="${formatRupiah(biaya.harga)}" readonly>
                            </div>
                        `);
                    });

                    // DEPOSIT KONTRAK
                    if (data.data.status_kontrak === 'Pembayaran Perdana' && data.data
                        .deposit !== null) {
                        $('#deposit-kontrak').removeClass('hidden');
                        $('#modal-deposit').val(formatRupiah(data.data.deposit));
                    } else {
                        $('#deposit-kontrak').addClass('hidden');
                    }

                    // REVISI
                    if (data.data.status_pembayaran === 'Revisi') {
                        $('#deposit-kontrak').addClass('hidden');
                        $('#denda-kontrak').addClass('hidden');
                        // $('#harga-kontrak').addClass('hidden');
                        $('#modal-harga').val(formatRupiah(data.data.total_bayar));
                    } else {
                        // $('#harga-kontrak').removeClass('hidden');
                        // Hanya tampilkan deposit jika ada nilai deposit
                        if (data.data.deposit !== null) {
                            $('#deposit-kontrak').removeClass('hidden');
                            $('#modal-deposit').val(formatRupiah(data.data.deposit));
                        } else {
                            $('#deposit-kontrak').addClass('hidden');
                        }
                    }

                    // Logika untuk denda
                    const today = new Date();
                    const dendaDate = new Date(data.data.dendaPembayaran);

                    if (today >= dendaDate && data.denda) {
                        $('#denda-kontrak').removeClass('hidden');

                        const jenisDenda = data.denda.jenis_denda;
                        const totalBayar = parseFloat(data.data.total_bayar);
                        const angka = parseFloat(data.denda.angka);
                        const angkaMingguan = parseFloat(data.denda.angka_mingguan);
                        const angkaHarian = parseFloat(data.denda.angka_harian);
                        const rentang = data.data.rentang;
                        const nilaiDenda = rentang === 'Bulan' ? angka : rentang ===
                            'Mingguan' ? angkaMingguan : angkaHarian;

                        let denda = 0;

                        if (data.data.status_kontrak === 'Pembayaran Perdana') {
                            if (data.data.deposit !== null) {
                                const deposit = parseFloat(data.data.deposit);

                                if (jenisDenda === 'Nominal') {
                                    denda = nilaiDenda;
                                } else if (jenisDenda === 'Persen') {
                                    denda = (totalBayar * nilaiDenda) / 100;
                                } else {
                                    const hari = Math.abs(today - dendaDate);
                                    const formatHari = Math.ceil(hari / (1000 * 60 * 60 *
                                        24));

                                    denda = formatHari * nilaiDenda;
                                }
                            } else {
                                $('#deposit-kontrak').addClass('hidden');

                                if (jenisDenda === 'Nominal') {
                                    denda = nilaiDenda;
                                } else if (jenisDenda === 'Persen') {
                                    denda = (totalBayar * nilaiDenda) / 100;
                                } else {
                                    const hari = Math.abs(today - dendaDate);
                                    const formatHari = Math.ceil(hari / (1000 * 60 * 60 *
                                        24));

                                    denda = formatHari * nilaiDenda;
                                }
                            }
                        } else {
                            $('#deposit-kontrak').addClass('hidden');

                            if (jenisDenda === 'Nominal') {
                                denda = nilaiDenda;
                            } else if (jenisDenda === 'Persen') {
                                denda = (totalBayar * nilaiDenda) / 100;
                            } else {
                                const hari = Math.abs(today - dendaDate);
                                const formatHari = Math.ceil(hari / (1000 * 60 * 60 * 24));

                                denda = formatHari * nilaiDenda;
                            }
                        }

                        // Atur nilai denda
                        $('#modal-denda').val(formatRupiah(denda));
                        $('#modal-total').val(formatRupiah(totalBayar + denda));
                    } else {
                        $('#denda-kontrak').addClass('hidden');
                        $('#modal-denda').val('');
                        $('#modal-total').val(formatRupiah(data.data.total_bayar));
                    }



                    // BAGIAN UBAH //
                    const claveUbahHargaKamar = new Cleave('#modal-ubahTagihan-total', {
                        numeral: true,
                        numeralThousandsGroupStyle: 'thousand',
                        numeralDecimalMark: ',',
                        delimiter: '.'
                    });

                    if (data.data.status_pembayaran === 'Revisi' || data.data.rentang !==
                        'Bulan') {
                        $('#modal-ubahTagihan-total').val(data.data.total_bayar);
                    } else {
                        // Mengubah biaya lainnya ke dalam modal
                        $('#ubah-biaya-container').empty();
                        $.each(data.biayaList, function(index, biaya) {
                            $('#ubah-biaya-container').append(`
                                <div class="mb-2 flex items-center space-x-4">
                                    <label class="w-32 text-md font-medium text-gray-700">${biaya.biaya}:</label>
                                    <input type="number" class="biaya-input flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" 
                                        name="biaya[${index}][harga]" value="${biaya.harga}" min="0" data-harga="${biaya.harga}">
                                    <input type="hidden" name="biaya[${index}][idbiaya]" value="${biaya.idBiaya}">
                                    <input type="hidden" name="biaya[${index}][idpembayaran]" value="${biaya.idPembayaran}">
                                </div>
                            `);
                        });

                        // Simpan harga dasar ke atribut data untuk perhitungan real-time
                        $('#modal-ubahTagihan-total').data('base-price', parseFloat(data
                            .data.harga) || 0);

                        // Fungsi untuk update total bayar secara real-time
                        const updateTotal = () => {
                            let total = parseFloat($('#modal-ubahTagihan-total').data(
                                'base-price')) || 0;
                            $('#ubah-biaya-container .biaya-input').each(function() {
                                total += parseFloat($(this).val()) || 0;
                            });
                            $('#modal-ubahTagihan-total').val(total);
                        };

                        // Panggil update total pertama kali saat modal terbuka
                        updateTotal();

                        // Event listener untuk perubahan nilai input biaya
                        $('#ubah-biaya-container').off('input').on('input', '.biaya-input',
                            function() {
                                updateTotal();
                            });
                    }

                }
            });
        });
    });
</script>

{{-- RIWAYAT PEMBAYARAN --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-riwayat').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/riwayat/' + id,
                type: 'GET',
                success: function(data) {
                    function formatRupiah(angka) {
                        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                            ".");
                    }

                    $('#modal-riwayat-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-riwayat-nama').val(data.data.nama);
                    $('#modal-riwayat-tgl_tagihan').val(data.data.tgl_tagihan);
                    $('#modal-riwayat-tgl_denda').val(data.data.tgl_denda);
                    $('#modal-riwayat-rentang').val(data.data.waktu + ' ' + data.data
                        .rentang);
                    $('#modal-riwayat-total').val(formatRupiah(data.data.dibayar));
                    $('#modal-riwayat-metode').val(data.data.metode + " - " + data.data
                        .nomor_tujuan);
                    $('#modal-riwayat-tanggal').val(data.data.tanggal);
                    $('#modal-riwayat-status').val(data.data.status_pembayaran);
                    $('#modal-riwayat-keterangan').val(data.data.keterangan_pembayaran);
                    $('#modal-riwayat-foto').attr('src', data.gambar_url)

                    // menambahkan biaya lainnya kedalaam modal
                    $('#riwayat-container').empty();

                    $.each(data.biayaList, function(index, biaya) {
                        $('#bukti-biaya-container').append(`
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">${biaya.biaya}:</span>
                                <input type="text" 
                                    id="${biaya.biaya}" 
                                    name="${biaya.biaya}" 
                                    class="w-1/3 text-right px-2 bg-transparent"
                                    value="${formatRupiah(biaya.harga)}" 
                                    readonly>
                            </div>
                        `);
                    });

                    // denda
                    if (!data.denda || data.denda.nominal_denda === null) {
                        $('#riwayat-denda').addClass('hidden');
                    } else {
                        $('#riwayat-denda').removeClass('hidden');
                        $('#modal-riwayat-denda').val(formatRupiah(data.denda
                            .nominal_denda));
                    }

                    // deposit
                    if (data.data.status_kontrak_pembayarannya === 'Pembayaran Perdana') {
                        $('#riwayat-deposit').removeClass('hidden');
                        $('#modal-riwayat-deposit').val(formatRupiah(data.data.deposit));
                    } else {
                        $('#riwayat-deposit').addClass('hidden');
                    }

                    // revisi
                    if (data.data.status_kontrak_pembayarannya === 'Revisi') {
                        $('#riwayat-harga').addClass('hidden');
                    } else {
                        $('#riwayat-harga').removeClass('hidden');
                        $('#modal-riwayat-harga').val(formatRupiah(data.data.harga));
                    }
                }
            });
        });
    });
</script>