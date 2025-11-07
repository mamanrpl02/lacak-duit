<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // 👈 Tambahkan ini

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'feedback' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'feedback.required' => 'Pesan feedback tidak boleh kosong.',
            'rating.required' => 'Silakan pilih rating terlebih dahulu.',
        ]);

        $user = Auth::user();

        // Batasi 5 feedback per bulan
        $feedbackCountThisMonth = Feedback::where('user_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        if ($feedbackCountThisMonth >= 5) {
            return response()->json([
                'error' => 'Kamu sudah mencapai batas maksimal 5 feedback dalam bulan ini. Terima kasih atas partisipasinya!'
            ], 400);
        }

        // Simpan ke database
        $feedback = Feedback::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'feedback' => $validated['feedback'],
            'rating' => $validated['rating'],
        ]);

        // Kirim ke Google Spreadsheet (pakai JSON)
        try {
            Http::asJson()->post('https://script.google.com/macros/s/AKfycbxHaAANZSRqlKCic5RkbXMxxytnXaDTdxektqeFjNdP7424_cy_X_TA3M6Tmd_U5BU/exec', [
                'name' => $feedback->name,
                'email' => $feedback->email,
                'rating' => $feedback->rating, // 💛 akan terbaca karena dikirim sebagai JSON
                'feedback' => $feedback->feedback,
                'created_at' => $feedback->created_at->toDateTimeString(), // opsional tapi berguna
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal kirim ke Spreadsheet: ' . $e->getMessage());
        }

        return response()->json(['message' => 'Feedback berhasil dikirim!']);
    }
}
