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
                    <a href="#tambahPenghuni" id="btnTambah" onclick="switchPage('tambahPenghuni')" 
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">Tambah Penghuni</a>
                    <a href="#listPenghuni" id="btnList" onclick="switchPage('listPenghuni')" 
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Data Penghuni</a>
                </nav>
            </div> 
        </section>
        
        <!-- PAGE TAMBAH PENGHUNI -->
        <section id="tambahPenghuni" class="block">

            <form action="{{ route('kontrak.store') }}" method="POST" class="mt-10">
                @csrf
                <div class="space-y-12">
                    <!-- Bagian Akun Penghuni -->
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Akun Penghuni*</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Informasi akun yang digunakan untuk login dan verifikasi penghuni.</p>
                
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="telpon" class="block text-sm font-medium leading-6 text-gray-900">Nomor Telepon</label>
                                <div class="mt-2">
                                    <input required type="text" name="telpon" id="telpon" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                    
                            <div class="sm:col-span-4">
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Kata Sandi</label>
                                <div class="mt-2">
                                    <input required type="text" name="password" id="password" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
              
                    <!-- Bagian Kontak -->
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Informasi Kontrak*</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Data informasi kontrak yang dibuat dengan penghuni kos.</p>
                
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        {{-- kamar --}}
                        <div class="sm:col-span-4">
                            <label for="kamar" class="block font-medium mb-2">Kamar:</label>
                            <select required id="kamar" name="kamar" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                @if ($listKamar && $listKamar->isNotEmpty())
                                    @foreach ($listKamar as $kamarId)
                                        <option value="{{ $kamarId->idKamar }}" data-harga="{{ $kamarId->harga }}">Kamar {{ $kamarId->idKamar }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Tidak ada kamar tersedia</option>
                                @endif
                            </select>  
                        </div> 

                        {{-- nama lengkap --}}
                        <div class="sm:col-span-4">
                            <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap</label>
                            <div class="mt-2">
                                <input required type="text" name="nama" id="nama" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
              
                        {{-- email --}}
                        <div class="sm:col-span-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                            <div class="mt-2">
                                <input required id="email" name="email" type="email" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
              
                        {{-- rentang kontrak --}}
                        <div class="sm:col-span-2 sm:col-start-1">
                            <label for="kontrak" class="block text-sm font-medium leading-6 text-gray-900">Rentang Kontrak</label>
                            <div class="mt-2">
                                <select required name="kontrak" id="kontrak" class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option>Bulan</option>
                                    <option>Mingguan</option>
                                    <option>Harian</option>
                                </select>
                            </div>
                        </div>

                        {{-- tgl masuk --}}
                        <div class="sm:col-span-2">
                            <label for="masuk" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Masuk</label>
                            <div class="mt-2">
                                <input required type="date" name="masuk" id="masuk" class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
              
                        {{-- waktu tinggal --}}
                        <div class="sm:col-span-2 sm:col-start-1">
                            <label for="tinggal" class="block text-sm font-medium leading-6 text-gray-900">Waktu Tinggal ( Hitungan Perbulan/Minggu/Hari )</label>
                            <div class="mt-2">
                                <input required type="number" name="tinggal" id="tinggal" class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
              
                        {{-- tgl keluar --}}
                        <div class="sm:col-span-2">
                            <label for="keluar" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Keluar</label>
                            <div class="mt-2">
                                <input type="date" name="keluar" id="keluar" class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        {{-- tgl tagihan --}}
                        <div class="sm:col-span-2 sm:col-start-1">
                            <label for="tagihan" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Tagihan</label>
                            <div class="mt-2">
                                <input required type="date" name="tagihan" id="tagihan" class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
              
                        {{-- tgl denda --}}
                        <div class="sm:col-span-2">
                            <label for="denda" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Denda</label>
                            <div class="mt-2">
                                <input required type="date" name="denda" id="denda" class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        
                        {{-- nominal deposit --}}
                        <div class="sm:col-span-1 sm:col-start-1">
                            <label for="deposit" class="block text-sm font-medium leading-6 text-gray-900">Nominal Deposit</label>
                            <div class="mt-2">
                                <input id="deposit" name="deposit" type="number" class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        {{-- total pembayaran --}}
                        <div class="sm:col-span-3">
                            <label for="pembayaran" class="block text-sm font-medium leading-6 text-gray-900">Total Nominal Pembayaran</label>
                            <div class="mt-2">
                                <input disabled id="pembayaran" value="" name="pembayaran" type="number" class="text-center block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
              
                    </div>
                </div>

                {{-- Bagian biaya kontrak --}}
                @if (!empty($biayaList)) 
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Biaya Fasilitas Kontrak*</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Fasilitas yang terkandung dalam kontrak <i>(Nominal biaya akan ditambahan pada nota saat pembayaran).</i></p>
                    
                        <div class="mt-3 mb-4 space-y-10"> 
                            {{-- biaya --}}
                            <div id="tambah-biaya-container" class="flex flex-wrap gap-x-8 gap-y-6 mt-6">
                                @foreach ($biayaList as $biaya)
                                    <div class="relative flex gap-x-2 items-center">
                                        <!-- Checkbox untuk biaya -->
                                        <input checked
                                            id="biaya_{{ $biaya->idBiaya }}" 
                                            name="idBiaya[]" 
                                            type="checkbox" 
                                            value="{{ $biaya->idBiaya }}" 
                                            class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        
                                        <!-- Label untuk checkbox -->
                                        <label for="biaya_{{ $biaya->idBiaya }}" class="text-sm font-medium text-gray-900">
                                            {{ $biaya->biaya }}
                                        </label>
                                    </div>
                                @endforeach      
                            </div>
                        </div>

                        <a href="#" data-toggle="modal" data-target="#ModalTambahBiaya" class="mt-3 text-sm leading-6 text-gray-600 mr-4">
                            <span aria-hidden="true">+</span> Tambah Biaya Baru</a>

                    </div>
                @endif

                {{-- Bagian data diri penghuni --}}
                @if (!empty($dataDiriList))
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Data Diri Penghuni*</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Data Diri Penghuni yang tinggal</p>

                        <div class="mt-10 mb-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            {{-- data diri --}}
                            @foreach($dataDiriList as $data) 
                                <div class="sm:col-span-4">
                                    <label for="deskripsi_{{ $data->idListDataDiri }}" class="block text-sm font-medium leading-6 text-gray-900">{{ $data->data_diri }}</label>
                                    <div class="mt-2">
                                        <input type="text" name="deskripsi[]" id="deskripsi_{{ $data->idListDataDiri }}" 
                                            class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <input required type="hidden" name="idListDataDiri[]" value="{{ $data->idListDataDiri }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a href="#" data-toggle="modal" data-target="#ModalTambahDataDiri" class="mt-3 text-sm leading-6 text-gray-600 mr-4">
                            <span aria-hidden="true">+</span> Tambah Data Diri Baru</a>
                        
                    </div>
                @endif

                <!-- Bagian Keterangan -->
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Keterangan</h2>
                    <div class="mt-2">
                        <textarea id="keterangan" name="keterangan" rows="3" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                    </div> 
                    <p class="mt-3 text-sm leading-6 text-gray-600">Bagian ini bersifat optional</p>
                </div>

                {{-- Bagian Submit --}}
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                    <button type="submit" class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                </div>
            </form>

            {{-- MODAL TAMBAH DATA DIRI --}}
            <div class="modal fade p-4" id="ModalTambahDataDiri" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                    <form action="{{ route('datadiri.store') }}" method="POST" class="modal-content rounded-lg shadow-lg bg-white">
                        @csrf
                        {{-- Header modal --}}
                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Tambah Data Diri</h3>
                            <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        {{-- Content modal --}}
                        <div class="modal-body p-6 space-y-2">
                            <div class="flex items-center space-x-4">
                                <label for="tambah-dataDiri" class="w-32 text-md font-medium text-gray-700">Tambah Baru:</label>
                                <input required id="tambah-dataDiri" name="dataDiri" type="text" value=""
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                            </div>
                        </div>
                        {{-- Footer --}}
                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                Tambah
                            </button>                                                               
                            <button type="button" class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600" data-dismiss="modal">
                                Tutup
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- MODAL TAMBAH BIAYA FASILITAS --}}
            <div class="modal fade p-4" id="ModalTambahBiaya" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                    <form action="{{ route('biaya.store') }}" method="POST" class="modal-content rounded-lg shadow-lg bg-white">
                        @csrf
                        {{-- Header modal --}}
                        <div class="modal-header border-b border-gray-200 py-4 px-6">
                            <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Tambah Biaya Fasilitas</h3>
                            <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        {{-- Content modal --}}
                        <div class="modal-body p-6 space-y-2">
                            <div class="flex items-center space-x-4">
                                <label for="tambah-biaya" class="w-32 text-md font-medium text-gray-700">Tambah Baru:</label>
                                <input required id="tambah-biaya" name="biaya" type="text" value=""
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                            </div>
                        </div>
                        {{-- Footer --}}
                        <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                Tambah
                            </button>                                                               
                            <button type="button" class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600" data-dismiss="modal">
                                Tutup
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </section>

        {{-- PAGE LIST PENGHUNI --}}
        <section id="listPenghuni" class="hidden">
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Penyewa</th>
                            <th class="py-3 px-4">No Telp</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse($penghuni as $item) 
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->no_telp }}</td>
                                <td class="py-3 px-4">{{ $item->status }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->id }}" data-toggle="modal" data-target="#ModalPenghuni" class="lihat-detail-penghuni text-indigo-500 hover:text-indigo-700 transition">
                                        Lihat Detail <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada data penghuni untuk kos ini.</td>
                            </tr>
                        @endforelse  
                    </tbody>
                </table>

                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalPenghuni" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            <div class="modal-header border-b border-gray-200 py-4 px-6">
                                <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Detail Penghuni</h3>
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
                                        Kamar:</label>
                                    <input id="modal-kamar" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
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
                                    <label for="status" class="w-32 text-md font-medium text-gray-700">
                                        Status:</label>
                                    <input id="modal-status" type="text" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" readonly>
                                </div>

                                {{-- AJAX DATA DIRI --}}
                                <div id="dataDiri-container"></div>
                                
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

