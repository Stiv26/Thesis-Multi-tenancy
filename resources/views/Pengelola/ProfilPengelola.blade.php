<x-layout>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        <a href="{{ url('/kos') }}"><button type="button" class=" rounded-md bg-indigo-500 px-8 py-1.5 text-white font-semibold hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
            ← Kembali
        </button></a>

        <form action="{{ route('update.profilPengelola') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mt-3 flex border-b border-gray-200">
                <div class="px-6 py-4 w-1/2">
                    <ul class="text-sm text-gray-600">
                        <li class="mb-4">
                            <label for="nama" class="block font-medium mb-2">Nama Lengkap:</label>
                            <input type="nama" id="nama" name="nama" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->nama }}">
                        </li>
                        <li class="mb-4">
                            <label for="no_telp" class="block font-medium mb-2">Nomor Telepon:</label>
                            <input type="text" id="no_telp" name="no_telp" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->no_telp }}">
                        </li>
                        <li class="mb-4">
                            <label for="email" class="block font-medium mb-2">Email:</label>
                            <input type="email" id="email" name="email" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->email }}">
                        </li>
                        <li class="flex">
                            <div class="w-[30%]">
                                <label for="metode" class="block font-medium mb-2">Rekening Tujuan:</label>
                                <select id="metode" name="metode" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @foreach ($metode as $item)
                                        <option value="{{ $item->idMetodePembayaran }}" data-tujuan="{{ $item->nomor_tujuan }}">{{ $item->metode }}</option>
                                    @endforeach
                                </select>
                            </div>                            

                            <div class="ml-3 w-full">
                                <label for="tujuan" class="block font-medium mb-2">Rekening Tujuan:</label>
                                <input type="text" id="tujuan" name="tujuan" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                    value="">
                            </div>

                            {{-- JS LOOP METODE --}}
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const metodeDropdown = document.getElementById('metode');
                                    const tujuanInput = document.getElementById('tujuan');
                            
                                    // Event listener untuk dropdown
                                    metodeDropdown.addEventListener('change', function () {
                                        // Ambil atribut data-tujuan dari opsi yang dipilih
                                        const selectedOption = metodeDropdown.options[metodeDropdown.selectedIndex];
                                        const tujuanValue = selectedOption.getAttribute('data-tujuan');
                            
                                        // Set nilai tujuan pada input
                                        tujuanInput.value = tujuanValue || ''; // Jika tidak ada tujuan, set kosong
                                    });
                            
                                    // Set nilai awal (jika diperlukan)
                                    const initialOption = metodeDropdown.options[metodeDropdown.selectedIndex];
                                    tujuanInput.value = initialOption.getAttribute('data-tujuan') || '';
                                });
                            </script>
                        </li>     
                        
                        <div class="flex">
                            <a href="#" data-toggle="modal" data-target="#ModalTambahMetode"
                                class="mt-3 text-sm leading-6 text-gray-600 mr-4">
                                <span aria-hidden="true">+</span> Tambah Rekening Tujuan Baru</a> 

                            <a href="#" data-id="{{ $item->idMetodePembayaran }}" data-toggle="modal" data-target="#ModalHapusMetode" 
                                class="mt-3 text-sm leading-6 text-red-800 mr-4">
                                    <span aria-hidden="true">-</span> Hapus Rekening</a>                                  
                        </div>       
                    </ul>
                </div>
            </div>
            <div class="flex justify-end mt-4 gap-x-4">
                <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                <button type="submit" class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Simpan</button>
            </div>
        </form>   
        
        {{-- MODAL TAMBAH METODE --}}
        <div class="modal fade p-4" id="ModalTambahMetode" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                <form action="{{ route('metode.store') }}" method="POST"
                    class="modal-content rounded-lg shadow-lg bg-white">
                    @csrf
                    {{-- Header modal --}}
                    <div class="modal-header border-b border-gray-200 py-4 px-6">
                        <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Tambah Rekening Tujuan
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal"
                            aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    {{-- Content modal --}}
                    <div class="modal-body p-6 space-y-2">
                        <div class="flex items-center space-x-4">
                            <label for="tambah-metode" class="w-32 text-md font-medium text-gray-700">Bank/E-Wallet:</label>
                            <input required id="tambah-metode" name="metode" type="text" value=""
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                        </div>

                        <div class="flex items-center space-x-4">
                            <label for="tambah-tujuan" class="w-32 text-md font-medium text-gray-700">Nomor Tujuan:</label>
                            <input required id="tambah-tujuan" name="tujuan" type="text" value=""
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-0">
                        </div>
                    </div>
                    {{-- Footer --}}
                    <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                        <button type="submit"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                            Tambah
                        </button>
                        <button type="button"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                            data-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL HAPUS METODE --}}
        <div class="modal fade p-4" id="ModalHapusMetode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog max-w-4xl mx-auto mt-24">
                <form id="deleteMetodeForm" action="" method="POST" class="modal-content rounded-lg shadow-lg bg-white">
                    @csrf
                    @method('DELETE')
                    <!-- Header modal -->
                    <div class="modal-header border-b border-gray-200 py-4 px-6">
                        <h3 class="text-2xl font-semibold text-gray-800" id="myModalLabel">Hapus Rekening Tujuan</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Content modal -->
                    <div class="modal-body p-6 space-y-2">
                        <p class="text-gray-700">Apakah Anda yakin ingin menghapus rekening tujuan ini?</p>
                    </div>
                    <!-- Footer -->
                    <div class="modal-footer border-t border-gray-200 py-2 px-6 flex">
                        <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-white font-semibold hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-600">
                            Hapus
                        </button>
                        <button type="button" class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-600" data-dismiss="modal">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>
</x-layout>

<SCript>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('[data-target="#ModalHapusMetode"]');
        const deleteForm = document.getElementById('deleteMetodeForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const metodeId = this.dataset.id; // Ambil ID dari atribut data-id
                deleteForm.action = `/metode-pembayaran/${metodeId}`; // Atur action form
            });
        });
    });
</SCript>

