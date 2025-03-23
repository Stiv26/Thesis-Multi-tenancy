<x-layout>

    <main class="px-5 py-8 bg-gray-50 rounded-xl">
        <a href="{{ url('/kos') }}"><button type="button" class=" rounded-md bg-indigo-500 px-8 py-1.5 text-white font-semibold hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
            ← Kembali
        </button></a>

        <form action="{{ route('kos.updateKontrak', $data->idKontrak) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mt-3 flex border-b border-gray-200">
                {{-- KIRI --}}
                <div class="px-6 py-4 w-1/2">
                    <ul class="text-sm text-gray-600">
                        <li class="mb-4">
                            <label for="nama" class="block font-medium mb-2">Nama Penyewa:</label>
                            <input type="text" id="nama" name="nama" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->nama }}" disabled>
                        </li>

                        {{-- DATA KONTRAK PENTING --}}
                        <div id="dataKontrak">
                            {{-- kamar --}}
                            <li class="mb-4">
                                <label for="kamar" class="block font-medium mb-2">Kamar:</label>
                                <select id="kamar" name="kamar" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @foreach ($kamarList as $kamar)
                                        <option value="{{ $kamar->idKamar }}" 
                                                data-harga="{{ $kamar->harga }}" 
                                                data-mingguan="{{ $kamar->harga_mingguan }}" 
                                                data-harian="{{ $kamar->harga_harian }}"
                                                @selected($data->idKamar == $kamar->idKamar)>
                                            Kamar {{ $kamar->idKamar }}
                                        </option>
                                    @endforeach
                                </select>
                                                          
                            </li>
                            {{-- harga --}}
                            <li class="mb-4">
                                <label for="harga" class="block font-medium mb-2">Harga Kamar:</label>
                                <input type="number" id="harga" name="harga" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                    value="{{ $data->harga }}" readonly>
                            </li>
                            {{-- rentang --}}
                            {{-- <li class="mb-4">
                                <label for="rentang" class="block font-medium mb-2">Rentang:</label>
                                <select id="rentang" name="rentang" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    <option value="bulan" @selected($data->rentang == 'Bulan')>Bulan</option>
                                    <option value="mingguan" @selected($data->rentang == 'Mingguan')>Mingguan</option>
                                    <option value="harian" @selected($data->rentang == 'Harian')>Harian</option>
                                </select>                            
                            </li> --}}

                            <li class="mb-4">
                                <label for="rentang" class="block font-medium mb-2">Rentang:</label>
                                <select id="rentang" name="rentang" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    <option value="bulan" @selected($data->rentang == 'Bulan')>Bulan</option>
                                    @php
                                        // Cek kamar yang dipilih awal
                                        $selectedKamar = $kamarList->firstWhere('idKamar', $data->idKamar ?? null);
                                        $showMingguan = $selectedKamar && !is_null($selectedKamar->harga_mingguan);
                                        $showHarian = $selectedKamar && !is_null($selectedKamar->harga_harian);
                                    @endphp
                                    @if($showMingguan)
                                        <option value="mingguan" @selected($data->rentang == 'Mingguan')>Mingguan</option>
                                    @endif
                                    @if($showHarian)
                                        <option value="harian" @selected($data->rentang == 'Harian')>Harian</option>
                                    @endif
                                </select>                            
                            </li>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const kamarSelect = document.getElementById('kamar');
                                    const rentangSelect = document.getElementById('rentang');
                                
                                    function updateRentang() {
                                        // Ambil data dari kamar yang dipilih
                                        const selectedOption = kamarSelect.options[kamarSelect.selectedIndex];
                                        const hasMingguan = selectedOption.dataset.mingguan !== '';
                                        const hasHarian = selectedOption.dataset.harian !== '';
                                
                                        // Update opsi mingguan
                                        let mingguanOption = rentangSelect.querySelector('option[value="mingguan"]');
                                        if(hasMingguan && !mingguanOption) {
                                            rentangSelect.innerHTML += '<option value="mingguan">Mingguan</option>';
                                        } else if(!hasMingguan && mingguanOption) {
                                            mingguanOption.remove();
                                        }
                                
                                        // Update opsi harian
                                        let harianOption = rentangSelect.querySelector('option[value="harian"]');
                                        if(hasHarian && !harianOption) {
                                            rentangSelect.innerHTML += '<option value="harian">Harian</option>';
                                        } else if(!hasHarian && harianOption) {
                                            harianOption.remove();
                                        }
                                
                                        // Reset ke bulan jika opsi tidak valid
                                        if(!rentangSelect.querySelector(`option[value="${rentangSelect.value}"]`)) {
                                            rentangSelect.value = 'bulan';
                                        }
                                    }
                                
                                    // Update saat pertama kali load
                                    updateRentang();
                                    
                                    // Update saat kamar berubah
                                    kamarSelect.addEventListener('change', updateRentang);
                                });
                            </script>

                            {{-- UPDATE HARGA KAMAR --}}
                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const kamarDropdown = document.getElementById('kamar'); // Dropdown kamar
                                    const rentangDropdown = document.getElementById('rentang'); // Dropdown rentang (Bulan/Mingguan/Harian)
                                    const hargaInput = document.getElementById('harga'); // Input harga kamar

                                    const updateHarga = () => {
                                        // Ambil opsi kamar yang dipilih
                                        const selectedKamar = kamarDropdown.options[kamarDropdown.selectedIndex];
                                        const rentangType = rentangDropdown.value; // Tipe rentang (Bulan/Mingguan/Harian)

                                        // Ambil harga berdasarkan tipe rentang
                                        let harga;
                                        if (rentangType === 'bulan') {
                                            harga = selectedKamar.getAttribute('data-harga');
                                        } else if (rentangType === 'mingguan') {
                                            harga = selectedKamar.getAttribute('data-mingguan');
                                        } else if (rentangType === 'harian') {
                                            harga = selectedKamar.getAttribute('data-harian');
                                        }

                                        // Perbarui nilai harga di input harga
                                        hargaInput.value = harga || ''; // Kosongkan jika tidak ada data
                                    };

                                    // Tambahkan event listener untuk dropdown kamar dan rentang
                                    kamarDropdown.addEventListener('change', updateHarga);
                                    rentangDropdown.addEventListener('change', updateHarga);

                                    // Jalankan saat halaman dimuat untuk menginisialisasi nilai harga
                                    updateHarga();
                                });
                            </script>

                        </div>

                        <li class="mb-4">
                            <label for="keterangan" class="block font-medium mb-2">Keterangan:</label>
                            <textarea id="keterangan" name="keterangan" rows="3" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ $data->keterangan }}</textarea>
                        </li>
                    </ul>
                </div>
                {{-- KANAN --}}
                <div class="px-6 py-4 w-1/2">
                    <ul class="text-sm text-gray-600">
                        <li class="mb-4">
                            <label for="tgl_tagihan" class="block font-medium mb-2">Tanggal Tagihan:</label>
                            <input type="date" id="tgl_tagihan" name="tgl_tagihan" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->tgl_tagihan }}" required>
                        </li>
                        <li class="mb-4">
                            <label for="tgl_denda" class="block font-medium mb-2">Tanggal Denda:</label>
                            <input type="date" id="tgl_denda" name="tgl_denda" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->tgl_denda }}" required>
                        </li>

                        {{-- BERDASARKAN RENTANG --}}
                        <li class="mb-4">
                            <div class="flex">
                                <div class="w-50 mr-4">
                                    <label for="waktu_tagihan" class="block font-medium mb-2">Pertanggal Tagihan:</label>
                                    <input type="number" id="waktu_tagihan" name="waktu_tagihan" class="text-center border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" min="1"
                                        value="{{ $pengaturan->waktu_tagihan }}" required>
                                </div>
                                <div class="w-50">
                                    <label for="waktu_denda" class="block font-medium mb-2">Pertanggal Denda:</label>
                                    <input type="number" id="waktu_denda" name="waktu_denda" class="text-center border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" min="1"
                                        value="{{ $pengaturan->waktu_denda }}" required>
                                </div>
                            </div>
                        </li>
                        
                        <li class="mb-4" id="waktu_tinggal">
                            <label for="tgl_denda" class="block font-medium mb-2">Waktu Tinggal:</label>
                            <input type="text" id="waktu" name="waktu" class="border border-gray-300 rounded-lg p-3 pl-3 w-full focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                                value="{{ $data->waktu }}" required>
                        </li>
                        
                        <label for="biaya_kontrak" class="block font-medium mb-4">Biaya Kontrak:</label>
                        @foreach ($biayaList as $biaya)
                            <li>
                                <div class="flex flex-wrap gap-x-2">
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
                                </div>                            
                            </li>                        
                        @endforeach
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

