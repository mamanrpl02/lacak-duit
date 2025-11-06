<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Dompet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $dompet = 'semua';
    public $tanggal_dari;
    public $tanggal_sampai;

    public function mount()
    {
        $this->tanggal_dari = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_sampai = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $query = Transaksi::with(['kategori', 'user'])
            ->where('user_id', Auth::id())
            ->whereBetween('created_at', [$this->tanggal_dari, $this->tanggal_sampai]);

        if ($this->dompet !== 'semua') {
            $query->where(function ($q) {
                $q->where('dompet_asal_id', $this->dompet)
                    ->orWhere('dompet_tujuan_id', $this->dompet);
            });
        }

        $transaksis = $query->get();

        $saldo = $this->hitungSaldo($transaksis);
        $pemasukan = $transaksis->where('status', 'Masuk')->sum('nominal');
        $pengeluaran = $transaksis->where('status', 'Keluar')->sum('nominal');

        $chartData = $this->getChartData($transaksis);
        $kategoriChart = $this->getKategoriChart($transaksis);
        $dompets = Dompet::all();

        return view('livewire.dashboard', [
            'saldo' => $saldo,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'chartData' => $chartData,
            'kategoriChart' => $kategoriChart,
            'dompets' => $dompets,
        ]);
    }

    private function hitungSaldo($transaksis)
    {
        $masuk = $transaksis->where('status', 'Masuk')->sum('nominal');
        $keluar = $transaksis->where('status', 'Keluar')->sum('nominal');
        return $masuk - $keluar;
    }

    private function getChartData($transaksis)
    {
        $bulan = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->shortMonthName);
        $pemasukan = [];
        $pengeluaran = [];

        foreach (range(1, 12) as $m) {
            $pemasukan[] = $transaksis->where('status', 'Masuk')->filter(fn($t) => Carbon::parse($t->created_at)->month == $m)->sum('nominal');
            $pengeluaran[] = $transaksis->where('status', 'Keluar')->filter(fn($t) => Carbon::parse($t->created_at)->month == $m)->sum('nominal');
        }

        return [
            'labels' => $bulan,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
        ];
    }

    private function getKategoriChart($transaksis)
    {
        return $transaksis->groupBy('kategori.nama_kategori')->map(fn($items) => $items->sum('nominal'));
    }
}
