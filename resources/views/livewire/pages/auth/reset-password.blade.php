<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset($this->only('email', 'password', 'password_confirmation', 'token'), function ($user) {
            $user
                ->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])
                ->save();

            event(new PasswordReset($user));
        });

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="min-h-screen flex items-center justify-center bg-blue-50 p-6">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden w-full max-w-5xl flex flex-col md:flex-row">

        <!-- Sisi Kiri - Gambar + Overlay -->
        <div class="hidden md:flex relative w-1/2 bg-cover bg-center"
            style="background-image: url('https://images.pexels.com/photos/10774600/pexels-photo-10774600.jpeg');">
            <div class="absolute inset-0 bg-blue-900/60"></div>
            <div class="relative z-10 flex flex-col justify-center text-white p-10">
                <h1 class="text-3xl font-bold mb-4">Lupa Kata Sandi? 🔒</h1>
                <p class="text-blue-100 text-lg leading-relaxed">
                    Masukkan email Anda untuk mereset kata sandi. Kami akan mengirimkan tautan reset password.
                </p>
            </div>
        </div>

        <!-- Sisi Kanan - Form Reset Password -->
        <div class="p-8 md:w-1/2 flex flex-col justify-center space-y-6 bg-white w-full md:max-w-md mx-auto">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-blue-600">Atur Ulang Kata Sandi</h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan kata sandi baru untuk akun Anda</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="resetPassword" class="space-y-4">
                <!-- Email (Non-editable) -->
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" type="email" name="email" readonly
                        class="block w-full mt-2 rounded-xl border-gray-300 bg-gray-100 cursor-not-allowed focus:ring-blue-500 focus:border-blue-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="relative">
                    <x-input-label for="password" value="Kata Sandi Baru" />
                    <x-text-input wire:model="password" id="password" type="password" name="password" required
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-10" />
                    <button type="button" id="togglePasswordReset"
                        class="absolute right-3 top-10 text-gray-500 hover:text-blue-600">👁️</button>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="relative">
                    <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password"
                        name="password_confirmation" required
                        class="block w-full mt-2 rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-10" />
                    <button type="button" id="togglePasswordConfirm"
                        class="absolute right-3 top-10 text-gray-500 hover:text-blue-600">👁️</button>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <x-primary-button
                    class="w-full justify-center py-3 rounded-xl text-base font-medium mt-3 bg-blue-600 hover:bg-blue-700">
                    Reset Kata Sandi
                </x-primary-button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Kembali ke
                <a href="{{ route('login') }}" wire:navigate class="text-blue-600 font-medium hover:underline">
                    Halaman Login
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePasswordReset').addEventListener('click', function() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    });

    document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
        const input = document.getElementById('password_confirmation');
        input.type = input.type === 'password' ? 'text' : 'password';
    });
</script>
