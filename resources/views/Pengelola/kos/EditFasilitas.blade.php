<x-layout>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        <a href="{{ url('/kos') }}"><button type="button" class=" rounded-md bg-indigo-500 px-8 py-1.5 text-white font-semibold hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
            ← Kembali
        </button></a>

        <form action="{{ route('kos.updateFasilitas', $data->idFasilitas) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mt-3 flex border-b border-gray-200">
                <div class="px-6 py-4 w-1/2">
                    <ul class="text-sm text-gray-600">
                        <li class="mb-4">
                            <label for="fasilitas" class="block font-medium mb-2">Fasilitas:</label>
                            <input type="text" id="fasilitas" name="fasilitas" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->fasilitas }}">
                        </li>
                        <li class="mb-4">
                            <label for="jumlah" class="block font-medium mb-2">Jumlah:</label>
                            <input type="number" id="jumlah" name="jumlah" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->jumlah }}">
                        </li>
                        <li class="mb-4">
                            <label for="jenis" class="block font-medium mb-2">Jenis:</label>
                            <select id="jenis" name="jenis" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="umum" @selected($data->jenis == 'umum')>Umum</option>
                                <option value="kamar" @selected($data->jenis == 'kamar')>Kamar</option>
                            </select>                            
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

