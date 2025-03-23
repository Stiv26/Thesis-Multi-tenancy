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
                <a href="#list" id="btnList" onclick="switchPage('list')" 
                    class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">Pemeliharaan</a>
                <a href="#pemeliharaan" id="btnPemeliharaan" onclick="switchPage('pemeliharaan')" 
                    class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Riwayat Pemeliharaan</a>
                </nav>
            </div> 
        </section>

        <!-- PAGE PEMELIHARAAN -->
        <section id="list" class="block">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click status untuk mengubah proses pemeliharan</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Pengirim</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Fasilitas</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Tgl Penjadwalan</th>
                            <th class="py-2 px-4">Pemeliharaan</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($pemeliharaan as $item) 
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">{{ $item->fasilitas }}</td>
                                <td class="py-3 px-4">{{ $item->status_pemeliharaan }}</td>
                                <td class="py-3 px-4">{{ $item->tgl_pemeliharaan }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idPemeliharaan }}" data-toggle="modal" data-target="#ModalPemeliharaan" class="lihat-detail-pemeliharaan text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada permintaan pemeliharaan fasilitas dari penghuni.</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>
                
                <!-- MODAL DATA -->
                <div class="modal fade p-4" id="ModalPemeliharaan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            {{-- HEADER --}}
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Pemeliharaan</h3>
                                <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <!-- AJAX -->
                            <div class="modal-body p-6 space-y-2">
                               <div class="flex items-center space-x-4">
                                    <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                        Pengirim:</label>
                                    <input id="modal-kamar" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Permintaan:</label>
                                    <input id="modal-tanggal" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="fasilitas" class="w-32 text-md font-medium text-gray-700">
                                        Fasilitas:</label>
                                    <input id="modal-fasilitas" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="pesan" class="w-32 text-md font-medium text-gray-700">
                                        Pesan:</label>
                                    <textarea id="modal-pesan" type="text" value="" rows="2" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                </div>

                                <label class="text-md text-gray-700 pt-3">
                                    Edit Pemeliharaan Fasilitas:</label>

                                <div class="flex items-center space-x-4">
                                    <label for="status" class="w-32 text-md font-medium text-gray-700">
                                        Status:</label>
                                    <select id="modal-status" name="status" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                        <option value="Permintaan" disabled>Permintaan</option>
                                        <option value="Pengerjaan">Pengerjaan</option>
                                        <option value="Tolak">Tolak</option>
                                    </select>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="jadwalkan" class="w-32 text-md font-medium text-gray-700">
                                        Penjadwalan:</label>
                                    <input required id="modal-jadwalkan" name="jadwalkan" type="datetime-local" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                </div>

                                <script>
                                    const input = document.getElementById('modal-jadwalkan');
                                    const now = new Date();
                                
                                    const pad = num => num.toString().padStart(2, '0');
                                    const formattedNow = now.getFullYear() + '-' +
                                        pad(now.getMonth() + 1) + '-' +
                                        pad(now.getDate()) + 'T' +
                                        pad(now.getHours()) + ':' +
                                        pad(now.getMinutes());
                                
                                    input.min = formattedNow;
                                </script>
                                
                            </div>
                            <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                <button type="button" data-toggle="modal" data-target="#ModalConfirmResponPemeliharaan" class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                    Lakukan Perubahan
                                </button>                                                               
                                <button type="button" class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600" data-dismiss="modal">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- PAGE RIWAYAT -->
        <section id="pemeliharaan" class="hidden">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail Pemeliharaan</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Pengirim</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Fasilitas</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Tgl Penjadwalan</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($riwayatPemeliharaan as $item) 
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">{{ $item->fasilitas }}</td>
                                <td class="py-3 px-4">{{ $item->status_pemeliharaan }}</td>
                                <td class="py-3 px-4">{{ $item->tgl_pemeliharaan }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idPemeliharaan }}" data-toggle="modal" data-target="#ModalRiwayat" class="lihat-detail-riwayat text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada riwayat pemeliharaan.</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>
                <!-- MODAL DATA -->
                <div class="modal fade p-4" id="ModalRiwayat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Pemeliharaan</h3>
                                <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body p-6 space-y-2">
                               <!-- AJAX -->
                               <div class="flex items-center space-x-4">
                                    <label for="kamar" class="w-32 text-md font-medium text-gray-700">
                                        Pengirim:</label>
                                    <input id="modal-detail-kamar" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Permintaan:</label>
                                    <input id="modal-detail-tanggal" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="fasilitas" class="w-32 text-md font-medium text-gray-700">
                                        Fasilitas:</label>
                                    <input id="modal-detail-fasilitas" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="penjadwalan" class="w-32 text-md font-medium text-gray-700">
                                        Tanggal Penjadwalan:</label>
                                    <input id="modal-detail-jadwal" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="pesan" class="w-32 text-md font-medium text-gray-700">
                                        Pesan:</label>
                                    <textarea id="modal-detail-pesan" type="text" value="" rows="2" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <label for="status" class="w-32 text-md font-medium text-gray-700">
                                        Status:</label>
                                    <input id="modal-detail-status" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
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
    
        </section>
   
    </main>
