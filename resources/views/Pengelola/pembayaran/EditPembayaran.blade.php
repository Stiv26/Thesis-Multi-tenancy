<x-layout>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        <a href="{{ url('/pembayaran') }}"><button type="button" class=" rounded-md bg-indigo-500 px-8 py-1.5 text-white font-semibold hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
            ← Kembali
        </button></a>

        <form action="{{ route('pembayaran.updatePembayaran', $data->idPembayaran) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mt-3 flex border-b border-gray-200">
                <div class="px-6 py-4 w-1/2">
                    <ul class="text-sm text-gray-600">
                        <li class="mb-4">
                            <label for="kamar" class="block font-medium mb-2">Kamar:</label>
                            <input type="text" id="kamar" name="kamar" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="Kamar {{ $data->idKamar }}" disabled>
                        </li>
                        <li class="mb-4">
                            <label for="penghuni" class="block font-medium mb-2">Nama Penyewa:</label>
                            <input type="text" id="penghuni" name="penghuni" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->nama }}" disabled>
                        </li>
                        <li class="mb-4">
                            <label for="status" class="block font-medium mb-2">Status:</label>
                            <select id="status" name="status" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="Belum Lunas" @selected($data->status == 'Belum Lunas')>Belum Lunas</option>
                                <option value="Lunas" @selected($data->status == 'Lunas')>Lunas</option>
                            </select>                            
                        </li>
                        <li class="mb-4">
                            <label for="keterangan" class="block font-medium mb-2">Keterangan:</label>
                            <textarea id="keterangan" name="keterangan" rows="3" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                >{{ $data->keterangan }}</textarea>
                        </li>
                    </ul>
                </div>
                <div class="px-6 py-4 w-1/2"> 
                    <ul class="text-sm text-gray-600">
                        <li class="mb-4">
                            <label for="tagihan" class="block font-medium mb-2">Tanggal Tagihan:</label>
                            <input type="date" id="tagihan" name="tagihan" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->tagihanPembayaran }}">
                        </li>

                        <li class="mb-4">
                            <label for="denda" class="block font-medium mb-2">Tanggal Denda:</label>
                            <input type="date" id="denda" name="denda" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->dendaPembayaran }}">
                        </li>

                        @foreach ($biayaList as $biaya)
                            <li class="mb-4">
                                <label for="{{ $biaya->idBiaya }}" class="block font-medium mb-2">{{ $biaya->biaya }}</label>
                                <input type="hidden" name="biaya[{{ $biaya->idBiaya }}][idpembayaran]" value="{{ $data->idPembayaran }}">
                                <input type="hidden" name="biaya[{{ $biaya->idBiaya }}][idbiaya]" value="{{ $biaya->idBiaya }}">
                                <input type="number" name="biaya[{{ $biaya->idBiaya }}][harga]" id="{{ $biaya->idBiaya }}" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                    value="{{ $biaya->harga }}">
                            </li>
                        @endforeach

                        <li class="mb-4">
                            <label for="total" class="block font-bold mb-2">
                                Total Pembayaran:</label>
                            <input type="text" id="total" name="total" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->total_bayar }}">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex justify-end mt-4 gap-x-4">
                    <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                    <button type="submit" class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Simpan</button>
            </div>
        </form>        
    </main>
</x-layout>

