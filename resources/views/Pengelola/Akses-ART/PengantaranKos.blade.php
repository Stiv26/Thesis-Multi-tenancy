<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>

        <!-- PAGE LAYANAN TAMBAHAN -->
        <section id="list" class="block">
            {{-- LIST LAYANAN --}}
            <section>
                <p class="text-sm text-gray-500 mb-3 px-3">Click untuk melihat Detail</p>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full table-auto">
                        <thead class=" bg-gray-100">
                            <tr class="text-sm text-gray-600">
                                <th class="py-3 px-4">Kamar</th>
                                <th class="py-3 px-4">Nama item</th>
                                <th class="py-3 px-4">Jumlah</th>
                                <th class="py-3 px-4">Tanggal Pengantaran</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Pesan</th>
                                <th class="text-right py-2 px-4">Lakukan Pengantaran</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse ($pesanan as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4">Kamar {{ $item->idKamar }}</td>
                                    <td class="py-3 px-4">{{ $item->nama_item }}</td>
                                    <td class="py-3 px-4">{{ $item->jumlah }}</td>
                                    <td class="py-3 px-4">{{ $item->tgl_terima }}</td>
                                    <td class="py-3 px-4">{{ $item->status_pengantaran }}</td>
                                    <td class="py-3 px-4">{{ $item->pesan }}</td>
                                    <td class="text-right py-3 px-4">
                                        <form action="{{ route('pengantaran.updateStatus', $item->idTransaksi) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" data-toggle="modal" data-target="#ModalSuksesSudahDiantar"
                                                class="text-indigo-500 hover:text-indigo-700 transition">
                                                Sudah diantar <span aria-hidden="true">→</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-3 px-4 text-center text-gray-500">Belum ada layanan tambahan untuk kos ini.</td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>

                    <!-- Modal pesanan sukses diantar -->
                    <div class="modal fade p-4" id="ModalSuksesSudahDiantar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                    <h3 class="text-lg font-semibold text-gray-900">Pesanan Berhasil Diantar</h3>
                                    <p class="text-sm text-gray-500">Pesanan sudah berhasil diantar dan tersimpan oleh sistem.</p>
                                    <div class="mt-4">
                                        <button type="button" data-dismiss="modal" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>  
        </section>
    </main>
</x-layout>
