<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-3fZDkM6ZozJ4f4WD"></script>

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
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">Pembayaran</a>
                    <a href="#pembayaran" id="btnPembayaran" onclick="switchPage('pembayaran')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Riwayat
                        Pembayaran</a>
                </nav>
            </div>
        </section>

        <!-- PAGE PEMBAYARAN -->
        <section id="list" class="block">
            {{-- VERIFIKASI --}}
            @if (!empty($verifikasi))
                <div id="verifikasi-pembayaran">
                    <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr class="text-left text-sm text-gray-600">
                                    <th class="py-3 px-4">Kamar</th>
                                    <th class="py-3 px-4">Penyewa</th>
                                    <th class="py-3 px-4">Nominal</th>
                                    <th class="py-3 px-4">Tanggal Denda</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-2 px-4">Lihat Detail</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-800">
                                @forelse ($verifikasi as $item)
                                    <tr class="border-t hover:bg-gray-50 transition duration-200">
                                        <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                        <td class="py-3 px-4">{{ $item->nama }}</td>
                                        <td class="py-3 px-4">{{ $item->total_bayar }}</td>
                                        <td class="py-3 px-4">{{ $item->dendanya }}</td>
                                        <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                        <td class="py-3 px-4">
                                            <a href="#" data-id="{{ $item->idPembayaran }}" data-toggle="modal"
                                                data-target="#ModalVerifikasi"
                                                class="lihat-detail-verifikasi text-indigo-500 hover:text-indigo-700 transition">
                                                Lihat Detail <span aria-hidden="true">→</span></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada
                                            pembayaran yang sedang diverifikasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- MODAL DATA --}}
                        <div class="modal fade p-4" id="ModalVerifikasi" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    {{-- header --}}
                                    <div class="modal-header border-b border-gray-200 py-4 px-6">
                                        <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail
                                            Tagihan
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
                                            <input id="modal-verifikasi-kamar" type="text" value=""
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                                Nama Penyewa:</label>
                                            <input id="modal-verifikasi-nama" type="text" value=""
                                                name="nama"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="status" class="w-32 text-md font-medium text-gray-700">
                                                Status:</label>
                                            <input id="modal-verifikasi-status" type="text" value=""
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="tagihan" class="w-32 text-md font-medium text-gray-700">
                                                Tanggal Tagihan:</label>
                                            <input id="modal-verifikasi-tagihan" type="text" value=""
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="tempo" class="w-32 text-md font-medium text-gray-700">
                                                Tanggal Denda:</label>
                                            <input id="modal-verifikasi-tempo" type="text" value=""
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="rentang" class="w-32 text-md font-medium text-gray-700">
                                                Rentang:</label>
                                            <input id="modal-verifikasi-rentang" type="text" value=""
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="text-center">
                                            <p class="text-gray-500 text-sm">Nominal Pembayaran</p>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                                Harga:</label>
                                            <input id="modal-verifikasi-harga" type="text" value=""
                                                name="harga"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4" id="deposit-verifikasi-kontrak">
                                            <label for="deposit" class="w-32 text-md font-medium text-gray-700">
                                                Deposit:</label>
                                            <input id="modal-verifikasi-deposit" type="text" value=""
                                                name="deposit"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <!-- Container untuk biayaList yang akan diisi melalui AJAX -->
                                        <div id="biaya-verifikasi-container"></div>

                                        <div class="flex items-center space-x-4" id="denda-verifikasi-kontrak">
                                            <label for="denda" class="w-32 text-md font-medium text-gray-700">
                                                Denda:</label>
                                            <input id="modal-verifikasi-denda" type="text" value=""
                                                name="denda"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="total" class="w-32 text-md font-medium text-gray-700">
                                                Total Bayar:</label>
                                            <input id="modal-verifikasi-total" type="text" value=""
                                                name="total"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="metode" class="w-32 text-md font-medium text-gray-700">
                                                Metode Pembayaran:</label>
                                            <input id="modal-verifikasi-metode" type="text" value=""
                                                name="metode"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                                Keterangan:</label>
                                            <textarea id="modal-verifikasi-keterangan" type="text" value="" rows="2"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                        </div>

                                        {{-- hidden idpembayaran --}}
                                        <input id="modal-verifikasi-idPembayaran" type="hidden" name="idPembayaran"
                                            value="">
                                    </div>
                                    {{-- subnmit --}}
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
                </div>
            @endif

            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3 mt-5">Click untuk melihat Detail</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Penyewa</th>
                            <th class="py-3 px-4">Nominal</th>
                            <th class="py-3 px-4">Tanggal Denda</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($tagihan as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->total_bayar }}</td>
                                <td class="py-3 px-4">{{ $item->dendanya }}</td>
                                <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idPembayaran }}" data-toggle="modal"
                                        data-target="#ModalTagihan"
                                        class="lihat-detail-tagihan text-indigo-500 hover:text-indigo-700 transition">
                                        Bayar <span aria-hidden="true">→</span></a>
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
                <div class="modal fade p-4" id="ModalTagihan" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            {{-- header --}}
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Tagihan
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
                            <form action="{{ route('pembayaran.store') }}" method="POST">
                                @csrf
                                {{-- content --}}
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
                                        <input id="modal-nama" type="text" value="" name="nama"
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

                                    <div class="flex items-center space-x-4">
                                        <label for="tagihan" class="w-32 text-md font-medium text-gray-700">
                                            Tanggal Tagihan:</label>
                                        <input id="modal-tagihan" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="tempo" class="w-32 text-md font-medium text-gray-700">
                                            Tanggal Denda:</label>
                                        <input id="modal-tempo" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="rentang" class="w-32 text-md font-medium text-gray-700">
                                            Rentang:</label>
                                        <input id="modal-rentang" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="text-center">
                                        <p class="text-gray-500 text-sm">Nominal Pembayaran</p>
                                    </div>

                                    <div class="flex items-center space-x-4" id="harga-kontrak">
                                        <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                            Harga:</label>
                                        <input id="modal-harga" type="text" value="" name="harga"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4" id="deposit-kontrak">
                                        <label for="deposit" class="w-32 text-md font-medium text-gray-700">
                                            Deposit:</label>
                                        <input id="modal-deposit" type="text" value="" name="deposit"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <!-- Container untuk biayaList yang akan diisi melalui AJAX -->
                                    <div id="biaya-container"></div>

                                    <div class="flex items-center space-x-4" id="denda-kontrak">
                                        <label for="denda" class="w-32 text-md font-medium text-gray-700">
                                            Denda:</label>
                                        <input id="modal-denda" type="text" value="" name="denda"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="total" class="w-32 text-md font-medium text-gray-700">
                                            Total Bayar:</label>
                                        <input id="modal-total" type="text" value="" name="total"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="metode" class="w-32 text-md font-medium text-gray-700">
                                            Metode Pembayaran:</label>
                                        <select id="modal-metode" name="metode"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">

                                        </select>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                            Keterangan:</label>
                                        <textarea id="modal-keterangan" type="text" value="" rows="2"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                    </div>

                                    <div class="text-center">
                                        <p class="text-gray-500 text-sm">Upload Bukti Pembayaran</p>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="bukti" class="w-32 text-md font-medium text-gray-700">
                                            Bukti:</label>
                                        <input required id="modal-buat-bukti" type="file" value=""
                                            name="bukti"
                                            class="w-20 flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                    </div>

                                    {{-- hidden idpembayaran --}}
                                    <input id="modal-idPembayaran" type="hidden" name="idPembayaran"
                                        value="">
                                </div>
                                {{-- subnmit --}}
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button type="submit" id="pay-button"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Bayar
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
            </div>
        </section>

        {{-- PAGE RIWAYAT --}}
        <section id="pembayaran" class="hidden">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Penyewa</th>
                            <th class="py-3 px-4">Nominal</th>
                            <th class="py-3 px-4">Tanggal Pembayaran</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($riwayatTagihan as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->dibayar }}</td>
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
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Riwayat
                                    Tagihan
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
                                    <input id="modal-riwayat-kamar" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                        Nama Penyewa:</label>
                                    <input id="modal-riwayat-nama" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tgl_tagihan" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Tagihan:</label>
                                    <input id="modal-riwayat-tgl_tagihan" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tgl_denda" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Denda:</label>
                                    <input id="modal-riwayat-tgl_denda" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="rentang" class="w-32 text-md font-medium text-gray-700">
                                        Rentang:</label>
                                    <input id="modal-riwayat-rentang" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="text-center">
                                    <p class="text-gray-500 text-sm">Nominal Pembayaran</p>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                        Harga:</label>
                                    <input id="modal-riwayat-harga" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4" id="riwayat-deposit">
                                    <label for="deposit" class="w-32 text-md font-medium text-gray-700">
                                        Deposit:</label>
                                    <input id="modal-riwayat-deposit" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <!-- Container untuk biayaList yang akan diisi melalui AJAX -->
                                <div id="riwayat-container"></div>

                                <div class="flex items-center space-x-4" id="riwayat-denda">
                                    <label for="denda" class="w-32 text-md font-medium text-gray-700">
                                        Denda:</label>
                                    <input id="modal-riwayat-denda" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="total" class="w-32 text-md font-medium text-gray-700">
                                        Total Bayar:</label>
                                    <input id="modal-riwayat-total" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="metode" class="w-32 text-md font-medium text-gray-700">
                                        Metode Pembayaran:</label>
                                    <input id="modal-riwayat-metode" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="text-center">
                                    <p class="text-gray-500 text-sm">Bukti Pembayaran</p>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Pembayaran:</label>
                                    <input id="modal-riwayat-tanggal" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="status" class="w-32 text-md font-medium text-gray-700">
                                        Status:</label>
                                    <input id="modal-riwayat-status" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                        Keterangan:</label>
                                    <textarea id="modal-riwayat-keterangan" type="text" value="" rows="2"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                </div>

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

