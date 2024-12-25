<x-layout>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        <a href="{{ url('/karyawan') }}"><button type="button" class=" rounded-md bg-indigo-500 px-8 py-1.5 text-white font-semibold hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
            ← Kembali
        </button></a>

        <form action="{{ route('karyawan.updatekaryawan', $data->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mt-3 flex border-b border-gray-200">
                <div class="px-6 py-4 w-1/2">
                    <ul class="text-sm text-gray-600">
                        <li class="mb-4">
                            <label for="no_telp" class="block font-medium mb-2">No Telp:</label>
                            <input type="text" id="no_telp" name="no_telp" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->no_telp }}">
                        </li>
                        <li class="mb-4">
                            <label for="password" class="block font-medium mb-2">Password:</label>
                            <input type="text" id="password" name="password" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->password }}">
                        </li>
                        <li class="mb-4">
                            <label for="email" class="block font-medium mb-2">Email:</label>
                            <input type="text" id="email" name="email" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->email }}">
                        </li>
                        <li class="mb-4">
                            <label for="nama" class="block font-medium mb-2">Nama:</label>
                            <input type="text" id="nama" name="nama" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->nama }}">
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

