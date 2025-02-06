<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>

        {{-- TOP KONTEN --}}
        <section class="flex justify-between items-center mb-6">
            <div class="flex items-center justify-between px-3 py-3 rounded-lg">
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <!-- Tab navigasi -->
                    <a href="#list" id="btnList" onclick="switchPage('list')"
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">
                        Layanan Tambahan</a>
                    <a href="#pesanan" id="btnPesanan" onclick="switchPage('pesanan')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                        Pesanan</a>
                    <a href="#riwayat" id="btnRiwayat" onclick="switchPage('riwayat')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                        Riwayat Pembelian</a>
                </nav>

                {{-- JS --}}
                <script>
                    function switchPage(page) {
                        var listSection = document.getElementById('list');
                        var pesananSection = document.getElementById('pesanan');
                        var riwayatSection = document.getElementById('riwayat');
                        var btnList = document.getElementById('btnList');
                        var btnPesanan = document.getElementById('btnPesanan');
                        var btnRiwayat = document.getElementById('btnRiwayat');

                        listSection.classList.add('hidden');
                        pesananSection.classList.add('hidden');
                        riwayatSection.classList.add('hidden');

                        btnList.classList.remove('bg-indigo-600', 'text-white');
                        btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                        btnPesanan.classList.remove('bg-indigo-600', 'text-white');
                        btnPesanan.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                        btnRiwayat.classList.remove('bg-indigo-600', 'text-white');
                        btnRiwayat.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

                        if (page === 'list') {
                            listSection.classList.remove('hidden');
                            btnList.classList.add('bg-indigo-600', 'text-white');
                            btnList.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                        } else if (page === 'pesanan') {
                            pesananSection.classList.remove('hidden');
                            btnPesanan.classList.add('bg-indigo-600', 'text-white');
                            btnPesanan.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                        } else if (page === 'riwayat') {
                            riwayatSection.classList.remove('hidden');
                            btnRiwayat.classList.add('bg-indigo-600', 'text-white');
                            btnRiwayat.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                        }

                        setTimeout(function() {
                            window.scrollTo(0, 0);
                        }, 50);
                    }
                </script>
            </div>
        </section>

        <!-- PAGE LAYANAN TAMBAHAN -->
        <section id="list" class="block">
            {{-- LIST LAYANAN --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click transaksi untuk melakukan pembelian.</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Jumlah</th>
                            <th class="py-3 px-4">Keterangan</th>
                            <th class="py-2 px-4">Transaksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($layananTambahan as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ $item->nama_item }}</td>
                                <td class="py-3 px-4">{{ $item->harga }}</td>
                                <td class="py-3 px-4">{{ $item->stok }}</td>
                                <td class="py-3 px-4">{{ $item->keterangan }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idLayananTambahan }}" data-toggle="modal"
                                        data-target="#ModalLayanan"
                                        class="lihat-detail-layanan text-indigo-500 hover:text-indigo-700 transition">
                                        Beli Layanan <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada layanan
                                    tambahan untuk kos ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <main id="modal-bagian-pembelian">
                    {{-- MODAL DATA --}}
                    <div class="modal fade p-4" id="ModalLayanan" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                {{-- HEADER --}}
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Layanan
                                        Tambahan</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal"
                                        aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                {{-- TRANSAKSI --}}
                                <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body p-6 space-y-2">
                                        <!-- AJAX -->
                                        <div class="flex items-center space-x-4">
                                            <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                                Nama:</label>
                                            <input id="modal-nama" type="text" value="" name="nama"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                                Harga:</label>
                                            <input id="modal-harga" type="text" value="" name="harga"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="stok" class="w-32 text-md font-medium text-gray-700">
                                                Stok:</label>
                                            <input id="modal-stok" type="text" value="" name="stok"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                                Keterangan:</label>
                                            <textarea id="modal-keterangan" type="text" value="" rows="2"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                        </div>

                                        <div class="text-center">
                                            <p class="text-gray-500 text-sm">Lakukan Pembelian Layanan Tambahan</p>
                                        </div>

                                        {{-- JUMLAH + TGL TERIMA --}}
                                        <div class="flex my-2">
                                            <div class="w-30">
                                                <label for="jumlah"
                                                    class="text-md font-medium text-gray-700">Jumlah</label>
                                                <div>
                                                    <input id="modal-jumlah" type="number" value=""
                                                        name="jumlah" required
                                                        class="w-30 flex-1 text-center py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                                </div>
                                            </div>
                                            <div class="ml-2 w-full">
                                                <label for="terima" class="text-md font-medium text-gray-700">Tanggal
                                                    Terima</label>
                                                <div>
                                                    <input id="modal-terima" type="datetime-local" value=""
                                                        name="tgl_terima" required
                                                        class="w-full text-center px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">

                                                    {{-- SETTING DATE --}}
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', () => {
                                                            const tanggalInput = document.getElementById('modal-terima'); // Input tanggal

                                                            // Fungsi untuk mendapatkan tanggal hari ini dalam format YYYY-MM-DD
                                                            const getTodayDate = () => {
                                                                const today = new Date();
                                                                const year = today.getFullYear();
                                                                const month = String(today.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0, jadi +1
                                                                const day = String(today.getDate()).padStart(2, '0');
                                                                return `${year}-${month}-${day}`;
                                                            };

                                                            // Set default tanggal menjadi hari ini
                                                            tanggalInput.value = getTodayDate();

                                                            // Set atribut min agar tidak bisa memilih tanggal sebelum hari ini
                                                            tanggalInput.setAttribute('min', getTodayDate());
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- TOTAL BAYAR --}}
                                        <div class="w-full text-center mt-2 pb-3">
                                            <label for="bayar"
                                                class="text-sm text-center font-medium text-gray-500">Total Bayar</label>
                                            <div>
                                                <input required readonly id="modal-bayar" type="number" value=""
                                                    name="total"
                                                    class="w-full text-center px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                            </div>
                                        </div>

                                        {{-- JENIS PENGANTARAN --}}
                                        <div class="flex items-center space-x-4">
                                            <label for="pengantaran" class="w-32 text-md font-medium text-gray-700">
                                                Pengantaran:</label>
                                            <select id="modal-pengantaran" name="pengantaran" required
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                                <option value="Ambil Sendiri">Ambil Sendiri</option>
                                                <option value="Diantar">Diantar</option>
                                            </select>
                                        </div>

                                        {{-- BUKTI --}}
                                        <div class="flex items-center space-x-4">
                                            <label for="bukti" class="w-32 text-md font-medium text-gray-700">
                                                Bukti:</label>
                                            <input id="modal-bukti" type="file" value="" name="bukti" required
                                                class="w-20 flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                        </div>

                                        {{-- PESAN --}}
                                        <div class="flex items-center space-x-4">
                                            <label for="pesan" class="w-32 text-md font-medium text-gray-700">
                                                Pesan:</label>
                                            <textarea id="modal-pesan" type="text" value="" rows="2" name="pesan"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"></textarea>
                                        </div>

                                        {{-- Hidden idLayanan --}}
                                        <input type="hidden" name="idLayanan" id="modal-idLayanan">

                                    </div>
                                    {{-- FOOTER --}}
                                    <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                        <button type="submit" data-toggle="modal" data-target="#ModalSuksesBeli"
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Beli Layanan
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

                    <!-- Modal sukses beli -->
                    <div class="modal fade p-4" id="ModalSuksesBeli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                <div class="modal-body p-6 space-y-4 text-center">
                                    <!-- Icon Success -->
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 mx-auto">
                                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 14.25l-3.375-3.375M10.125 14.25l6.75-6.75M10.125 14.25l6.75-6.75m0 0L7.5 16.875m0 0L3.75 13.125" />
                                        </svg>
                                    </div>
                                    <!-- Pesan -->
                                    <h3 class="text-lg font-semibold text-gray-900">Pembelian Layanan Berhasil</h3>
                                    <p class="text-sm text-gray-500">Pembelian layanan berhasil dilakukan, tunggu konfirmasi pembayaran.</p>
                                    <div class="mt-4">
                                        <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </section>

        {{-- LIST PESANAN --}}
        <section id="pesanan" class="hidden">

            {{-- REVISI PEMBAYARAN --}}
            @if ($revisiPembayaran->isNotEmpty())
                <section id="antar-pesanan" class="mb-5">
                    <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melakukan pembayaran</p>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <table class="min-w-full table-auto">
                            <thead class=" bg-gray-100">
                                <tr class="text-sm text-gray-600">
                                    <th class="py-3 px-4">Kamar</th>
                                    <th class="py-3 px-4">Nama item</th>
                                    <th class="py-3 px-4">Jumlah</th>
                                    <th class="py-3 px-4">Total Bayar</th>
                                    <th class="py-3 px-4">Status Pembayaran</th>
                                    <th class="py-2 px-4">Bayar</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-800">
                                @forelse ($revisiPembayaran as $item)
                                    <tr class="border-t hover:bg-gray-50 transition duration-200">
                                        <td class="py-3 px-4">Kamar {{ $item->idKamar }}</td>
                                        <td class="py-3 px-4">{{ $item->nama_item }}</td>
                                        <td class="py-3 px-4">{{ $item->jumlah }}</td>
                                        <td class="py-3 px-4">{{ $item->total_bayar }}</td>
                                        <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                        <td class="py-3 px-4">
                                            <a href="#" data-id="{{ $item->idTransaksi }}" data-toggle="modal"
                                                data-target="#ModalRevisi"
                                                class="lihat-detail-revisi text-indigo-500 hover:text-indigo-700 transition">
                                                Lihat Detail <span aria-hidden="true">→</span></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada
                                            tagihan yang belum dibayar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <main id="modal-bagian-revisi">
                            {{-- MODAL DATA --}}
                            <div class="modal fade p-4" id="ModalRevisi" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                    <div class="modal-content rounded-lg shadow-lg bg-white">
                                        {{-- HEADER --}}
                                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Pembayaran
                                            </h3>
                                            <button type="button" class="text-gray-400 hover:text-gray-600"
                                                data-dismiss="modal" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('revisiTransaksi.store') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <!-- AJAX -->
                                            <div class="modal-body p-6 space-y-2">
                                                <div class="flex items-center space-x-4">
                                                    <label for="kamar"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Kamar:</label>
                                                    <input id="modal-revisi-kamar" type="text" value=""
                                                        name="idKamar"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="pembeli"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Pembeli:</label>
                                                    <input id="modal-revisi-pembeli" type="text" value=""
                                                        name="pembeli"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="text-center">
                                                    <p class="text-gray-500 text-sm">Pembelian Layanan Tambahan</p>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="nama"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Nama Barang:</label>
                                                    <input id="modal-revisi-nama" type="text" value=""
                                                        name="item"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="jumlah"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Jumlah:</label>
                                                    <input id="modal-revisi-jumlah" type="text" value=""
                                                        name="jumlah"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="tanggal"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Tanggal:</label>
                                                    <input id="modal-revisi-tanggal" type="text" value=""
                                                        name="tanggal"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="harga"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Total Harga:</label>
                                                    <input id="modal-revisi-total" type="text" value=""
                                                        name="total_bayar"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="pesan"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Pesan:</label>
                                                    <textarea id="modal-revisi-pesan" type="text" value="" rows="2" name="pesan"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                                </div>

                                                <div class="text-center">
                                                    <p class="text-gray-500 text-sm">Masukan bukti pembayaran</p>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="bukti"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Bukti:</label>
                                                    <input id="modal-revisi-bukti" type="file" value=""
                                                        name="bukti"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <input type="hidden" id="modal-revisi-idTransaksi" name="idTransaksi">
                                            </div>
                                            {{-- FOOTER --}}
                                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                                <button type="button"
                                                    class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                    data-dismiss="modal">
                                                    Tutup
                                                </button>
                                                <button type="submit" data-toggle="modal" data-target="#ModalSuksesBayar"
                                                    class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                    Lakukan Pembayaran
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Modal sukses revisi bayar -->
                            <div class="modal fade p-4" id="ModalSuksesBayar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                    <div class="modal-content rounded-lg shadow-lg bg-white">
                                        <div class="modal-body p-6 space-y-4 text-center">
                                            <!-- Icon Success -->
                                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 mx-auto">
                                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 14.25l-3.375-3.375M10.125 14.25l6.75-6.75M10.125 14.25l6.75-6.75m0 0L7.5 16.875m0 0L3.75 13.125" />
                                                </svg>
                                            </div>
                                            <!-- Pesan -->
                                            <h3 class="text-lg font-semibold text-gray-900">Pembayaran Layanan Berhasil</h3>
                                            <p class="text-sm text-gray-500">Pembayaran layanan berhasil dilakukan, tunggu konfirmasi pembayaran.</p>
                                            <div class="mt-4">
                                                <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </section>
            @endif

            {{-- PESANAN YANG BELUM DIANTAR --}}
            @if ($pesanan->isNotEmpty())
                <section id="antar-pesanan" class="mb-5">
                    <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat detail pesanan yang sudah diterima
                    </p>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <table class="min-w-full table-auto">
                            <thead class=" bg-gray-100">
                                <tr class="text-sm text-gray-600">
                                    <th class="py-3 px-4">Kamar</th>
                                    <th class="py-3 px-4">Nama item</th>
                                    <th class="py-3 px-4">Jumlah</th>
                                    <th class="py-3 px-4">Tanggal Terima</th>
                                    <th class="py-3 px-4">Status Pengantaran</th>
                                    <th class="py-2 px-4">Pesanan</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-800">
                                @forelse ($pesanan as $item)
                                    <tr class="border-t hover:bg-gray-50 transition duration-200">
                                        <td class="py-3 px-4">Kamar {{ $item->idKamar }}</td>
                                        <td class="py-3 px-4">{{ $item->nama_item }}</td>
                                        <td class="py-3 px-4">{{ $item->jumlah }}</td>
                                        <td class="py-3 px-4">{{ $item->tgl_terima }}</td>
                                        <td class="py-3 px-4">{{ $item->status_pengantaran }}</td>
                                        <td class="py-3 px-4">
                                            <a href="#" data-id="{{ $item->idTransaksi }}" data-toggle="modal"
                                                data-target="#ModalPengantaran" 
                                                class="lihat-detail-pengantaran text-indigo-500 hover:text-indigo-700 transition">
                                                Sudah diterima <span aria-hidden="true">→</span></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada
                                            layanan tambahan untuk kos ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                            {{-- MODAL DATA --}}
                            <div class="modal fade p-4" id="ModalPengantaran" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                    <div class="modal-content rounded-lg shadow-lg bg-white">
                                        {{-- HEADER --}}
                                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail
                                                Pembelian
                                            </h3>
                                            <button type="button" class="text-gray-400 hover:text-gray-600"
                                                data-dismiss="modal" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('transaksi.pesananSelesai') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <!-- AJAX -->
                                            <div class="modal-body p-6 space-y-2">
                                                <div class="flex items-center space-x-4">
                                                    <label for="kamar"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Kamar:</label>
                                                    <input id="modal-pengantaran-kamar" type="text" value=""
                                                        name="idKamar"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="pembeli"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Pembeli:</label>
                                                    <input id="modal-pengantaran-pembeli" type="text"
                                                        value="" name="pembeli"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="text-center">
                                                    <p class="text-gray-500 text-sm">Pembelian Layanan Tambahan</p>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="nama"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Nama Barang:</label>
                                                    <input id="modal-pengantaran-nama" type="text" value=""
                                                        name="item"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="jumlah"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Jumlah:</label>
                                                    <input id="modal-pengantaran-jumlah" type="text"
                                                        value="" name="jumlah"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="tanggal"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Tanggal:</label>
                                                    <input id="modal-pengantaran-tanggal" type="text"
                                                        value="" name="tanggal"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="harga"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Total Harga:</label>
                                                    <input id="modal-pengantaran-total" type="text" value=""
                                                        name="total_bayar"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="tgl_terima"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Tanggal Terima:</label>
                                                    <input id="modal-pengantaran-tgl_terima" type="text"
                                                        value="" name="tgl_terima"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="status_pengantaran"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Pengantaran:</label>
                                                    <input id="modal-pengantaran-status_pengantaran" type="text"
                                                        value="" name="pengantaran"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="status"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Status:</label>
                                                    <input id="modal-pengantaran-status" type="text"
                                                        value="" name="status"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="pesan"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Pesan:</label>
                                                    <textarea id="modal-pengantaran-pesan" type="text" value="" rows="2" name="pesan"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                                </div>

                                                {{-- input hidden --}}
                                                <input type="hidden" name="idTransaksi"
                                                    id="modal-pengantaran-idTransaksi">
                                                <input type="hidden" name="idLayanan"
                                                    id="modal-pengantaran-idLayanan">
                                                <input type="hidden" name="stok" id="modal-pengantaran-stok">

                                            </div>
                                            {{-- FOOTER --}}
                                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                                <button type="submit" data-toggle="modal" data-target="#ModalSuksesTerantar"
                                                    class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                    Pesanan diterima
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

                            <!-- Modal sukses pesanan terantar -->
                            <div class="modal fade p-4" id="ModalSuksesTerantar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                    <div class="modal-content rounded-lg shadow-lg bg-white">
                                        <div class="modal-body p-6 space-y-4 text-center">
                                            <!-- Icon Success -->
                                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 mx-auto">
                                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 14.25l-3.375-3.375M10.125 14.25l6.75-6.75M10.125 14.25l6.75-6.75m0 0L7.5 16.875m0 0L3.75 13.125" />
                                                </svg>
                                            </div>
                                            <!-- Pesan -->
                                            <h3 class="text-lg font-semibold text-gray-900">Pesanan Berhasil Diterima</h3>
                                            <p class="text-sm text-gray-500">Pesanan berhasil diantar oleh pengelola dan telah diterima.</p>
                                            <div class="mt-4">
                                                <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal sukses pesanan diterima -->
                            <div class="modal fade p-4" id="ModalSuksesDiterima" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                    <div class="modal-content rounded-lg shadow-lg bg-white">
                                        <div class="modal-body p-6 space-y-4 text-center">
                                            <!-- Icon Success -->
                                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 mx-auto">
                                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 14.25l-3.375-3.375M10.125 14.25l6.75-6.75M10.125 14.25l6.75-6.75m0 0L7.5 16.875m0 0L3.75 13.125" />
                                                </svg>
                                            </div>
                                            <!-- Pesan -->
                                            <h3 class="text-lg font-semibold text-gray-900">Pesanan Berhasil Diterima</h3>
                                            <p class="text-sm text-gray-500">Pesanan berhasil diantar oleh pengelola dan telah diterima.</p>
                                            <div class="mt-4">
                                                <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </table>
                    </div>
                </section>
            @endif

            {{-- PESANAN YANG SUDAH DITERIMA --}}
            @if ($konfirmLIst->isNotEmpty())
                <section id="antar-pesanan" class="mb-5">
                    <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat detail pesanan yang sudah diterima
                    </p>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <table class="min-w-full table-auto">
                            <thead class=" bg-gray-100">
                                <tr class="text-sm text-gray-600">
                                    <th class="py-3 px-4">Kamar</th>
                                    <th class="py-3 px-4">Nama item</th>
                                    <th class="py-3 px-4">Jumlah</th>
                                    <th class="py-3 px-4">Tanggal Terima</th>
                                    <th class="py-3 px-4">Status Pengantaran</th>
                                    <th class="py-2 px-4">Pesanan</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-800">
                                @forelse ($konfirmLIst as $item)
                                    <tr class="border-t hover:bg-gray-50 transition duration-200">
                                        <td class="py-3 px-4">Kamar {{ $item->idKamar }}</td>
                                        <td class="py-3 px-4">{{ $item->nama_item }}</td>
                                        <td class="py-3 px-4">{{ $item->jumlah }}</td>
                                        <td class="py-3 px-4">{{ $item->tgl_terima }}</td>
                                        <td class="py-3 px-4">{{ $item->status_pengantaran }}</td>
                                        <td class="py-3 px-4">
                                            <a href="#" data-id="{{ $item->idTransaksi }}" data-toggle="modal"
                                                data-target="#ModalPengantaran"
                                                class="lihat-detail-pengantaran text-indigo-500 hover:text-indigo-700 transition">
                                                Sudah diterima <span aria-hidden="true">→</span></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada
                                            layanan
                                            tambahan untuk kos ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                            {{-- MODAL DATA --}}
                            <div class="modal fade p-4" id="ModalPengantaran" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                    <div class="modal-content rounded-lg shadow-lg bg-white">
                                        {{-- HEADER --}}
                                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail
                                                Pembelian
                                            </h3>
                                            <button type="button" class="text-gray-400 hover:text-gray-600"
                                                data-dismiss="modal" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('transaksi.pesananSelesai') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <!-- AJAX -->
                                            <div class="modal-body p-6 space-y-2">
                                                <div class="flex items-center space-x-4">
                                                    <label for="kamar"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Kamar:</label>
                                                    <input id="modal-pengantaran-kamar" type="text" value=""
                                                        name="idKamar"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="pembeli"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Pembeli:</label>
                                                    <input id="modal-pengantaran-pembeli" type="text"
                                                        value="" name="pembeli"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="text-center">
                                                    <p class="text-gray-500 text-sm">Pembelian Layanan Tambahan</p>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="nama"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Nama Barang:</label>
                                                    <input id="modal-pengantaran-nama" type="text" value=""
                                                        name="item"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="jumlah"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Jumlah:</label>
                                                    <input id="modal-pengantaran-jumlah" type="text"
                                                        value="" name="jumlah"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="tanggal"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Tanggal:</label>
                                                    <input id="modal-pengantaran-tanggal" type="text"
                                                        value="" name="tanggal"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="harga"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Total Harga:</label>
                                                    <input id="modal-pengantaran-total" type="text" value=""
                                                        name="total_bayar"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="tgl_terima"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Tanggal Terima:</label>
                                                    <input id="modal-pengantaran-tgl_terima" type="text"
                                                        value="" name="tgl_terima"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="status_pengantaran"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Pengantaran:</label>
                                                    <input id="modal-pengantaran-status_pengantaran" type="text"
                                                        value="" name="pengantaran"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="status"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Status:</label>
                                                    <input id="modal-pengantaran-status" type="text"
                                                        value="" name="status"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="pesan"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Pesan:</label>
                                                    <textarea id="modal-pengantaran-pesan" type="text" value="" rows="2" name="pesan"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                                </div>

                                                {{-- input hidden --}}
                                                <input type="hidden" name="idTransaksi"
                                                    id="modal-pengantaran-idTransaksi">
                                                <input type="hidden" name="idLayanan"
                                                    id="modal-pengantaran-idLayanan">
                                                <input type="hidden" name="stok" id="modal-pengantaran-stok">

                                            </div>
                                            {{-- FOOTER --}}
                                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                                <button type="submit" data-toggle="modal" data-target="#ModalSuksesSelesai"
                                                    class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                    Sudah diterima
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

                            <!-- Modal sukses pesanan diterima -->
                            <div class="modal fade p-4" id="ModalSuksesSelesai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                    <div class="modal-content rounded-lg shadow-lg bg-white">
                                        <div class="modal-body p-6 space-y-4 text-center">
                                            <!-- Icon Success -->
                                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 mx-auto">
                                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 14.25l-3.375-3.375M10.125 14.25l6.75-6.75M10.125 14.25l6.75-6.75m0 0L7.5 16.875m0 0L3.75 13.125" />
                                                </svg>
                                            </div>
                                            <!-- Pesan -->
                                            <h3 class="text-lg font-semibold text-gray-900">Pesanan Berhasil Diterima</h3>
                                            <p class="text-sm text-gray-500">Pesanan telah diterima oleh penghuni.</p>
                                            <div class="mt-4">
                                                <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </table>
                    </div>
                </section>
            @endif

            {{-- LIST PESANAN --}}
            <section id="list-pesanan" class="mb-5">
                <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat detail pesanan yang sudah diterima</p>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full table-auto">
                        <thead class=" bg-gray-100">
                            <tr class="text-sm text-gray-600">
                                <th class="py-3 px-4">Kamar</th>
                                <th class="py-3 px-4">Nama item</th>
                                <th class="py-3 px-4">Jumlah</th>
                                <th class="py-3 px-4">Tanggal Terima</th>
                                <th class="py-3 px-4">Pengantaran</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-2 px-4">Lihat Detail</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse ($listTransaksi as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">Kamar {{ $item->idKamar }}</td>
                                    <td class="py-3 px-4">{{ $item->nama_item }}</td>
                                    <td class="py-3 px-4">{{ $item->jumlah }}</td>
                                    <td class="py-3 px-4">{{ $item->tgl_terima }}</td>
                                    <td class="py-3 px-4">{{ $item->pengantaran }}</td>
                                    <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                    <td class="py-3 px-4">
                                        <a href="#" data-id="{{ $item->idTransaksi }}" data-toggle="modal"
                                            data-target="#ModalListPesanan"
                                            class="lihat-list-pesanan text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-3 px-4 text-center text-gray-500">Belum ada pesanan yang dilakukan.</td>
                                </tr>
                            @endforelse
                        </tbody>

                        {{-- MODAL DATA --}}
                        <div class="modal fade p-4" id="ModalListPesanan" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    {{-- HEADER --}}
                                    <div class="modal-header border-b border-gray-200 py-4 px-6">
                                        <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail
                                            Pembelian
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
                                    <!-- AJAX -->
                                    <div class="modal-body p-6 space-y-2">
                                        <div class="flex items-center space-x-4">
                                            <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                                Kamar:</label>
                                            <input id="modal-list-kamar" type="text" value=""
                                                name="idKamar"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="pembeli" class="w-32 text-md font-medium text-gray-700">
                                                Pembeli:</label>
                                            <input id="modal-list-pembeli" type="text" value=""
                                                name="pembeli"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="text-center">
                                            <p class="text-gray-500 text-sm">Pembelian Layanan Tambahan</p>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                                Nama Barang:</label>
                                            <input id="modal-list-nama" type="text" value="" name="item"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="jumlah" class="w-32 text-md font-medium text-gray-700">
                                                Jumlah:</label>
                                            <input id="modal-list-jumlah" type="text" value=""
                                                name="jumlah"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="tgl_terima" class="w-32 text-md font-medium text-gray-700">
                                                Tanggal Terima:</label>
                                            <input id="modal-list-tgl_terima" type="text" value=""
                                                name="tgl_terima"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="status_pengantaran"
                                                class="w-32 text-md font-medium text-gray-700">
                                                Pengantaran:</label>
                                            <input id="modal-list-status_pengantaran" type="text" value=""
                                                name="pengantaran"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="status" class="w-32 text-md font-medium text-gray-700">
                                                Status:</label>
                                            <input id="modal-list-status" type="text" value=""
                                                name="status"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="text-center">
                                            <p class="text-gray-500 text-sm">Bukti Pembayaran</p>
                                        </div>
        
                                        <div class="flex items-center space-x-4">
                                            <label for="bukti" class="w-32 text-md font-medium text-gray-700">
                                                Bukti Pembayaran:</label>
                                            <img src="" id="modal-list-foto" alt="Bukti Pembayaran"
                                                class="w-80 h-80 object-cover border border-gray-300 rounded-md">
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                                Total Harga:</label>
                                            <input id="modal-list-total" type="text" value=""
                                                name="total_bayar"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                                Tanggal:</label>
                                            <input id="modal-list-tanggal" type="text" value=""
                                                name="tanggal"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="pesan" class="w-32 text-md font-medium text-gray-700">
                                                Pesan:</label>
                                            <textarea id="modal-list-pesan" type="text" value="" rows="2" name="pesan"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                        </div>

                                        {{-- input hidden --}}
                                        <input type="hidden" name="idTransaksi" id="modal-list-idTransaksi">
                                        <input type="hidden" name="idLayanan" id="modal-list-idLayanan">
                                        <input type="hidden" name="stok" id="modal-list-stok">

                                    </div>
                                    {{-- FOOTER --}}
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
                    </table>
                </div>
            </section>

        </section>

        <!-- PAGE RIWAYAT PEMBELIAN -->
        <section id="riwayat" class="hidden">
            <p class="text-sm text-gray-500 mb-3 px-3">Riwayat pembelian yang telah dilakukan.</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Nama Layanan</th>
                            <th class="py-3 px-4">Jumlah</th>
                            <th class="py-3 px-4">Total Bayar</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($riwayatTransaksi as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ $item->nama_item }}</td>
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->dibayar }}</td>
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idTransaksi }}" data-toggle="modal"
                                        data-target="#ModalTransaksi"
                                        class="lihat-detail-transaksi text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada riwayat
                                    transaksi dari penghuni.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalTransaksi" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            {{-- header --}}
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Pembelian
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
                                    <label for="pembeli" class="w-32 text-md font-medium text-gray-700">
                                        Pembeli:</label>
                                    <input id="modal-detail-pembeli" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                        Nama Barang:</label>
                                    <input id="modal-detail-nama" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal:</label>
                                    <input id="modal-detail-tanggal" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="jumlah" class="w-32 text-md font-medium text-gray-700">
                                        Jumlah:</label>
                                    <input id="modal-detail-jumlah" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tgl_terima" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Terima:</label>
                                    <input id="modal-detail-tgl_terima" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="pengantaran" class="w-32 text-md font-medium text-gray-700">
                                        Pengantaran:</label>
                                    <input id="modal-detail-pengantaran" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="text-center">
                                    <p class="text-gray-500 text-sm">Bukti Pembayaran</p>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="bukti" class="w-32 text-md font-medium text-gray-700">
                                        Bukti Pembayaran:</label>
                                    <img src="" id="modal-detail-foto" alt="Bukti Pembayaran"
                                        class="w-80 h-80 object-cover border border-gray-300 rounded-md">
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="total" class="w-32 text-md font-medium text-gray-700">
                                        Total Bayar:</label>
                                    <input id="modal-detail-total" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="status" class="w-32 text-md font-medium text-gray-700">
                                        Status:</label>
                                    <input id="modal-detail-status" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="pesan" class="w-32 text-md font-medium text-gray-700">
                                        Pesan:</label>
                                    <textarea id="modal-detail-pesan" type="text" value="" rows="2"
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



