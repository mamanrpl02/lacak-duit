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

        <!-- Gambar Kiri -->
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

        <!-- Form -->
        <div class="p-8 md:w-1/2 flex flex-col justify-center space-y-6 bg-white w-full md:max-w-md mx-auto">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-blue-600">Atur Ulang Kata Sandi</h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan email Anda untuk menerima tautan reset password</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit.prevent="sendPasswordResetLink" class="space-y-4">
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" type="email"
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full justify-center py-3 rounded-xl text-base font-medium mt-3 bg-blue-600 hover:bg-blue-700 text-white flex items-center">
                    <span wire:loading.remove>Kirim Tautan Reset Password</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="w-5 h-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 100 16v-4l3 3-3 3v-4a8 8 0 01-8-8z">
                            </path>
                        </svg>
                    </span>
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                <a href="{{ route('login') }}" wire:navigate class="text-blue-600 font-medium hover:underline">
                    Kembali ke halaman login
                </a>
            </p>
        </div>
    </div>
</div>

<!-- Tambahkan ini di bawah -->
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('reset-link-sent', () => {
            Swal.fire({
                icon: 'success',
                title: 'Email Terkirim!',
                text: 'Tautan reset kata sandi telah dikirim ke email Anda.',
                confirmButtonColor: '#2563eb'
            })
        })
    </script>
@endpush
