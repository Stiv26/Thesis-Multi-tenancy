<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>

            @php
                $tabelDenda = Schema::hasTable('denda');
            @endphp

            @if ($pengumuman->isNotEmpty())
                <section class="bg-white p-3 rounded-xl shadow-lg w-full mt-5">
                    <h2 class="text-center text-xl font-semibold text-gray-800 mb-8">Pengumuman</h2>
                    <table class="min-w-full table-auto">
                        <tbody class="text-md text-gray-800">
                            @foreach ($pengumuman as $item)
                                <tr class="border-t hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-5 w-[80%]">{{ $item->pesan }}</td>
                                    <td class="py-3 px-4 text-right">{{ $item->tanggal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            @endif

            <section class="flex items-center justify-center mt-5">
                <div class="bg-white p-10 rounded-xl shadow-lg max-w-4xl w-full">
                    <h2 class="text-center text-2xl font-semibold text-gray-800 mb-8">Detail Kontrak Penghuni</h2>
                    <div class="flex items-center gap-6 px-3">
                        <div class="mr-3">
                            <h3 class="text-lg font-semibold text-gray-900 pl-1">Kamar</h3>
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 w-16 h-16 flex items-center justify-center rounded-full text-white text-xl font-bold shadow-lg">
                                {{ $kontrakPenghuni->idKamar }}
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Harga: <span class="text-indigo-600">{{ $kontrakPenghuni->harga }}</span></h3>
                            <p class="text-md font-medium text-gray-600">Durasi: <span class="text-gray-800">{{ $kontrakPenghuni->rentang }}</span></p>
                            <p class="text-md font-medium text-gray-600">Tanggal Masuk: <span class="text-gray-800">{{ $kontrakPenghuni->tgl_masuk }}</span></p>
                            <p class="text-md font-medium text-gray-600">Tanggal Tagihan: <span class="text-gray-800">{{ $kontrakPenghuni->tgl_tagihan }}</span></p>
                            @if ($tabelDenda)
                                <p class="text-md font-medium text-gray-600">Tanggal Denda: <span class="text-gray-800">{{ $kontrakPenghuni->tgl_denda }}</span></p>
                            @endif
                            <p class="text-md font-medium text-gray-600">Deposit: <span class="text-gray-800">{{ $kontrakPenghuni->deposit }}</span></p>
                            <p class="text-md font-medium text-gray-600">Keterangan: <span class="text-gray-800">{{ $kontrakPenghuni->keterangan }}</span></p>
                        </div>
                    </div>
                </div>
            </section>

            @if ($peraturanPenghuni->isNotEmpty())
                <section class="flex items-center justify-center">
                    <div class="bg-white p-3 rounded-xl shadow-lg max-w-4xl w-full mt-5">
                        <h2 class="text-center text-xl font-semibold text-gray-800 mb-8">SOP Kos {{ tenancy()->tenant->id }}</h2>
                        <ol class="list-decimal pl-5">
                            @foreach ($peraturanPenghuni as $item)
                                <li class="text-lg py-1 px-3">{{ $item->aturan }}</li>
                            @endforeach
                        </ol>
                    </div>
                </section>
            @endif
          
    </main>
</x-layout>
