<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Dashboard;



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
    Route::get('/dashboard', function () {
        return view('dashboard'); // memanggil blade yang berisi <x-app-layout><livewire:dashboard/></x-app-layout>
    })->middleware('auth')->name('dashboard');

    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart-data');


    // Transaksi
    Route::get('/transaksi', function () {
        return view('transaksi');
    })->name('transaksi');


    // Dompet
    Route::get('/dompet', function () {
        return view('dompet');
    })->name('dompet');


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
