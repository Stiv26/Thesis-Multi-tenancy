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
                    <a href="#list" id="btnList" onclick="switchPage('list')"
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">Pembayaran</a>
                    <a href="#pembayaran" id="btnPembayaran" onclick="switchPage('pembayaran')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Riwayat
                        Pembayaran</a>
                </nav>
            </div>
        </section>

        <!-- PAGE PEMBAYARAN -->
        <section id="list" class="block">
            {{-- VERIFIKASI --}}
            @if ($verifikasi->IsNotEmpty())
                <div id="verifikasi-pembayaran">
                    <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr class="text-left text-sm text-gray-600">
                                    <th class="py-3 px-4">Kamar</th>
                                    <th class="py-3 px-4">Penyewa</th>
                                    <th class="py-3 px-4">Nominal</th>
                                    <th class="py-3 px-4">Tanggal Denda</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-2 px-4">Lihat Detail</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-800">
                                @forelse ($verifikasi as $item)
                                    <tr class="border-t hover:bg-gray-50 transition duration-200">
                                        <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                        <td class="py-3 px-4">{{ $item->nama }}</td>
                                        <td class="py-3 px-4">{{ $item->total_bayar }}</td>
                                        <td class="py-3 px-4">{{ $item->dendanya }}</td>
                                        <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                        <td class="py-3 px-4">
                                            <a href="#" data-id="{{ $item->idPembayaran }}" data-toggle="modal"
                                                data-target="#ModalVerifikasi"
                                                class="lihat-detail-verifikasi text-indigo-500 hover:text-indigo-700 transition">
                                                Lihat Detail <span aria-hidden="true">→</span></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada
                                            pembayaran yang sedang diverifikasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- MODAL DATA --}}
                        <div class="modal fade p-4" id="ModalVerifikasi" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                                <div class="modal-content rounded-lg shadow-lg bg-white">
                                    {{-- header --}}
                                    <div class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-start">
                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-800">VERIFIKASI PEMBAYARAN</h3>
                                        </div>
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
                                    <div class="modal-body p-6">
                                        <!-- Informasi Utama -->
                                        <div class="flex flex-col gap-4 mb-6">
                                            <div class="flex justify-between items-center border-b pb-2">
                                                <span class="font-medium text-gray-600">Kamar</span>
                                                <input id="modal-verifikasi-kamar" type="text" 
                                                    class="w-1/2 text-right font-medium text-gray-800 bg-transparent border-none" 
                                                    readonly>
                                            </div>
                                            
                                            <div class="flex justify-between items-center border-b pb-2">
                                                <span class="font-medium text-gray-600">Nama Penyewa</span>
                                                <input id="modal-verifikasi-nama" type="text"
                                                    class="w-1/2 text-right text-gray-700 bg-transparent border-none" 
                                                    readonly>
                                            </div>
                                        </div>
                        
                                        <!-- Detail Status -->
                                        <div class="flex flex-col gap-4 mb-6">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-600">Status</span>
                                                <input id="modal-verifikasi-status" type="text" 
                                                    class="w-1/2 text-right px-2 py-1 bg-gray-100 rounded-md border-none" 
                                                    readonly>
                                            </div>
                                            
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-600">Tanggal Tagihan</span>
                                                <input id="modal-verifikasi-tagihan" type="text" 
                                                    class="w-1/2 text-right text-gray-700 bg-transparent border-none" 
                                                    readonly>
                                            </div>
                                            
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-600">Tanggal Denda</span>
                                                <input id="modal-verifikasi-tempo" type="text" 
                                                    class="w-1/2 text-right text-gray-700 bg-transparent border-none" 
                                                    readonly>
                                            </div>
                                        </div>
                        
                                        <!-- Rentang Waktu -->
                                        <div class="flex justify-between items-center mb-6 px-4 py-2 bg-blue-50 rounded-lg">
                                            <span class="font-medium text-blue-600">Rentang Pembayaran</span>
                                            <input id="modal-verifikasi-rentang" type="text" 
                                                class="text-right font-semibold text-blue-700 bg-transparent border-none" 
                                                readonly>
                                        </div>
                        
                                        <!-- Detail Pembayaran -->
                                        <div class="border rounded-lg p-4 mb-4">
                                            <h4 class="text-lg font-bold mb-4">Rincian Pembayaran</h4>
                                            
                                            <div class="space-y-3">
                                                <div class="flex justify-between" id="harga-verifikasi-kontrak">
                                                    <span class="font-medium">Harga Sewa:</span>
                                                    <input id="modal-verifikasi-harga" type="text"
                                                        class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                </div>
                        
                                                <div class="flex justify-between" id="deposit-verifikasi-kontrak">
                                                    <span class="font-medium">Deposit:</span>
                                                    <input id="modal-verifikasi-deposit" type="text"
                                                        class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                </div>
                        
                                                <div id="biaya-verifikasi-container" class="space-y-3"></div>
                        
                                                <div class="flex justify-between" id="denda-verifikasi-kontrak">
                                                    <span class="font-medium">Denda:</span>
                                                    <input id="modal-verifikasi-denda" type="text"
                                                        class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                </div>
                        
                                                <div class="flex justify-between border-t pt-3">
                                                    <span class="font-bold">Total Pembayaran:</span>
                                                    <input id="modal-verifikasi-total" type="text"
                                                        class="w-1/3 text-right px-2 font-bold bg-transparent" readonly>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <!-- Bukti Pembayaran -->
                                        <div class="mb-6">
                                            <div class="flex flex-col items-center space-y-2">
                                                <span class="font-medium text-gray-600">Bukti Pembayaran</span>
                                                <img src="" id="modal-verifikasi-foto" alt="Bukti Pembayaran"
                                                    class="h-72 object-contain border border-gray-200 rounded-lg p-2">
                                            </div>
                                        </div>
                        
                                        <!-- Detail Tambahan -->
                                        <div class="space-y-4">
                                            <div class="flex justify-between items-center border-b pb-2">
                                                <span class="font-medium text-gray-600">Metode Pembayaran</span>
                                                <input id="modal-verifikasi-metode" type="text"
                                                    class="w-1/2 text-right bg-transparent border-none" readonly>
                                            </div>
                        
                                            <div class="flex justify-between items-center border-b pb-2">
                                                <span class="font-medium text-gray-600">Keterangan</span>
                                                <textarea id="modal-verifikasi-keterangan" rows="2"
                                                    class="w-1/2 text-right bg-transparent border-none resize-none" readonly></textarea>
                                            </div>
                                        </div>
                        
                                        <input id="modal-verifikasi-idPembayaran" type="hidden" name="idPembayaran" value="">
                                    </div>
                        
                                    {{-- footer --}}
                                    <div class="modal-footer border-t border-gray-200 py-4 px-6 flex justify-end">
                                        <button type="button"
                                            class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors"
                                            data-dismiss="modal">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3 mt-5">Click untuk melihat Detail</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Penyewa</th>
                            <th class="py-3 px-4">Nominal</th>
                            <th class="py-3 px-4">Tanggal Denda</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($tagihan as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->total_bayar }}</td>
                                <td class="py-3 px-4">{{ $item->dendanya }}</td>
                                <td class="py-3 px-4">{{ $item->status_pembayaran }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-id="{{ $item->idPembayaran }}" data-toggle="modal"
                                        data-target="#ModalTagihan"
                                        class="lihat-detail-tagihan text-indigo-500 hover:text-indigo-700 transition">
                                        Bayar <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada data
                                    pembayaran yang tersedia untuk periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <main id="modal-bagian-tagihan">
                    {{-- MODAL DATA --}}
                    <div class="modal fade p-4" id="ModalTagihan" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog max-w-4xl mx-auto mt-24">
                            <div class="modal-content rounded-lg shadow-lg bg-white">
                                {{-- header --}}
                                <div class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-start">
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-800">INVOICE TAGIHAN</h3>
                                    </div>
                                    <button type="button" class="text-gray-400 hover:text-gray-600"
                                        data-dismiss="modal" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- content --}}
                                    <div class="modal-body p-6">
                                        <!-- Informasi Utama -->
                                        <div class="flex flex-col gap-4 mb-6">
                                            <div class="flex justify-between items-center border-b pb-2">
                                                <span class="font-medium text-gray-600">Kamar</span>
                                                <input id="modal-kamar" type="text" 
                                                    class="w-1/2 text-right font-medium text-gray-800 bg-transparent border-none" 
                                                    readonly>
                                            </div>
                                            
                                            <div class="flex justify-between items-center border-b pb-2">
                                                <span class="font-medium text-gray-600">Nama Penyewa</span>
                                                <input id="modal-nama" type="text" name="nama"
                                                    class="w-1/2 text-right text-gray-700 bg-transparent border-none" 
                                                    readonly>
                                            </div>
                                        </div>
                    
                                        <!-- Detail Status -->
                                        <div class="flex flex-col gap-4 mb-6">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-600">Status</span>
                                                <input id="modal-status" type="text" 
                                                    class="w-1/2 text-right px-2 py-1 bg-gray-100 rounded-md border-none" 
                                                    readonly>
                                            </div>
                                            
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-600">Tanggal Tagihan</span>
                                                <input id="modal-tagihan" type="text" 
                                                    class="w-1/2 text-right text-gray-700 bg-transparent border-none" 
                                                    readonly>
                                            </div>
                                            
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-600">Tanggal Denda</span>
                                                <input id="modal-tempo" type="text" 
                                                    class="w-1/2 text-right text-gray-700 bg-transparent border-none" 
                                                    readonly>
                                            </div>
                                        </div>
                    
                                        <!-- Rentang Waktu -->
                                        <div class="flex justify-between items-center mb-6 px-4 py-2 bg-blue-50 rounded-lg">
                                            <span class="font-medium text-blue-600">Rentang Pembayaran</span>
                                            <input id="modal-rentang" type="text" 
                                                class="text-right font-semibold text-blue-700 bg-transparent border-none" 
                                                readonly>
                                        </div>
                    
                                        <!-- Detail Pembayaran -->
                                        <div class="border rounded-lg p-4 mb-6">
                                            <h4 class="text-lg font-bold mb-4">Rincian Pembayaran</h4>
                                            
                                            <div class="space-y-3">
                                                <div class="flex justify-between" id="harga-kontrak">
                                                    <span class="font-medium">Harga Sewa:</span>
                                                    <input id="modal-harga" type="text" name="harga"
                                                        class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                </div>
                    
                                                <div class="flex justify-between" id="deposit-kontrak">
                                                    <span class="font-medium">Deposit:</span>
                                                    <input id="modal-deposit" type="text" name="deposit"
                                                        class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                </div>
                    
                                                <div id="biaya-container" class="space-y-3"></div>
                    
                                                <div class="flex justify-between" id="denda-kontrak">
                                                    <span class="font-medium">Denda:</span>
                                                    <input id="modal-denda" type="text" name="denda"
                                                        class="w-1/3 text-right px-2 bg-transparent" readonly>
                                                </div>
                    
                                                <div class="flex justify-between border-t pt-3">
                                                    <span class="font-bold">Total Pembayaran:</span>
                                                    <input id="modal-total" type="text" name="total"
                                                        class="w-1/3 text-right px-2 font-bold bg-transparent" readonly>
                                                </div>
                                            </div>
                                        </div>
                    
                                        <!-- Form Input -->
                                        <div class="space-y-4">
                                            <div class="flex justify-between items-center border-b pb-2">
                                                <span class="font-medium text-gray-600">Metode Pembayaran</span>
                                                <select id="modal-metode" name="metode"
                                                    class="w-1/2 text-right bg-transparent border-none focus:ring-0">
                                                    <!-- Options akan diisi via JS -->
                                                </select>
                                            </div>
                    
                                            <div class="flex justify-between items-center border-b pb-2">
                                                <span class="font-medium text-gray-600">Keterangan</span>
                                                <textarea id="modal-keterangan" rows="2" name="keterangan"
                                                    class="w-1/2 text-right bg-transparent border-none resize-none"></textarea>
                                            </div>
                    
                                            <div class="flex justify-between items-center border-b pb-2">
                                                <span class="font-medium text-gray-600">Bukti Pembayaran</span>
                                                <input required id="modal-buat-bukti" type="file" name="bukti"
                                                    class="w-1/2 text-right file:border file:px-4 file:py-2 file:rounded-md file:text-sm file:font-medium">
                                            </div>
                                        </div>
                    
                                        <input id="modal-idPembayaran" type="hidden" name="idPembayaran" value="">
                                    </div>
                    
                                    {{-- submit --}}
                                    <div class="modal-footer border-t border-gray-200 py-4 px-6 flex justify-end space-x-3">
                                        <button type="submit" data-toggle="modal" data-target="#ModalSuksesBayar"
                                            class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                            Bayar
                                        </button>
                                        <button type="button"
                                            class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors"
                                            data-dismiss="modal">
                                            Tutup
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </section>

        {{-- PAGE RIWAYAT --}}
        <section id="pembayaran" class="hidden">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4">Kamar</th>
                            <th class="py-3 px-4">Penyewa</th>
                            <th class="py-3 px-4">Nominal</th>
                            <th class="py-3 px-4">Tanggal Pembayaran</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-2 px-4">Lihat Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($riwayatTagihan as $item)
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ 'Kamar ' . $item->idKamar }}</td>
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->dibayar }}</td>
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
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
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada riwayat
                                    pembayaran untuk kos ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- MODAL DATA --}}
                <div class="modal fade p-4" id="ModalRiwayat" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog max-w-4xl mx-auto mt-24">
                        <div class="modal-content rounded-lg shadow-lg bg-white">
                            {{-- Header --}}
                            <div class="modal-header border-b border-gray-200 py-4 px-6 flex justify-between items-start">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">DETAIL RIWAYAT TAGIHAN</h3>
                                </div>
                                <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal"
                                    aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                
                            {{-- Content --}}
                            <div class="modal-body p-6">
                                <!-- Informasi Utama -->
                                <div class="flex flex-col gap-4 mb-6">
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Kamar</span>
                                        <input id="modal-riwayat-kamar" type="text"
                                            class="w-1/2 text-right font-medium text-gray-800 bg-transparent border-none" readonly>
                                    </div>
                                    
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Nama Penyewa</span>
                                        <input id="modal-riwayat-nama" type="text"
                                            class="w-1/2 text-right text-gray-700 bg-transparent border-none" readonly>
                                    </div>
                                </div>
                
                                <!-- Detail Waktu -->
                                <div class="flex flex-col gap-4 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-600">Tanggal Tagihan</span>
                                        <input id="modal-riwayat-tgl_tagihan" type="text"
                                            class="w-1/2 text-right bg-transparent border-none" readonly>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-600">Tanggal Denda</span>
                                        <input id="modal-riwayat-tgl_denda" type="text"
                                            class="w-1/2 text-right bg-transparent border-none" readonly>
                                    </div>
                                </div>
                
                                <!-- Rentang Waktu -->
                                <div class="flex justify-between items-center mb-6 px-4 py-2 bg-blue-50 rounded-lg">
                                    <span class="font-medium text-blue-600">Rentang Pembayaran</span>
                                    <input id="modal-riwayat-rentang" type="text"
                                        class="text-right font-semibold text-blue-700 bg-transparent border-none" readonly>
                                </div>
                
                                <!-- Detail Pembayaran -->
                                <div class="border rounded-lg p-4 mb-6">
                                    <h4 class="text-lg font-bold mb-4">Rincian Pembayaran</h4>
                                    
                                    <div class="space-y-3">
                                        <div class="flex justify-between" id="riwayat-harga">
                                            <span class="font-medium">Harga Sewa:</span>
                                            <input id="modal-riwayat-harga" type="text"
                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                        </div>
                
                                        <div class="flex justify-between" id="riwayat-deposit">
                                            <span class="font-medium">Deposit:</span>
                                            <input id="modal-riwayat-deposit" type="text"
                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                        </div>
                
                                        <div id="riwayat-container" class="space-y-3"></div>
                
                                        <div class="flex justify-between" id="riwayat-denda">
                                            <span class="font-medium">Denda:</span>
                                            <input id="modal-riwayat-denda" type="text"
                                                class="w-1/3 text-right px-2 bg-transparent" readonly>
                                        </div>
                
                                        <div class="flex justify-between border-t pt-3">
                                            <span class="font-bold">Total Pembayaran:</span>
                                            <input id="modal-riwayat-total" type="text"
                                                class="w-1/3 text-right px-2 font-bold bg-transparent" readonly>
                                        </div>
                                    </div>
                                </div>
                
                                <!-- Bukti Pembayaran -->
                                <div class="mb-6">
                                    <div class="flex flex-col items-center space-y-2">
                                        <span class="font-medium text-gray-600">Bukti Pembayaran</span>
                                        <img src="" id="modal-riwayat-foto" alt="Bukti Pembayaran"
                                            class="h-72 object-contain border border-gray-200 rounded-lg p-2">
                                    </div>
                                </div>
                
                                <!-- Detail Tambahan -->
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Metode Pembayaran</span>
                                        <input id="modal-riwayat-metode" type="text"
                                            class="w-1/2 text-right bg-transparent border-none" readonly>
                                    </div>
                
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Tanggal Pembayaran</span>
                                        <input id="modal-riwayat-tanggal" type="text"
                                            class="w-1/2 text-right bg-transparent border-none" readonly>
                                    </div>
                
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Status</span>
                                        <input id="modal-riwayat-status" type="text"
                                            class="w-1/2 text-right bg-transparent border-none" readonly>
                                    </div>
                
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="font-medium text-gray-600">Keterangan</span>
                                        <textarea id="modal-riwayat-keterangan" rows="2"
                                            class="w-1/2 text-right bg-transparent border-none resize-none" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                
                            {{-- Footer --}}
                            <div class="modal-footer border-t border-gray-200 py-4 px-6 flex justify-end">
                                <button type="button"
                                    class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors"
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
        const listSection = document.getElementById('list');
        const pembayaranSection = document.getElementById('pembayaran');
        const btnList = document.getElementById('btnList');
        const btnPembayaran = document.getElementById('btnPembayaran');

        // Menghilangkan semua section
        listSection.classList.add('hidden');
        pembayaranSection.classList.add('hidden');

        // Menghilangkan aktifasi dari button
        btnList.classList.remove('bg-indigo-600', 'text-white');
        btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        btnPembayaran.classList.remove('bg-indigo-600', 'text-white');
        btnPembayaran.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

        if (page === 'list') {
            // Tampilkan halaman Fasilitas dan set button aktif
            listSection.classList.remove('hidden');
            btnList.classList.add('bg-indigo-600', 'text-white');
            btnList.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        } else if (page === 'pembayaran') {
            // Tampilkan halaman Kamar dan set button aktif
            pembayaranSection.classList.remove('hidden');
            btnPembayaran.classList.add('bg-indigo-600', 'text-white');
            btnPembayaran.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300',
                'hover:bg-gray-50');
        }

        // Memberikan sedikit delay sebelum scroll
        setTimeout(function() {
            window.scrollTo(0, 0);
        }, 50);
    }
