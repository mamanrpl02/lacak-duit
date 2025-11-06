<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Dompet;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $tanggal_dari;
    public $tanggal_sampai;
    public $dompet_id;

    public $pemasukan = 0;
    public $pengeluaran = 0;
    public $withdraw = 0;
    public $saldo = 0;

    public $chartData = [];
    public $kategoriChart = [];

    public function mount()
    {
        // Default periode: bulan ini
        $this->tanggal_dari = now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_sampai = now()->endOfMonth()->format('Y-m-d');
        $this->loadData();
    }

    public function updated($property)
    {
        // Muat ulang data setiap filter berubah
        $this->loadData();
        $this->dispatch('refreshCharts', $this->chartData, $this->kategoriChart);
    }

    private function loadData()
    {
        $query = Transaksi::where('user_id', Auth::id())
            ->whereBetween('tanggal', [$this->tanggal_dari, $this->tanggal_sampai]);

        // Filter dompet (asal atau tujuan)
        if ($this->dompet_id) {
            $query->where(function ($q) {
                $q->where('dompet_asal_id', $this->dompet_id)
                  ->orWhere('dompet_tujuan_id', $this->dompet_id);
            });
        }

        $transaksis = $query->get();

        // Hitung total per jenis transaksi
        $this->pemasukan = $transaksis->where('status', 'Masuk')->sum('nominal');
        $this->pengeluaran = $transaksis->where('status', 'Keluar')->sum('nominal');
        $this->withdraw = $transaksis->where('status', 'Withdraw')->sum('nominal');

        // Saldo akhir = pemasukan - pengeluaran (withdraw sudah tercatat di dompet asal & tujuan)
        $this->saldo = $this->pemasukan - $this->pengeluaran;

        // === Chart Bulanan ===
        $grouped = $transaksis->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('M Y');
        });

        $this->chartData = [
            'labels' => $grouped->keys()->toArray(),
            'pemasukan' => $grouped->map(fn($g) => $g->where('status', 'Masuk')->sum('nominal'))->values()->toArray(),
            'pengeluaran' => $grouped->map(fn($g) => $g->where('status', 'Keluar')->sum('nominal'))->values()->toArray(),
            'withdraw' => $grouped->map(fn($g) => $g->where('status', 'Withdraw')->sum('nominal'))->values()->toArray(),
        ];

        // === Chart Kategori ===
        $kategoriGroup = $transaksis->groupBy('kategori_id');
        $this->kategoriChart = [
            'labels' => $kategoriGroup->keys()->map(fn($id) =>
                optional(Kategori::find($id))->nama_kategori ?? 'Tanpa Kategori'
            )->toArray(),
            'data' => $kategoriGroup->map(fn($g) => $g->sum('nominal'))->values()->toArray(),
        ];
    }

    /**
     * Fungsi membuat Withdraw
     */
    public function buatWithdraw($asalId, $tujuanId, $nominal, $keterangan = null)
    {
        $asal = Dompet::findOrFail($asalId);
        $tujuan = Dompet::findOrFail($tujuanId);

        if ($asal->saldo < $nominal) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Saldo dompet asal tidak cukup.']);
            return;
        }

        // Update saldo dompet
        $asal->saldo -= $nominal;
        $tujuan->saldo += $nominal;
        $asal->save();
        $tujuan->save();

        // Buat transaksi withdraw
        Transaksi::create([
            'keterangan' => $keterangan ?? "Withdraw dari {$asal->nama_dompet} ke {$tujuan->nama_dompet}",
            'nominal' => $nominal,
            'status' => 'Withdraw',
            'dompet_asal_id' => $asalId,
            'dompet_tujuan_id' => $tujuanId,
            'user_id' => Auth::id(),
            'kategori_id' => null,
            'tanggal' => now(),
        ]);

        // Reload data
        $this->loadData();

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Withdraw berhasil.']);
    }

    public function render()
    {
        $dompetList = Dompet::where('user_id', Auth::id())->pluck('nama_dompet', 'id');

        return view('livewire.dashboard', [
            'chartData' => $this->chartData,
            'kategoriChart' => $this->kategoriChart,
            'dompetList' => $dompetList,
        ]);
    }
}
