<div class="p-6 space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Keuangan</h1>
            <p class="text-gray-500 text-sm">Pantau arus pemasukan dan pengeluaran dengan mudah</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <input type="date" wire:model="tanggal_dari" class="border rounded-lg px-3 py-2 text-sm">
            <span class="text-gray-500">sampai</span>
            <input type="date" wire:model="tanggal_sampai" class="border rounded-lg px-3 py-2 text-sm">
            <select wire:model="dompet_id" class="border rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Dompet</option>
                @foreach ($dompetList as $id => $nama)
                    <option value="{{ $id }}">{{ $nama }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
            <p class="text-sm text-green-700 font-semibold mb-1">Total Pemasukan</p>
            <h2 class="text-2xl font-bold text-green-800">Rp{{ number_format($pemasukan, 0, ',', '.') }}</h2>
            <p class="text-xs text-gray-500 mt-1">Dari semua transaksi dengan status <b>Masuk</b></p>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
            <p class="text-sm text-red-700 font-semibold mb-1">Total Pengeluaran</p>
            <h2 class="text-2xl font-bold text-red-800">Rp{{ number_format($pengeluaran, 0, ',', '.') }}</h2>
            <p class="text-xs text-gray-500 mt-1">Dari semua transaksi dengan status <b>Keluar</b></p>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 shadow-sm">
            <p class="text-sm text-blue-700 font-semibold mb-1">Saldo Saat Ini</p>
            <h2 class="text-2xl font-bold text-blue-800">Rp{{ number_format($saldo, 0, ',', '.') }}</h2>
            <p class="text-xs text-gray-500 mt-1">Selisih antara pemasukan dan pengeluaran</p>
        </div>
    </div>

    <!-- Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Grafik Pemasukan & Pengeluaran -->
        <div class="bg-white rounded-xl p-5 shadow-sm border">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-semibold text-gray-700">Grafik Pemasukan & Pengeluaran</h2>
                <span class="text-sm text-gray-400">Per Bulan</span>
            </div>
            <canvas id="chartTransaksi" class="h-64"></canvas>
            <p class="text-xs text-gray-500 mt-3">
                Grafik ini menampilkan tren pemasukan dan pengeluaran sepanjang tahun berjalan.
            </p>
        </div>

        <!-- Grafik Kategori -->
        <div class="bg-white rounded-xl p-5 shadow-sm border">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-semibold text-gray-700">Kategori Transaksi Terbanyak</h2>
                <span class="text-sm text-gray-400">Berdasarkan Total Nominal</span>
            </div>
            <canvas id="chartKategori" class="h-64"></canvas>
            <p class="text-xs text-gray-500 mt-3">
                Menampilkan kategori yang paling sering digunakan berdasarkan total nilai transaksi.
            </p>
        </div>
    </div>

    <!-- Catatan Ringkas -->
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mt-4">
        <h3 class="font-semibold text-gray-700 mb-2">Catatan Singkat</h3>
        <ul class="list-disc text-sm text-gray-600 pl-6 space-y-1">
            <li>Data diambil berdasarkan periode tanggal yang kamu pilih di atas.</li>
            <li>Gunakan fitur filter tanggal & dompet untuk melihat data yang lebih spesifik.</li>
            <li>Pastikan setiap transaksi memiliki tanggal dan dompet yang valid.</li>
        </ul>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('refreshCharts', (chartData, kategoriChart) => {
                renderCharts(chartData, kategoriChart);
            });

            renderCharts(@json($chartData), @json($kategoriChart));

            function renderCharts(chartData, kategoriChart) {
                new Chart(document.getElementById('chartTransaksi'), {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                                label: 'Pemasukan',
                                data: chartData.pemasukan,
                                backgroundColor: 'rgba(16, 185, 129, 0.5)',
                                borderColor: 'rgba(16, 185, 129, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Pengeluaran',
                                data: chartData.pengeluaran,
                                backgroundColor: 'rgba(239, 68, 68, 0.5)',
                                borderColor: 'rgba(239, 68, 68, 1)',
                                borderWidth: 1,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                new Chart(document.getElementById('chartKategori'), {
                    type: 'doughnut',
                    data: {
                        labels: kategoriChart.labels,
                        datasets: [{
                            label: 'Total per Kategori',
                            data: kategoriChart.data,
                            backgroundColor: [
                                '#3B82F6', '#10B981', '#F59E0B', '#EF4444',
                                '#8B5CF6', '#06B6D4', '#F97316',
                            ],
                        }],
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    },
                });
            }
        });
    </script>
</div>
