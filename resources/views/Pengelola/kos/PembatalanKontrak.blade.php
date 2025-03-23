<x-layout>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        <a href="{{ url('/kos') }}"><button type="button" class=" rounded-md bg-indigo-500 px-8 py-1.5 text-white font-semibold hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
            ← Kembali
        </button></a>

        <form action="{{ route('kos.destroyKontrak', $data->idKontrak) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mt-3 flex border-b border-gray-200">
                <div class="px-6 py-4 w-2/5">
                    <ul class="text-sm text-gray-600">
                        <li class="mb-4">
                            <label for="nama" class="block font-medium mb-2">Nama Penyewa:</label>
                            <input type="text" id="nama" name="nama" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->nama }}" disabled>
                        </li>
                        <li class="mb-4">
                            <label for="kamar" class="block font-medium mb-2">Kamar:</label>
                            <input type="text" id="nama" name="nama" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="Kamar {{ $data->idKamar }}" disabled>                         
                        </li>
                        @if ($data->deposit)
                            <li class="mb-4">
                                <label for="depo" class="block font-medium mb-2">Deposit Kontrak:</label>
                                <input type="text" id="depo" name="depo" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->deposit }}" disabled>                         
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="px-6 py-4 w-3/5">
                    <ul class="text-sm text-gray-600">
                        @if ($data->deposit)
                            <li class="mb-4">
                                <label for="deposit" class="block font-medium mb-2">Deposit:</label>
                                <select required id="deposit" name="deposit" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    <option value="Kembalikan">Kembalikan</option>
                                    <option value="Potong">Potong</option>
                                </select>   
                            </li>
                            <li class="mb-4">
                                <label for="pengembalian" class="block font-medium mb-2">Nominal Pengembalian Deposit:</label>
                                <input readonly required type="number" id="pengembalian" name="pengembalian" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                    value="{{ $data->deposit }}">                         
                            </li>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const depositSelect = document.getElementById('deposit');
                                    const pengembalianInput = document.getElementById('pengembalian');
                        
                                    depositSelect.addEventListener('change', () => {
                                        if (depositSelect.value === 'Potong') {
                                            pengembalianInput.removeAttribute('readonly');
                                        } else {
                                            pengembalianInput.setAttribute('readonly', true);
                                            pengembalianInput.value = "{{ $data->deposit }}"; 
                                        }
                                    });
                                });
                            </script>
                        @endif
                        <li class="mb-4">
                            <label for="alasan" class="block font-medium mb-2">Alasan:</label>
                            <textarea id="alasan" name="alasan" rows="3" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
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