</script>

{{-- AJAX DETAIL + BIAYA --}}
<script>
    $(document).ready(function() {
        $('.lihat-detail-tagihan').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/detailTagihan/' + id,
                type: 'GET',
                success: function(data) {
                    function formatRupiah(angka) {
                        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }

                    $('#modal-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-nama').val(data.data.nama);
                    $('#modal-total').val(data.data.total_bayar);
                    $('#modal-tempo').val(data.data.denda);
                    $('#modal-tagihan').val(data.data.tagihan);
                    $('#modal-status').val(data.data.status_pembayaran);
                    $('#modal-rentang').val(data.data.waktu + " " + data.data.rentang);
                    $('#modal-harga').val(formatRupiah(data.data.harga * data.data.waktu));
                    $('#modal-keterangan').val(data.data.keterangan_pembayaran);
                    $('#modal-idPembayaran').val(data.data.idPembayaran);

                    // menambahkan biaya lainnya kedalaam modal
                    $('#biaya-container').empty();
                    $.each(data.biayaList, function(index, biaya) {
                        $('#biaya-container').append(`
                            <div class="flex justify-between mb-2">
                                <span class="w-32 text-md font-medium text-gray-700">${biaya.biaya}:</span>
                                <input type="text" id="${biaya.biaya}" name="${biaya.biaya}" 
                                    class="w-1/3 px-2 text-right bg-transparent"
                                    value="${ formatRupiah(biaya.harga) }" readonly>
                            </div>
                        `);
                    });

                    $('#modal-metode').empty();
                    $.each(data.metode, function(index, metode) {
                        $('#modal-metode').append(
                            `<option value="${metode.idMetodePembayaran}">${metode.metode} - ${metode.nomor_tujuan}</option>`
                        );
                    });

                    // DEPOSIT KONTRAK
                    if (data.data.status_kontrak === 'Pembayaran Perdana' && data.data.deposit !== null) {
                        $('#deposit-kontrak').show();
                        $('#modal-deposit').val(formatRupiah(data.data.deposit));
                    } else {
                        $('#deposit-kontrak').hide();
                    }

                    // REVISI
                    if (data.data.status_pembayaran === 'Revisi') {
                        $('#deposit-kontrak').addClass('hidden');
                        $('#denda-kontrak').addClass('hidden');
                        // $('#harga-kontrak').addClass('hidden');
                        $('#modal-harga').val(formatRupiah(data.data.total_bayar));
                    } else {
                        // $('#harga-kontrak').removeClass('hidden');
                        $('#deposit-kontrak').removeClass('hidden');
                        $('#modal-deposit').val(data.data.deposit);
                    }

                    // Logika untuk denda
                    const today = new Date();
                    const dendaDate = new Date(data.data.denda);

                    if (today >= dendaDate && data.denda) {
                        $('#denda-kontrak').removeClass('hidden');

                        const jenisDenda = data.denda.jenis_denda;
                        const totalBayar = parseFloat(data.data.total_bayar);
                        const angka = parseFloat(data.denda.angka);
                        const angkaMingguan = parseFloat(data.denda.angka_mingguan);
                        const angkaHarian = parseFloat(data.denda.angka_harian);
                        const rentang = data.data.rentang;
                        const nilaiDenda = rentang === 'Bulan' ? angka : rentang ===
                            'Mingguan' ? angkaMingguan : angkaHarian;

                        let denda = 0;

                        if (data.data.status_kontrak === 'Pembayaran Perdana') {
                            if (data.data.deposit !== null) {
                                const deposit = parseFloat(data.data.deposit);

                                if (jenisDenda === 'Nominal') {
                                    denda = nilaiDenda;
                                } else if (jenisDenda === 'Persen') {
                                    denda = (totalBayar  * nilaiDenda) / 100;
                                } else {
                                    const hari = Math.abs(today - dendaDate);
                                    const formatHari = Math.ceil(hari / (1000 * 60 * 60 *
                                        24));

                                    denda = formatHari * nilaiDenda;
                                }
                            } else {
                                $('#deposit-kontrak').addClass('hidden');

                                if (jenisDenda === 'Nominal') {
                                    denda = nilaiDenda;
                                } else if (jenisDenda === 'Persen') {
                                    denda = (totalBayar * nilaiDenda) / 100;
                                } else {
                                    const hari = Math.abs(today - dendaDate);
                                    const formatHari = Math.ceil(hari / (1000 * 60 * 60 *
                                        24));

                                    denda = formatHari * nilaiDenda;
                                }
                            }
                        } else {
                            $('#deposit-kontrak').addClass('hidden');

                            if (jenisDenda === 'Nominal') {
                                denda = nilaiDenda;
                            } else if (jenisDenda === 'Persen') {
                                denda = (totalBayar * nilaiDenda) / 100;
                            } else {
                                const hari = Math.abs(today - dendaDate);
                                const formatHari = Math.ceil(hari / (1000 * 60 * 60 * 24));

                                denda = formatHari * nilaiDenda;
                            }
                        }

                        // Atur nilai denda
                        $('#modal-denda').val(denda);
                        $('#modal-total').val(totalBayar + denda);
                    } else {
                        $('#denda-kontrak').addClass('hidden');
                        $('#modal-denda').val('');
                        $('#modal-total').val(data.data.total_bayar);
                    }

                  

                    // mengirim id ke editpembayaran yang sesuai
                    $('#edit-pembayaran-btn').attr('href', '/list/edit-pembayaran/' + id);
                }
            });
        });

        $('.lihat-detail-verifikasi').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: '/detailMenungguVerifikasi/' + id,
                type: 'GET',
                success: function(data) {
                    function formatRupiah(angka) {
                        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }

                    $('#modal-verifikasi-kamar').val('Kamar ' + data.data.idKamar);
                    $('#modal-verifikasi-nama').val(data.data.nama);
                    $('#modal-verifikasi-total').val(formatRupiah(data.data.dibayar));
                    $('#modal-verifikasi-tempo').val(data.data.denda);
                    $('#modal-verifikasi-tagihan').val(data.data.tagihan);
                    $('#modal-verifikasi-status').val(data.data.status_pembayaran);
                    $('#modal-verifikasi-rentang').val(data.data.waktu + " " + data.data.rentang);
                    $('#modal-verifikasi-metode').val(data.data.metode + " - " + data.data.nomor_tujuan);
                    $('#modal-verifikasi-keterangan').val(data.data.keterangan_pembayaran);
                    $('#modal-verifikasi-idPembayaran').val(data.data.idPembayaran);
                    $('#modal-verifikasi-foto').attr('src', data.gambar_url)

                    // menambahkan biaya lainnya kedalaam modal
                    $('#biaya-verifikasi-container').empty();
                    $.each(data.biayaList, function(index, biaya) {
                        $('#biaya-verifikasi-container').append(`
                            <div class="flex justify-between mb-2" id="harga-verifikasi-kontrak">
                                <span class="font-medium">${biaya.biaya}:</span>
                                <input type="text" id="${biaya.biaya}" name="${biaya.biaya}" 
                                    class="w-1/3 text-right px-2 bg-transparent"
                                    value="${ formatRupiah(biaya.harga) }" readonly>
                            </div>
                        `);
                    });

                    // DISPLAY REVISI
                    if (data.data.status_kontrak === 'Revisi') {
                        $('#harga-verifikasi-kontrak').addClass('hidden');
                    } else {
                        $('#harga-verifikasi-kontrak').removeClass('hidden');
                        $('#modal-verifikasi-harga').val(formatRupiah(data.data.harga * data.data.waktu));
                    }

                    // DEPOSIT KONTRAK
                    if (data.data.deposit === null || data.data.status_kontrak ===
                        'Revisi' || data.data.status_kontrak === 'Aktif') {
                        $('#deposit-verifikasi-kontrak').addClass('hidden');
                    } else {
                        $('#deposit-verifikasi-kontrak').removeClass('hidden');
                        $('#modal-verifikasi-deposit').val(formatRupiah(data.data.deposit));
                    }

                    // DENDA KONTRAK
                    if (data.denda === null) {
                        $('#denda-verifikasi-kontrak').addClass('hidden');
                    } else {
                        $('#denda-verifikasi-kontrak').removeClass('hidden');
                        $('#modal-verifikasi-denda').val(formatRupiah(data.denda.nominal_denda));
                    }

                    // revisi
                    if (data.data.status_kontrak_pembayarannya === 'Revisi') {
                        $('#riwayat-harga').addClass('hidden');
                    } else {
                        $('#riwayat-harga').removeClass('hidden');
                        $('#modal-riwayat-harga').val(formatRupiah(data.data.harga));
                    }
                }
            });
        });
    });
