<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>
        {{-- TOP CONTENT --}}
        <section class="flex justify-between items-center mb-6">
            <div class="flex items-center justify-between px-3 py-3 rounded-lg">
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#pelaporan" id="btnPelaporan" onclick="switchPage('pelaporan')"
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">Pelaporan</a>
                    <a href="#riwayat" id="btnRiwayat" onclick="switchPage('riwayat')"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Riwayat
                        Pelaporan</a>
                </nav>
            </div>
        </section>

        {{-- PAGE PELAPORAN --}}
        <section x-data="{ showWarningModal: false }" id="pelaporan" class="block">
            <p class="text-sm text-gray-500 mb-3 px-3">Click lihat detail untuk melihat status pemeliharaan</p>
            <div x-data="{ showModal: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4 w-[20%]">Pengirim</th>
                            <th class="py-3 px-4 w-[15%]">Tanggal</th>
                            <th class="py-3 px-4">Pesan</th>
                            <th class="py-2 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($pelaporan as $item) 
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">{{ $item->pesan }}</td>
                                <td class="py-3 px-4">{{ $item->status_pelaporan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada pelaporan dari anda.</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>
            </div>

            {{-- TAMBAH DATA --}}
            <section class="mt-10">
                <form id="pelaporanForm" method="POST" action="{{ route('pelaporan.store') }}" class="mt-10">
                    @csrf
                    <!-- Bagian Keterangan -->
                    <div class="border-b border-gray-900/10 pb-10">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Tuliskan Laporan Anda</h2>
    
                        <div class="mt-2">
                            <textarea id="pesan" name="pesan" rows="5"
                                class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Bagian ini akan tersampaikan kepada pengelola kos</p>
                    </div>
    
                    {{-- Bagian Submit --}}
                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                        <!-- Button to Open Modal -->
                        <button type="button" data-toggle="modal" data-target="#ModalConfirm" class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            Kirim
                        </button>                
                    </div>

                    <input type="hidden" name="whoIsTheOwner" value="{{ $whoIsTheOwner->email }}">
                    <input type="hidden" name="whatName" value="{{ $whoIsTheOwner->nama }}">

                    <main id="modal-bagian-konfirmasi-pelaporan">
                        <!-- Modal Konfirmasi -->
                        <div class="modal fade p-4" id="ModalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Konfirmasi Pelaporan</h3>
                                                <p class="mt-2 text-sm text-gray-500">Apakah anda yakin ingin mengirimkan pesan pelaporan ini?</p>
                                            </div>
                                        </div>
                
                                        <!-- Footer: Tombol Aksi -->
                                        <div class="mt-6 flex justify-end space-x-4">
                                            <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Batal</button>
                                            <button type="submit" data-toggle="modal" data-target="#ModalSuksesBuatPelaporan" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </form>
            </section>
        </section>

        {{-- PAGE RIWAYAT --}}
        <section id="riwayat" class="hidden">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4 w-[20%]">Pengirim</th>
                            <th class="py-3 px-4 w-[15%]">Tanggal</th>
                            <th class="py-3 px-4">Pesan</th>
                            <th class="py-2 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($riwayatPelaporan as $item) 
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">{{ $item->pesan }}</td>
                                <td class="py-3 px-4">{{ $item->terbaca }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada pesan dari penghuni.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</x-layout>

{{-- JS --}}
<script>
    function switchPage(page) {
        const pelaporanSection = document.getElementById('pelaporan');
        const riwayatSection = document.getElementById('riwayat');
        const btnPelaporan = document.getElementById('btnPelaporan');
        const btnRiwayat = document.getElementById('btnRiwayat');

        // Menghilangkan semua section
        pelaporanSection.classList.add('hidden');
        riwayatSection.classList.add('hidden');

        // Menghilangkan aktifasi dari button
        btnPelaporan.classList.remove('bg-indigo-600', 'text-white');
        btnPelaporan.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        btnRiwayat.classList.remove('bg-indigo-600', 'text-white');
        btnRiwayat.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

        if (page === 'pelaporan') {
            // Tampilkan halaman list dan set button aktif
            pelaporanSection.classList.remove('hidden');
            btnPelaporan.classList.add('bg-indigo-600', 'text-white');
            btnPelaporan.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        } else if (page === 'riwayat') {
            // Tampilkan halaman pengumuman dan set button aktif
            riwayatSection.classList.remove('hidden');
            btnRiwayat.classList.add('bg-indigo-600', 'text-white');
            btnRiwayat.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300',
                'hover:bg-gray-50');
        }

        // Memberikan sedikit delay sebelum scroll
        setTimeout(function() {
            window.scrollTo(0, 0);
        }, 50);
    }
</script>