{{-- AJAX DETAIL --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-layanan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/detailPembelian/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-nama').val(data.nama_item);
                    $('#modal-harga').val(data.harga);
                    $('#modal-stok').val(data.stok);
                    $('#modal-keterangan').val(data.keterangan);
                    $('#modal-idLayanan').val(data.idLayananTambahan);
                }
            });
        });

        $('.lihat-list-pesanan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/pembelian/listPesanan/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-list-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-list-pembeli').val(data.data.nama);
                    $('#modal-list-nama').val(data.data.nama_item);
                    $('#modal-list-tanggal').val(data.data.tanggal);
                    $('#modal-list-jumlah').val(data.data.jumlah);
                    $('#modal-list-total').val(data.data.total_bayar);
                    $('#modal-list-tgl_terima').val(data.data.tgl_terima);
                    $('#modal-list-status_pengantaran').val(data.data.status_pengantaran);
                    $('#modal-list-status').val(data.data.status_pembayaran);
                    $('#modal-list-pesan').val(data.data.pesan);
                    $('#modal-list-foto').attr('src', data.gambar_url);

                    $('#modal-list-idTransaksi').val(data.data.idTransaksi);
                    $('#modal-list-idLayanan').val(data.data.idLayananTambahan);
                    $('#modal-list-stok').val(data.data.stok);
                }
            });
        });

        $('.lihat-detail-revisi').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/pembelian/revisiPembayaran/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-revisi-kamar').val('Kamar ' + data.idKamar);
                    $('#modal-revisi-pembeli').val(data.nama);
                    $('#modal-revisi-nama').val(data.nama_item);
                    $('#modal-revisi-tanggal').val(data.tanggal);
                    $('#modal-revisi-jumlah').val(data.jumlah);
                    $('#modal-revisi-total').val(data.total_bayar);
                    $('#modal-revisi-pesan').val(data.pesan);

                    $('#modal-revisi-idTransaksi').val(data.idTransaksi);
                }
            });
        });

        $('.lihat-detail-pengantaran').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/detailPengantaran/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-pengantaran-kamar').val('Kamar ' + data.idKamar);
                    $('#modal-pengantaran-pembeli').val(data.nama);
                    $('#modal-pengantaran-nama').val(data.nama_item);
                    $('#modal-pengantaran-tanggal').val(data.tanggal);
                    $('#modal-pengantaran-jumlah').val(data.jumlah);
                    $('#modal-pengantaran-total').val(data.total_bayar);
                    $('#modal-pengantaran-tgl_terima').val(data.tgl_terima);
                    $('#modal-pengantaran-status_pengantaran').val(data.status_pengantaran);
                    $('#modal-pengantaran-status').val(data.status_pembayaran);
                    $('#modal-pengantaran-pesan').val(data.pesan);

                    $('#modal-pengantaran-idTransaksi').val(data.idTransaksi);
                    $('#modal-pengantaran-idLayanan').val(data.idLayananTambahan);
                    $('#modal-pengantaran-stok').val(data.stok);
                }
            });
        });

        $('.lihat-detail-transaksi').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/detailRiwayatPembelian/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-detail-pembeli').val('Kamar ' + data.data.idKamar);
                    $('#modal-detail-nama').val(data.data.nama_item);
                    $('#modal-detail-tanggal').val(data.data.tanggal);
                    $('#modal-detail-jumlah').val(data.data.jumlah);
                    $('#modal-detail-tgl_terima').val(data.data.tgl_terima);
                    $('#modal-detail-pengantaran').val(data.data.pengantaran);
                    $('#modal-detail-total').val(data.data.dibayar);
                    $('#modal-detail-status').val(data.data.status_pembelian);
                    $('#modal-detail-pesan').val(data.data.pesan);
                    $('#modal-detail-foto').attr('src', data.gambar_url);
                }
            });
        });
    });
