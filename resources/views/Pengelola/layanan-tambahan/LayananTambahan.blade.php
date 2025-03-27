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
                                    <td class="py-3 px-4">{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
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
                                        
                                        <!-- Header -->
                                        <div class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-start">
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-800">VERIFIKASI PEMBAYARAN LAYANAN</h3>
                                            </div>
                                            <button type="button" class="text-gray-400 hover:text-gray-600" 
                                                    data-dismiss="modal" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                            d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                        
                                        <!-- Body -->
                                        <div class="modal-body p-6 space-y-4">
                                            <!-- Informasi Utama -->
                                            <div class="flex flex-col gap-4 mb-6">
                                                <div class="flex justify-between items-center border-b pb-2">
                                                    <span class="font-medium text-gray-600">Kamar</span>
                                                    <input id="modal-bukti-kamar" type="text" name="idKamar" 
                                                            class="w-1/2 text-right font-medium text-gray-800 bg-transparent border-none" 
                                                            disabled>
                                                </div>
                                                
                                                <div class="flex justify-between items-center border-b pb-2">
                                                    <span class="font-medium text-gray-600">Nama Pembeli</span>
                                                    <input id="modal-bukti-nama" type="text" name="nama" 
                                                            class="w-1/2 text-right text-gray-700 bg-transparent border-none" 
                                                            disabled>
                                                </div>
                                            </div>
                        
                                            <!-- Detail Layanan Tambahan -->
                                            <div class="border rounded-lg p-4 mb-6">
                                                <h4 class="text-lg font-bold mb-4">Detail Layanan Tambahan</h4>
                                                
                                                <div class="space-y-3">
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Nama Barang</span>
                                                        <input id="modal-bukti-item" type="text" name="nama_item" 
                                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Jumlah</span>
                                                        <input id="modal-bukti-jumlah" type="text" name="jumlah" 
                                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Status</span>
                                                        <input id="modal-bukti-status" type="text" name="status" 
                                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Pengantaran</span>
                                                        <input id="modal-bukti-pengantaran" type="text" name="pengantaran" 
                                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Tanggal Ambil</span>
                                                        <input id="modal-bukti-pengambilan" type="text" name="pengambilan" 
                                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                    </div>
                                                </div>
                                            </div>
                        
                                            <!-- Bukti Pembayaran -->
                                            <div class="border rounded-lg p-4 mb-6">
                                                <h4 class="text-lg font-bold mb-4">Bukti Pembayaran</h4>
                                                
                                                <div class="space-y-3">
                                                    <div class="flex flex-col items-center mb-4">
                                                        <img src="" id="modal-bukti-foto" alt="Bukti Pembayaran" 
                                                                class="h-72 object-cover border border-gray-300 rounded-md">
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Total Bayar</span>
                                                        <input id="modal-bukti-total_bayar" type="text" name="total_bayar" 
                                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Tanggal Transaksi</span>
                                                        <input id="modal-bukti-tanggal" type="text" name="tanggal" 
                                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                    </div>
                                                </div>
                                            </div>
                        
                                            <!-- Pesan -->
                                            <div class="mb-4">
                                                <p class="font-medium text-gray-700">Pesan:</p>
                                                <textarea id="modal-bukti-pesan" rows="2" name="status" 
                                                            class="w-full px-3 py-2 border rounded-md bg-gray-50" readonly></textarea>
                                            </div>
                        
                                            <input type="hidden" id="modal-bukti-idTransaksi" name="idTransaksi">
                                        </div>
                        
                                        <!-- Footer -->
                                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex justify-end space-x-3">
                                            <button type="button" name="action" value="tolak" 
                                                    data-toggle="modal" data-target="#ModalTolakPembayaran" data-dismiss="modal"
                                                    class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                                Pembayaran Salah
                                            </button>
                                            <button type="submit" name="action" value="verifikasi" 
                                                    data-toggle="modal" data-target="#ModalSuksesVerifikasiTransaksi"
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

                        {{-- MODAL DATA --}}
                        <div class="modal fade p-4" id="ModalSelesaikan" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    <form action="{{ route('transaksi.selesaikanPesanan') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <!-- Header -->
                                        <div class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-start">
                                            <h3 class="text-2xl font-bold text-gray-800">KONFIRMASI PENERIMAAN PESANAN</h3>
                                            <button type="button" class="text-gray-400 hover:text-gray-600" 
                                                    data-dismiss="modal" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                        
                                        <!-- Body -->
                                        <div class="modal-body p-6 space-y-4">
                                            <!-- Informasi Utama -->
                                            <div class="flex flex-col gap-4 mb-6">
                                                <div class="flex justify-between items-center border-b pb-2">
                                                    <span class="font-medium text-gray-600">Kamar</span>
                                                    <input id="modal-selesaikan-kamar" type="text" 
                                                        class="w-1/2 text-right font-medium text-gray-800 bg-transparent border-none" 
                                                        name="idKamar" readonly>
                                                </div>
                                                
                                                <div class="flex justify-between items-center border-b pb-2">
                                                    <span class="font-medium text-gray-600">Pembeli</span>
                                                    <input id="modal-selesaikan-pembeli" type="text" 
                                                        class="w-1/2 text-right text-gray-700 bg-transparent border-none" 
                                                        name="pembeli" readonly>
                                                </div>
                                            </div>
                        
                                            <!-- Detail Layanan -->
                                            <div class="border rounded-lg p-4 mb-6">
                                                <h4 class="text-lg font-bold mb-4">Detail Pembelian</h4>
                                                
                                                <div class="space-y-3">
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Nama Barang</span>
                                                        <input id="modal-selesaikan-nama" type="text" 
                                                            class="w-1/3 text-right px-2 bg-transparent" 
                                                            name="item" readonly>
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Jumlah</span>
                                                        <input id="modal-selesaikan-jumlah" type="text" 
                                                            class="w-1/3 text-right px-2 bg-transparent" 
                                                            name="jumlah" readonly>
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Total Harga</span>
                                                        <input id="modal-selesaikan-total" type="text" 
                                                            class="w-1/3 text-right px-2 bg-transparent" 
                                                            name="total_bayar" readonly>
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Tanggal Transaksi</span>
                                                        <input id="modal-selesaikan-tanggal" type="text" 
                                                            class="w-1/3 text-right px-2 bg-transparent" 
                                                            name="tanggal" readonly>
                                                    </div>
                                                </div>
                                            </div>
                        
                                            <!-- Status Pengiriman -->
                                            <div class="border rounded-lg p-4 mb-6">
                                                <h4 class="text-lg font-bold mb-4">Status Pengantaran</h4>
                                                
                                                <div class="space-y-3">
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Metode Pengantaran</span>
                                                        <input id="modal-selesaikan-status_pengantaran" type="text" 
                                                            class="w-1/3 text-right px-2 bg-transparent" 
                                                            name="selesaikan" readonly>
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Tanggal Diterima</span>
                                                        <input id="modal-selesaikan-tgl_terima" type="text" 
                                                            class="w-1/3 text-right px-2 bg-transparent" 
                                                            name="tgl_terima" readonly>
                                                    </div>
                        
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">Status Pesanan</span>
                                                        <input id="modal-selesaikan-status" type="text" 
                                                            class="w-1/3 text-right px-2 bg-transparent" 
                                                            name="status" readonly>
                                                    </div>
                                                </div>
                                            </div>
                        
                                            <!-- Pesan -->
                                            <div class="mb-4">
                                                <p class="font-medium text-gray-700">Pesan:</p>
                                                <textarea id="modal-selesaikan-pesan" rows="2"
                                                        class="w-full px-3 py-2 border rounded-md bg-gray-50" 
                                                        name="pesan" readonly></textarea>
                                            </div>
                        
                                            <!-- Hidden Inputs -->
                                            <input type="hidden" name="idTransaksi" id="modal-selesaikan-idTransaksi">
                                            <input type="hidden" name="idLayanan" id="modal-selesaikan-idLayanan">
                                            <input type="hidden" name="stok" id="modal-selesaikan-stok">
                                        </div>
                        
                                        <!-- Footer -->
                                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex justify-end space-x-3">
                                            <button type="submit" data-toggle="modal" data-target="#ModalSuksesSudahDiambil"
                                                    class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                                Pesanan Diterima
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
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
                                    <td class="py-3 px-4">{{ number_format($item->harga, 0, ',', '.') }}</td>
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
                                                <label for="harga" class="w-32 text-md font-medium text-gray-700">Harga:</label>
                                                <input id="modal-layanan-harga-display" 
                                                       type="text" 
                                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                       required>
                                                <input type="hidden" id="modal-layanan-harga" name="harga">
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
                                        <input type="text" id="harga-display" 
                                            class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                                        <input type="hidden" name="harga" id="harga">
                                    </div>
                                </div>

                                <script>
                                    const cleaveHarga = new Cleave('#harga-display', {
                                        numeral: true,
                                        numeralThousandsGroupStyle: 'thousand',
                                        numeralDecimalMark: ',',
                                        delimiter: '.'
                                    });

                                    // Update nilai hidden saat input berubah
                                    document.getElementById('harga-display').addEventListener('input', function() {
                                        document.getElementById('harga').value = cleaveHarga.getRawValue();
                                    });
                                </script>
                                
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
                    function formatRupiah(angka) {
                        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }

                    $('#modal-selesaikan-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-selesaikan-pembeli').val(data.data.nama);
                    $('#modal-selesaikan-nama').val(data.data.nama_item);
                    $('#modal-selesaikan-jumlah').val(data.data.jumlah);
                    $('#modal-selesaikan-tanggal').val(data.data.tanggal);
                    $('#modal-selesaikan-total').val(formatRupiah(data.data.total_bayar));
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
                    function formatRupiah(angka) {
                        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }

                    // ACTION SUCCESS
                    $('#modal-bukti-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-bukti-nama').val(data.data.nama);
                    $('#modal-bukti-item').val(data.data.nama_item);
                    $('#modal-bukti-jumlah').val(data.data.jumlah);
                    $('#modal-bukti-tanggal').val(data.data.tanggal);
                    $('#modal-bukti-total_bayar').val(formatRupiah(data.data.total_bayar));
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

            const cleaveEditHarga = new Cleave('#modal-layanan-harga-display', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                numeralDecimalMark: ',',
                delimiter: '.'
            });

            document.getElementById('modal-layanan-harga-display').addEventListener('input', function() {
                document.getElementById('modal-layanan-harga').value = cleaveEditHarga.getRawValue();
            });

            $.ajax({
                url: '/detailLayanan/' + id,
                type: 'GET',
                success: function(data) {
                    function formatRupiah(angka) {
                        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }

                    cleaveEditHarga.setRawValue(data.harga.toString());

                    $('#modal-nama').val(data.nama_item);
                    $('#modal-harga').val(formatRupiah(data.harga));
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
                    function formatRupiah(angka) {
                        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }

                    $('#modal-detail-pembeli').val(data.data.idKamar);
                    $('#modal-detail-nama').val(data.data.nama_item);
                    $('#modal-detail-tanggal').val(data.data.tanggal);
                    $('#modal-detail-jumlah').val(data.data.jumlah);
                    $('#modal-detail-tgl_terima').val(data.data.tgl_terima);
                    $('#modal-detail-pengantaran').val(data.data.pengantaran);
                    $('#modal-detail-total').val(formatRupiah(data.data.dibayar));
                    $('#modal-detail-status').val(data.data.status_pembelian);
                    $('#modal-detail-pesan').val(data.data.pesan);
                    $('#modal-detail-foto').attr('src', data.gambar_url);
                }
            });
        });
    });
</script>
