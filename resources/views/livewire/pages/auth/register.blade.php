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

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-green-100 p-6">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden w-full max-w-5xl flex flex-col md:flex-row">
        <!-- Sisi Kiri - Deskripsi -->
        <div class="hidden md:flex relative w-1/2 bg-cover bg-center"
            style="background-image: url('https://images.pexels.com/photos/8052293/pexels-photo-8052293.jpeg');">
            <div class="absolute inset-0 bg-gray-900/60"></div>
            <div class="relative z-10 flex flex-col justify-center text-white p-10">
                <h1 class="text-3xl font-bold mb-4">Selamat Datang Kembali 👋</h1>
                <p class="text-green-100 text-lg leading-relaxed">
                    Masuk ke akunmu untuk mengelola dan memantau keuangan dengan mudah.
                </p>
            </div>
        </div>

        <!-- Sisi Kanan - Form Register -->
        <div class="p-8 md:w-1/2 flex flex-col justify-center space-y-6">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-green-600">Daftar Akun</h2>
                <p class="text-sm text-gray-500 mt-1">Isi data dengan benar untuk membuat akun baru</p>
            </div>

            <a href="/auth/google/redirect"
                class="w-full flex items-center justify-center gap-x-3 py-3 px-4 text-sm font-medium rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                <svg class="w-5 h-auto" width="46" height="47" viewBox="0 0 46 47" fill="none">
                    <path
                        d="M46 24.0287C46 22.09 45.8533 20.68 45.5013 19.2112H23.4694V27.9356H36.4069C36.1429 30.1094 34.7347 33.37 31.5957 35.5731L31.5663 35.8669L38.5191 41.2719L38.9885 41.3306C43.4477 37.2181 46 31.1669 46 24.0287Z"
                        fill="#4285F4" />
                    <path
                        d="M23.4694 47C29.8061 47 35.1161 44.9144 39.0179 41.3012L31.625 35.5437C29.6301 36.9244 26.9898 37.8937 23.4987 37.8937C17.2793 37.8937 12.0281 33.7812 10.1505 28.1412L9.88649 28.1706L2.61097 33.7812L2.52296 34.0456C6.36608 41.7125 14.287 47 23.4694 47Z"
                        fill="#34A853" />
                    <path
                        d="M10.1212 28.1413C9.62245 26.6725 9.32908 25.1156 9.32908 23.5C9.32908 21.8844 9.62245 20.3275 10.0918 18.8588V18.5356L2.75765 12.8369L2.52296 12.9544C0.909439 16.1269 0 19.7106 0 23.5C0 27.2894 0.909439 30.8731 2.49362 34.0456L10.1212 28.1413Z"
                        fill="#FBBC05" />
                    <path
                        d="M23.4694 9.07688C27.8699 9.07688 30.8622 10.9863 32.5344 12.5725L39.1645 6.11C35.0867 2.32063 29.8061 0 23.4694 0C14.287 0 6.36607 5.2875 2.49362 12.9544L10.0918 18.8588C11.9987 13.1894 17.25 9.07688 23.4694 9.07688Z"
                        fill="#EB4335" />
                </svg>
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
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                        required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" type="email"
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                        required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div x-data="{ show: false }">
                    <x-input-label for="password" value="Kata Sandi" />

                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" wire:model="password" id="password"
                            class="block w-full mt-2 rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 pr-10"
                            required autocomplete="new-password">

                        <!-- Tombol mata -->
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-green-600">

                            <!-- Icon saat hidden -->
                            <i x-show="!show" class="bi bi-eye text-xl"></i>

                            <!-- Icon saat visible -->
                            <i x-show="show" class="bi bi-eye-slash text-xl"></i>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div x-data="{ show: false }">
                    <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />

                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" wire:model="password_confirmation"
                            id="password_confirmation"
                            class="block w-full mt-2 rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 pr-10"
                            required autocomplete="new-password">

                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-green-600">

                            <i x-show="!show" class="bi bi-eye text-xl"></i>
                            <i x-show="show" class="bi bi-eye-slash text-xl"></i>

                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>


                <button type="submit"
                    class="w-full justify-center py-3 rounded-xl text-base font-medium mt-3 bg-green-600 hover:bg-green-700 text-white flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed transition"
                    wire:loading.class="opacity-70 cursor-wait" wire:target="register" wire:loading.attr="disabled">
                    <!-- Normal text -->
                    <span wire:loading.remove wire:target="register">
                        Daftar Sekarang
                    </span>

                    <!-- Loading spinner -->
                    <span wire:loading wire:target="register" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </span>
                </button>

            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" wire:navigate class="text-green-600 font-medium hover:underline">
                    Masuk Sekarang
                </a>
            </p>
        </div>
    </div>
</div>
