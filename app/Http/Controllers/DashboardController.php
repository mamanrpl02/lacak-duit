<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Dompet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $selectedDompet = $request->get('dompet'); // dompet yang dipilih dari dropdown

        $query = Transaksi::where('user_id', Auth::id())
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun);

        if ($selectedDompet) {
            $query->where(function ($q) use ($selectedDompet) {
                $q->where('dompet_asal_id', $selectedDompet)
                  ->orWhere('dompet_tujuan_id', $selectedDompet);
            });
        }

        $transaksis = $query->get();

        // 💰 Hitung saldo semua dompet (berdasarkan transaksi)
        $dompetSaldos = Dompet::select('id', 'nama_dompet')
            ->withSum(['transaksiAsal as keluar' => function ($q) {
                $q->where('status', 'Keluar')
                  ->orWhere('status', 'Withdraw');
            }], 'nominal')
            ->withSum(['transaksiTujuan as masuk' => function ($q) {
                $q->where('status', 'Masuk')
                  ->orWhere('status', 'Withdraw');
            }], 'nominal')
            ->get()
            ->map(function ($d) {
                $d->saldo = ($d->masuk ?? 0) - ($d->keluar ?? 0);
                return $d;
            });

        // Total saldo aktif (semua dompet)
        $totalSaldo = $dompetSaldos->sum('saldo');

        // Pemasukan & pengeluaran bulan ini
        $pemasukan = $transaksis->where('status', 'Masuk')->sum('nominal');
        $pengeluaran = $transaksis->where('status', 'Keluar')->sum('nominal');

        // 📊 Chart kategori (bulan ini)
        $chartKategori = Transaksi::select('kategori_id', DB::raw('SUM(nominal) as total'))
            ->where('user_id', Auth::id())
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get();

        // Ambil 1 kategori paling tinggi bulan ini
        $kategoriTeratas = $chartKategori->sortByDesc('total')->first();

        return view('dashboard', compact(
            'bulan',
            'tahun',
            'transaksis',
            'totalSaldo',
            'pemasukan',
            'pengeluaran',
            'chartKategori',
            'dompetSaldos',
            'kategoriTeratas',
            'selectedDompet'
        ));
    }
}
