<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>

        {{-- PAGE LIST TENANT --}}
        <section id="tenant" class="mt-10">
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kos</th>
                            <th class="py-3 px-4">Nama Penyewa</th>
                            <th class="py-3 px-4">No Telp</th>
                            <th class="py-3 px-4">Domain</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($tenant as $item) 
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ $item->tenant_id }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->no_telp }}</td>
                                <td class="py-3 px-4">
                                    <a href="http://{{ $item->domain }}:8000" target="_blank">{{ $item->domain }}</a>
                                </td>                                
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idTenant }}" data-toggle="modal" data-target="#ModalTenant" class="lihat-detail-tenant text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada tenant penyewa.</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>

                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalTenant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Tenant</h3>
                                <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <!-- AJAX -->
                            <div class="modal-body p-6 space-y-2">
                                <div class="flex items-center space-x-4">
                                    <label for="kos" class="w-32 text-md font-medium text-gray-700">
                                        Kos:</label>
                                    <input id="modal-kos" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="domain" class="w-32 text-md font-medium text-gray-700">
                                        Domain:</label>
                                    <input id="modal-domain" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                        Nama Penyewa:</label>
                                    <input id="modal-nama" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="telp" class="w-32 text-md font-medium text-gray-700">
                                        No Telp:</label>
                                    <input id="modal-telp" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="email" class="w-32 text-md font-medium text-gray-700">
                                        Email:</label>
                                    <input id="modal-email" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="alamat" class="w-32 text-md font-medium text-gray-700">
                                        Alamat:</label>
                                    <input id="modal-alamat" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                        Keterangan:</label>
                                    <textarea id="modal-keterangan" type="text" value="" rows="2" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"></textarea>
                                </div>

                                
                            </div>
                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">                              
                                <button type="button" class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600" data-dismiss="modal">
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

<script>
    $(document).ready(function(){
        $('.lihat-detail-tenant').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); 

            // AJAX untuk mengambil data kamar
            $.ajax({
                url: '/tenant/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-kos').val(data.tenant_id);
                    $('#modal-domain').val(data.domain);
                    $('#modal-nama').val(data.nama);
                    $('#modal-telp').val(data.no_telp);
                    $('#modal-email').val(data.email);
                    $('#modal-alamat').val(data.alamat);
                    $('#modal-keterangan').val(data.keterangan);
                }
            });
        });
    });
</script>
