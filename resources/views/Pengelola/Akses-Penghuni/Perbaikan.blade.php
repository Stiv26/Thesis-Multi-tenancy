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
        </section>

        <!-- PAGE PEMELIHARAAN -->
        <section id="list" class="block">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click lihat detail untuk melihat status pemeliharaan</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Pengirim</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Fasilitas</th>
                            <th class="py-2 px-4">Tgl Penjadwalan</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Pemeliharaan</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($perbaikan as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">{{ $item->fasilitas }}</td>
                                <td class="py-3 px-4">{{ $item->tgl_pemeliharaan ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $item->status_pemeliharaan }}</td>
                                <td class="py-3 px-4">
                                    @if ($item->status_pemeliharaan === 'Tolak')
                                        <a href="#" data-id="{{ $item->idPemeliharaan }}" data-toggle="modal" data-target="#ModalRevisiJadwal"
                                        class="lihat-detail-pemeliharaan text-indigo-500 hover:text-indigo-700 transition">
                                            Ajukan Kembali <span aria-hidden="true">→</span>
                                        </a>
                                    @elseif ($item->status_pemeliharaan === 'Pengerjaan')
                                        <a href="#" data-toggle="modal" data-target="#ModalKonfirmasiSelesaikan" class="text-indigo-500 hover:text-indigo-700 transition">
                                            Tandai Selesai <span aria-hidden="true">→</span>
                                        </a>

                                        <!-- Modal Konfirmasi -->
                                        <div class="modal fade p-4" id="ModalKonfirmasiSelesaikan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                                    <div class="modal-body p-6 space-y-2">
                                                        <div class="flex items-center space-x-4">
                                                            <!-- Icon Warning -->
                                                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                                </svg>
                                                            </div>
                                                            <!-- Modal Title & Description -->
                                                            <div class="text-left">
                                                                <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Konfirmasi Selesaikan Pemeliharaan</h3>
                                                                <p class="mt-2 text-sm text-gray-500">Apakah anda yakin menyelesaian pemeliharaan ini?</p>
                                                            </div>
                                                        </div>
                                
                                                        <!-- Footer: Tombol Aksi -->
                                                        <div class="mt-6 flex justify-end space-x-4">
                                                            <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Batal</button>
                                                            <button type="submit" data-id="{{ $item->idPemeliharaan }}" class="ubah-pemeliharaan bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">Kirim</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @else
                                        <a href="#" data-id="{{ $item->idPemeliharaan }}" data-toggle="modal" data-target="#ModalPemeliharaan"
                                        class="lihat-detail-pemeliharaan text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span>
                                        </a>
                                    @endif                 
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada permintaan pemeliharaan dari anda.</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>

                <main id="modal-bagian-perbaikan">
                    <!-- MODAL DATA -->
                    <div class="modal fade p-4" id="ModalPemeliharaan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                {{-- header --}}
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Pemeliharaan</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                {{-- content --}}
                                <div class="modal-body p-6 space-y-2">
                                    <!-- AJAX -->
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

                                    <div class="flex items-center space-x-4">
                                        <label for="status" class="w-32 text-md font-medium text-gray-700">
                                            Status:</label>
                                        <input id="modal-status" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button id="button-ajukan-kembali" type="button" data-toggle="modal" 
                                        data-target="#ModalRevisiJadwal" data-dismiss="modal" 
                                        class="hidden rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Ajukan Kembali
                                    </button>                
                                    <button type="button" class=" rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600" data-dismiss="modal">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL REVISI --}}
                    <div class="modal fade p-4" id="ModalRevisiJadwal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white"> 
                                <form action="{{ route('perbaikan.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    {{-- header --}}
                                    <div class="modal-header border-b border-gray-200 py-4 px-6">
                                        <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Perbaikan</h3>
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
                                            <label for="fasilitas" class="w-32 text-md font-medium text-gray-700">
                                                Fasilitas:</label>
                                            <input id="modal-revisi-fasilitas" type="text" value="" name="fasilitas"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                disabled>
                                        </div>
                                        
                                        <div class="text-center">
                                            <p class="text-gray-500 text-sm">Masukan Pesan Permintaan Perbaikan.</p>
                                        </div>

                                        {{-- pesan --}}
                                        <div class="flex items-center space-x-4 mt-4">
                                            <label for="keterangan" class="w-32 text-md font-medium text-gray-700">
                                                Pesan:</label>
                                            <textarea id="modal-revisi-pesan" type="text" value="" rows="2" name="pesan"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"></textarea>
                                        </div>

                                        <input type="hidden" id="modal-revisi-idPemeliharaan" name="idPemeliharaan">

                                    </div> 
                                    {{-- SUBMIT --}}
                                    <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                        <button type="button" data-dismiss="modal" 
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Tutup
                                        </button>
                                        <button type="submit" name="action" value="tolak" data-toggle="modal" data-target="#ModalSuksesRevisiPerbaikan"
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Kirim
                                        </button>
                                    </div>                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
            {{-- TAMBAH DATA --}}
            <section class="mt-10">
                <form action="{{ route('perbaikan.store') }}" method="POST">
                    @csrf 
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-10">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Ajukan Pemeliharaan Fasilitas*</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Semua kolom wajib di isi.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                {{-- fasilitas --}}
                                @if ($listFasilitas && $listFasilitas->isNotEmpty())
                                    <div class="sm:col-span-1 sm:col-start-1">
                                        <label for="pilihan"
                                            class="block text-sm font-medium leading-6 text-gray-900">Fasilitas Tersedia</label>
                                        <div class="mt-2">
                                            <select name="pilihan" id="pilihan"
                                                class="text-center block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    <option value="" disabled selected>Pilih Fasilitas</option>
                                                    @foreach ($listFasilitas as $fasilitasId)
                                                        <option value="{{ $fasilitasId->fasilitas }}">{{ $fasilitasId->fasilitas }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- input fasilitas --}}
                                    <div class="sm:col-span-2">
                                        <label for="fasilitas"
                                            class="block text-sm font-medium leading-6 text-gray-900">Fasilitas yang diajukan</label>
                                        <div class="mt-2">
                                            <input type="text" name="fasilitas" id="fasilitas"
                                                class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                required>
                                        </div>
                                    </div>

                                    {{-- update fasilitas --}}
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const pilihan = document.getElementById('pilihan');
                                            const fasilitasInput = document.getElementById('fasilitas');
                                    
                                            if (pilihan) {
                                                pilihan.addEventListener('change', function () {
                                                    fasilitasInput.value = pilihan.value;
                                                });
                                            }
                                        });
                                    </script>
                                    
                                @else
                                    <div class="sm:col-span-3 sm:col-start-1">
                                        <label for="fasilitas"
                                            class="block text-sm font-medium leading-6 text-gray-900">Fasilitas</label>
                                        <div class="mt-2">
                                            <input type="text" name="fasilitas" id="fasilitas"
                                                class="text-center block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                required>
                                        </div>
                                    </div>
                                @endif

                                {{-- pesan --}}
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label for="pesan"
                                        class="block text-sm font-medium leading-6 text-gray-900">Pesan</label>
                                    <div class="mt-2">
                                        <textarea required id="pesan" name="pesan" rows="3" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian Submit --}}
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                            <button type="submit" data-toggle="modal" data-target="#ModalSuksesBuatPerbaikan"
                                class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajukan Pemeliharaan</button>
                        </div>
                    </div>
                </form>
            </section>
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



