<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

// Halaman utama
Route::view('/', 'welcome');

// Google Login
Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')
        ->with(['prompt' => 'select_account'])
        ->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
        'google_id' => $googleUser->id,
        'email' => $googleUser->email,
    ], [
        'name' => $googleUser->name,
        'google_token' => $googleUser->token,
        'google_refresh_token' => $googleUser->refreshToken,
        'password' => Hash::make('password')
    ]);

    Auth::login($user);

    return redirect()->route('dashboard');
});

// Semua halaman di bawah hanya bisa diakses oleh user login
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Transaksi
    Route::view('/transaksi', 'transaksi')->name('transaksi');

    // Dompet
    Route::view('/dompet', 'dompet')->name('dompet');

    // Feedback
    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    // Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');

    Route::get('/kategori', function () {
        return view('kategori');
    })->name('kategori');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__ . '/auth.php';
