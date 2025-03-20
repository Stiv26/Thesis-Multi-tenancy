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
                        <p class="mt-1 text-sm leading-6 text-gray-600">Informasi akun yang digunakan untuk login Tenant.
                        </p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            {{-- NAMA --}}
                            <div class="sm:col-span-4">
                                <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama
                                    Penyewa</label>
                                <div class="mt-2">
                                    <input required type="text" name="nama" id="nama"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- email --}}
                            <div class="sm:col-span-4">
                                <label for="email"
                                    class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                <div class="mt-2">
                                    <input required id="email" name="email" type="email"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- NO TELP --}}
                            <div class="sm:col-span-4">
                                <label for="telpon" class="block text-sm font-medium leading-6 text-gray-900">Nomor
                                    Telepon</label>
                                <div class="mt-2">
                                    <input required type="text" name="telpon" id="telpon" minlength="8"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- PASS --}}
                            <div class="sm:col-span-4">
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Kata
                                    Sandi</label>
                                <div class="mt-2">
                                    <input required type="password" name="password" id="password" minlength="6"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- CONFIRM PASS --}}
                            <div class="sm:col-span-4">
                                <label for="confirm" class="block text-sm font-medium leading-6 text-gray-900">Konfirmasi Kata Sandi</label>
                                <div class="mt-2">
                                    <input required type="password" name="confirm" id="confirm" 
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    @error('confirm')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
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
                                <label for="id" class="block text-sm font-medium leading-6 text-gray-900">Nama
                                    Tenant</label>
                                <div class="mt-2">
                                    <input required type="text" name="id" id="id"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- alamat --}}
                            <div class="sm:col-span-4">
                                <label for="alamat"
                                    class="block text-sm font-medium leading-6 text-gray-900">Alamat</label>
                                <div class="mt-2">
                                    <input required id="alamat" name="alamat" type="text"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>


                            {{-- Nomor Rekening --}}
                            <div class="sm:col-span-2 sm:col-start-1">
                                <label for="bank" class="block text-sm font-medium leading-6 text-gray-900">Bank
                                    Utama</label>
                                <div class="mt-2">
                                    <select id="bank" name="bank" required
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option value="BCA">BCA (BANK CENTRAL ASIA)</option>
                                        <option value="BRI">BRI (BANK RAKYAT INDONESIA)</option>
                                        <option value="Mandiri">Bank Mandiri</option>
                                        <option value="BNI">BNI (BANK NEGARA INDONESIA)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="rekening" class="block text-sm font-medium leading-6 text-gray-900">Nomor
                                    Rekening</label>
                                <div class="mt-2">
                                    <input required id="rekening" name="rekening" type="text"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            {{-- keterangan --}}
                            <div class="sm:col-span-4">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Keterangan</h2>
                                <div class="mt-2">
                                    <textarea id="keterangan" name="keterangan" rows="3"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
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
                                <label for="card1" class="w-1/3 p-4 cursor-pointer group">
                                    <input type="checkbox" id="card1" name="custom_tables[]" value="addDataDiri" class="hidden peer">
                                    <div class="border border-gray-200 rounded-lg p-6 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                        <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900 peer-checked:text-indigo-600">Data Diri</h2>
                                        <p class="text-base peer-checked:text-indigo-600">Kelola informasi data diri penghuni kos.</p>
                                    </div>
                                </label>
                                {{-- BIAYA FASILITAS --}}
                                <label for="card3" class="w-1/3 p-4 cursor-pointer group">
                                    <input type="checkbox" id="card3" name="custom_tables[]" value="addBiaya" class="hidden peer">
                                    <div class="border border-gray-200 rounded-lg p-6 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                        <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                                                <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
                                                <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900 peer-checked:text-indigo-600">Biaya</h2>
                                        <p class="text-base peer-checked:text-indigo-600">Atur rincian biaya kos secara detail.</p>
                                    </div>
                                </label>
                                {{-- LAYANAN TAMBAHAN --}}
                                <label for="card2" class="w-1/3 p-4 cursor-pointer group">
                                    <input type="checkbox" id="card2" name="custom_tables[]" value="addLayananTambahan" class="hidden peer">
                                    <div class="border border-gray-200 rounded-lg p-6 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                        <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900 peer-checked:text-indigo-600">Layanan Tambahan</h2>
                                        <p class="text-base peer-checked:text-indigo-600">Penjualan barang untuk penghuni kos.</p>
                                    </div>
                                </label>
                                {{-- PEMELIHARAN --}}
                                <label for="card4" class="w-1/3 p-4 cursor-pointer group">
                                    <input type="checkbox" id="card4" name="custom_tables[]" value="addPemeliharaan" class="hidden peer">
                                    <div class="border border-gray-200 rounded-lg p-6 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                        <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-recycle" viewBox="0 0 16 16">
                                                <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.5.5 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244z"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900 peer-checked:text-indigo-600">Pemeliharaan</h2>
                                        <p class="text-base peer-checked:text-indigo-600">Pantau permintaan perbaikan fasilitas.</p>
                                    </div>
                                </label>
                                {{-- KARYAWAN --}}
                                <label for="card5" class="w-1/3 p-4 cursor-pointer group">
                                    <input type="checkbox" id="card5" name="custom_tables[]" value="addKaryawan" class="hidden peer">
                                    <div class="border border-gray-200 rounded-lg p-6 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                        <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900 peer-checked:text-indigo-600">Karyawan</h2>
                                        <p class="text-base peer-checked:text-indigo-600">Kelola karyawan yang bekerja pada kos.</p>
                                    </div>
                                </label>
                                {{-- DENDA --}}
                                <label for="card6" class="w-1/3 p-4 cursor-pointer group">
                                    <input type="checkbox" id="card6" name="custom_tables[]" value="addDenda" class="hidden peer">
                                    <div class="border border-gray-200 rounded-lg p-6 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                        <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 peer-checked:bg-indigo-500 peer-checked:text-white mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-octagon-fill" viewBox="0 0 16 16">
                                                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-medium text-gray-900 peer-checked:text-indigo-600">Denda</h2>
                                        <p class="text-base peer-checked:text-indigo-600">Kelola denda tagihan pembayaran kos.</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </section>

                    {{-- Bagian Submit --}}
                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <p class="text-sm leading-6 text-gray-500">Periksa Kembali Data Anda</p>
                        <button type="submit"
                            class="rounded-md bg-indigo-600 px-20 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                    </div>
            </form>
        </section>

    </main>
</x-layout>



<script>
    document.getElementById('id').addEventListener('input', function (e) {
        this.value = this.value.replace(/ /g, '_');
    });
</script>