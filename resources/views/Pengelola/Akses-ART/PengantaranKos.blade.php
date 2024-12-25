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
                                            <button type="submit" class="text-indigo-500 hover:text-indigo-700 transition">
                                                Sudah diantar <span aria-hidden="true">→</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 px-4 text-center text-gray-500">Belum ada layanan tambahan untuk kos ini.</td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>
                </div>
            </section>  
        </section>
    </main>
</x-layout>
