<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', __($status));
    }
}; ?>

<div class="min-h-screen flex items-center justify-center bg-blue-50 p-6">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden w-full max-w-5xl flex flex-col md:flex-row">

        <!-- Sisi Kiri - Gambar + Overlay -->
        <div class="hidden md:flex relative w-1/2 bg-cover bg-center"
            style="background-image: url('https://images.pexels.com/photos/10774600/pexels-photo-10774600.jpeg');">
            <div class="absolute inset-0 bg-blue-900/60"></div>
            <div class="relative z-10 flex flex-col justify-center text-white p-10">
                <h1 class="text-3xl font-bold mb-4">Lupa Kata Sandi?</h1>
                <p class="text-blue-100 text-lg leading-relaxed">
                    Masukkan email Anda untuk menerima tautan reset password. Kami akan bantu Anda mengatur ulang
                    kata sandi dengan mudah.
                </p>
            </div>
        </div>

        <!-- Sisi Kanan - Form -->
        <div class="p-8 md:w-1/2 flex flex-col justify-center space-y-6 bg-white w-full md:max-w-md mx-auto">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-blue-600">Atur Ulang Kata Sandi</h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan email Anda untuk menerima tautan reset password</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="sendPasswordResetLink" class="space-y-4">
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" type="email"
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <x-primary-button
                    class="w-full justify-center py-3 rounded-xl text-base font-medium mt-3 bg-blue-600 hover:bg-blue-700">
                    Kirim Tautan Reset Password
                </x-primary-button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                <a href="{{ route('login') }}" wire:navigate class="text-blue-600 font-medium hover:underline">
                    Kembali ke halaman login
                </a>
            </p>
        </div>
    </div>
</div>
