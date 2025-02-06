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
                    <a href="#pesanan" id="btnPesanan" onclick="switchPage('pesanan')"
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">
                        Pesanan</a>
                    <a href="#list" id="btnList" onclick="switchPage('list')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                        Layanan Tambahan</a>
                    <a href="#riwayat" id="btnRiwayat" onclick="switchPage('riwayat')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                        Riwayat Pembelian</a>
                </nav>
            </div>

            {{-- JS --}}
            <script>
                function switchPage(page) {
                    const pesananSection = document.getElementById('pesanan');
                    const listSection = document.getElementById('list');
                    const riwayatSection = document.getElementById('riwayat');
                    const btnPesanan = document.getElementById('btnPesanan');
                    const btnList = document.getElementById('btnList');
                    const btnRiwayat = document.getElementById('btnRiwayat');

                    // Sembunyikan semua section
                    pesananSection.classList.add('hidden');
                    listSection.classList.add('hidden');
                    riwayatSection.classList.add('hidden');

                    // Atur ulang semua tombol
                    btnPesanan.classList.remove('bg-indigo-600', 'text-white');
                    btnPesanan.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnList.classList.remove('bg-indigo-600', 'text-white');
                    btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnRiwayat.classList.remove('bg-indigo-600', 'text-white');
                    btnRiwayat.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

                    // Tampilkan section yang dipilih
                    if (page === 'pesanan') {
                        pesananSection.classList.remove('hidden');
                        btnPesanan.classList.add('bg-indigo-600', 'text-white');
                        btnPesanan.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'list') {
                        listSection.classList.remove('hidden');
                        btnList.classList.add('bg-indigo-600', 'text-white');
                        btnList.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'riwayat') {
                        riwayatSection.classList.remove('hidden');
                        btnRiwayat.classList.add('bg-indigo-600', 'text-white');
                        btnRiwayat.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    }

                    // Scroll ke atas
                    setTimeout(() => window.scrollTo(0, 0), 50);
                }
            </script>

        </section>

        {{-- PAGE PESANAN --}}
        <section id="pesanan" class="block">
            {{-- VERIFIKASI --}}
            <div id="verifikasi">
                <p class="text-sm text-gray-500 mb-3 px-3">Click Verifikasi apabila pembayaran</p>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full table-auto">
                        <thead class=" bg-gray-100">
                            <tr class="text-sm text-gray-600">
                                <th class="py-3 px-4">Kamar</th>
                                <th class="py-3 px-4">Nama item</th>
                                <th class="py-3 px-4">Jumlah</th>
                                <th class="py-3 px-4">Total Bayar</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="text-right py-2 px-4">Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse ($verifikasi as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">Kamar {{ $item->idKamar }}</td>
                                    <td class="py-3 px-4">{{ $item->nama_item }}</td>
                                    <td class="py-3 px-4">{{ $item->jumlah }}</td>
                                    <td class="py-3 px-4">{{ $item->total_bayar }}</td>
                                    <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                    <td class="text-right py-3 px-4">
                                        <a href="#" data-id="{{ $item->idTransaksi }}" data-toggle="modal"
                                            data-target="#ModalVerifikasiTransaksi"
                                            class="verifikasi-pembayaran text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Bukti <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada pesanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <main id="modal-bagian-pesanan">
                        {{-- MODAL DATA --}}
                        <div class="modal fade p-4" id="ModalVerifikasiTransaksi" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <form action="{{ route('transaksi.verifikasiPembayaran') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        {{-- header --}}
                                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Verifikasi
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
                                            <!-- AJAX -->
                                            <div class="flex items-center space-x-4">
                                                <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                                    Kamar:</label>
                                                <input id="modal-bukti-kamar" type="text" value="" name="idKamar"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    disabled>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                                    Nama Pembeli:</label>
                                                <input id="modal-bukti-nama" type="text" value="" name="nama"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    disabled>
                                            </div>

                                            <div class="text-center">
                                                <p class="text-gray-500 text-sm">Pembelian Layanan Tambahan</p>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                                    Nama Barang:</label>
                                                <input id="modal-bukti-item" type="text" value="" name="nama_item"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    readonly>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="jumlah" class="w-32 text-md font-medium text-gray-700">
                                                    Jumlah:</label>
                                                <input id="modal-bukti-jumlah" type="text" value=""
                                                    name="jumlah"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    readonly>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="status" class="w-32 text-md font-medium text-gray-700">
                                                    Status:</label>
                                                <input id="modal-bukti-status" type="text" value=""
                                                    name="status"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    readonly>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="pengantaran" class="w-32 text-md font-medium text-gray-700">
                                                    Pengantaran:</label>
                                                <input id="modal-bukti-pengantaran" type="text" value=""
                                                    name="pengantaran"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    readonly>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="pengambilan" class="w-32 text-md font-medium text-gray-700">
                                                    Tanggal Ambil:</label>
                                                <input id="modal-bukti-pengambilan" type="text" value=""
                                                    name="pengambilan"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    readonly>
                                            </div>

                                            <div class="text-center">
                                                <p class="text-gray-500 text-sm">Bukti Pembayaran</p>
                                            </div>
            
                                            <div class="flex items-center space-x-4">
                                                <label for="bukti" class="w-32 text-md font-medium text-gray-700">
                                                    Bukti Pembayaran:</label>
                                                <img src="" id="modal-bukti-foto" alt="Bukti Pembayaran"
                                                    class="w-80 h-80 object-cover border border-gray-300 rounded-md">
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="total_bayar" class="w-32 text-md font-medium text-gray-700">
                                                    Total Bayar:</label>
                                                <input id="modal-bukti-total_bayar" type="text" value=""
                                                    name="total_bayar"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    readonly>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                                    Tanggal:</label>
                                                <input id="modal-bukti-tanggal" type="text" value=""
                                                    name="tanggal"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    readonly>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="pesan" class="w-32 text-md font-medium text-gray-700">
                                                    Pesan:</label>
                                                <textarea id="modal-bukti-pesan" type="text" value="" rows="2" name="status"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                            </div>

                                            <input type="hidden" id="modal-bukti-idTransaksi" name="idTransaksi">

                                        </div>
                                        {{-- SUBMIT --}}
                                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                            <button type="button" name="action" value="tolak" data-toggle="modal"
                                                data-target="#ModalTolakPembayaran" data-dismiss="modal"
                                                class="verifikasi-pembayaran rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-600">
                                                Pembayaran Salah
                                            </button>
                                            <button type="submit" name="action" value="verifikasi" data-toggle="modal" data-target="#ModalSuksesVerifikasiTransaksi" 
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Verifikasi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal sukses verifikasi -->
                        <div class="modal fade p-4" id="ModalSuksesVerifikasiTransaksi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                        <h3 class="text-lg font-semibold text-gray-900">Transaksi Berhasil Diverifikasi</h3>
                                        <p class="text-sm text-gray-500">Transaksi telah lunas dan disimpan oleh sistem.</p>
                                        <div class="mt-4">
                                            <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL REVISI --}}
                        <div class="modal fade p-4" id="ModalTolakPembayaran" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <form action="{{ route('transaksi.verifikasiPembayaran') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        {{-- header --}}
                                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Revisi
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
                                            <!-- AJAX -->
                                            <div class="flex items-center space-x-4">
                                                <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                                    Nama Pembeli:</label>
                                                <input id="modal-revisi-nama" type="text" value=""
                                                    name="nama"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    disabled>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="belanja" class="w-32 text-md font-medium text-gray-700">
                                                    Belanja:</label>
                                                <input id="modal-revisi-belanja" type="text" value=""
                                                    name="belanja"
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
                                                <input id="modal-revisi-nominal" type="text" value=""
                                                    name="nominal"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                            </div>

                                            {{-- pesan --}}
                                            <div class="flex items-center space-x-4 mt-4">
                                                <label for="pesan" class="w-32 text-md font-medium text-gray-700">
                                                    Pesan:</label>
                                                <textarea id="modal-revisi-pesan" type="text" value="" rows="2" name="pesan"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"></textarea>
                                            </div>

                                            <input type="hidden" id="modal-revisi-idTransaksi" name="idTransaksi">
                                            <input type="hidden" id="modal-revisi-idKontrak" name="idKontrak">
                                            <input type="hidden" id="modal-revisi-idLayanan" name="idLayanan">
                                            <input type="hidden" id="modal-revisi-jumlah" name="jumlah">
                                            <input type="hidden" id="modal-revisi-total_bayar" name="total_bayar">
                                            <input type="hidden" id="modal-revisi-tanggal" name="tanggal">
                                            <input type="hidden" id="modal-revisi-tgl_terima" name="tgl_terima">
                                            <input type="hidden" id="modal-revisi-pengantaran" name="pengantaran">
                                            <input type="hidden" id="modal-revisi-status_pengantaran"
                                                name="status_pengantaran">

                                        </div>
                                        {{-- SUBMIT --}}
                                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                            <button type="button" data-dismiss="modal"
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Tutup
                                            </button>
                                            <button type="submit" name="action" value="tolak" data-toggle="modal" data-target="#ModalSuksesTolakVerifikasi"
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Revisi Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal sukses tolak verifikasi -->
                        <div class="modal fade p-4" id="ModalSuksesTolakVerifikasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                        <h3 class="text-lg font-semibold text-gray-900">Transaksi Berhasil Direvisi</h3>
                                        <p class="text-sm text-gray-500">Transaksi telah direvisi dan dikirim tagihan telah dikirimkan.</p>
                                        <div class="mt-4">
                                            <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>

                </div>
            </div>

            {{-- PENGANTARAN - DIANTAR --}}
            @if ($pesanan->isNotEmpty())
                <div id="pengantaran" class="mt-5">
                    <p class="text-sm text-gray-500 mb-3 px-3">CLick Pengantaran Barang Apabila Pesanan Sudah diantar
                    </p>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <table class="min-w-full table-auto">
                            <thead class=" bg-gray-100">
                                <tr class="text-sm text-gray-600">
                                    <th class="py-3 px-4">Kamar</th>
                                    <th class="py-3 px-4">Nama item</th>
                                    <th class="py-3 px-4">Jumlah</th>
                                    <th class="py-3 px-4">Tanggal Pengantaran</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4">Pesan</th>
                                    <th class="text-right py-2 px-4">Lakukan Pengantaran</th>
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
                                        <td class="py-3 px-4">{{ $item->pesan }}</td>
                                        <td class="text-right py-3 px-4">
                                            <form action="{{ route('pengantaran.layanan', $item->idTransaksi) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" data-toggle="modal" data-target="#ModalSuksesSudahDiantar"
                                                    class="text-indigo-500 hover:text-indigo-700 transition">
                                                    Pesanan Selesai <span aria-hidden="true">→</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada
                                            pesanan yang perlu di antar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Modal pesanan sukses diantar -->
                        <div class="modal fade p-4" id="ModalSuksesSudahDiantar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                        <h3 class="text-lg font-semibold text-gray-900">Pesanan Berhasil Diantar</h3>
                                        <p class="text-sm text-gray-500">Pesanan sudah berhasil diantar dan tersimpan oleh sistem.</p>
                                        <div class="mt-4">
                                            <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- PESANAN --}}
            @if ($update->isNotEmpty())
                <div id="pesanan" class="mt-5">
                    <p class="text-sm text-gray-500 mb-3 px-3">Click untuk mengubah barang sudah diterima</p>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <table class="min-w-full table-auto">
                            <thead class=" bg-gray-100">
                                <tr class="text-sm text-gray-600">
                                    <th class="py-3 px-4">Kamar</th>
                                    <th class="py-3 px-4">Nama item</th>
                                    <th class="py-3 px-4">Jumlah</th>
                                    <th class="py-3 px-4">Tanggal Pengantaran</th>
                                    <th class="py-3 px-4">Status Pengantaran</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="text-right py-2 px-4">Pesanan</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-800">
                                @forelse ($update as $item)
                                    <tr class="border-t hover:bg-gray-50 transition duration-200">
                                        <td class="py-3 px-4">Kamar {{ $item->idKamar }}</td>
                                        <td class="py-3 px-4">{{ $item->nama_item }}</td>
                                        <td class="py-3 px-4">{{ $item->jumlah }}</td>
                                        <td class="py-3 px-4">{{ $item->tgl_terima }}</td>
                                        <td class="py-3 px-4">{{ $item->status_pengantaran }}</td>
                                        <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                        <td class="text-right py-3 px-4">
                                            <a href="#" data-id="{{ $item->idTransaksi }}" data-toggle="modal"
                                                data-target="#ModalSelesaikan"
                                                class="selesaikan-pesanan text-indigo-500 hover:text-indigo-700 transition">
                                                Lihat Detail <span aria-hidden="true">→</span></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-3 px-4 text-center text-gray-500">Belum ada pesanan yang diteirma.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <main id="modal-bagian-pesanan-ambilsendiri">
                            {{-- MODAL DATA --}}
                            <div class="modal fade p-4" id="ModalSelesaikan" tabindex="-1" role="dialog"
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
                                        {{-- CONTENT --}}
                                        <form action="{{ route('transaksi.selesaikanPesanan') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <!-- AJAX -->
                                            <div class="modal-body p-6 space-y-2">
                                                <div class="flex items-center space-x-4">
                                                    <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                                        Kamar:</label>
                                                    <input id="modal-selesaikan-kamar" type="text" value=""
                                                        name="idKamar"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="pembeli" class="w-32 text-md font-medium text-gray-700">
                                                        Pembeli:</label>
                                                    <input id="modal-selesaikan-pembeli" typ e="text" value=""
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
                                                    <input id="modal-selesaikan-nama" type="text" value=""
                                                        name="item"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="jumlah" class="w-32 text-md font-medium text-gray-700">
                                                        Jumlah:</label>
                                                    <input id="modal-selesaikan-jumlah" type="text" value=""
                                                        name="jumlah"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                                        Tanggal:</label>
                                                    <input id="modal-selesaikan-tanggal" type="text" value=""
                                                        name="tanggal"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                                        Total Harga:</label>
                                                    <input id="modal-selesaikan-total" type="text" value=""
                                                        name="total_bayar"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="tgl_terima"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Tanggal Terima:</label>
                                                    <input id="modal-selesaikan-tgl_terima" type="text" value=""
                                                        name="tgl_terima"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="status_pengantaran"
                                                        class="w-32 text-md font-medium text-gray-700">
                                                        Pengantaran:</label>
                                                    <input id="modal-selesaikan-status_pengantaran" type="text"
                                                        value="" name="selesaikan"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="status" class="w-32 text-md font-medium text-gray-700">
                                                        Status:</label>
                                                    <input id="modal-selesaikan-status" type="text" value=""
                                                        name="status"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                        readonly>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <label for="pesan" class="w-32 text-md font-medium text-gray-700">
                                                        Pesan:</label>
                                                    <textarea id="modal-selesaikan-pesan" type="text" value="" rows="2" name="pesan"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                                </div>

                                                {{-- input hidden --}}
                                                <input type="hidden" name="idTransaksi" id="modal-selesaikan-idTransaksi">
                                                <input type="hidden" name="idLayanan" id="modal-selesaikan-idLayanan">
                                                <input type="hidden" name="stok" id="modal-selesaikan-stok">

                                            </div>
                                            {{-- FOOTER --}}
                                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                                <button type="submit"  data-toggle="modal" data-target="#ModalSuksesSudahDiambil"
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

                            <!-- Modal sukses sudah diteirma -->
                            <div class="modal fade p-4" id="ModalSuksesSudahDiambil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                            <h3 class="text-lg font-semibold text-gray-900">Pesanan Sudah Diterima</h3>
                                            <p class="text-sm text-gray-500">Pesanan sudah diterima penghuni dan tersimpan oleh sistem.</p>
                                            <div class="mt-4">
                                                <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            @endif
        </section>

        <!-- PAGE LAYANAN TAMBAHAN -->
        <section id="list" class="hidden">
            {{-- LIST LAYANAN --}}
            <section class="mt-5">
                <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr class="text-left text-sm text-gray-600">
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">Harga</th>
                                <th class="py-3 px-4">Jumlah</th>
                                <th class="py-3 px-4">Keterangan</th>
                                <th class="py-2 px-4">Edit</th>
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
                                        <a href="#" data-id="{{ $item->idLayananTambahan }}"
                                            data-toggle="modal" data-target="#ModalLayanan"
                                            class="lihat-detail-layanan text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
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

                    <main id="modal-bagian-layanan-tambahan">
                        {{-- MODAL DATA --}}
                        <div class="modal fade p-4" id="ModalLayanan" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <div class="modal-header border-b border-gray-200 py-4 px-6">
                                        <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Layanan
                                            Tambahan</h3>
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
                                            <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                                Nama:</label>
                                            <input id="modal-nama" type="text" value=""
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                readonly>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                                Harga:</label>
                                            <input id="modal-harga" type="text" value=""
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
                                            <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                                Keterangan:</label>
                                            <textarea id="modal-keterangan" type="text" value="" rows="2"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                        <button type="button" data-toggle="modal" data-target="#ModalHapusLayanan" data-dismiss="modal"
                                            class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500">
                                            Hapus
                                        </button>
                                        <button type="button" data-toggle="modal" data-target="#ModalUbahLayanan" data-dismiss="modal"
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Ubah Layanan
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

                        {{-- MODAL UBAH LAYANAN --}}
                        <div class="modal fade p-4" id="ModalUbahLayanan" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white"> 
                                    <form action="{{ route('layanan-tambahan.updateLayanan') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        {{-- header --}}
                                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Ubah Layanan Tambahan</h3>
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
                                        <div class="modal-body p-6 space-y-2">
                                            <!-- AJAX -->
                                            <div class="flex items-center space-x-4">
                                                <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                                    Nama Layanan Tambahan:</label>
                                                <input id="modal-layanan-nama" type="text" value="" name="nama_item"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    required>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                                    Harga:</label>
                                                <input id="modal-layanan-harga" type="number" value="" name="harga"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    required>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="stok" class="w-32 text-md font-medium text-gray-700">
                                                    Stok:</label>
                                                <input id="modal-layanan-stok" type="number" value="" name="stok"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                    required>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                                    Keterangan:</label>
                                                <textarea id="modal-layanan-keterangan" type="text" value="" rows="2" name="keterangan"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" required></textarea>
                                            </div>

                                            <input type="hidden" id="modal-layanan-idLayananTambahan" name="idLayanan">
                                        </div> 
                                        {{-- SUBMIT --}}
                                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                            <button type="button" data-dismiss="modal" 
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Tutup
                                            </button>
                                            <button type="submit" data-toggle="modal" data-target="#ModalSuksesUbahLayanan" 
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Simpan Perubahan
                                            </button>
                                        </div>                                    
                                    </form>
                                </div>
                            </div>

                            <!-- Modal sukses ubah kamar -->
                            <div class="modal fade p-4" id="ModalSuksesUbahLayanan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                            <h3 class="text-lg font-semibold text-gray-900">Layanan Berhasil Diubah</h3>
                                            <p class="text-sm text-gray-500">Layanan telah diperbaruhi dari sistem.</p>
                                            <div class="mt-4">
                                                <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         {{-- MODAL HAPUS LAYANAN --}}
                         <div class="modal fade p-4" id="ModalHapusLayanan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <div class="modal-body p-6 space-y-2">
                                        <form action="{{ route('layanan.destroy') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="flex items-center space-x-4">
                                                <!-- Icon Warning -->
                                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                    </svg>
                                                </div>
                                                <!-- Modal Title -->
                                                <div class="text-left">
                                                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Konfirmasi Penghapusan Layanan</h3>
                                                    <p class="mt-2 text-sm text-gray-500">Apakah anda yakin ingin menghapus Layanan ini?</p>

                                                    <input type="hidden" id="modal-hapusLayanan-idLayanan" name="idLayanan">
                                                </div>
                                            </div>
                    
                                            <!-- Footer: Tombol Aksi -->
                                            <div class="mt-6 flex justify-end space-x-4">
                                                <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Batal</button>
                                                <button type="submit" data-toggle="modal" data-target="#ModalSuksesHapusFasilitas" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal sukses hapus -->
                            <div class="modal fade p-4" id="ModalSuksesHapusFasilitas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                            <h3 class="text-lg font-semibold text-gray-900">Fasilitas Berhasil Dihapus</h3>
                                            <p class="text-sm text-gray-500">Fasilitas telah dihapus dari sistem.</p>
                                            <div class="mt-4">
                                                <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </main>
                </div>
            </section>

            {{-- TAMBAH DATA --}}
            <section>
                <form method="POST" action="{{ route('layanan-tambahan.store') }}" class="mt-10">
                    @csrf
                    <div class="space-y-12">
                        <!-- Input data -->
                        <div class="border-b border-gray-900/10 pb-10">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Tambah Layanan Tambahan*</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Semua kolom wajib di isi.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <!-- Nama Layanan -->
                                <div class="sm:col-span-3">
                                    <label for="nama"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nama Layanan
                                        Tambahan</label>
                                    <div class="mt-2">
                                        <input type="text" name="nama" id="nama"
                                            class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                </div>
                                <!-- Harga -->
                                <div class="sm:col-span-2 sm:col-start-1">
                                    <label for="harga"
                                        class="block text-sm font-medium leading-6 text-gray-900">Harga</label>
                                    <div class="mt-2">
                                        <input type="number" name="harga" id="harga"
                                            class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                </div>
                                <!-- Jumlah -->
                                <div class="sm:col-span-1">
                                    <label for="jumlah"
                                        class="block text-sm font-medium leading-6 text-gray-900">Jumlah</label>
                                    <div class="mt-2">
                                        <input type="number" name="jumlah" id="jumlah"
                                            class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                </div>
                                <!-- Keterangan -->
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label for="keterangan"
                                        class="block text-sm font-medium leading-6 text-gray-900">Keterangan</label>
                                    <div class="mt-2">
                                        <textarea id="keterangan" name="keterangan" rows="2"
                                            class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-gray-600">Bagian ini bersifat optional</p>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Submit -->
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                            <button type="submit" data-toggle="modal" data-target="#ModalSuksesBuatLayanan"
                                class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                        </div>
                    </div>
                </form>
            </section>

            {{-- modal sukses tambah penghuni --}}
            <div class="modal fade p-4" id="ModalSuksesBuatLayanan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                            <h3 class="text-lg font-semibold text-gray-900">Layanan Kos Berhasil Ditambahkan</h3>
                            <p class="text-sm text-gray-500">Layanan Tambahan berhasil disimpan oleh sistem.</p>
                            <div class="mt-4">
                                <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- PAGE RIWAYAT PEMBELIAN -->
        <section id="riwayat" class="hidden">
            <p class="text-sm text-gray-500 mb-3 px-3">Riwayat pemeliharaan yang telah dilakukan.</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Nama Layanan</th>
                            <th class="py-3 px-4">Pembeli</th>
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
                            <div class="modal-body p-6 space-y-2">
                                <!-- AJAX -->
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

                                <div class="flex items-center space-x-4">
                                    <label for="status" class="w-32 text-md font-medium text-gray-700">
                                        Status:</label>
                                    <input id="modal-detail-status" type="text" value=""
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
                                    <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal:</label>
                                    <input id="modal-detail-tanggal" type="text" value=""
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



