<x-app-layout>
  <!-- Header -->
  <div class="flex justify-between items-center mb-8">
    <div>
      <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
      <p class="text-gray-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }} 👋</p>
    </div>
    <div>
      <a
        href="{{ route('transaksi') }}"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md"
      >
        + Tambah Transaksi
      </a>
    </div>
  </div>

  <!-- Statistik -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
      <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">Saldo Dompet</h2>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3m0 0a3 3 0 006 0m-6 0v3m6-3v3m-9 4h12a2 2 0 002-2V9a2 2 0 00-2-2H7l-2 2v10a2 2 0 002 2z" />
        </svg>
      </div>
      <p class="mt-4 text-3xl font-bold text-blue-600">Rp 2.150.000</p>
      <p class="text-sm text-gray-400 mt-1">Total saldo aktif</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
      <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">Pemasukan Bulan Ini</h2>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m0 0l-3-3m3 3l3-3m6-5a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <p class="mt-4 text-3xl font-bold text-green-600">Rp 500.000</p>
      <p class="text-sm text-gray-400 mt-1">Naik 8% dari bulan lalu</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
      <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">Pengeluaran Bulan Ini</h2>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V8m0 0l3 3m-3-3l-3 3m-6 5a9 9 0 1118 0 9 9 0 01-18 0z" />
        </svg>
      </div>
      <p class="mt-4 text-3xl font-bold text-red-500">Rp 300.000</p>
      <p class="text-sm text-gray-400 mt-1">Turun 12% dari bulan lalu</p>
    </div>
  </div>

  <!-- Grafik & Aktivitas -->
  <div class="grid md:grid-cols-2 gap-6 mt-10">
    <!-- Grafik -->
    <div class="bg-white p-6 rounded-2xl shadow">
      <h3 class="font-semibold text-gray-700 mb-4">Statistik Bulanan</h3>
      <canvas id="chartTransaksi" height="180"></canvas>
    </div>

    <!-- Aktivitas Terakhir -->
    <div class="bg-white p-6 rounded-2xl shadow">
      <h3 class="font-semibold text-gray-700 mb-4">Aktivitas Terbaru</h3>
      <ul class="divide-y divide-gray-100">
        <li class="py-3 flex justify-between items-center">
          <span class="text-gray-600">Top up saldo</span>
          <span class="text-green-600 font-semibold">+Rp 100.000</span>
        </li>
        <li class="py-3 flex justify-between items-center">
          <span class="text-gray-600">Beli alat tulis</span>
          <span class="text-red-600 font-semibold">-Rp 35.000</span>
        </li>
        <li class="py-3 flex justify-between items-center">
          <span class="text-gray-600">Bayar kas kelas</span>
          <span class="text-red-600 font-semibold">-Rp 10.000</span>
        </li>
        <li class="py-3 flex justify-between items-center">
          <span class="text-gray-600">Terima donasi</span>
          <span class="text-green-600 font-semibold">+Rp 50.000</span>
        </li>
      </ul>
    </div>
  </div>

  <!-- Chart Script -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('chartTransaksi');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        datasets: [{
          label: 'Pemasukan',
          data: [400, 500, 350, 600, 700, 500],
          borderColor: '#22c55e',
          fill: false,
          tension: 0.3
        }, {
          label: 'Pengeluaran',
          data: [300, 450, 500, 400, 600, 350],
          borderColor: '#ef4444',
          fill: false,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
      }
    });
  </script>
</x-app-layout>
