{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Information Section -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200 relative">
                        <p class="font-semibold text-black">Jumlah Guru:</p>
                        <p class="text-lg font-medium text-black">{{ number_format($jumlahGuru, 0, '.', ',') }}</p>
                        <img src="{{ asset('build/assets/teacher.svg') }}" alt="Guru Icon" class="absolute bottom-1 top-5 left-15 right-4 w-20 h-20 mt-2">
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                        <p class="font-semibold text-gray-700">Jumlah Siswa:</p>
                        <p class="text-lg font-medium text-gray-700">{{ number_format($jumlahSiswa, 0, '.', ',') }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                        <p class="font-semibold text-gray-700">Jumlah Pegawai:</p>
                        <p class="text-lg font-medium text-gray-700">{{ number_format($jumlahPegawai, 0, '.', ',') }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                        <p class="font-semibold text-gray-700">Jumlah Sekolah:</p>
                        <p class="text-lg font-medium text-gray-700">{{ number_format($jumlahSekolah, 0, '.', ',') }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                        <p class="font-semibold text-gray-700">Jumlah Ruang Kelas:</p>
                        <p class="text-lg font-medium text-gray-700">{{ number_format($jumlahRuangKelas, 0, '.', ',') }}</p>
                    </div>
                </div>
                

                <!-- Filter Form -->
                <form method="GET" action="{{ route('dashboard') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label for="pokok" class="block text-sm font-medium text-gray-700">Pokok</label>
                            <select id="pokok" name="pokok" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Semua</option>
                                @foreach ($pokokOptions as $option)
                                    <option value="{{ $option->pokok }}" {{ request('pokok') == $option->pokok ? 'selected' : '' }}>
                                        {{ $option->pokok }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="tingkat" class="block text-sm font-medium text-gray-700">Tingkat</label>
                            <select id="tingkat" name="tingkat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Semua</option>
                                @foreach ($tingkatOptions as $option)
                                    <option value="{{ $option->tingkat }}" {{ request('tingkat') == $option->tingkat ? 'selected' : '' }}>
                                        {{ $option->tingkat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="ket" class="block text-sm font-medium text-gray-700">Ket</label>
                            <select id="ket" name="ket" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Semua</option>
                                <!-- JavaScript will dynamically populate options here -->
                            </select>
                        </div>

                        <div>
                            <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <select id="provinsi" name="provinsi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Semua</option>
                                @foreach ($provinsiOptions as $option)
                                    <option value="{{ $option->provinsi }}" {{ request('provinsi') == $option->provinsi ? 'selected' : '' }}>
                                        {{ $option->provinsi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="mt-6 w-full px-4 py-2 bg-blue-500 text-white rounded">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Tabel Data -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pokok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provinsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($datasets as $dataset)
                            <tr>
                                <td class="px-6 py-4">{{ $dataset->pokok }}</td>
                                <td class="px-6 py-4">{{ $dataset->tingkat }}</td>
                                <td class="px-6 py-4">{{ $dataset->ket }}</td>
                                <td class="px-6 py-4">{{ $dataset->provinsi }}</td>
                                <td class="px-6 py-4">{{ number_format($dataset->nilai, 0, '.', ',') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $datasets->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic "ket" filter -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pokokSelect = document.getElementById('pokok');
            const ketSelect = document.getElementById('ket');

            const updateKetOptions = () => {
                const selectedPokok = pokokSelect.value;
                ketSelect.innerHTML = '<option value="">Semua</option>'; // Add "Semua" option first

                if (selectedPokok === 'Guru' || selectedPokok === 'Pegawai' || selectedPokok === 'Siswa') {
                    ketSelect.insertAdjacentHTML('beforeend', '<option value="L" {{ request("ket") == "L" ? "selected" : "" }}>Laki-Laki (L)</option>');
                    ketSelect.insertAdjacentHTML('beforeend', '<option value="P" {{ request("ket") == "P" ? "selected" : "" }}>Perempuan (P)</option>');
                } else if (selectedPokok === 'Sekolah') {
                    ketSelect.insertAdjacentHTML('beforeend', '<option value="N" {{ request("ket") == "N" ? "selected" : "" }}>Negeri (N)</option>');
                    ketSelect.insertAdjacentHTML('beforeend', '<option value="S" {{ request("ket") == "S" ? "selected" : "" }}>Swasta (S)</option>');
                }
                // No options for Ruang Kelas
            };

            // Trigger change event to update 'ket' options when 'pokok' changes
            pokokSelect.addEventListener('change', updateKetOptions);

            // Initialize ket options based on the current value of 'pokok'
            updateKetOptions();
        });
    </script>
</x-app-layout> --}}
