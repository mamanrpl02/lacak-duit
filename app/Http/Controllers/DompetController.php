<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dompet;
use Illuminate\Support\Facades\Auth;

class DompetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_dompet' => 'required|string|max:255',
        ]);

        $dompet = Dompet::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'nama_dompet' => $request->nama_dompet
            ]
        );

        return response()->json([
            'success' => true,
            'dompet' => $dompet
        ]);
    }

    public function check()
    {
        $hasDompet = Dompet::where('user_id', Auth::id())->exists();
        return response()->json(['hasDompet' => $hasDompet]);
    }
}
