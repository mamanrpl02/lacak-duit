<div>
    <!-- 🔍 Filter -->
    <div class="bg-white p-4 rounded-2xl shadow mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full md:w-auto">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Dari Tanggal</label>
                <input wire:model="tanggal_dari" type="date"
                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Sampai Tanggal</label>
                <input wire:model="tanggal_sampai" type="date"
                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Pilih Dompet</label>
                <select wire:model="dompet"
                    class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="semua">Semua</option>
                    @foreach ($dompets as $d)
                        <option value="{{ $d->id }}">{{ $d->nama_dompet }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button wire:click="$refresh"
            class="mt-2 md:mt-0 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
            Terapkan
        </button>
    </div>

    <!-- 💰 Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-gray-700">Saldo Dompet</h2>
            <p class="mt-4 text-3xl font-bold text-blue-600">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-gray-700">Pemasukan</h2>
            <p class="mt-4 text-3xl font-bold text-green-600">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-gray-700">Pengeluaran</h2>
            <p class="mt-4 text-3xl font-bold text-red-500">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- 📊 Chart -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold text-gray-700 mb-4">Grafik Pemasukan & Pengeluaran</h3>
            <canvas id="chartTransaksi"></canvas>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold text-gray-700 mb-4">Kategori Terbanyak</h3>
            <canvas id="chartKategori"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', () => {
            Livewire.hook('message.processed', () => {
                const chartData = @json($chartData);
                const kategoriChart = @json($kategoriChart);

                const ctx1 = document.getElementById('chartTransaksi');
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                                label: 'Pemasukan',
                                data: chartData.pemasukan,
                                borderColor: '#22c55e',
                                fill: false,
                                tension: 0.3
                            },
                            {
                                label: 'Pengeluaran',
                                data: chartData.pengeluaran,
                                borderColor: '#ef4444',
                                fill: false,
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true
                    }
                });

                const ctx2 = document.getElementById('chartKategori');
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(kategoriChart),
                        datasets: [{
                            data: Object.values(kategoriChart),
                            backgroundColor: ['#3b82f6', '#22c55e', '#ef4444', '#f59e0b',
                                '#8b5cf6'
                            ],
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            });
        });
    </script>
</div>
