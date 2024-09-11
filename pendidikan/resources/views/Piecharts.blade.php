<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Piecharts') }}
        </h2>
    </x-slot> --}}

    <!-- Layout with Information and Pie Chart -->
    <div class="py-4">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#DAE2F7] overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <!-- Information Section -->
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="font-semibold text-gray-700">Jumlah Guru Laki:</p>
                            <p class="text-lg font-medium">{{ number_format($total['guru_laki']) }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="font-semibold text-gray-700">Jumlah Siswa Laki:</p>
                            <p class="text-lg font-medium">{{ number_format($total['siswa_laki']) }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="font-semibold text-gray-700">Jumlah Pegawai Laki:</p>
                            <p class="text-lg font-medium">{{ number_format($total['pegawai_laki']) }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="font-semibold text-gray-700">Jumlah Sekolah Negeri:</p>
                            <p class="text-lg font-medium">{{ number_format($total['sekolah_negeri']) }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="font-semibold text-gray-700">Jumlah Guru Perempuan:</p>
                            <p class="text-lg font-medium">{{ number_format($total['guru_perempuan']) }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="font-semibold text-gray-700">Jumlah Siswa Perempuan:</p>
                            <p class="text-lg font-medium">{{ number_format($total['siswa_perempuan']) }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="font-semibold text-gray-700">Jumlah Pegawai Perempuan:</p>
                            <p class="text-lg font-medium">{{ number_format($total['pegawai_perempuan']) }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm border border-gray-200">
                            <p class="font-semibold text-gray-700">Jumlah Sekolah Swasta:</p>
                            <p class="text-lg font-medium">{{ number_format($total['sekolah_swasta']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex">
                    <!-- Pie Chart on the Left -->
                    <div class="w-1/2 p-6 border-r border-gray-200">
                        <div id="pie-chart"></div>
                    </div>

                    <!-- Filters on the Right -->
                    <div class="w-1/2 p-6">
                        <form action="{{ route('Piecharts') }}" method="GET">
                            <div class="mb-4">
                                <label for="pokok" class="block mb-2 text-sm font-medium text-gray-700">Pilih Pokok:</label>
                                <select id="pokok" name="pokok" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="guru" {{ $selectedPokok == 'guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="siswa" {{ $selectedPokok == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                    <option value="pegawai" {{ $selectedPokok == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                    <option value="sekolah" {{ $selectedPokok == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                                    <option value="ruang kelas" {{ $selectedPokok == 'ruang kelas' ? 'selected' : '' }}>Ruang Kelas</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="tingkat" class="block mb-2 text-sm font-medium text-gray-700">Pilih Tingkat:</label>
                                <select id="tingkat" name="tingkat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Semua Tingkat</option>
                                    <option value="SD" {{ $selectedTingkat == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ $selectedTingkat == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ $selectedTingkat == 'SMA' ? 'selected' : '' }}>SMA</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="provinsi" class="block mb-2 text-sm font-medium text-gray-700">Pilih Provinsi:</label>
                                <select id="provinsi" name="provinsi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Semua Provinsi</option>
                                    @foreach ($provinsiList as $provinsiItem)
                                        <option value="{{ $provinsiItem }}" {{ $selectedProvinsi == $provinsiItem ? 'selected' : '' }}>
                                            {{ $provinsiItem }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tampilkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var optionsPieChart = {
                chart: {
                    type: 'pie',
                    height: 600
                },
                series: @json($categories->values()), // Data untuk pie chart
                labels: @json($categories->keys()),  // Label untuk pie chart
                plotOptions: {
                    pie: {
                        donut: {
                            size: '0%' // Set ke 0% agar menjadi pie chart biasa
                        }
                    }
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    show: true,
                    width: 2
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val.toLocaleString() + " nilai";
                        }
                    }
                }
            };

            var chartPie = new ApexCharts(document.querySelector("#pie-chart"), optionsPieChart);
            chartPie.render();
        });
    </script>
</x-app-layout>
