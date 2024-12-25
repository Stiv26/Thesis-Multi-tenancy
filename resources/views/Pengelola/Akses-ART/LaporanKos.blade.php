<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>

        {{-- TOP CONTENT --}}
        <section class="flex justify-between items-center mb-6">
            <div class="flex items-center justify-between px-3 py-3 rounded-lg">
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
                <a href="#tugas" id="btnTugas" onclick="switchPage('tugas')" 
                    class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">Tugas</a>
                <a href="#riwayat" id="btnRiwayat" onclick="switchPage('riwayat')" 
                    class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Riwayat Laporan</a>
                </nav>
            </div>

            <script>
                function switchPage(page) {
                    const tugasSection = document.getElementById('tugas'); // Section Tugas
                    const riwayatSection = document.getElementById('riwayat'); // Section Riwayat
                    const btnTugas = document.getElementById('btnTugas'); // Tombol Tugas
                    const btnRiwayat = document.getElementById('btnRiwayat'); // Tombol Riwayat

                    // Sembunyikan semua section
                    tugasSection.classList.add('hidden');
                    riwayatSection.classList.add('hidden');

                    // Reset styling tombol ke default
                    btnTugas.classList.remove('bg-indigo-600', 'text-white');
                    btnTugas.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnRiwayat.classList.remove('bg-indigo-600', 'text-white');
                    btnRiwayat.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

                    // Tampilkan section yang dipilih dan ubah tombol menjadi aktif
                    if (page === 'tugas') {
                        tugasSection.classList.remove('hidden');
                        btnTugas.classList.add('bg-indigo-600', 'text-white');
                        btnTugas.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'riwayat') {
                        riwayatSection.classList.remove('hidden');
                        btnRiwayat.classList.add('bg-indigo-600', 'text-white');
                        btnRiwayat.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    }

                    // Memberikan sedikit delay sebelum scroll ke atas
                    setTimeout(function () {
                        window.scrollTo(0, 0);
                    }, 50);
                }
            </script>
        </section>
        
        <!-- PAGE LAPORAN -->
        <section id="tugas" class="block">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click status untuk mengubah proses pemeliharan</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">tugas</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Pengerjaan</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($laporan as $item) 
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">{{ $item->tugas }}</td>
                                <td class="py-3 px-4">{{ $item->status }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idTugas }}" data-toggle="modal" data-target="#ModalTugas" class="lihat-detail-laporan text-indigo-500 hover:text-indigo-700 transition">
                                        Upload Pengerjaan <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada tugas sementara ini.</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>

                <!-- MODAL DATA -->
                <div class="modal fade p-4" id="ModalTugas" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            {{-- header --}}
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Upload Pengerjaan
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
                            <form id="form-upload-laporan" action="{{ route('laporan.update', ['id' => ':id']) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            
                                <div class="modal-body p-6 space-y-2">
                                    <div class="flex items-center space-x-4">
                                        <label id="modal-tanggal" class="text-md font-medium text-gray-700"></label>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <textarea id="modal-tugas" type="text" value="" rows="2"
                                            class="flex-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                        <input type="hidden" id="modal-id" name="idTugas">
                                    </div>
                                    <div class="flex items-center space-x-4 mt-3">
                                        <label for="bukti" class="w-32 text-md font-medium text-gray-700">Upload File:</label>
                                        <input id="modal-bukti" type="file" name="bukti"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                    </div>
                                </div>
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button type="submit"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Simpan
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
                
            </div>
        </section>

        <!-- PAGE RIWAYAT -->
        <section id="riwayat" class="hidden">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click status untuk mengubah proses pemeliharan</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">tugas</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($riwayat as $item) 
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">{{ $item->tugas }}</td>
                                <td class="py-3 px-4">{{ $item->status }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idTugas }}" data-toggle="modal" data-target="#ModalRiwayat" class="lihat-detail-riwayat text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada tugas sementara ini.</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>

                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalRiwayat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Laporan Tugas</h3>
                                <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body p-6 space-y-2">
                               <!-- AJAX -->
                                <div class="flex items-center space-x-4">
                                    <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal:</label>
                                    <input id="modal-riwayat-tanggal" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tugas" class="w-32 text-md font-medium text-gray-700">
                                        Tugas:</label>
                                    <textarea id="modal-riwayat-tugas" type="text" value="" rows="2"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="status" class="w-32 text-md font-medium text-gray-700">
                                        Status:</label>
                                    <input id="modal-riwayat-statustugas" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <img id="modal-riwayat-bukti" src="" alt="Bukti Laporan Terkirim" class="flex-1 w-32 h-64 border border-gray-300 rounded-md object-cover">
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="upload" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Upload:</label>
                                    <input id="modal-riwayat-upload" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
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

{{-- AJAX UPLOAD --}}
<script>
    $(document).ready(function(){
        $('.lihat-detail-laporan').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/akses/laporan/' + id,
                type: 'GET',
                success: function (data) {
                    $('#modal-tanggal').text(data.tanggal);
                    $('#modal-tugas').text(data.tugas);

                    $('#modal-id').val(data.id);

                    var formAction = '{{ route('laporan.update', ':id') }}'.replace(':id', id);
                    $('#form-upload-laporan').attr('action', formAction);
                },
                error: function () {
                    alert('Gagal mengambil data tugas.');
                }
            });
        });

        // $('.lihat-detail-riwayat').on('click', function (e) {
        //     e.preventDefault();
        //     var id = $(this).data('id');

        //     $.ajax({
        //         url: '/akses/riwayat-laporan/' + id,
        //         type: 'GET',
        //         success: function (data) {
        //             $('#modal-riwayat-tugas').val(data.tugas);
        //             $('#modal-riwayat-tanggal').val(data.tanggal);
        //             $('#modal-riwayat-statustugas').val(data.status);
        //             $('#modal-riwayat-upload').val(data.tgl_update);
        //             $('#modal-riwayat-bukti').val(data.tgl_update);

        //             // if (data.bukti) {
        //             //     $('#modal-riwayat-bukti').attr('src', '/storage/tenant000/app/public/bukti_laporan/' + data.bukti).show();
        //             // } 
        //             // else {
        //             //     $('#modal-riwayat-bukti').hide(); // Sembunyikan jika tidak ada bukti
        //             // }
        //         },
        //         error: function () {
        //             alert('Gagal mengambil data tugas.');
        //         }
        //     });
        // });
    });
</script>