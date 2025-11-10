<div class="p-6 space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Keuangan</h1>
            <p class="text-gray-500 text-sm">Pantau arus pemasukan dan pengeluaran dengan mudah</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <input type="date" wire:model.lazy="tanggal_dari" class="border rounded-lg px-3 py-2 text-sm">
            <span class="text-gray-500">sampai</span>
            <input type="date" wire:model.lazy="tanggal_sampai" class="border rounded-lg px-3 py-2 text-sm">
            <select wire:model.lazy="dompet_id" class="border rounded-lg px-3 pr-9   py-2 text-sm">
                <option value="">Semua</option>
                @foreach ($dompetList as $id => $nama)
                    <option value="{{ (int) $id }}">{{ $nama }}</option>
                @endforeach
            </select>

        </div>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 shadow-sm">
            <p class="text-sm text-blue-700 font-semibold mb-1">Saldo Saat Ini</p>
            <h2 class="text-2xl font-bold text-blue-800">Rp{{ number_format($saldo, 0, ',', '.') }}</h2>
            <p class="text-xs text-gray-500 mt-1">Selisih antara pemasukan dan pengeluaran</p>
        </div>
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
    </div>

    <!-- Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Grafik Pemasukan & Pengeluaran -->
        <div wire:ignore class="bg-white rounded-xl p-5 shadow-sm border flex flex-col">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-semibold text-gray-700">Grafik Pemasukan & Pengeluaran</h2>
                <span class="text-sm text-gray-400">Per Bulan</span>
            </div>
            <div class="flex-1">
                <canvas id="chartTransaksi" class="w-full" style="height:250px;"></canvas>
            </div>
            <p class="text-xs text-gray-500 mt-3">
                Grafik ini menampilkan tren pemasukan dan pengeluaran sepanjang tahun berjalan.
            </p>
        </div>

        <!-- Grafik Kategori -->
        <div wire:ignore class="bg-white rounded-xl p-5 shadow-sm border flex flex-col">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-semibold text-gray-700">Kategori Transaksi Terbanyak</h2>
                <span class="text-sm text-gray-400">Berdasarkan Total Nominal</span>
            </div>
            <div class="flex-1">
                <canvas id="chartKategori" class="w-full" style="height:250px;"></canvas>
            </div>
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
</div>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const chartTransaksiCtx = document.getElementById('chartTransaksi').getContext('2d');
        const chartKategoriCtx = document.getElementById('chartKategori').getContext('2d');

        let chartTransaksi, chartKategori;

        async function loadChartData() {
            const tanggal_dari = document.querySelector('input[wire\\:model\\.lazy="tanggal_dari"]').value;
            const tanggal_sampai = document.querySelector('input[wire\\:model\\.lazy="tanggal_sampai"]')
                .value;
            const dompet_id = document.querySelector('select[wire\\:model\\.lazy="dompet_id"]').value;

            const url =
                `/dashboard/chart-data?tanggal_dari=${tanggal_dari}&tanggal_sampai=${tanggal_sampai}&dompet_id=${dompet_id}`;
            const res = await fetch(url);
            const data = await res.json();

            // Chart Transaksi
            if (chartTransaksi) {
                chartTransaksi.data.labels = data.chartData.labels;
                chartTransaksi.data.datasets[0].data = data.chartData.pemasukan;
                chartTransaksi.data.datasets[1].data = data.chartData.pengeluaran;
                chartTransaksi.update();
            } else {
                chartTransaksi = new Chart(chartTransaksiCtx, {
                    type: 'bar',
                    data: {
                        labels: data.chartData.labels,
                        datasets: [{
                                label: 'Pemasukan',
                                data: data.chartData.pemasukan,
                                backgroundColor: 'rgba(16,185,129,0.5)',
                                borderColor: 'rgba(16,185,129,1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Pengeluaran',
                                data: data.chartData.pengeluaran,
                                backgroundColor: 'rgba(239,68,68,0.5)',
                                borderColor: 'rgba(239,68,68,1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Chart Kategori
            if (chartKategori) {
                chartKategori.data.labels = data.kategoriChart.labels;
                chartKategori.data.datasets[0].data = data.kategoriChart.data;
                chartKategori.update();
            } else {
                chartKategori = new Chart(chartKategoriCtx, {
                    type: 'doughnut',
                    data: {
                        labels: data.kategoriChart.labels,
                        datasets: [{
                            label: 'Total per Kategori',
                            data: data.kategoriChart.data,
                            backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        }

        // Load pertama kali
        loadChartData();

        // Update saat filter berubah
        const inputs = document.querySelectorAll('input[wire\\:model\\.lazy], select[wire\\:model\\.lazy]');
        inputs.forEach(el => el.addEventListener('change', loadChartData));

    });
</script>
