<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Dompet;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        $this->tanggal_dari = now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_sampai = now()->endOfMonth()->format('Y-m-d');
        $this->loadData();
    }

    public function updated($property)
    {
        $this->loadData();
        $this->dispatch('refreshCharts', $this->chartData, $this->kategoriChart);
    }

    private function loadData()
    {
        $query = Transaksi::where('user_id', Auth::id())
            ->whereBetween('tanggal', [$this->tanggal_dari, $this->tanggal_sampai]);

        $transaksis = $query->get();
        $dompetId = $this->dompet_id ? (int)$this->dompet_id : null;

        Log::debug('=== LOAD DATA DASHBOARD ===', [
            'dompet_id' => $dompetId,
            'tanggal_dari' => $this->tanggal_dari,
            'tanggal_sampai' => $this->tanggal_sampai,
            'total_transaksi' => $transaksis->count(),
        ]);

        if ($dompetId) {
            // === Filter berdasarkan dompet aktif ===
            $this->pemasukan = $transaksis
                ->filter(
                    fn($t) => ($t->status === 'Masuk' && (int)$t->dompet_asal_id === $dompetId) ||
                        ($t->status === 'Withdraw' && (int)$t->dompet_tujuan_id === $dompetId)
                )
                ->sum('nominal');

            $this->pengeluaran = $transaksis
                ->filter(
                    fn($t) => ($t->status === 'Keluar' && (int)$t->dompet_asal_id === $dompetId) ||
                        ($t->status === 'Withdraw' && (int)$t->dompet_asal_id === $dompetId)
                )
                ->sum('nominal');

            $this->withdraw = $transaksis
                ->filter(
                    fn($t) =>
                    $t->status === 'Withdraw' &&
                        ((int)$t->dompet_asal_id === $dompetId || (int)$t->dompet_tujuan_id === $dompetId)
                )
                ->sum('nominal');

            $this->saldo = $this->pemasukan - $this->pengeluaran;
        } else {
            // === Semua dompet (global) ===
            $this->pemasukan = $transaksis->where('status', 'Masuk')->sum('nominal');
            $this->pengeluaran = $transaksis->where('status', 'Keluar')->sum('nominal');
            $this->withdraw = $transaksis->where('status', 'Withdraw')->sum('nominal');
            $this->saldo = $this->pemasukan - $this->pengeluaran;
        }

        // === Chart Bulanan ===
        $grouped = $transaksis->groupBy(fn($item) => Carbon::parse($item->tanggal)->format('M Y'));
        $this->chartData = [
            'labels' => $grouped->keys()->toArray(),
            'pemasukan' => $grouped->map(fn($g) => $g->where('status', 'Masuk')->sum('nominal'))->values()->toArray(),
            'pengeluaran' => $grouped->map(fn($g) => $g->where('status', 'Keluar')->sum('nominal'))->values()->toArray(),
            'withdraw' => $grouped->map(fn($g) => $g->where('status', 'Withdraw')->sum('nominal'))->values()->toArray(),
        ];

        // === Chart Kategori ===
        $kategoriGroup = $transaksis->groupBy('kategori_id');
        $this->kategoriChart = [
            'labels' => $kategoriGroup->keys()->map(
                fn($id) => optional(Kategori::find($id))->nama_kategori ?? 'Tanpa Kategori'
            )->toArray(),
            'data' => $kategoriGroup->map(fn($g) => $g->sum('nominal'))->values()->toArray(),
        ];

        Log::debug('HASIL PERHITUNGAN', [
            'pemasukan' => $this->pemasukan,
            'pengeluaran' => $this->pengeluaran,
            'withdraw' => $this->withdraw,
            'saldo' => $this->saldo,
        ]);
    }

    // === Fungsi Withdraw ===
    public function buatWithdraw($asalId, $tujuanId, $nominal, $keterangan = null)
    {
        $asal = Dompet::findOrFail($asalId);
        $tujuan = Dompet::findOrFail($tujuanId);

        $saldoAsal = $this->hitungSaldoDompet($asalId);

        if ($saldoAsal < $nominal) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Saldo dompet asal tidak cukup.']);
            return;
        }

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

        $this->loadData();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Withdraw berhasil.']);
    }

    // === Hitung saldo dompet spesifik ===
    private function hitungSaldoDompet($dompetId)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->get();

        $pemasukan = $transaksi
            ->where('status', 'Masuk')
            ->where('dompet_tujuan_id', $dompetId)
            ->sum('nominal');

        $pengeluaran = $transaksi
            ->where('status', 'Keluar')
            ->where('dompet_asal_id', $dompetId)
            ->sum('nominal');

        $withdrawKeluar = $transaksi
            ->where('status', 'Withdraw')
            ->where('dompet_asal_id', $dompetId)
            ->sum('nominal');

        $withdrawMasuk = $transaksi
            ->where('status', 'Withdraw')
            ->where('dompet_tujuan_id', $dompetId)
            ->sum('nominal');

        return $pemasukan + $withdrawMasuk - $pengeluaran - $withdrawKeluar;
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