{{-- JS --}}
<script>
    function switchPage(page) {
        const listSection = document.getElementById('list');
        const pembayaranSection = document.getElementById('pembayaran');
        const btnList = document.getElementById('btnList');
        const btnPembayaran = document.getElementById('btnPembayaran');

        // Menghilangkan semua section
        listSection.classList.add('hidden');
        pembayaranSection.classList.add('hidden');

        // Menghilangkan aktifasi dari button
        btnList.classList.remove('bg-indigo-600', 'text-white');
        btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        btnPembayaran.classList.remove('bg-indigo-600', 'text-white');
        btnPembayaran.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

        if (page === 'list') {
            // Tampilkan halaman Fasilitas dan set button aktif
            listSection.classList.remove('hidden');
            btnList.classList.add('bg-indigo-600', 'text-white');
            btnList.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        } else if (page === 'pembayaran') {
            // Tampilkan halaman Kamar dan set button aktif
            pembayaranSection.classList.remove('hidden');
            btnPembayaran.classList.add('bg-indigo-600', 'text-white');
            btnPembayaran.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300',
            'hover:bg-gray-50');
        }

        // Memberikan sedikit delay sebelum scroll
        setTimeout(function() {
            window.scrollTo(0, 0);
        }, 50);
    }
</script>

