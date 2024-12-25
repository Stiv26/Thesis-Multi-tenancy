<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>

        {{-- TOP CONTENT --}}
        <section class="flex justify-between items-center mb-6">
            <div class="flex items-center justify-between px-3 py-3 rounded-lg">
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#laporan" id="btnlaporan" onclick="switchPage('laporan')"
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">Laporan
                        Tugas</a>
                    <a href="#riwayat" id="btnRiwayat" onclick="switchPage('riwayat')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Riwayat
                        Laporan</a>
                    <a href="#karyawan" id="btnkaryawan" onclick="switchPage('karyawan')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Karyawan</a>
                    <a href="#riwayatkaryawan" id="btnRiwayatkaryawan" onclick="switchPage('riwayatkaryawan')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Riwayat
                        Karyawan</a>
                </nav>
            </div>

            {{-- JS --}}
            <script>
                function switchPage(page) {
                    const laporanSection = document.getElementById('laporan');
                    const riwayatSection = document.getElementById('riwayat');
                    const karyawanSection = document.getElementById('karyawan');
                    const riwayatKaryawanSection = document.getElementById('riwayatKaryawan');
                    const btnLaporan = document.getElementById('btnlaporan');
                    const btnKaryawan = document.getElementById('btnkaryawan');
                    const btnRiwayat = document.getElementById('btnRiwayat');
                    const btnRiwayatKaryawan = document.getElementById('btnRiwayatkaryawan'); // Tambahan untuk tombol baru

                    // Sembunyikan semua section
                    laporanSection.classList.add('hidden');
                    karyawanSection.classList.add('hidden');
                    riwayatSection.classList.add('hidden');
                    riwayatKaryawanSection.classList.add('hidden'); // Tambahan untuk menyembunyikan riwayatKaryawan

                    // Reset button styles
                    btnLaporan.classList.remove('bg-indigo-600', 'text-white');
                    btnLaporan.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnKaryawan.classList.remove('bg-indigo-600', 'text-white');
                    btnKaryawan.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnRiwayat.classList.remove('bg-indigo-600', 'text-white');
                    btnRiwayat.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    btnRiwayatKaryawan.classList.remove('bg-indigo-600',
                        'text-white'); // Tambahan untuk reset tombol RiwayatKaryawan
                    btnRiwayatKaryawan.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

                    // Tampilkan section yang dipilih dan aktifkan tombol terkait
                    if (page === 'laporan') {
                        laporanSection.classList.remove('hidden');
                        btnLaporan.classList.add('bg-indigo-600', 'text-white');
                        btnLaporan.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'riwayat') {
                        riwayatSection.classList.remove('hidden');
                        btnRiwayat.classList.add('bg-indigo-600', 'text-white');
                        btnRiwayat.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'karyawan') {
                        karyawanSection.classList.remove('hidden');
                        btnKaryawan.classList.add('bg-indigo-600', 'text-white');
                        btnKaryawan.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                    } else if (page === 'riwayatkaryawan') { // Tambahan untuk RiwayatKaryawan
                        riwayatKaryawanSection.classList.remove('hidden');
                        btnRiwayatKaryawan.classList.add('bg-indigo-600', 'text-white');
                        btnRiwayatKaryawan.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300',
                            'hover:bg-gray-50');
                    }

                    // Memberikan sedikit delay sebelum scroll
                    setTimeout(function() {
                        window.scrollTo(0, 0);
                    }, 50);
                }
            </script>
        </section>

        {{-- PAGE LAPORAN --}}
        <section id="laporan" class="block">
            <section>
                <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
                {{-- LIST --}}
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full table-auto text-center">
                        <thead class="bg-gray-100">
                            <tr class="text-sm text-gray-600">
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Tugas</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-2 px-4">Lihat Detail</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse ($tugas as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                    <td class="py-3 px-4">{{ $item->tugas }}</td>
                                    <td class="py-3 px-4">{{ $item->status }}</td>
                                    <td class="py-3 px-4">
                                        <a href="#" data-id="{{ $item->idTugas }}" data-toggle="modal"
                                            data-target="#ModalTugas"
                                            class="lihat-detail-tugas text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada karyawan
                                        untuk kos ini.</td>
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
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Tugas
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
                                {{-- content --}}
                                <div class="modal-body p-6 space-y-2">
                                    <!-- AJAX -->
                                    <div class="flex items-center space-x-4">
                                        <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                            Tanggal:</label>
                                        <input id="modal-tanggal" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="tugas" class="w-32 text-md font-medium text-gray-700">
                                            Tugas:</label>
                                        <textarea id="modal-tugas" type="text" value="" rows="2"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="statustugas" class="w-32 text-md font-medium text-gray-700">
                                            Status:</label>
                                        <input id="modal-statustugas" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                </div>
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">

                                    <a href="#" id="edit-tugas-btn">
                                        <button type="button"
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Ubah Data
                                        </button>
                                    </a>
                                    <button type="button"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                        data-dismiss="modal">
                                        Tutup
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="border-b border-gray-900/10 pb-10">
            </section>

            <a href="#" data-toggle="modal" data-target="#ModalBuatTugas"
                class="mt-3 text-md leading-6 text-gray-600 ml-4">
                <span aria-hidden="true">+</span> Buat Tugas Karyawan</a>

            {{-- MODAL TAMBAH TUGAS --}}
            <div class="modal fade p-4" id="ModalBuatTugas" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                    <form action="{{ route('tugas.store') }}" method="POST"
                        class="modal-content rounded-lg shadow-lg bg-white">
                        @csrf
                        {{-- Header modal --}}
                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Buat Tugas Baru</h3>
                            <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal"
                                aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        {{-- Content modal --}}
                        <div class="modal-body p-6 space-y-2">
                            <div class="flex items-center space-x-4">
                                <label for="tambah-tugas"
                                    class="w-32 text-md font-medium text-gray-700">Tugas:</label>
                                <textarea id="tambah-tugas" type="text" name="tugas" value="" rows="2"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" required></textarea>
                            </div>
                            <div class="flex items-center space-x-4">
                                <label for="tambah-pengerjaan" class="w-32 text-md font-medium text-gray-700">Tanggal
                                    Pengerjaan:</label>
                                <input required id="tambah-pengerjaan" name="pengerjaan" type="datetime-local"
                                    value=""
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                            </div>
                        </div>
                        {{-- Footer --}}
                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                Tambah
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
        </section>

        {{-- PAGE RIWAYAT --}}
        <section id="riwayat" class="hidden">
            <section>
                <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
                {{-- LIST --}}
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full table-auto text-center">
                        <thead class="bg-gray-100">
                            <tr class="text-sm text-gray-600">
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Tugas</th>
                                <th class="py-3 px-4">Status</th>
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
                                        <a href="#" data-id="{{ $item->idTugas }}" data-toggle="modal"
                                            data-target="#ModalRiwayat"
                                            class="lihat-detail-riwayat text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada laporan.
                                    </td>
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
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Laporan
                                        Tugas</h3>
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
                                        <label for="tanggal" class="w-32 text-md font-medium text-gray-700">
                                            Tanggal:</label>
                                        <input id="modal-riwayat-tanggal" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
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
                                        <input id="modal-riwayat-statustugas" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <img id="modal-riwayat-bukti" src="/storage/bukti_laporan/example.jpg" alt="Bukti Laporan Terkirim">

                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="upload" class="w-32 text-md font-medium text-gray-700">
                                            Tanggal Upload:</label>
                                        <input id="modal-riwayat-upload" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
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

        </section>

        {{-- PAGE KARYAWAN --}}
        <section id="karyawan" class="hidden">
            <section>
                <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
                {{-- LIST --}}
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full table-auto text-center">
                        <thead class="bg-gray-100">
                            <tr class="text-sm text-gray-600">
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">No Telp</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-2 px-4">Lihat Detail</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse ($karyawan as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">{{ $item->nama }}</td>
                                    <td class="py-3 px-4">{{ $item->no_telp }}</td>
                                    <td class="py-3 px-4">{{ $item->email }}</td>
                                    <td class="py-3 px-4">
                                        <a href="#" data-id="{{ $item->id }}" data-toggle="modal"
                                            data-target="#ModalKaryawan"
                                            class="lihat-detail-karyawan text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada karyawan
                                        untuk kos ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- MODAL DATA -->
                    <div class="modal fade p-4" id="ModalKaryawan" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                {{-- header --}}
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Karyawan
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
                                {{-- content --}}
                                <div class="modal-body p-6 space-y-2">
                                    <!-- AJAX -->
                                    <div class="flex items-center space-x-4">
                                        <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                            Nama Karyawan:</label>
                                        <input id="modal-nama" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="telp" class="w-32 text-md font-medium text-gray-700">
                                            No Telp:</label>
                                        <input id="modal-no_telp" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="password" class="w-32 text-md font-medium text-gray-700">
                                            Password:</label>
                                        <input id="modal-password" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="email" class="w-32 text-md font-medium text-gray-700">
                                            Email:</label>
                                        <input id="modal-email" type="text" value=""
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


                                </div>
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">

                                    <a href="#" id="hapus-karyawan-btn">
                                        <button type="submit"
                                            class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500">
                                            Berhentikan
                                        </button>
                                    </a>

                                    <a href="#" id="edit-karyawan-btn">
                                        <button type="button"
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                            Ubah Data
                                        </button>
                                    </a>
                                    <button type="button"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                        data-dismiss="modal">
                                        Tutup
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="border-b border-gray-900/10 pb-10">
            </section>

            {{-- TAMBAH DATA --}}
            <section>
                <form action="{{ route('karyawan.store') }}" method="POST" class="mt-10">
                    @csrf
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-10">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Tambah Karyawan Kos*</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Semua kolom wajib diisi.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                {{-- No Telp --}}
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label for="no_telp" class="block text-sm font-medium leading-6 text-gray-900">No
                                        Telp</label>
                                    <div class="mt-2">
                                        <input type="text" name="no_telp" id="no_telp"
                                            class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                </div>
                                {{-- Password --}}
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label for="password"
                                        class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                    <div class="mt-2">
                                        <input type="text" name="password" id="password"
                                            class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                </div>
                                {{-- Email --}}
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label for="email"
                                        class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                    <div class="mt-2">
                                        <input type="text" name="email" id="email"
                                            class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                </div>
                                {{-- Nama --}}
                                <div class="sm:col-span-3 sm:col-start-1">
                                    <label for="nama"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nama</label>
                                    <div class="mt-2">
                                        <input type="text" name="nama" id="nama"
                                            class=";block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian Submit --}}
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                        </div>
                    </div>
                </form>

            </section>
        </section>

        {{-- PAGE KARYAWAN --}}
        <section id="riwayatKaryawan" class="hidden">
            <section>
                <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
                {{-- LIST --}}
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full table-auto text-center">
                        <thead class="bg-gray-100">
                            <tr class="text-sm text-gray-600">
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">No Telp</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-2 px-4">Lihat Detail</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse ($riwayatKaryawan as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">{{ $item->nama }}</td>
                                    <td class="py-3 px-4">{{ $item->no_telp }}</td>
                                    <td class="py-3 px-4">{{ $item->email }}</td>
                                    <td class="py-3 px-4">
                                        <a href="#" data-id="{{ $item->id }}" data-toggle="modal"
                                            data-target="#ModalRiwayatKaryawan"
                                            class="lihat-riwayat-karyawan text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada riwayat
                                        karyawan untuk kos ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- MODAL DATA -->
                    <div class="modal fade p-4" id="ModalRiwayatKaryawan" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                {{-- header --}}
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Karyawan
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
                                {{-- content --}}
                                <div class="modal-body p-6 space-y-2">
                                    <!-- AJAX -->
                                    <div class="flex items-center space-x-4">
                                        <label for="nama" class="w-32 text-md font-medium text-gray-700">
                                            Nama Karyawan:</label>
                                        <input id="modal-riwayat-nama" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="telp" class="w-32 text-md font-medium text-gray-700">
                                            No Telp:</label>
                                        <input id="modal-riwayat-no_telp" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="password" class="w-32 text-md font-medium text-gray-700">
                                            Password:</label>
                                        <input id="modal-riwayat-password" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="email" class="w-32 text-md font-medium text-gray-700">
                                            Email:</label>
                                        <input id="modal-riwayat-email" type="text" value=""
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
                                        <label for="status" class="w-32 text-md font-medium text-gray-700">
                                            Tanggal Berhenti:</label>
                                        <input id="modal-riwayat-tgl" type="text" value=""
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                            readonly>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="status" class="w-32 text-md font-medium text-gray-700">
                                            Alasan:</label>
                                        <textarea id="modal-riwayat-alasan" type="text" value="" rows="2"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly></textarea>
                                    </div>

                                </div>
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button type="button"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                        data-dismiss="modal">
                                        Tutup
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="border-b border-gray-900/10 pb-10">
            </section>

        </section>

    </main>
</x-layout>


{{-- AJAX --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-tugas').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/tugas/' + id,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#modal-tugas').val(data.tugas);
                    $('#modal-tanggal').val(data.tanggal);
                    $('#modal-statustugas').val(data.status);

                    $('#edit-tugas-btn').attr('href', '/tugas/edit-tugas/' + id);
                },
                error: function() {
                    alert('Gagal mengambil data tugas.');
                }
            });
        });

        $('.lihat-detail-riwayat').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/tugas/riwayat/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-riwayat-tugas').val(data.tugas);
                    $('#modal-riwayat-tanggal').val(data.tanggal);
                    $('#modal-riwayat-statustugas').val(data.status);
                    $('#modal-riwayat-upload').val(data.tgl_update);
                    // $('#modal-riwayat-bukti').attr('src', '/' + data.bukti);

                    // if (data.bukti) {
                    //     $('#modal-riwayat-bukti').attr('src', '/storage/tenant000/app/public/bukti_laporan/' + data.bukti).show();
                    // } 
                    // else {
                    //     $('#modal-riwayat-bukti').hide(); // Sembunyikan jika tidak ada bukti
                    // }
                },
                error: function() {
                    alert('Gagal mengambil data tugas.');
                }
            });
        });

        $('.lihat-detail-karyawan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/karyawan/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-nama').val(data.nama);
                    $('#modal-no_telp').val(data.no_telp);
                    $('#modal-password').val(data.password);
                    $('#modal-email').val(data.email);
                    $('#modal-status').val(data.status);

                    $('#edit-karyawan-btn').attr('href', '/karyawan/edit-karyawan/' + id);
                    $('#hapus-karyawan-btn').attr('href',
                        '/karyawan/pemberhentian-karyawan/' + id);
                }
            });
        });

        $('.lihat-riwayat-karyawan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/karyawan/riwayat/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-riwayat-nama').val(data.nama);
                    $('#modal-riwayat-no_telp').val(data.no_telp);
                    $('#modal-riwayat-password').val(data.password);
                    $('#modal-riwayat-email').val(data.email);
                    $('#modal-riwayat-status').val(data.status);
                    $('#modal-riwayat-tgl').val(data.tanggal);
                    $('#modal-riwayat-alasan').val(data.alasan);
                }
            });
        });
    });
</script>