{{-- JS --}}
<script>
    function switchPage(page) {
        const tambahSection = document.getElementById('tambahPenghuni');
        const listSection = document.getElementById('listPenghuni');
        const btnTambah = document.getElementById('btnTambah');
        const btnList = document.getElementById('btnList');

        // Menghilangkan semua section
        tambahSection.classList.add('hidden');
        listSection.classList.add('hidden');

        // Menghilangkan aktifasi dari button
        btnTambah.classList.remove('bg-indigo-600', 'text-white');
        btnTambah.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        btnList.classList.remove('bg-indigo-600', 'text-white');
        btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

        if (page === 'tambahPenghuni') {
            // Tampilkan halaman pesan dan set button aktif
            tambahSection.classList.remove('hidden');
            btnTambah.classList.add('bg-indigo-600', 'text-white');
            btnTambah.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        } else if (page === 'listPenghuni') {
            // Tampilkan halaman pengumuman dan set button aktif
            listSection.classList.remove('hidden');
            btnList.classList.add('bg-indigo-600', 'text-white');
            btnList.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        }

        // Memberikan sedikit delay sebelum scroll
        setTimeout(function() {
            window.scrollTo(0, 0);
        }, 50);
    }

    function getCurrentDate() {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Ambil elemen input
        const masukInput = document.getElementById('masuk');
        const keluarInput = document.getElementById('keluar');
        const tagihanInput = document.getElementById('tagihan');
        const dendaInput = document.getElementById('denda');

        // Set default tanggal masuk
        masukInput.value = getCurrentDate();

        // Update minimal tanggal pada input lainnya berdasarkan tanggal masuk
        const updateMinDates = () => {
            const minDate = masukInput.value;
            keluarInput.min = minDate;
            tagihanInput.min = minDate;
            dendaInput.min = minDate;
        };

        // Set minimal tanggal awal
        updateMinDates();

        // Update minimal tanggal setiap kali tanggal masuk diubah
        masukInput.addEventListener('change', updateMinDates);
    });
