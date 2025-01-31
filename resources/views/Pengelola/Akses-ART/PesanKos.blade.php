<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>
        
        {{-- TOP CONTENT --}}
        <section class="flex justify-between items-center mb-6">
            <div class="flex items-center justify-between px-3 py-3 rounded-lg">
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#list" id="btnList" onclick="switchPage('list')" 
                        class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20">Pesan</a>
                    <a href="#pengumuman" id="btnPengumuman" onclick="switchPage('pengumuman')" 
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 md:inline-flex">Buat Pengumuman</a>
                </nav>
            </div> 
        </section>

        {{-- PAGE PESAN --}}
        <section id="list" class="block">
            {{-- LIST --}}
            <p class="text-sm text-gray-500 mb-3 px-3">Click tandai sudah terbaca untuk menghapus pesan</p>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-3 px-4 w-[20%]">Pengirim</th>
                            <th class="py-3 px-4 w-[15%]">Tanggal</th>
                            <th class="py-3 px-4">Pesan</th>
                            <th class="py-2 px-4">Edit Pesan</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @forelse ($pesan as $item) 
                            <tr class="border-t hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4">{{ $item->nama }}</td>
                                <td class="py-3 px-4">{{ $item->tanggal }}</td>
                                <td class="py-3 px-4">{{ $item->pesan }}</td>
                                <td class="py-3 px-4">
                                    <a href="#" data-toggle="modal" data-target="#ModalSuksesTebaca" data-id="{{ $item->idNotifikasi }}" class="lihat-detail-pesan text-indigo-500 hover:text-indigo-700 transition">
                                        Tandai Sudah Terbaca <span aria-hidden="true">→</span></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada pesan dari penghuni.</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>
            </div>

            <!-- Modal sukses terbaca -->
            <div class="modal fade p-4" id="ModalSuksesTebaca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog max-w-4xl mx-auto mt-24">
                    <div class="modal-content rounded-lg shadow-lg bg-white">
                        <div class="modal-body p-6 space-y-4 text-center">
                            <!-- Icon Success -->
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 mx-auto">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 14.25l-3.375-3.375M10.125 14.25l6.75-6.75M10.125 14.25l6.75-6.75m0 0L7.5 16.875m0 0L3.75 13.125" />
                                </svg>
                            </div>
                            <!-- Pesan -->
                            <h3 class="text-lg font-semibold text-gray-900">Pesan Pelaporan Terbaca</h3>
                            <p class="text-sm text-gray-500">Pesan pelaporan penghuni sudah dibaca, silahkan menindak lanjuti pelaporan.</p>
                            <div class="mt-4">
                                <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- PAGE PENGUMUMAN --}}
        <section id="pengumuman" class="hidden">
            <!-- Form pengumuman -->
            <form id="pengumumanForm" method="POST" action="{{ route('pesan.store') }}">
                @csrf
                <!-- Bagian Keterangan -->
                <div class="border-b border-gray-900/10 pb-10">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Tuliskan Berita Anda</h2>
                    <div class="mt-2">
                        <textarea id="pesan" name="pesan" rows="4" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required></textarea>
                    </div> 
                    <p class="mt-3 text-sm leading-6 text-gray-600">Bagian ini akan tersampaikan kepada seluruh penghuni kos</p>
                </div>

                {{-- Bagian Submit --}}
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                    <!-- Button to Open Modal -->
                    <button type="button" data-toggle="modal" data-target="#ModalConfirm" class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        Kirim
                    </button>                
                </div>

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
                                        <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Konfirmasi Pengumuman</h3>
                                        <p class="mt-2 text-sm text-gray-500">Masukan tanggal expired pengumuman?</p>
                                        <input name="tgl_expired" id="tgl_expired" type="date" value="" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                                    
                                        {{-- Nonaktifkan tanggal --}}
                                        <script>
                                            document.addEventListener('DOMContentLoaded', () => {
                                                const tglExpiredInput = document.getElementById('tgl_expired');
                                        
                                                // Ambil tanggal hari ini
                                                const today = new Date();
                                        
                                                // Tambahkan 1 hari untuk mendapatkan besok
                                                const tomorrow = new Date(today);
                                                tomorrow.setDate(today.getDate() + 2);
                                        
                                                // Format tanggal ke format YYYY-MM-DD
                                                const minDate = tomorrow.toISOString().split('T')[0];
                                        
                                                // Tetapkan atribut min pada input
                                                tglExpiredInput.setAttribute('min', minDate);
                                            });
                                        </script>
                                    </div>
                                </div>

                                <!-- Footer: Tombol Aksi -->
                                <div class="mt-6 flex justify-end space-x-4">
                                    <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Batal</button>
                                    <button type="button" onclick="document.getElementById('pengumumanForm').submit();" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">Kirim</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

    </main>
</x-layout>

{{-- JS --}}
<script>
    function switchPage(page) {
        const listSection = document.getElementById('list');
        const pengumumanSection = document.getElementById('pengumuman');
        const btnList = document.getElementById('btnList');
        const btnPengumuman = document.getElementById('btnPengumuman');

        // Menghilangkan semua section
        listSection.classList.add('hidden');
        pengumumanSection.classList.add('hidden');

        // Menghilangkan aktifasi dari button
        btnList.classList.remove('bg-indigo-600', 'text-white');
        btnList.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        btnPengumuman.classList.remove('bg-indigo-600', 'text-white');
        btnPengumuman.classList.add('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');

        if (page === 'list') {
            // Tampilkan halaman list dan set button aktif
            listSection.classList.remove('hidden');
            btnList.classList.add('bg-indigo-600', 'text-white');
            btnList.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        } else if (page === 'pengumuman') {
            // Tampilkan halaman pengumuman dan set button aktif
            pengumumanSection.classList.remove('hidden');
            btnPengumuman.classList.add('bg-indigo-600', 'text-white');
            btnPengumuman.classList.remove('text-gray-900', 'ring-1', 'ring-inset', 'ring-gray-300', 'hover:bg-gray-50');
        }

        // Memberikan sedikit delay sebelum scroll
        setTimeout(function() {
            window.scrollTo(0, 0);
        }, 50);
    }
</script>
{{-- UPDATE PESAN --}}
<script>
    $(document).on('click', '.lihat-detail-pesan', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            url: '/akses/pesan/tandai-terbaca/' + id,
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