</x-layout>

{{-- JS --}}
<script>
    function switchPage(page) {
        const listSection = document.getElementById('list');
        const pemeliharaanSection = document.getElementById('pemeliharaan');
        const btnList = document.getElementById('btnList');
        const btnPemeliharaan = document.getElementById('btnPemeliharaan');

        // Menghilangkan semua section
        listSection.classList.add('hidden');
        pemeliharaanSection.classList.add('hidden');

        // Menghilangkan aktifasi dari button
        btnList.classList.remove('bg-indigo-600', 'text-white');
        btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        btnPemeliharaan.classList.remove('bg-indigo-600', 'text-white');
        btnPemeliharaan.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

        if (page === 'list') {
            // Tampilkan halaman Fasilitas dan set button aktif
            listSection.classList.remove('hidden');
            btnList.classList.add('bg-indigo-600', 'text-white');
            btnList.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        } else if (page === 'pemeliharaan') {
            // Tampilkan halaman Kamar dan set button aktif
            pemeliharaanSection.classList.remove('hidden');
            btnPemeliharaan.classList.add('bg-indigo-600', 'text-white');
            btnPemeliharaan.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        }

        // Memberikan sedikit delay sebelum scroll
        setTimeout(function() {
            window.scrollTo(0, 0);
        }, 50);
    }
</script>

{{-- AJAX DETAIL --}}
<script>
    $(document).ready(function(){
        $('.lihat-detail-pemeliharaan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); 

            // AJAX untuk mengambil data kamar
            $.ajax({
                url: '/akses/detailPemeliharaan/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-kamar').val('Kamar ' + data.idKamar);
                    $('#modal-tanggal').val(data.tanggal);
                    $('#modal-fasilitas').val(data.fasilitas);
                    // $('#modal-jadwal').val(data.tgl_pemeliharaan);
                    $('#modal-pesan').val(data.pesan);

                    $('#modal-status').val(data.status_pemeliharaan);
                    $('#modal-jadwalkan').val(data.tgl_pemeliharaan);

                    // ubah id pemeliharaan
                    $('#ubah-pemeliharaan-btn').data('id', id);
                }
            });
        });

        $('#ubah-pemeliharaan-btn').on('click', function () {
            var idPemeliharaan = $(this).data('id');
            var status = $('#modal-status').val();
            var jadwal = $('#modal-jadwalkan').val();

            $.ajax({
                url: '/akses/pemeliharaan/update/' + idPemeliharaan,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    tgl_pemeliharaan: jadwal
                },
                success: function (response) {
                    location.reload(); 
                },
                error: function (xhr) {
                    console.error('Gagal memperbarui data:', xhr.responseText);
                }
            });
        });

        $('.lihat-detail-riwayat').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); 

            // AJAX untuk mengambil data kamar
            $.ajax({
                url: '/akses/detailRiwayat/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-detail-kamar').val('Kamar ' + data.idKamar);
                    $('#modal-detail-tanggal').val(data.tanggal);
                    $('#modal-detail-fasilitas').val(data.fasilitas);
                    $('#modal-detail-jadwal').val(data.tgl_pemeliharaan);
                    $('#modal-detail-pesan').val(data.pesan);
                    $('#modal-detail-status').val(data.status_pemeliharaan);
                }
            });
        });
    });
</script>
{{-- DROPDOWN STATUS SESUAI TANGGAL  --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const statusDropdown = document.getElementById('modal-status'); // Dropdown status
        const jadwalkanInput = document.getElementById('modal-jadwalkan'); // Input penjadwalan

        const updateVisibility = () => {
            const selectedStatus = statusDropdown.value; // Nilai terpilih dari dropdown status
            
            if (selectedStatus === 'Tolak') {
                // Sembunyikan input penjadwalan jika statusnya "Tolak"
                jadwalkanInput.parentElement.classList.add('hidden');
                jadwalkanInput.value = ''; // Reset nilai input
            } else {
                // Tampilkan input penjadwalan untuk status selain "Tolak"
                jadwalkanInput.parentElement.classList.remove('hidden');
            }
        };

        // Jalankan saat halaman dimuat untuk memastikan visibilitas awal
        updateVisibility();

        // Tambahkan event listener untuk perubahan pada dropdown status
        statusDropdown.addEventListener('change', updateVisibility);
    });
</script>