{{-- AJAX DETAIL --}}
<script>
    $(document).ready(function(){
        $('.lihat-detail-pemeliharaan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); 

            // AJAX untuk mengambil data kamar
            $.ajax({
                url: '/detailPerbaikan/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-kamar').val('Kamar ' + data.idKamar);
                    $('#modal-tanggal').val(data.tanggal);
                    $('#modal-fasilitas').val(data.fasilitas);
                    $('#modal-jadwal').val(data.tgl_pemeliharaan);
                    $('#modal-pesan').val(data.pesan);
                    $('#modal-status').val(data.status_pemeliharaan);

                    if (data.status_pemeliharaan === 'Tolak') {
                        $('#button-ajukan-kembali').removeClass('hidden');
                    } else {
                        $('#button-ajukan-kembali').addClass('hidden');
                    }

                    $('#modal-revisi-idPemeliharaan').val(data.idPemeliharaan);
                    $('#modal-revisi-fasilitas').val(data.fasilitas);
                    $('#modal-revisi-pesan').val(data.pesan);
                }
            });
        });

        $('.lihat-detail-riwayat').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); 

            // AJAX untuk mengambil data kamar
            $.ajax({
                url: '/detailPerbaikanRiwayat/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-detail-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-detail-tanggal').val(data.data.tanggal);
                    $('#modal-detail-fasilitas').val(data.data.fasilitas);
                    $('#modal-detail-jadwal').val(data.data.tgl_pemeliharaan);
                    $('#modal-detail-pesan').val(data.data.pesan);
                    $('#modal-detail-status').val(data.data.status_pemeliharaan);
                }
            });
        });
    });
</script>
{{-- UPDATE SELESAI  --}}
<script>
    $(document).on('click', '.ubah-pemeliharaan', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            url: '/pemeliharaan/tandai-selesai/' + id,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload(); 
            }
        });
    });
</script>