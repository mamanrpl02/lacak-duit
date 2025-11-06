<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-gray-600 text-sm">Total Saldo</h2>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($totalSaldo) }}</p>
    </div>
    <div class="bg-green-100 p-4 rounded-lg shadow">
        <h2 class="text-gray-600 text-sm">Pemasukan</h2>
        <p class="text-2xl font-bold text-green-600">{{ number_format($pemasukan) }}</p>
    </div>
    <div class="bg-red-100 p-4 rounded-lg shadow">
        <h2 class="text-gray-600 text-sm">Pengeluaran</h2>
        <p class="text-2xl font-bold text-red-600">{{ number_format($pengeluaran) }}</p>
    </div>
</div>
