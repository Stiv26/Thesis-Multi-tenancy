<x-layout>
    <main class="px-5 py-8 bg-gray-50 rounded-xl">

        {{-- FIRST PAGE --}}
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-semibold text-gray-700 mb-4">Dashboard</h1>
            {{-- SETTINGS --}}
            <div class="mb-4 flex items-center pt-2">
                {{-- ICON --}}
                <div class="detailAturan relative group" data-toggle="modal" data-target="#ModalPengaturan"
                    id="detailAturan" data-id="1">
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-12 text-gray-900 transition-transform transform group-hover:scale-125 cursor-pointer"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                        <path
                            d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                    </svg>
                </div>

                @php
                    $tabelDefault = Schema::hasTable('default');
                @endphp

                {{-- MODAL PENGATURAN --}}
                <div class="modal fade p-4" id="ModalPengaturan" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            {{-- header --}}
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Pengaturan Kos</h3>
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
                            <form action="{{ route('atur.pengaturan') }}" method="POST">
                                @csrf
                                <div class="modal-body p-6 space-y-2">

                                    <div class="text-center">
                                        <p class="text-gray-500 text-sm">Masukan Pengaturan Default Kontrak Kos</p>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="angka_mingguan"
                                            class="w-48 text-md font-medium text-gray-700">
                                            Nominal Depoist:</label>
                                        <input id="modal-buat-angka_mingguan" type="number"
                                            value="" name="angka_mingguan" placeholder="Nominal Denda Kos"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="angka_mingguan"
                                            class="w-48 text-md font-medium text-gray-700">
                                            Tanggal Tagihan Bulanan:</label>
                                        <input id="modal-buat-angka_mingguan" type="number"
                                            value="" name="angka_mingguan" placeholder="Tanggal Tiap Tagihan" min="1"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="angka_mingguan"
                                            class="w-48 text-md font-medium text-gray-700">
                                            Tanggal Denda Bulanan:</label>
                                        <input id="modal-buat-angka_mingguan" type="number"
                                            value="" name="angka_mingguan" placeholder="Tanggal Tiap Denda" min="1"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                    </div>

                                    @if ($tabelDefault)
                                        <div class="flex items-center text-center space-x-4">
                                            <button type="button" id="toggle-denda" class="text-indigo-600 font-medium focus:outline-none">
                                                Lihat Detail Denda &#9662; <!-- Panah ke bawah -->
                                            </button>
                                        </div>

                                        <div id="daftar-denda" class="hidden">
                                            <input type="hidden" name="idDenda" value="1">

                                            <div class="flex items-center space-x-4 py-3">
                                                <label for="jenis_denda" class="w-32 text-md font-medium text-gray-700">
                                                    Tipe Denda:</label>
                                                <select id="modal-buat-jenis_denda" name="jenis_denda"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                                    <option value="Nominal">Nominal</option>
                                                    <option value="Perhari">Perhari</option>
                                                    <option value="Persen">Persen</option>
                                                </select>
                                            </div>

                                            <div class="text-center">
                                                <p class="text-gray-500 text-sm">Masukan Nominal/Persen sesuai dengan
                                                    rentang kontrak</p>
                                            </div>

                                            <div class="flex items-center space-x-4 mb-2">
                                                <label for="angka" class="w-48 text-md font-medium text-gray-700">
                                                    Denda Bulan:</label>
                                                <input id="modal-buat-angka" type="number" value=""
                                                    name="angka" placeholder="Nominal Rp atau %"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                            </div>

                                            <div class="flex items-center space-x-4 mb-2">
                                                <label for="angka_mingguan"
                                                    class="w-48 text-md font-medium text-gray-700">
                                                    Denda Mingguan:</label>
                                                <input id="modal-buat-angka_mingguan" type="number"
                                                    value="" name="angka_mingguan" placeholder="Nominal Rp atau %"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <label for="angka_harian"
                                                    class="w-48 text-md font-medium text-gray-700">
                                                    Denda Harian:</label>
                                                <input id="modal-buat-angka_harian" type="number"
                                                    value="" name="angka_harian" placeholder="Nominal Rp atau %"
                                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function () {
                                                $('#toggle-denda').on('click', function () {
                                                    $('#daftar-denda').toggleClass('hidden'); // Show/hide daftar denda
                                        
                                                    // Ubah ikon panah sesuai kondisi (naik/turun)
                                                    if ($('#daftar-denda').hasClass('hidden')) {
                                                        $(this).html('Lihat Detail Denda &#9662;'); // Panah ke bawah
                                                    } else {
                                                        $(this).html('Tutup Detail Denda &#9652;'); // Panah ke atas
                                                    }
                                                });
                                            });
                                        </script>
                                    @endif

                                </div>
                                {{-- SUBMIT --}}
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button type="submit"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Simpan Aturan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PERMINTAAN --}}
        @if ($permintaan->isNotEmpty())
            <section class="bg-white py-2 rounded-xl shadow-md w-full mb-12">
                <h2 class="text-center text-xl font-semibold text-gray-700 mb-4">Permintaan hunian kamar</h2>
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-sm text-gray-600">
                                <th class="py-2.5 pl-5">Nama Penghuni</th>
                                <th class="py-2.5 px-3">No Telp</th>
                                <th class="py-2.5 px-3">Kamar</th>
                                <th class="py-2.5 px-3">Rentang</th>
                                <th class="py-2.5 px-3">Tanggal Masuk</th>
                                <th class="py-2.5 px-3">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @foreach ($permintaan as $data)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-2 pl-5 text-gray-500">{{ $data->nama }}</td>
                                    <td class="py-2 px-3 text-gray-500">{{ $data->no_telp }}</td>
                                    <td class="py-2 px-3 text-gray-500">{{ 'Kamar ' . $data->idKamar }}</td>
                                    <td class="py-2 px-3 text-gray-500">{{ $data->waktu }} {{ $data->rentang }}</td>
                                    <td class="py-2 px-3 text-gray-500">{{ $data->tgl_masuk }}</td>
                                    <td class="py-2 px-3">
                                        <a href="#" data-id="{{ $data->id }}" data-toggle="modal"
                                            data-target="#ModalKontrak"
                                            class="lihat-detail-kontrak text-indigo-500 hover:text-indigo-700 transition">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </section>
        @endif

        {{-- BARIS 2 --}}
        <main class="items-center mt-2">
            <section class="flex justify-between items-start">
                {{-- ROOM'S --}}
                <div class="bg-white p-3 rounded-xl shadow-md mr-4 w-72">
                    <p class="text-center text-xl font-semibold text-gray-800 mb-3">Kamar Kosong</p>
                    <h2 class="text-center text-2xl font-semibold text-gray-700">{{ $room }}</h2>
                </div>
                {{-- ROOM'S --}}
                <div class="bg-white p-3 rounded-xl shadow-md mr-4 w-72">
                    <p class="text-center text-xl font-semibold text-gray-800 mb-3">Kamar Terisi</p>
                    <h2 class="text-center text-2xl font-semibold text-gray-700">{{ $count }}</h2>
                </div>
                {{-- CREATE PAYMENT --}}
                <div class="bg-white py-3 rounded-xl shadow-md w-full">
                    <h2 class="text-center text-xl font-semibold text-gray-700 mb-3">Buat Tagihan</h2>
                    <table class="min-w-full table-auto">
                        <thead class="">
                            <tr class="text-left text-sm text-gray-500">
                                <th class="py-2.5 pl-4 text-center">Nama</th>
                                <th class="py-2.5 px-3 text-center">Kamar</th>
                                <th class="py-2.5 px-3 text-center">Selengkapnya</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600">
                            @foreach ($tagihan as $data)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-2 pl-5 text-gray-500 text-center">{{ $data->nama }}</td>
                                    <td class="py-2 pl-5 text-gray-500 text-center">Kamar {{ $data->idKamar }}</td>
                                    <td class="py-2 px-3">
                                        <a href="/pembayaran" class="lihat-detail-kontrak text-indigo-500 hover:text-indigo-700 transition text-center">
                                            Lihat Detail <span aria-hidden="true">→</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </section>
        </main>

        {{-- INBOX --}}
        @if ($pesan->isNotEmpty())
            <div class="bg-white py-3 rounded-xl shadow-md w-full mr-4 mt-10">
                <h2 class="text-center text-xl font-semibold text-gray-700 mb-3">Pesan Pelaporan Penghuni</h2>
                <table class="min-w-full table-auto">
                    <thead class="">
                        <tr class="text-left text-sm text-gray-500">
                            <th class="py-2.5 pl-4">Nama</th>
                            <th class="py-2.5 px-3 text-left">Pesan</th>
                            <th class="py-2.5 px-3 text-right">Selengkapnya</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-600">
                        @foreach ($pesan as $data)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-1.5 pl-4 text-gray-500">{{ $data->nama }}</td>
                                <td class="py-1.5 px-3 text-left text-gray-500">{{ $data->pesan }}</td>
                                <td class="py-1.5 px-3 text-right">
                                    <a href="/pesan" class="lihat-detail-kontrak text-indigo-500 hover:text-indigo-700 transition">
                                        Baca Pesan <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- BARIS 3 KEUANGAN --}}
        <main id="keuangan" class="block mt-10">
            {{-- LIST --}}
            <p class="text-md text-gray-500 mb-3 px-1">Data Keuangan 3 bulan terakhir</p>
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Total Pembayaran
                                <span class="ml-1 font-medium">{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <div>
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                @foreach ($riwayatBulan as $riwayat)
                                    <a href="{{ route('dashboard.index', ['bulan' => $riwayat->bulan, 'tahun' => $riwayat->tahun]) }}"
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
                            <th class="py-3 px-4">Nominal Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($bulanTersedia as $list)
                            <tr class="text-center">
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($list->tanggal)->format('d-m-Y') }}</td>
                                <td class="py-3 px-4">{{ number_format($list->dibayar, 0, ',', '.') }}</td>
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
        </main>
        
    </main>
</x-layout>


