<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function chartData(Request $request)
    {
        $tanggal_dari = $request->tanggal_dari ?? now()->startOfMonth()->format('Y-m-d');
        $tanggal_sampai = $request->tanggal_sampai ?? now()->endOfMonth()->format('Y-m-d');
        $dompet_id = $request->dompet_id;

        $query = Transaksi::where('user_id', Auth::id())
            ->whereBetween('tanggal', [$tanggal_dari, $tanggal_sampai]);

        if ($dompet_id) {
            $query->where(function ($q) use ($dompet_id) {
                $q->where('dompet_asal_id', $dompet_id)
                  ->orWhere('dompet_tujuan_id', $dompet_id);
            });
        }

        $transaksis = $query->get();

        // Chart Bulanan
        $grouped = $transaksis->groupBy(function($item){
            return Carbon::parse($item->tanggal)->format('M Y');
        });

        $chartData = [
            'labels' => $grouped->keys()->toArray(),
            'pemasukan' => $grouped->map(fn($g) => $g->where('status','Masuk')->sum('nominal'))->values()->toArray(),
            'pengeluaran' => $grouped->map(fn($g) => $g->where('status','Keluar')->sum('nominal'))->values()->toArray(),
            'withdraw' => $grouped->map(fn($g) => $g->where('status','Withdraw')->sum('nominal'))->values()->toArray(),
        ];

        // Chart Kategori
        $kategoriGroup = $transaksis->groupBy('kategori_id');
        $kategoriChart = [
            'labels' => $kategoriGroup->keys()->map(fn($id) => optional(Kategori::find($id))->nama_kategori ?? 'Tanpa Kategori')->toArray(),
            'data' => $kategoriGroup->map(fn($g) => $g->sum('nominal'))->values()->toArray(),
        ];

        return response()->json([
            'chartData' => $chartData,
            'kategoriChart' => $kategoriChart
        ]);
    }
}