</script>

{{-- RIWAYAT --}}
<script>
    $('.lihat-detail-riwayat').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            url: '/detailRiwayatTagihan/' + id,
            type: 'GET',
            success: function(data) {
                function formatRupiah(angka) {
                    return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }

                $('#modal-riwayat-kamar').val('Kamar ' + data.data.idKamar);
                $('#modal-riwayat-nama').val(data.data.nama);
                $('#modal-riwayat-tgl_tagihan').val(data.data.tgl_tagihan);
                $('#modal-riwayat-tgl_denda').val(data.data.tgl_denda);
                $('#modal-riwayat-rentang').val(data.data.waktu + " " + data.data.rentang);
                $('#modal-riwayat-total').val(formatRupiah(data.data.dibayar));
                $('#modal-riwayat-metode').val(data.data.metode + " - " + data.data.nomor_tujuan);
                $('#modal-riwayat-tanggal').val(data.data.tanggal);
                $('#modal-riwayat-status').val(data.data.status_pembayaran);
                $('#modal-riwayat-keterangan').val(data.data.keterangan_pembayaran);
                $('#modal-riwayat-foto').attr('src', data.gambar_url)

                // menambahkan biaya lainnya kedalaam modal
                $('#riwayat-container').empty();

                $.each(data.biayaList, function(index, biaya) {
                    $('#riwayat-container').append(`
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">${biaya.biaya}:</span>
                            <input type="text" 
                                id="${biaya.biaya}" 
                                name="${biaya.biaya}" 
                                class="w-1/3 text-right px-2 bg-transparent"
                                value="${formatRupiah(biaya.harga)}" 
                                readonly>
                        </div>
                    `);
                });
                

                if (!data.denda || data.denda.nominal_denda === null) {
                    $('#riwayat-denda').addClass('hidden');
                } else {
                    $('#riwayat-denda').removeClass('hidden');
                    $('#modal-riwayat-denda').val(formatRupiah(data.denda.nominal_denda));
                }

                if (data.data.status_kontrak_pembayarannya === 'Pembayaran Perdana')
                {
                    $('#riwayat-deposit').removeClass('hidden');
                    $('#modal-riwayat-deposit').val(formatRupiah(data.data.deposit));
                } else {
                    $('#riwayat-deposit').addClass('hidden');
                }
            }
        });
    });
</script>