</script>
{{-- AJAX TAMBAH PENGHUNI --}}
<script>
    $(document).ready(function(){
        function updateHarga() {
            var harga = $('#kamar option:selected').data('harga') || 0;
            var deposit = $('#deposit').val() || 0;

            var totalPembayaran = parseFloat(harga) + parseFloat(deposit);

            $('#pembayaran').val(totalPembayaran);
        }

        updateHarga();  

        $('#kamar').change(function() {
            updateHarga(); 
        });

        $('#deposit').on('input', function() {
            updateHarga();
        });

        dataKontrak();
    });
</script>
{{-- AJAX PENGHUNI --}}
<script>
    $(document).ready(function(){
        $('.lihat-detail-penghuni').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); 

            // AJAX untuk mengambil data penghuni
            $.ajax({
                url: '/penghuni/' + id,
                type: 'GET',
                success: function(data) {
                    $('#modal-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-nama').val(data.data.nama);
                    $('#modal-telp').val(data.data.no_telp);
                    $('#modal-status').val(data.data.status);

                    // menambahkan data diri kedalaam modal
                    $('#dataDiri-container').empty();
                    
                    $.each(data.dataDiriList, function(index, dataDiri) {
                        $('#dataDiri-container').append(`
                            <div class="mb-2 flex items-center space-x-4">
                            <label for="${dataDiri.data_diri}" class="w-32 text-md font-medium text-gray-700">${dataDiri.data_diri}:</label>
                                <input type="text" id="${dataDiri.data_diri}" name="${dataDiri.data_diri}" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0" 
                                value="${dataDiri.deskripsi}">
                            </div>
                        `);
                    });
                }
            });
        });
    }); 
</script>