</script>

{{-- JS TAGIHAN --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const jumlahInput = document.getElementById('modal-jumlah');
        const hargaInput = document.getElementById('modal-harga');
        const stokInput = document.getElementById('modal-stok');
        const totalBayarInput = document.getElementById('modal-bayar');

        // Fungsi untuk memperbarui total bayar
        const updateTotalBayar = () => {
            const jumlah = parseInt(jumlahInput.value) || 0; // Nilai jumlah (default 0 jika kosong)
            const harga = parseFloat(hargaInput.value) || 0; // Nilai harga (default 0 jika kosong)
            const stok = parseInt(stokInput.value) || 0; // Nilai stok (default 0 jika kosong)

            // Batasi nilai jumlah agar tidak melebihi stok
            if (jumlah > stok) {
                jumlahInput.value = stok;
            }

            // Hitung ulang total bayar
            const validJumlah = Math.min(jumlah, stok); // Pastikan jumlah tidak lebih dari stok
            const totalBayar = validJumlah * harga;

            // Tetapkan nilai total bayar
            totalBayarInput.value = totalBayar.toFixed(0); // Format menjadi dua desimal
        };

        // Event listener untuk perubahan jumlah
        jumlahInput.addEventListener('input', () => {
            const jumlah = parseInt(jumlahInput.value) || 0;

            // Cegah nilai negatif
            if (jumlah < 0) {
                jumlahInput.value = 0;
            }

            updateTotalBayar();
        });

        // Event listener untuk perubahan stok atau harga, jika diperlukan
        stokInput.addEventListener('input', updateTotalBayar);
        hargaInput.addEventListener('input', updateTotalBayar);

        // Inisialisasi total bayar saat halaman dimuat
        updateTotalBayar();
    });
</script>
