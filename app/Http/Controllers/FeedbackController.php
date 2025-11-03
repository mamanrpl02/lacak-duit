<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'feedback' => 'required|string|max:1000',
        ]);

        // 🧠 Batas 5 feedback per bulan per user
        $userId = auth()->id();
        $bulanIni = Carbon::now()->startOfMonth();
        $jumlahFeedback = Feedback::where('user_id', $userId)
            ->where('created_at', '>=', $bulanIni)
            ->count();

        if ($jumlahFeedback >= 5) {
            return redirect()
                ->back()
                ->with('error', 'Kamu sudah mencapai batas maksimal 5 feedback bulan ini, Tunggu lagi bulan depan ya! ');
        }

        // 📝 Simpan ke database
        Feedback::create([
            'user_id' => $userId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'feedback' => $validated['feedback'],
        ]);

        // 📤 Kirim ke Google Sheets
        try {
            $url = env('GOOGLE_SHEET_WEBHOOK');

            Http::withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'feedback' => $validated['feedback'],
                ]);
        } catch (\Exception $e) {
            Log::error('Gagal kirim ke Google Sheet: ' . $e->getMessage());
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Terima kasih! Feedback kamu sudah dikirim');
    }
}
