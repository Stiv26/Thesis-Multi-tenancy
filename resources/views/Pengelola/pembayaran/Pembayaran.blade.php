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
                    <a href="#keuangan" id="btnKeuangan" onclick="switchPage('keuangan')"
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">
                        Keuangan</a>
                    <a href="#list" id="btnList" onclick="switchPage('list')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                        Pembayaran</a>
                    <a href="#riwayat" id="btnRiwayat" onclick="switchPage('riwayat')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                        Riwayat Pembayaran</a>
                </nav>
            </div>
            {{-- <div class="flex space-x-4">
                <div class="text-center border border-indigo-600 px-10 py-2 rounded-xl">
                    <p class="text-lg text-gray-600">Pemasukan</p>
                    <p class="text-2xl font-semibold text-indigo-600">{{ $header['pendapatan'] }}</p>
                </div>
            </div>             --}}
        </section>

        {{-- PAGE KEUANGAN --}}
        <section id="keuangan" class="block">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Data Keuangan 3 bulan terakhir</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                    <div class="flex flex-1 justify-between sm:hidden">
                        <a href="#"
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                        <a href="#"
                            class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                    </div>
                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Nominal Pendapatan
                                <span class="font-medium">{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <div>
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                @foreach ($riwayatBulan as $riwayat)
                                    <a href="{{ route('pembayaran.index', ['bulan' => $riwayat->bulan, 'tahun' => $riwayat->tahun]) }}"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold 
                                        {{ $riwayat->bulan == $bulan && $riwayat->tahun == $tahun ? 'bg-indigo-600 text-white' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50' }}">
                                        {{ sprintf('%02d-%04d', $riwayat->bulan, $riwayat->tahun) }}
                                    </a>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                </div>
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-center text-sm text-gray-600">
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Total Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($bulanTersedia as $list)
                            <tr class="text-center">
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($list->tanggal)->format('d-m-Y') }}</td>
                                <td class="py-3 px-4">{{ number_format($list->total_bayar, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-3 px-4 text-center text-gray-500">
                                    Tidak ada data pembayaran untuk bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- PAGE PEMBAYARAN -->
        <section id="list" class="hidden">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Penyewa</th>
                            <th class="py-3 px-4">Total Bayar</th>
                            <th class="py-3 px-4">Jatuh Tempo</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($pembayaran as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->total_bayar }}</td>
                                <td class="py-3 px-4">{{ $item->tgl_denda }}</td>
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
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada data pembayaran yang tersedia untuk periode ini.</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>
                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalPembayaran" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Pembayaran
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
                                    <label for="total" class="w-32 text-md font-medium text-gray-700">
                                        Total Bayar:</label>
                                    <input id="modal-total" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tempo" class="w-32 text-md font-medium text-gray-700">
                                        Jatuh Tempo:</label>
                                    <input id="modal-tempo" type="text" value=""
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

                                <!-- Container untuk biayaList yang akan diisi melalui AJAX -->
                                <div id="biaya-container"></div>

                                <div class="flex items-center space-x-4">
                                    <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                        Keterangan:</label>
                                    <textarea id="modal-keterangan" type="text" value="" rows="2"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                </div>
                            </div> 
                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                <a href="#" id="edit-pembayaran-btn">
                                    <button type="button"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Ubah Pembayaran
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
                            <th class="py-3 px-4">Jatuh Tempo</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($riwayatPembayaran as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->total_bayar }}</td>
                                <td class="py-3 px-4">{{ $item->tgl_denda }}</td>
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
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada riwayat pembayaran untuk kos ini.</td>
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
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Pembayaran
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
                                    <label for="total" class="w-32 text-md font-medium text-gray-700">
                                        Total Bayar:</label>
                                    <input id="modal-riwayat-total" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tempo" class="w-32 text-md font-medium text-gray-700">
                                        Jatuh Tempo:</label>
                                    <input id="modal-riwayat-tempo" type="text" value=""
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

                                <div class="flex items-center space-x-4">
                                    <label for="status" class="w-32 text-md font-medium text-gray-700">
                                        Status:</label>
                                    <input id="modal-riwayat-status" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tagihan" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Tagihan:</label>
                                    <input id="modal-riwayat-tagihan" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
                                </div>

                                <!-- Container untuk biayaList yang akan diisi melalui AJAX -->
                                <div id="riwayat-container"></div>

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
        const keuanganSection = document.getElementById('keuangan');
        const listSection = document.getElementById('list');
        const riwayatSection = document.getElementById('riwayat');

        // Buttons
        const btnKeuangan = document.getElementById('btnKeuangan');
        const btnList = document.getElementById('btnList');
        const btnRiwayat = document.getElementById('btnRiwayat');

        // Sembunyikan semua section
        keuanganSection.classList.add('hidden');
        listSection.classList.add('hidden');
        riwayatSection.classList.add('hidden');

        // Nonaktifkan semua tombol
        btnKeuangan.classList.remove('bg-indigo-600', 'text-white');
        btnKeuangan.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

        btnList.classList.remove('bg-indigo-600', 'text-white');
        btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

        btnRiwayat.classList.remove('bg-indigo-600', 'text-white');
        btnRiwayat.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

        // Tampilkan section dan aktifkan tombol sesuai halaman
        if (page === 'keuangan') {
            keuanganSection.classList.remove('hidden');
            btnKeuangan.classList.add('bg-indigo-600', 'text-white');
            btnKeuangan.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        } else if (page === 'list') {
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
{{-- AJAX DETAIL --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-pembayaran').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/list/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-nama').val(data.data.nama);
                    $('#modal-total').val(data.data.total_bayar);
                    $('#modal-tempo').val(data.data.tgl_denda);
                    $('#modal-tagihan').val(data.data.tgl_tagihan);
                    $('#modal-status').val(data.data.status_pembayaran);
                    $('#modal-keterangan').val(data.data.keterangan_pembayaran);

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

                    // mengirim id ke editpembayaran yang sesuai
                    $('#edit-pembayaran-btn').attr('href', '/list/edit-pembayaran/' + id);
                }
            }); 
        });

        $('.lihat-detail-riwayat').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/riwayat/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-riwayat-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-riwayat-nama').val(data.data.nama);
                    $('#modal-riwayat-total').val(data.data.total_bayar);
                    $('#modal-riwayat-tempo').val(data.data.tgl_denda);
                    $('#modal-riwayat-tagihan').val(data.data.tgl_tagihan);
                    $('#modal-riwayat-metode').val(data.data.metode);
                    $('#modal-riwayat-status').val(data.data.status_pembayaran);
                    $('#modal-riwayat-keterangan').val(data.data.keterangan);

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
                }
            });
        });
    });
</script>
