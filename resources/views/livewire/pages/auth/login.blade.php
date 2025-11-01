<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
};
?>

<div class="min-h-screen flex items-center justify-center bg-blue-50 p-6">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden w-full max-w-5xl flex flex-col md:flex-row">

        <!-- Sisi Kiri - Gambar + Overlay -->
        <div class="hidden md:flex relative w-1/2 bg-cover bg-center"
            style="background-image: url('https://images.pexels.com/photos/8052293/pexels-photo-8052293.jpeg');">
            <div class="absolute inset-0 bg-blue-900/60"></div>
            <div class="relative z-10 flex flex-col justify-center text-white p-10">
                <h1 class="text-3xl font-bold mb-4">Selamat Datang Kembali 👋</h1>
                <p class="text-blue-100 text-lg leading-relaxed">
                    Masuk ke akunmu untuk mengelola dan memantau keuangan dengan mudah.
                </p>
            </div>
        </div>

        <!-- Sisi Kanan - Form Login -->
        <div class="p-8 md:w-1/2 flex flex-col justify-center space-y-6 bg-white w-full md:max-w-md mx-auto">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-blue-600">Masuk Akun</h2>
                <p class="text-sm text-gray-500 mt-1">Gunakan email atau Google untuk melanjutkan</p>
            </div>

            <!-- Tombol Google -->
            <a href="/auth/google/redirect"
                class="w-full flex items-center justify-center gap-x-3 py-3 px-4 text-sm font-medium rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                Masuk dengan Google
            </a>

            <div class="flex items-center my-5">
                <div class="flex-1 border-t border-gray-200"></div>
                <span class="mx-3 text-xs text-gray-400 uppercase">atau</span>
                <div class="flex-1 border-t border-gray-200"></div>
            </div>

            <form wire:submit="login" class="space-y-4">
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="form.email" id="email" type="email"
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <div class="relative">
                    <x-input-label for="password" value="Kata Sandi" />
                    <x-text-input wire:model="form.password" id="password" type="password"
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-10"
                        required autocomplete="current-password" />
                    <button type="button" id="togglePassword"
                        class="absolute right-3 top-10 text-gray-500 hover:text-blue-600">
                        <i class="bi bi-eye"></i>
                    </button>
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label for="remember" class="flex items-center gap-2 text-gray-600">
                        <input wire:model="form.remember" id="remember" type="checkbox"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" wire:navigate
                            class="text-blue-600 hover:text-blue-500 transition-colors">Lupa password?</a>
                    @endif
                </div>

                <x-primary-button
                    class="w-full justify-center py-3 rounded-xl text-base font-medium mt-3 bg-blue-600 hover:bg-blue-700">
                    Masuk Sekarang
                </x-primary-button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" wire:navigate class="text-blue-600 font-medium hover:underline">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });
</script>
