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
                    $tabelDefault = Schema::hasTable('denda');
                    $tabelDataDiri = Schema::hasTable('listdatadiri');
                    $tabelBiaya = Schema::hasTable('biaya');
                @endphp

                {{-- MODAL PENGATURAN --}}
                <div class="modal fade p-4" id="ModalPengaturan" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            {{-- header --}}
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Pengaturan Kos</h3>
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
                                {{-- content --}}
                                @if ($tabelDefault || $tabelDataDiri || $tabelBiaya)
                                    <section class="flex justify-center items-center mb-2">
                                        <div class="flex items-center justify-between px-3 py-3 rounded-lg">
                                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                                <a href="#pengaturan-kontrak" id="btnPengaturanKontrak" onclick="switchPengaturan('pengaturan-kontrak')"
                                                    class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">
                                                    Kontrak</a>
                                                @if ($tabelDefault)
                                                    <a href="#pengaturan-denda" id="btnPengaturanDenda" onclick="switchPengaturan('pengaturan-denda')"
                                                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                                                        Denda</a>
                                                @endif
                                                @if ($tabelDataDiri)
                                                <a href="#formulir-data-diri" id="btnFormulirDataDiri" onclick="switchPengaturan('formulir-data-diri')"
                                                    class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                                                    Data Diri</a>
                                                @endif
                                                @if ($tabelBiaya)
                                                <a href="#biaya-kontrak-lainnya" id="btnBiayaKontrak" onclick="switchPengaturan('biaya-kontrak-lainnya')"
                                                    class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">
                                                    Biaya</a>
                                                @endif
                                            </nav>
                                        </div>
                                    
                                        <script>
                                            function switchPengaturan(page) {
                                                const sections = {
                                                    'pengaturan-kontrak': document.getElementById('pengaturan-kontrak'),
                                                    'pengaturan-denda': document.getElementById('pengaturan-denda'),
                                                    'formulir-data-diri': document.getElementById('formulir-data-diri'),
                                                    'biaya-kontrak-lainnya': document.getElementById('biaya-kontrak-lainnya')
                                                };
                                    
                                                const buttons = {
                                                    'pengaturan-kontrak': document.getElementById('btnPengaturanKontrak'),
                                                    'pengaturan-denda': document.getElementById('btnPengaturanDenda'),
                                                    'formulir-data-diri': document.getElementById('btnFormulirDataDiri'),
                                                    'biaya-kontrak-lainnya': document.getElementById('btnBiayaKontrak')
                                                };
                                    
                                                // Hide all sections
                                                Object.values(sections).forEach(section => {
                                                    if(section) section.classList.add('hidden');
                                                });
                                    
                                                // Reset all buttons
                                                Object.values(buttons).forEach(button => {
                                                    if(button) {
                                                        button.classList.remove('bg-indigo-600', 'text-white');
                                                        button.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                                                    }
                                                });
                                    
                                                // Show selected section and activate button
                                                if(sections[page]) {
                                                    sections[page].classList.remove('hidden');
                                                    buttons[page].classList.add('bg-indigo-600', 'text-white');
                                                    buttons[page].classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
                                                }
                                    
                                                // Smooth scroll to top
                                                setTimeout(() => {
                                                    window.scrollTo({
                                                        top: 0,
                                                        behavior: 'smooth'
                                                    });
                                                }, 50);
                                            }
                                    
                                            // Aktifkan halaman pertama saat load
                                            document.addEventListener('DOMContentLoaded', function() {
                                                switchPengaturan('pengaturan-kontrak');
                                            });
                                        </script>
                                    </section>
                                @endif

                                <form action="{{ route('atur.pengaturan') }}" method="POST">
                                    @csrf
                                    <main id="pengaturan-kontrak" class="block">
                                        
                                        <div class="text-center">
                                            <p class="text-gray-500 text-sm">Masukan Pengaturan Default Kontrak Kos</p>
                                        </div>

                                        <div class="flex items-center space-x-4 mb-2">
                                            <label for="modal-buat-deposit" class="w-48 text-md font-medium text-gray-700">
                                                Nominal Depoist:</label>
                                            <input id="modal-buat-deposit" type="number"
                                                value="{{ $pengaturan->nominal_deposit ?? '' }}" name="deposit"
                                                placeholder="Nominal Denda Kos"
                                                class="text-center flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                        </div>

                                        <div class="flex items-center space-x-4 mb-2">
                                            <label for="modal-buat-tagihan_perbulan"
                                                class="w-48 text-md font-medium text-gray-700">
                                                Tanggal Tagihan Bulanan:</label>
                                            <input id="modal-buat-tagihan_perbulan" type="number"
                                                value="{{ $pengaturan->pertanggal_tagihan_bulan ?? '' }}"
                                                name="tagihan_perbulan" placeholder="Tanggal Tiap Tagihan" min="1"
                                                max="31"
                                                class="text-center flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                        </div>

                                        <div class="flex items-center space-x-4 mb-3">
                                            <label for="modal-buat-denda_perbulan"
                                                class="w-48 text-md font-medium text-gray-700">
                                                Tanggal Denda Bulanan:</label>
                                            <input id="modal-buat-denda_perbulan" type="number"
                                                value="{{ $pengaturan->pertanggal_denda_bulan ?? '' }}"
                                                name="denda_perbulan" placeholder="Tanggal Tiap Denda" min="1"
                                                max="31"
                                                class="text-center flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                        </div>

                                        {{-- SUBMIT --}}
                                        <div class="modal-footer border-t border-gray-200 flex">
                                            <button type="submit"
                                                class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                Simpan Aturan
                                            </button>
                                        </div>
                                    </main>
                                </form>

                                {{-- PENGATURAN DENDA --}}
                                @if ($tabelDefault)
                                    <main id="pengaturan-denda" class="hidden">
                                        <form action="{{ route('atur.denda') }}" method="POST">
                                            @csrf
                                            <div class="text-center">
                                                <p class="text-gray-500 text-sm">Masukan Pengaturan Denda Pembayaran</p>
                                            </div>

                                            <div id="daftar-denda">
                                                <input type="hidden" name="idDenda" value="1">

                                                <div class="flex items-center space-x-4 py-3">
                                                    <label for="jenis_denda" class="w-32 text-md font-medium text-gray-700">
                                                        Tipe Denda:</label>
                                                    <select id="modal-buat-jenis_denda" name="jenis_denda"
                                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                                        <option value="Nominal"
                                                            {{ ($pengaturanDenda->jenis_denda ?? '') == 'Nominal' ? 'selected' : '' }}>
                                                            Nominal</option>
                                                        <option value="Perhari"
                                                            {{ ($pengaturanDenda->jenis_denda ?? '') == 'Perhari' ? 'selected' : '' }}>
                                                            Perhari</option>
                                                        <option value="Persen"
                                                            {{ ($pengaturanDenda->jenis_denda ?? '') == 'Persen' ? 'selected' : '' }}>
                                                            Persen</option>
                                                    </select>

                                                </div>

                                                <div class="text-center">
                                                    <p class="text-gray-500 text-sm">Masukan Nominal/Persen sesuai dengan
                                                        rentang kontrak</p>
                                                </div>

                                                <div class="flex items-center space-x-4 mb-2">
                                                    <label for="angka" class="w-48 text-md font-medium text-gray-700">
                                                        Denda Bulan:</label>
                                                    <input id="modal-buat-angka" type="number"
                                                        value="{{ $pengaturanDenda->angka ?? '' }}" name="angka"
                                                        placeholder="Nominal Rp atau %"
                                                        class="text-center flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                                </div>

                                                <div class="flex items-center space-x-4 mb-2">
                                                    <label for="angka_mingguan"
                                                        class="w-48 text-md font-medium text-gray-700">
                                                        Denda Mingguan:</label>
                                                    <input id="modal-buat-angka_mingguan" type="number"
                                                        value="{{ $pengaturanDenda->angka_mingguan ?? '' }}"
                                                        name="angka_mingguan" placeholder="Nominal Rp atau %"
                                                        class="text-center flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                                </div>

                                                <div class="flex items-center space-x-4 mb-3">
                                                    <label for="angka_harian"
                                                        class="w-48 text-md font-medium text-gray-700">
                                                        Denda Harian:</label>
                                                    <input id="modal-buat-angka_harian" type="number"
                                                        value="{{ $pengaturanDenda->angka_harian ?? '' }}"
                                                        name="angka_harian" placeholder="Nominal Rp atau %"
                                                        class="text-center flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                                </div>

                                                {{-- SUBMIT --}}
                                                <div class="modal-footer border-t border-gray-200 flex">
                                                    <button type="submit"
                                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                                        Simpan Aturan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </main>
                                @endif

                                {{-- DATA DIRI --}}
                                @if ($tabelDataDiri)
                                    <main id="formulir-data-diri" class="hidden">
                                        <div class="text-center">
                                            <p class="text-gray-500 text-sm">Masukan Pengaturan Formulir Data Diri</p>
                                        </div>

                                        <ol class="list-decimal pl-4">
                                            @foreach ($dataDiriList as $item)
                                                <div class="flex justify-between">
                                                    <li class="btn-tindakan-dataDiri text-md py-1 px-3">
                                                        {{ $item->data_diri }}</li>
                                                    <a href="#" 
                                                        data-id="{{ $item->idListDataDiri }}" data-dataDiri="{{ $item->data_diri }}" 
                                                        data-toggle="modal" data-target="#ModalTindakanDataDiri" data-dismiss="modal"
                                                        class="lihat-detail-aturan text-red-600 text-sm py-1 px-3">Tindakan</a>
                                                </div>
                                            @endforeach
                                        </ol>
                                        <a href="#" data-toggle="modal" data-target="#ModalTambahDataDiri"
                                            data-dismiss="modal" class="mt-3 text-sm leading-6 text-gray-600 ml-7">
                                            <span aria-hidden="true">+</span> Tambah Data Diri Baru</a>
                                    </main>
                                @endif

                                {{-- BIAYA --}}
                                @if ($tabelBiaya)
                                    <main id="biaya-kontrak-lainnya" class="hidden">
                                        <div class="text-center">
                                            <p class="text-gray-500 text-sm">Masukan Pengaturan Biaya Kontrak Lainnya</p>
                                        </div>

                                        <ol class="list-decimal pl-4">
                                            @foreach ($biayaList as $item)
                                                <div class="flex justify-between">
                                                    <li class="text-md py-1 px-3">{{ $item->biaya }}</li>
                                                    <a href="#" 
                                                        data-id="{{ $item->idBiaya }}" data-biaya="{{ $item->biaya }}" 
                                                        data-toggle="modal" data-target="#ModalTindakanBiaya" data-dismiss="modal"
                                                        class="lihat-detail-biaya text-red-600 text-sm py-1 px-3">Tindakan
                                                    </a>
                                                </div>
                                            @endforeach
                                        </ol>
                                        <a href="#" data-toggle="modal" data-target="#ModalTambahBiaya"
                                            data-dismiss="modal" class="mt-3 text-sm leading-6 text-gray-600 ml-7">
                                            <span aria-hidden="true">+</span> Tambah Biaya Baru</a>
                                    </main>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <main id="modal-bagian-datadiri-biaya">

                    {{-- MODAL TAMBAH DATA DIRI --}}
                    <div class="modal fade p-4" id="ModalTambahDataDiri" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <form action="{{ route('dashboard.dataDiri.store') }}" method="POST"
                                class="modal-content rounded-lg shadow-lg bg-white">
                                @csrf
                                {{-- Header modal --}}
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Tambah Formulir
                                        Data Diri
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
                                {{-- Content modal --}}
                                <div class="modal-body p-6 space-y-2">
                                    <div class="flex items-center space-x-4">
                                        <label for="tambah-dataDiri"
                                            class="w-32 text-md font-medium text-gray-700">Data Diri:</label>
                                        <input required id="tambah-dataDiri" name="dataDiri" type="text"
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
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- MODAL TINDAKAN DATA DIRI --}}
                    <div class="modal fade p-4" id="ModalTindakanDataDiri" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                {{-- header --}}
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Formulir Data
                                        Diri</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-600"
                                        data-dismiss="modal" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- Content --}}
                                <div class="modal-body p-6 space-y-2">
                                    <!-- Form untuk Update -->
                                    <form id="updateForm" action="{{ route('dashboard.dataDiri.update') }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex items-center space-x-4">
                                            <label for="modal-tindakan-dataDiri"
                                                class="w-32 text-md font-medium text-gray-700">
                                                Data Diri:
                                            </label>
                                            <input id="modal-tindakan-dataDiri" type="text" name="dataDiri"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                required>
                                        </div>
                                        <input type="hidden" id="modal-tindakan-idDataDiri-update"
                                            name="idDataDiri">
                                    </form>

                                    <!-- Form untuk Delete -->
                                    <form id="deleteForm" action="{{ route('dashboard.dataDiri.destroy') }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" id="modal-tindakan-idDataDiri-delete"
                                            name="idDataDiri">
                                    </form>
                                </div>

                                {{-- Footer --}}
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button type="submit" form="deleteForm" id="btn-hapus-dataDiri"
                                        class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500">
                                        Hapus
                                    </button>
                                    <button type="submit" form="updateForm" id="btn-ubah-dataDiri"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Ubah Aturan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL TAMBAH BIAYA --}}
                    <div class="modal fade p-4" id="ModalTambahBiaya" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <form action="{{ route('dashboard.biaya.store') }}" method="POST"
                                class="modal-content rounded-lg shadow-lg bg-white">
                                @csrf
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800">Tambah Biaya</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body p-6 space-y-2">
                                    <div class="flex items-center space-x-4">
                                        <label for="tambah-biaya" class="w-32 text-md font-medium text-gray-700">Biaya:</label>
                                        <input required id="tambah-biaya" name="biaya" type="text"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                    </div>
                                </div>
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button type="submit"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Tambah
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- MODAL TINDAKAN BIAYA --}}
                    <div class="modal fade p-4" id="ModalTindakanBiaya" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                <div class="modal-header border-b border-gray-200 py-4 px-6">
                                    <h3 class="text-2xl font-semibold text-gray-800">Formulir Biaya</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body p-6 space-y-2">
                                    <!-- Form Update -->
                                    <form id="updateBiayaForm" action="{{ route('dashboard.biaya.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex items-center space-x-4">
                                            <label for="modal-tindakan-biaya" class="w-32 text-md font-medium text-gray-700">
                                                Biaya:
                                            </label>
                                            <input id="modal-tindakan-biaya" type="text" name="biaya"
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0"
                                                required>
                                        </div>
                                        <input type="hidden" id="modal-tindakan-idBiaya-update" name="idBiaya">
                                    </form>

                                    <!-- Form Delete -->
                                    <form id="deleteBiayaForm" action="{{ route('dashboard.biaya.destroy') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" id="modal-tindakan-idBiaya-delete" name="idBiaya">
                                    </form>
                                </div>
                                <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                                    <button type="submit" form="deleteBiayaForm"
                                        class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500">
                                        Hapus
                                    </button>
                                    <button type="submit" form="updateBiayaForm"
                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Ubah Biaya
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </main>
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
                                    <a href="/penghuni"
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
                    <a href="" data-toggle="modal" data-target="#ModalKamarKosong">
                        <p class="text-center text-xl font-semibold text-gray-800 mb-3">Kamar Kosong</p>
                        <h2 class="text-center text-2xl font-semibold text-gray-700">{{ $room }}</h2>
                    </a>

                    <!-- MODAL DATA -->
                    <div class="modal fade p-4" id="ModalKamarKosong" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24"> <!-- Lebar lebih besar -->
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                <!-- Header -->
                                <div
                                    class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-center">
                                    <h3 class="text-2xl font-semibold text-gray-800">Kamar Kosong</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-600"
                                        data-dismiss="modal" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Content -->
                                <div class="modal-body p-6 space-y-4"> 
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600">Daftar Kamar Kosong</label>
                                        <div class="space-y-2 mt-2">
                                            @foreach ($kamarKosong as $item)
                                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100" value="Kamar {{ $item->idKamar }}" readonly>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ROOM'S --}}
                <div class="bg-white p-3 rounded-xl shadow-md mr-4 w-72">
                    <a href="" data-toggle="modal" data-target="#ModalKamarTerisi">
                        <p class="text-center text-xl font-semibold text-gray-800 mb-3">Kamar Terisi</p>
                        <h2 class="text-center text-2xl font-semibold text-gray-700">{{ $count }}</h2>
                    </a>

                    <!-- MODAL DATA -->
                    <div class="modal fade p-4" id="ModalKamarTerisi" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24"> <!-- Lebar lebih besar -->
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                <!-- Header -->
                                <div
                                    class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-center">
                                    <h3 class="text-2xl font-semibold text-gray-800">Kamar Terisi</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-600"
                                        data-dismiss="modal" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Content -->
                                <div class="modal-body p-6 space-y-4"> 
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600">Daftar Kamar Terisi</label>
                                        <div class="space-y-2 mt-2">
                                            @foreach ($kamarTerisi as $item)
                                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100" value="Kamar {{ $item->idKamar }}" readonly>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                    <td class="py-2 px-3 text-center">
                                        <a href="/pembayaran"
                                            class="lihat-detail-kontrak text-indigo-500 hover:text-indigo-700 transition">
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
                                    <a href="/pesan"
                                        class="lihat-detail-kontrak text-indigo-500 hover:text-indigo-700 transition">
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
                                <span
                                    class="ml-1 font-medium">{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
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
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($list->tanggal)->format('d-m-Y') }}
                                </td>
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

