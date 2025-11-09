<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;
use App\Models\Dompet;

class SetupController extends Controller
{
    public function storeKategori(Request $request)
    {
        try {
            $data = $request->validate([
                'kategori' => 'required|array',
                'kategori.*.nama' => 'required|string|max:255',
                'kategori.*.type' => 'required|string|max:255',
            ]);

            $userId = Auth::id();
            $saved = [];

            foreach ($data['kategori'] as $kat) {
                $kategori = Kategori::firstOrCreate([
                    'user_id' => $userId,
                    'nama_kategori' => $kat['nama'],
                    'type' => $kat['type'],
                ]);
                $saved[] = $kategori;
            }

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil disimpan!',
                'saved' => $saved,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function storeDompet(Request $request)
    {
        try {
            $data = $request->validate([
                'nama_dompet' => 'required|string|max:255',
            ]);

            $userId = Auth::id();

            $dompet = Dompet::firstOrCreate([
                'user_id' => $userId,
                'nama_dompet' => $data['nama_dompet'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dompet berhasil disimpan!',
                'saved' => $dompet,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
