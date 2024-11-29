<x-layout>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        <a href="{{ url('/kos') }}"><button type="button" class=" rounded-md bg-indigo-500 px-8 py-1.5 text-white font-semibold hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
            ← Kembali
        </button></a>

        <form action="{{ route('kos.updateKontrak', $data->idKontrak) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mt-3 flex border-b border-gray-200">
                <div class="px-6 py-4 w-1/2">
                    <ul class="text-sm text-gray-600">
                        <li class="mb-4">
                            <label for="nama" class="block font-medium mb-2">Nama Penyewa:</label>
                            <select id="nama" name="nama" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                @foreach ($penghuniList as $users)
                                    <option value="{{ $users }}" @selected($data->nama == $users)>{{ $users }}</option>
                                @endforeach
                            </select> 
                        </li>
                        <li class="mb-4">
                            <label for="kamar" class="block font-medium mb-2">Kamar:</label>
                            <select id="kamar" name="kamar" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                @foreach ($kamarList as $kamarId)
                                    <option value="{{ $kamarId }}" @selected($data->idKamar == $kamarId)>Kamar {{ $kamarId }}</option>
                                @endforeach
                            </select>                            
                        </li>
                        <li class="mb-4">
                            <label for="harga" class="block font-medium mb-2">Harga Kamar:</label>
                            <input type="number" id="harga" name="harga" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->harga }}">
                        </li>
                        <li class="mb-4">
                            <label for="rentang" class="block font-medium mb-2">Rentang:</label>
                            <select id="rentang" name="rentang" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="bulan" @selected($data->rentang == 'Bulan')>Bulan</option>
                                <option value="mingguan" @selected($data->rentang == 'Mingguan')>Mingguan</option>
                                <option value="harian" @selected($data->rentang == 'Harian')>Harian</option>
                            </select>                            
                        </li>
                        <li class="mb-4">
                            <label for="waktu" class="block font-medium mb-2">Waktu (Bulan/Minggu/Hari):</label>
                            <input type="number" id="waktu" name="waktu" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->waktu }}">
                        </li>
                        <li class="mb-4">
                            <label for="keterangan" class="block font-medium mb-2">Keterangan:</label>
                            <textarea id="keterangan" name="keterangan" rows="3" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ $data->keterangan }}</textarea>
                        </li>
                    </ul>
                </div>
                <div class="px-6 py-4 w-1/2">
                    <ul class="text-sm text-gray-600">
                        <li class="mb-4">
                            <label for="tgl_masuk" class="block font-medium mb-2">Tanggal Masuk:</label>
                            <input type="date" id="tgl_masuk" name="tgl_masuk" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->tgl_masuk }}">
                        </li>
                        <li class="mb-4">
                            <label for="tgl_tagihan" class="block font-medium mb-2">Tanggal Tagihan:</label>
                            <input type="date" id="tgl_tagihan" name="tgl_tagihan" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->tgl_tagihan }}">
                        </li>
                        <li class="mb-4">
                            <label for="tgl_denda" class="block font-medium mb-2">Tanggal Denda:</label>
                            <input type="date" id="tgl_denda" name="tgl_denda" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->tgl_denda }}">
                        </li>
                        <li class="mb-4">
                            <label for="tgl_keluar" class="block font-medium mb-2">Tanggal Keluar:</label>
                            <input type="date" id="tgl_keluar" name="tgl_keluar" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->tgl_keluar }}">
                        </li>
                        <li class="mb-4">
                            <label for="deposit" class="block font-medium mb-2">Deposit:</label>
                            <input type="number" id="deposit" name="deposit" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->deposit }}">
                        </li>
                        <li class="mb-4">
                            <label for="biaya_kontrak" class="block font-medium mb-2">Biaya Kontrak:</label>
                            <div class="flex flex-wrap gap-x-2">
                                @foreach ($biayaList as $biaya)
                                    <div class="w-1/8 mb-2"> 
                                        <input type="hidden" name="biaya[{{ $biaya->idBiaya }}][idKontrak]" value="{{ $data->idKontrak }}">
                                        <input type="hidden" name="biaya[{{ $biaya->idBiaya }}][idbiaya]" value="{{ $biaya->idBiaya }}">
                                        
                                        <input 
                                            id="{{ $biaya->biaya }}" 
                                            name="idBiaya[]" 
                                            type="checkbox" 
                                            value="{{ $biaya->idBiaya }}" 
                                            class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                            @if(in_array($biaya->idBiaya, $biayaKontrakId)) checked @endif
                                        >
                                        <label for="{{ $biaya->biaya }}" class="w-32 text-md font-medium text-gray-700">{{ $biaya->biaya }}</label>
                                    </div>
                                @endforeach
                            </div>                            
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

