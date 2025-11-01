<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        event(new Registered(($user = User::create($validated))));
        Auth::login($user);
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
};
?>

<div class="min-h-screen flex items-center justify-center bg-blue-50 p-4 sm:p-6">
    <div
        class="bg-white shadow-lg rounded-2xl overflow-hidden w-full max-w-lg sm:max-w-2xl md:max-w-5xl flex flex-col md:flex-row">

        <!-- Sisi Kiri - Gambar + Overlay -->
        <div class="hidden md:flex relative w-1/2 bg-cover bg-center"
            style="background-image: url('https://images.pexels.com/photos/887751/pexels-photo-887751.jpeg');">
            <div class="absolute inset-0 bg-blue-900/60"></div>
            <div class="relative z-10 flex flex-col justify-center text-white p-10">
                <h1 class="text-3xl font-bold mb-4">Buat Akun Baru 🚀</h1>
                <p class="text-blue-100 text-lg leading-relaxed">
                    Daftar sekarang dan mulai kelola keuanganmu lebih rapi dan efisien!
                </p>
            </div>
        </div>

        <!-- Sisi Kanan - Form Register -->
        <div class="p-6 sm:p-8 md:w-1/2 flex flex-col justify-center space-y-6 bg-white w-full">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-blue-600">Daftar Akun</h2>
                <p class="text-sm text-gray-500 mt-1">Isi data berikut untuk membuat akun baru</p>
            </div>

            <a href="/auth/google/redirect"
                class="w-full flex items-center justify-center gap-x-3 py-3 px-4 text-sm font-medium rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                Daftar dengan Google
            </a>

            <div class="flex items-center my-5">
                <div class="flex-1 border-t border-gray-200"></div>
                <span class="mx-3 text-xs text-gray-400 uppercase">atau</span>
                <div class="flex-1 border-t border-gray-200"></div>
            </div>

            <form wire:submit.prevent="register" class="space-y-4">
                <div>
                    <x-input-label for="name" value="Nama Lengkap" />
                    <x-text-input wire:model="name" id="name" type="text"
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" type="email"
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <div class="relative">
                    <x-input-label for="password" value="Kata Sandi" />
                    <x-text-input wire:model="password" id="password" type="password"
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-10"
                        required />
                    <button type="button" id="togglePasswordReg"
                        class="absolute right-3 top-10 text-gray-500 hover:text-blue-600">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                <div>
                    <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password"
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>

                <x-primary-button
                    class="w-full justify-center py-3 rounded-xl text-base font-medium mt-3 bg-blue-600 hover:bg-blue-700">
                    Daftar Sekarang
                </x-primary-button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" wire:navigate class="text-blue-600 font-medium hover:underline">
                    Masuk Sekarang
                </a>
            </p>
        </div>
    </div>
</div>


<script>
    document.getElementById('togglePasswordReg').addEventListener('click', function() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    });
</script>