{{-- AJAX DETAIL + BIAYA --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-tagihan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/detailTagihan/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-nama').val(data.data.nama);
                    $('#modal-total').val(data.data.total_bayar);
                    $('#modal-tempo').val(data.data.denda);
                    $('#modal-tagihan').val(data.data.tagihan);
                    $('#modal-status').val(data.data.status_pembayaran);
                    $('#modal-rentang').val(data.data.waktu + " " + data.data.rentang);
                    $('#modal-harga').val(data.data.harga);
                    $('#modal-keterangan').val(data.data.keterangan_pembayaran);
                    $('#modal-idPembayaran').val(data.data.idPembayaran);

                    // menambahkan biaya lainnya kedalaam modal
                    $('#biaya-container').empty();
                    $.each(data.biayaList, function(index, biaya) {
                        $('#biaya-container').append(`
                        <div class="mb-2 flex items-center space-x-4">
                            <label for="${biaya.biaya}" class="w-32 text-md font-medium text-gray-700">${biaya.biaya}:</label>
                                <input type="text" id="${biaya.biaya}" name="${biaya.biaya}" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" 
                                value="${biaya.harga}" readonly>
                            </div>
                        `);
                    });

                    $('#modal-metode').empty();
                    $.each(data.metode, function(index, metode) {
                        $('#modal-metode').append(
                            `<option value="${metode.idMetodePembayaran}">${metode.metode} - ${metode.nomor_tujuan}</option>`
                        );
                    });

                    if (data.data.status_pembayaran === 'Revisi') {
                        $('#deposit-kontrak').addClass('hidden');
                        $('#denda-kontrak').addClass('hidden');
                        $('#harga-kontrak').addClass('hidden');
                    }
                    else {
                        $('#harga-kontrak').removeClass('hidden');
                    }

                    // Logika untuk denda
                    const today = new Date();
                    const dendaDate = new Date(data.data.denda);

                    if (today >= dendaDate && data.denda) {
                        $('#denda-kontrak').removeClass('hidden');
                        
                        const jenisDenda = data.denda.jenis_denda;
                        const totalBayar = parseFloat(data.data.total_bayar);
                        const angka = parseFloat(data.denda.angka);
                        const angkaMingguan = parseFloat(data.denda.angka_mingguan);
                        const angkaHarian = parseFloat(data.denda.angka_harian);
                        const rentang = data.data.rentang;
                        const nilaiDenda = rentang === 'Bulan' ? angka : rentang === 'Mingguan' ? angkaMingguan : angkaHarian;

                        let denda = 0;

                        if (data.data.status_kontrak === 'Pembayaran Perdana') {
                            if (data.data.deposit !== null) {
                                const deposit = parseFloat(data.data.deposit);

                                if (jenisDenda === 'Nominal') {
                                    denda = nilaiDenda;
                                } else if (jenisDenda === 'Persen') {
                                    denda = ((totalBayar - deposit) * nilaiDenda) / 100;
                                } else {
                                    const hari = Math.abs(today - dendaDate);
                                    const formatHari = Math.ceil(hari / (1000 * 60 * 60 *
                                        24));

                                    denda = (formatHari * nilaiDenda) - deposit;
                                }
                            } else {
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
                        $('#modal-denda').val(denda);
                        $('#modal-total').val(totalBayar + denda);
                    } else {
                        $('#denda-kontrak').addClass('hidden');
                        $('#modal-denda').val('');
                        $('#modal-total').val(data.data.total_bayar);
                    }

                    // DEPOSIT KONTRAK
                    if (data.data.deposit === null || data.data.status_kontrak === 'Aktif') {
                        $('#deposit-kontrak').addClass('hidden');
                    } else {
                        $('#deposit-kontrak').removeClass('hidden');
                        $('#modal-deposit').val(data.data.deposit);
                    }



                    // mengirim id ke editpembayaran yang sesuai
                    $('#edit-pembayaran-btn').attr('href', '/list/edit-pembayaran/' + id);
                }
            });
        });

        $('.lihat-detail-verifikasi').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/detailMenungguVerifikasi/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-verifikasi-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-verifikasi-nama').val(data.data.nama);
                    $('#modal-verifikasi-total').val(data.data.dibayar);
                    $('#modal-verifikasi-tempo').val(data.data.denda);
                    $('#modal-verifikasi-tagihan').val(data.data.tagihan);
                    $('#modal-verifikasi-status').val(data.data.status_pembayaran);
                    $('#modal-verifikasi-rentang').val(data.data.waktu + " " + data.data.rentang);
                    $('#modal-verifikasi-harga').val(data.data.harga);
                    $('#modal-verifikasi-metode').val(data.data.metode + " - " + data.data.nomor_tujuan);
                    $('#modal-verifikasi-keterangan').val(data.data.keterangan_pembayaran);
                    $('#modal-verifikasi-idPembayaran').val(data.data.idPembayaran);

                    // menambahkan biaya lainnya kedalaam modal
                    $('#biaya-verifikasi-container').empty();
                    $.each(data.biayaList, function(index, biaya) {
                        $('#biaya-verifikasi-container').append(`
                        <div class="mb-2 flex items-center space-x-4">
                            <label for="${biaya.biaya}" class="w-32 text-md font-medium text-gray-700">${biaya.biaya}:</label>
                                <input type="text" id="${biaya.biaya}" name="${biaya.biaya}" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" 
                                value="${biaya.harga}" readonly>
                            </div>
                        `);
                    });

                    // DEPOSIT KONTRAK
                    if (data.data.deposit === null || data.data.kontrak === 'Aktif') {
                        $('#deposit-verifikasi-kontrak').addClass('hidden');
                    } else {
                        $('#deposit-verifikasi-kontrak').removeClass('hidden');
                        $('#modal-verifikasi-deposit').val(data.data.deposit);
                    }

                    // DENDA KONTRAK
                    if (data.denda === null) {
                        $('#denda-verifikasi-kontrak').addClass('hidden');
                    } else {
                        $('#denda-verifikasi-kontrak').removeClass('hidden');
                        $('#modal-verifikasi-denda').val(data.denda.nominal_denda);
                    }
                }
            });
        });
    });