<script>
    $(document).ready(function() {
        // Event listener untuk tombol tindakan
        $(document).on('click', '.lihat-detail-aturan', function() {
            let id = $(this).data('id'); // Ambil ID dari atribut data-id
            let dataDiri = $(this).data('datadiri'); // Ambil data dari atribut data-dataDiri

            $('#modal-tindakan-idDataDiri').val(id); // Isi input hidden dengan ID
            $('#modal-tindakan-dataDiri').val(dataDiri); // Isi input dengan data diri
        });

        $('#ModalTindakanDataDiri').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idDataDiri = button.data('id');
            var dataDiri = button.data('data-diri');

            var modal = $(this);
            modal.find('#modal-tindakan-dataDiri').val(dataDiri);
            // Isi kedua input hidden di kedua form
            modal.find('#modal-tindakan-idDataDiri-update').val(idDataDiri);
            modal.find('#modal-tindakan-idDataDiri-delete').val(idDataDiri);
        });

        $('#ModalTindakanBiaya').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idBiaya = button.data('id');
            var biaya = button.data('biaya');

            var modal = $(this);
            modal.find('#modal-tindakan-biaya').val(biaya);
            modal.find('#modal-tindakan-idBiaya-update').val(idBiaya);
            modal.find('#modal-tindakan-idBiaya-delete').val(idBiaya);
        });
    });
</script>