{{-- DETAIL AJAX --}}
<script>
    $(document).ready(function() {
        $('.selesaikan-pesanan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/selesaikan-pesanan/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-selesaikan-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-selesaikan-pembeli').val(data.data.nama);
                    $('#modal-selesaikan-nama').val(data.data.nama_item);
                    $('#modal-selesaikan-jumlah').val(data.data.jumlah);
                    $('#modal-selesaikan-tanggal').val(data.data.tanggal);
                    $('#modal-selesaikan-total').val(data.data.total_bayar);
                    $('#modal-selesaikan-tgl_terima').val(data.data.tgl_terima);
                    $('#modal-selesaikan-status_pengantaran').val(data.data.status_pengantaran);
                    $('#modal-selesaikan-status').val(data.data.status_pembayaran);
                    $('#modal-selesaikan-pesan').val(data.data.pesan);

                    $('#modal-selesaikan-idTransaksi').val(data.data.idTransaksi);
                    $('#modal-selesaikan-idLayanan').val(data.data.idLayananTambahan);
                    $('#modal-selesaikan-stok').val(data.data.stok);
                }
            });
        });

        $('.verifikasi-pembayaran').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/layanan-tambahan/verifikasi/' + id,
                type: 'GET',
                success: function(data) {
                    // ACTION SUCCESS
                    $('#modal-bukti-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-bukti-nama').val(data.data.nama);
                    $('#modal-bukti-item').val(data.data.nama_item);
                    $('#modal-bukti-jumlah').val(data.data.jumlah);
                    $('#modal-bukti-tanggal').val(data.data.tanggal);
                    $('#modal-bukti-total_bayar').val(data.data.total_bayar);
                    $('#modal-bukti-status').val(data.data.status_pembayaran);
                    $('#modal-bukti-pengantaran').val(data.data.pengantaran);
                    $('#modal-bukti-pengambilan').val(data.data.tgl_terima);
                    $('#modal-bukti-pesan').val(data.data.pesan);
                    $('#modal-bukti-idTransaksi').val(data.data.idTransaksi);
                    $('#modal-bukti-foto').attr('src', data.gambar_url);

                    // ACTION BATAL
                    $('#modal-revisi-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-revisi-nama').val(data.data.nama);
                    $('#modal-revisi-belanja').val(data.data.jumlah + ' ' + data.data.nama_item);

                    $('#modal-revisi-idTransaksi').val(data.data.idTransaksi);
                    $('#modal-revisi-idKontrak').val(data.data.idKontrak);
                    $('#modal-revisi-idLayanan').val(data.data.idLayananTambahan);
                    $('#modal-revisi-jumlah').val(data.data.jumlah);
                    $('#modal-revisi-total_bayar').val(data.data.total_bayar);
                    $('#modal-revisi-tanggal').val(data.data.tanggal);
                    $('#modal-revisi-tgl_terima').val(data.data.tgl_terima);
                    $('#modal-revisi-pengantaran').val(data.data.pengantaran);
                    $('#modal-revisi-status_pengantaran').val(data.data.status_pengantaran);
                }
            });
        });

        $('.lihat-detail-layanan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/detailLayanan/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-nama').val(data.nama_item);
                    $('#modal-harga').val(data.harga);
                    $('#modal-jumlah').val(data.stok);
                    $('#modal-keterangan').val(data.keterangan);

                    $('#modal-layanan-nama').val(data.nama_item);
                    $('#modal-layanan-harga').val(data.harga);
                    $('#modal-layanan-stok').val(data.stok);
                    $('#modal-layanan-keterangan').val(data.keterangan);
                    $('#modal-layanan-idLayananTambahan').val(id);

                    $('#modal-hapusLayanan-idLayanan').val(id);
                }
            });
        });

        $('.lihat-detail-transaksi').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/detailTransaksi/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-detail-pembeli').val(data.data.idKamar);
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