</script>

{{-- RIWAYAT --}}
<script>
    $('.lihat-detail-riwayat').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            url: '/detailRiwayatTagihan/' + id,
            type: 'GET',
            success: function(data) {
                $('#modal-riwayat-kamar').val('Kamar ' + data.data.idKamar);
                $('#modal-riwayat-nama').val(data.data.nama);
                $('#modal-riwayat-tgl_tagihan').val(data.data.tgl_tagihan);
                $('#modal-riwayat-tgl_denda').val(data.data.tgl_denda);
                $('#modal-riwayat-rentang').val(data.data.waktu + " " + data.data.rentang);
                $('#modal-riwayat-harga').val(data.data.harga);
                $('#modal-riwayat-deposit').val(data.data.deposit);
                $('#modal-riwayat-total').val(data.data.dibayar);
                $('#modal-riwayat-metode').val(data.data.metode + " - " + data.data.nomor_tujuan);
                $('#modal-riwayat-tanggal').val(data.data.tanggal);
                $('#modal-riwayat-status').val(data.data.status_pembayaran);
                $('#modal-riwayat-keterangan').val(data.data.keterangan_pembayaran);

                // menambahkan biaya lainnya kedalaam modal
                $('#riwayat-container').empty();

                $.each(data.biayaList, function(index, biaya) {
                    $('#riwayat-container').append(`
                    <div class="mb-2 flex items-center space-x-4">
                        <label for="${biaya.biaya}" class="w-32 text-md font-medium text-gray-700">${biaya.biaya}:</label>
                            <input type="text" id="${biaya.biaya}" name="${biaya.biaya}" 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" 
                            value="${biaya.harga}" readonly>
                        </div>
                    `);
                });

                if (!data.denda || data.denda.nominal_denda === null) {
                    $('#riwayat-denda').addClass('hidden');
                } else {
                    $('#riwayat-denda').removeClass('hidden');
                    $('#modal-riwayat-denda').val(data.denda.nominal_denda);
                }
            }
        });
    });
</script>
