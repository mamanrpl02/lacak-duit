<?php

use App\Models\User;
use Laravel\Socialite\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;



Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


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
        'email' => $googleUser->email,
        'google_token' => $googleUser->token,
        'google_refresh_token' => $googleUser->refreshToken,
        'password' => Hash::make('password')
    ]);

    Auth::login($user);

    return redirect('/dashboard');
});



// Middleware auth agar hanya user login yang bisa akses dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/transaksi', function () {
        return view('transaksi');
    })->name('transaksi');

    Route::get('/dompet', function () {
        return view('dompet');
    })->name('dompet');

    Route::get('/kategori', function () {
        return view('kategori');
    })->name('kategori');

    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    
});




Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');



require __DIR__ . '/auth.php';
