<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Dompet;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $userId = auth()->id();
            $hasDompet = \App\Models\Dompet::where('user_id', $userId)->exists();
            $hasKategori = \App\Models\Kategori::where('user_id', $userId)->exists();

            $view->with([
                'showSetupModal' => !$hasDompet || !$hasKategori,
                'hasDompet' => $hasDompet,
                'hasKategori' => $hasKategori
            ]);
        });
    }
}
