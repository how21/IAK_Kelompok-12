<x-app-layout>
    <!-- Dropdown untuk memilih pokok -->
    <div class="py-4">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-[#DAE2F7] border-b border-gray-200">
                    <form action="{{ route('columncharts') }}" method="GET" id="filterForm" class="flex space-x-4">
                        <!-- Dropdown Pilih Pokok -->
                        <div class="flex-1">
                            <label for="pokok" class="block mb-2 text-sm font-medium text-gray-700">Pilih Kategori:</label>
                            <select id="pokok" name="pokok" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="updateKetOptions();">
                                <option value="guru" {{ $selectedPokok == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="siswa" {{ $selectedPokok == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="pegawai" {{ $selectedPokok == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                <option value="sekolah" {{ $selectedPokok == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                                <option value="ruang kelas" {{ $selectedPokok == 'ruang kelas' ? 'selected' : '' }}>Ruang Kelas</option>
                            </select>
                        </div>

                        <!-- Dropdown Pilih Ket -->
                        <div class="flex-1">
                            <label for="ket" class="block mb-2 text-sm font-medium text-gray-700">Pilih Keterangan:</label>
                            <select id="ket" name="ket" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="document.getElementById('filterForm').submit();">
                                <!-- Opsi ket akan diperbarui oleh JavaScript -->
                            </select>
                        </div>

                        <!-- Tombol Filter -->
                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart pertama -->
    <div>
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-[#DAE2F7] border-b border-gray-200">
                    <div id="basic-column-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart kedua: Stacked Columns 100 -->
    <div class="mb-4">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-[#DAE2F7] border-b border-gray-200">
                    <div id="stacked-columns-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk ApexCharts dan dropdown dinamis -->
    @php
        $provinsi = array_keys($chartData); // Ambil daftar provinsi
        $totalNilai = [];
        $tingkatData = [];
        $tingkatPercentages = [];

        // Hitung total nilai per jenjang untuk setiap provinsi
        foreach (['SD', 'SMP', 'SMA'] as $tingkat) {
            $tingkatValues = [];
            foreach ($provinsi as $prov) {
                $total = array_sum($chartData[$prov]); // Total nilai per provinsi
                $totalNilai[$prov] = $total;
                $tingkatValues[] = $chartData[$prov][$tingkat] ?? 0;
            }
            $tingkatData[] = [
                'name' => $tingkat,
                'data' => $tingkatValues
            ];
        }

        // Hitung persentase nilai per jenjang dari total nilai di masing-masing provinsi
        foreach (['SD', 'SMP', 'SMA'] as $tingkat) {
            $percentageValues = [];
            foreach ($provinsi as $index => $prov) {
                $total = $totalNilai[$prov] ?? 1; // Untuk menghindari pembagian dengan 0
                $currentValue = $chartData[$prov][$tingkat] ?? 0;
                $percentageValues[] = $total > 0 ? ( $currentValue / $total * 100 ) : 0;
            }
            $tingkatPercentages[] = [
                'name' => $tingkat,
                'data' => $percentageValues
            ];
        }
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Konfigurasi untuk Chart Pertama (Total Nilai)
            var optionsBasicColumn = {
                chart: {
                    type: 'bar',
                    height: 525,
                },
                series: @json($tingkatData),
                xaxis: {
                    categories: @json($provinsi),
                    labels: {
                        formatter: function(value) {
                            return value.startsWith('Prov. ') ? value.substring(5) : value;
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '65%',
                        endingShape: 'rounded'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['transparent']
                },
                yaxis: {
                    title: {
                        text: 'Total Nilai'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val.toLocaleString() + " nilai";
                        }
                    }
                }
            };

            var chartBasicColumn = new ApexCharts(document.querySelector("#basic-column-chart"), optionsBasicColumn);
            chartBasicColumn.render();

            // Konfigurasi untuk Chart Kedua (Stacked Columns 100)
            var optionsStackedColumns = {
                chart: {
                    type: 'bar',
                    height: 525,
                    stacked: true
                },
                series: @json($tingkatPercentages),
                xaxis: {
                    categories: @json($provinsi),
                    labels: {
                        formatter: function(value) {
                            return value.startsWith('Prov. ') ? value.substring(5) : value;
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '65%',
                        endingShape: 'rounded'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Persentase'
                    },
                    labels: {
                        formatter: function(value) {
                            return value + "%";
                        }
                    },
                    max: 100 // Atur maksimum nilai y-axis menjadi 100% untuk stacked 100 chart
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val.toFixed(2).toLocaleString() + "%";
                        }
                    }
                }
            };

            var chartStackedColumns = new ApexCharts(document.querySelector("#stacked-columns-chart"), optionsStackedColumns);
            chartStackedColumns.render();

            // Update opsi ket ketika halaman pertama kali dimuat
            updateKetOptions();
        });

        function updateKetOptions() {
            const pokok = document.getElementById('pokok').value;
            const ketSelect = document.getElementById('ket');
            ketSelect.innerHTML = ''; // Hapus semua opsi sebelumnya

            // Tambahkan opsi "Semua"
            addOption(ketSelect, 'all', 'Semua');

            if (pokok === 'sekolah') {
                // Jika pokok adalah sekolah, tambahkan opsi negeri dan swasta
                addOption(ketSelect, 'n', 'Negeri');
                addOption(ketSelect, 's', 'Swasta');
            } else if (pokok === 'ruang kelas') {
                // Jika pokok adalah ruang kelas, tidak ada pilihan ket
                // (Opsi "Semua" sudah ditambahkan di atas)
            } else {
                // Jika pokok adalah guru, siswa, atau pegawai, tambahkan opsi perempuan dan laki-laki
                addOption(ketSelect, 'p', 'Perempuan');
                addOption(ketSelect, 'l', 'Laki-laki');
            }

            // Pilih kembali opsi yang sebelumnya dipilih, jika ada
            const selectedKet = '{{ $selectedKet }}';
            if (selectedKet) {
                ketSelect.value = selectedKet;
            }
        }

        function addOption(selectElement, value, text) {
            const option = document.createElement('option');
            option.value = value;
            option.text = text;
            selectElement.appendChild(option);
        }
    </script>
</x-app-layout>
