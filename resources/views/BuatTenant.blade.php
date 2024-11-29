<x-layout>
    <x-slot:header>{{ $header }}</x-slot:header>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        {{-- header dari page yang diberikan x-slot + data dari route dan dikirim ke header --}}
        <x-header>{{ $header }}</x-header>
        
        <section id="tambahTenant" class="block">
            <form action="{{ route('tenants.store') }}" method="POST" class="mt-10">
                @csrf
                <div class="space-y-12">
                    <!-- Bagian Akun Pengelola -->
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Akun Tenant*</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Informasi akun yang digunakan untuk login Tenant.</p>
                        
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama Penyewa</label>
                                <div class="mt-2">
                                    <input type="text" name="nama" id="nama" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="telpon" class="block text-sm font-medium leading-6 text-gray-900">Nomor Telepon</label>
                                <div class="mt-2">
                                    <input type="text" name="telpon" id="telpon" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                    
                            <div class="sm:col-span-4">
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Kata Sandi</label>
                                <div class="mt-2">
                                    <input type="text" name="password" id="password" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
              
                    <!-- Bagian Kontrak -->
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Data Tenant*</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Data informasi tenant kos.</p>
                
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        {{-- nama tenant --}}
                        <div class="sm:col-span-4">
                            <label for="id" class="block text-sm font-medium leading-6 text-gray-900">Nama Tenant</label>
                            <div class="mt-2">
                                <input required type="text" name="id" id="id" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        {{-- email --}}
                        <div class="sm:col-span-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        {{-- alamat --}}
                        <div class="sm:col-span-4">
                            <label for="alamat" class="block text-sm font-medium leading-6 text-gray-900">Alamat</label>
                            <div class="mt-2">
                                <input id="alamat" name="alamat" type="text" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        {{-- keterangan --}}
                        <div class="sm:col-span-4">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Keterangan</h2>
                            <div class="mt-2">
                                <textarea id="keterangan" name="keterangan" rows="3" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                            </div> 
                            <p class="mt-3 text-sm leading-6 text-gray-600">Bagian ini bersifat optional</p>
                        </div>
                    </div>
                </div>

                {{-- SAAS --}}
                <section class="text-gray-600 body-font">
                    <div class="container mx-auto">
                        <div class="flex flex-wrap -m-4">
                            <!-- DATA DIRI -->
                            <label for="card1" class="w-1/4 p-4 cursor-pointer group">
                                <input type="checkbox" id="card1" name="custom_tables[]" value="addDataDiri" class="hidden peer">

                                <div class="border border-gray-200 rounded-lg p-6 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                    <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white mb-4">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-medium text-gray-900 peer-checked:text-indigo-600">Data Diri</h2>
                                    <p class="text-base peer-checked:text-indigo-600">A brief description of the card.</p>
                                </div>
                            </label>
                            {{-- BIAYA FASILITAS --}}
                            <label for="card3" class="w-1/4 p-4 cursor-pointer group">
                                <input type="checkbox" id="card3" name="custom_tables[]" value="addBiaya" class="hidden peer">

                                <div class="border border-gray-200 rounded-lg p-6 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                    <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white mb-4">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-medium text-gray-900 peer-checked:text-indigo-600">Biaya</h2>
                                    <p class="text-base peer-checked:text-indigo-600">A brief description of the card.</p>
                                </div>
                            </label>
                            {{-- LAYANAN TAMBAHAN --}}
                            <label for="card2" class="w-1/4 p-4 cursor-pointer group">
                                <input type="checkbox" id="card2" name="custom_tables[]" value="addLayananTambahan" class="hidden peer">

                                <div class="border border-gray-200 rounded-lg p-6 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                    <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white mb-4">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-medium text-gray-900 peer-checked:text-indigo-600">Layanan Tambahan</h2>
                                    <p class="text-base peer-checked:text-indigo-600">A brief description of the card.</p>
                                </div>
                            </label>
                            {{-- PEMELIHARAAN --}}
                            <label for="card4" class="w-1/4 p-4 cursor-pointer group">
                                <input type="checkbox" id="card4" name="custom_tables[]" value="addPemeliharaan" class="hidden peer">

                                <div class="border border-gray-200 rounded-lg p-6 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                    <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white mb-4">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-medium text-gray-900 peer-checked:text-indigo-600">Pemeliharaan</h2>
                                    <p class="text-base peer-checked:text-indigo-600">A brief description of the card.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </section>

                {{-- Bagian Submit --}}
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                    <button type="submit" class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                </div>
            </form>
            
        </section>

    </main>
</x-layout>
