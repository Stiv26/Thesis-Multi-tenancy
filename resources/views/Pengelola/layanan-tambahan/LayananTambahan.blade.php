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
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">Layanan
                        Tambahan</a>
                    <a href="#riwayat" id="btnRiwayat" onclick="switchPage('riwayat')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Riwayat
                        Pembelian</a>
                </nav>
            </div>
        </section>

        <!-- PAGE LAYANAN TAMBAHAN -->
        <section id="list" class="block">
            {{-- LIST LAYANAN --}}
            <section>
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
                                        <a href="#" data-id="{{ $item->idLayananTambahan }}" data-toggle="modal"
                                            data-target="#ModalLayanan"
                                            class="lihat-detail-layanan text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada layanan tambahan untuk kos ini.</td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>

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
                                    @if(!empty($item->idLayananTambahan))
                                        <button type="button" id="hapus-layanan-btn" data-id="{{ $item->idLayananTambahan }}" class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500">
                                            Hapus
                                        </button>   
                                    @endif
                                    <a href="#" id="edit-layanan-btn">
                                        <button type="button" class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Ubah Layanan
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
                                    <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama Layanan Tambahan</label>
                                    <div class="mt-2">
                                        <input type="text" name="nama" id="nama" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
                                    </div>
                                </div>
                                <!-- Harga -->
                                <div class="sm:col-span-2 sm:col-start-1">
                                    <label for="harga" class="block text-sm font-medium leading-6 text-gray-900">Harga</label>
                                    <div class="mt-2">
                                        <input type="number" name="harga" id="harga" class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
                                    </div>
                                </div>
                                <!-- Jumlah -->
                                <div class="sm:col-span-1">
                                    <label for="jumlah" class="block text-sm font-medium leading-6 text-gray-900">Jumlah</label>
                                    <div class="mt-2">
                                        <input type="number" name="jumlah" id="jumlah" class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
                                    </div>
                                </div>
                                <!-- Keterangan -->
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label for="keterangan" class="block text-sm font-medium leading-6 text-gray-900">Keterangan</label>
                                    <div class="mt-2">
                                        <textarea id="keterangan" name="keterangan" rows="2" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-gray-600">Bagian ini bersifat optional</p>
                                </div>
                            </div>
                        </div> 
            
                        <!-- Bagian Submit -->
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                            <button type="submit" class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
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
                                <td class="py-3 px-4">{{ $item->total_bayar }}</td>
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idLayananTambahan }}" data-toggle="modal"
                                        data-target="#ModalTransaksi"
                                        class="lihat-detail-transaksi text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada riwayat transaksi dari penghuni.</td>
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
                                    <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal:</label>
                                    <input id="modal-detail-tanggal" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="harga" class="w-32 text-md font-medium text-gray-700">
                                        Harga:</label>
                                    <input id="modal-detail-harga" type="text" value=""
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
                                    <label for="metode" class="w-32 text-md font-medium text-gray-700">
                                        Metode Pembayaran:</label>
                                    <input id="modal-detail-metode" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="total" class="w-32 text-md font-medium text-gray-700">
                                        Total Bayar:</label>
                                    <input id="modal-detail-total" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                        Keterangan:</label>
                                    <textarea id="modal-detail-keterangan" type="text" value="" rows="2"
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
        var listSection = document.getElementById('list');
        var riwayatSection = document.getElementById('riwayat');
        var btnList = document.getElementById('btnList');
        var btnRiwayat = document.getElementById('btnRiwayat');

        listSection.classList.add('hidden');
        riwayatSection.classList.add('hidden');

        btnList.classList.remove('bg-indigo-600', 'text-white');
        btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        btnRiwayat.classList.remove('bg-indigo-600', 'text-white');
        btnRiwayat.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

        if (page === 'list') {
            listSection.classList.remove('hidden');
            btnList.classList.add('bg-indigo-600', 'text-white');
            btnList.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
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

<script>
    $(document).ready(function() {
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

                    $('#edit-layanan-btn').attr('href', '/layanan-tambahan/edit-layanan/' + id);
                }
            });
        });

        $('#hapus-layanan-btn').on('click', function() {
            var idLayanan = $(this).data('id');

            if (confirm('Apakah Anda yakin ingin menghapus layanan ini?')) {
                $.ajax({
                    url: '{{ route("layanan.destroy", ":id") }}'.replace(':id', idLayanan),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus layanan. Silakan coba lagi.');
                    }
                });
            }
        });

        $('.lihat-detail-transaksi').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/detailTransaksi/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-detail-pembeli').val(data.idKamar);
                    $('#modal-detail-nama').val(data.nama_item);
                    $('#modal-detail-tanggal').val(data.tanggal);
                    $('#modal-detail-harga').val(data.harga);
                    $('#modal-detail-jumlah').val(data.jumlah);
                    $('#modal-detail-metode').val(data.metode);
                    $('#modal-detail-total').val(data.total_bayar);
                    $('#modal-detail-keterangan').val();
                }
            });
        });
    });
</script>
