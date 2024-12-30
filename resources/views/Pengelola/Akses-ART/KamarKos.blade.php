<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>

        {{-- PAGE KAMAR --}} 
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
                        @forelse ($penghuni as $item)
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
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Penghuni</h3>
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
                                <div class="flex items-center space-x-4">
                                    <label for="deposit" class="w-32 text-md font-medium text-gray-700">
                                        Deposit:</label>
                                    <input id="modal-deposit" type="text" value=""
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                        readonly>
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

{{-- AJAX PENGHUNI --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-kontrak').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/akses/kamar/' + id,
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
                    $('#modal-keterangan').val(data.data.keterangan);
                }
            });
        });
    });
</script>