{{-- UPDATE RENTANG --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const rentangDropdown = document.getElementById('rentang'); // Dropdown rentang
        const waktuInput = document.getElementById('waktu'); // Input waktu tinggal
        
        const waktuContainer = document.getElementById('waktu_tinggal'); // Container untuk input waktu
        const waktuTagihanInput = document.getElementById('waktu_tagihan'); // Input waktu tagihan
        const waktuDendaInput = document.getElementById('waktu_denda'); // Input waktu denda

        const updateVisibility = () => {
            const selectedRentang = rentangDropdown.value; // Nilai dropdown rentang

            if (selectedRentang === 'bulan') {
                // Jika rentang adalah Bulanan
                waktuContainer.classList.add('hidden'); // Sembunyikan input waktu tinggal
                
                waktuTagihanInput.parentElement.parentElement.classList.remove('hidden'); // Tampilkan input waktu tagihan
                waktuDendaInput.parentElement.parentElement.classList.remove('hidden'); // Tampilkan input waktu denda
            } 
            else {
                // Jika rentang adalah Mingguan atau Harian
                waktuContainer.classList.remove('hidden'); // Tampilkan input waktu tinggal
                waktuInput.value = 1;

                waktuTagihanInput.parentElement.parentElement.classList.add('hidden'); // Sembunyikan input waktu tagihan
                waktuDendaInput.parentElement.parentElement.classList.add('hidden'); // Sembunyikan input waktu denda
            
                // Reset nilai waktu tagihan dan waktu denda
                waktuTagihanInput.value = 1; 
                waktuDendaInput.value = 1;
            }
        };

        // Jalankan saat halaman dimuat untuk memastikan visibilitas awal
        updateVisibility();
        // Tambahkan event listener untuk perubahan pada dropdown rentang
        rentangDropdown.addEventListener('change', updateVisibility);
    });
</script>


