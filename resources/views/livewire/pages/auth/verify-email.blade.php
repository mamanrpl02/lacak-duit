<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Kirim ulang tautan verifikasi email.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            return;
        }

        Auth::user()->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Logout user dari aplikasi.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="min-h-screen flex items-center justify-center bg-blue-50 p-6">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden w-full max-w-5xl flex flex-col md:flex-row">

        <!-- Kiri: Gambar + Overlay -->
        <div class="hidden md:flex relative w-1/2 bg-cover bg-center"
            style="background-image: url('https://images.pexels.com/photos/1181341/pexels-photo-1181341.jpeg');">
            <div class="absolute inset-0 bg-blue-900/60"></div>
            <div class="relative z-10 flex flex-col justify-center text-white p-10">
                <h1 class="text-3xl font-bold mb-4">Verifikasi Email Anda</h1>
                <p class="text-blue-100 text-lg leading-relaxed">
                    Kami telah mengirimkan tautan verifikasi ke email Anda. Silakan periksa inbox atau folder spam
                    dan klik tautan untuk mengaktifkan akun Anda.
                </p>
            </div>
        </div>

        <!-- Kanan: Konten & Tombol -->
        <div class="p-8 md:w-1/2 flex flex-col justify-center space-y-6 bg-white w-full md:max-w-md mx-auto">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-blue-600">Konfirmasi Email</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Sebelum lanjut, verifikasi dulu alamat email kamu.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm text-center">
                    {{ __('Tautan verifikasi baru telah dikirim ke email Anda.') }}
                </div>
            @endif

            <div class="flex flex-col gap-4 mt-6">
                <x-primary-button
                    wire:click="sendVerification"
                    class="w-full justify-center py-3 rounded-xl text-base font-medium bg-blue-600 hover:bg-blue-700 transition-all duration-200">
                    Kirim Tautan Verifikasi
                </x-primary-button>

                <button wire:click="logout"
                    class="w-full justify-center py-3 rounded-xl text-base font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-200">
                    Keluar
                </button>
            </div>

            <p class="text-center text-sm text-gray-500 mt-6">
                Tidak menerima email? Klik tombol di atas untuk mengirim ulang.
            </p>
        </div>
    </div>
</div>
