<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|array',
            'kategori.*.nama' => 'required|string|max:255',
            'kategori.*.tipe' => 'required|string|in:Pengeluaran,Pemasukan,Switch Saldo',
        ]);

        $userId = Auth::id();
        $savedKategori = [];

        foreach ($request->kategori as $kat) {
            $kategori = Kategori::firstOrCreate(
                [
                    'user_id' => $userId,
                    'nama_kategori' => $kat['nama'],
                ],
                [
                    'tipe' => $kat['tipe']
                ]
            );
            $savedKategori[] = $kategori;
        }

        return response()->json([
            'success' => true,
            'saved' => $savedKategori
        ]);
    }
}
