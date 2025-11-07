<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ✏️ Update Data Diri --}}
            <div class="bg-white shadow rounded-xl p-8 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Akun</h3>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                            class="w-full border-gray-200 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                            required>
                        @error('name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email (tidak bisa diubah) --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                        <input type="email" id="email" value="{{ Auth::user()->email }}" readonly
                            class="w-full bg-gray-100 border-gray-200 rounded-lg text-gray-500 cursor-not-allowed">
                        <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah.</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg shadow-md transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- 🔒 Ganti Password --}}
            <div class="bg-white shadow rounded-xl p-8 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Ubah Password</h3>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-600 mb-1">Password Lama</label>
                        <input type="password" name="current_password" id="current_password"
                            class="w-full border-gray-200 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                            required>
                        @error('current_password')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="w-full border-gray-200 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                            required>
                        @error('password')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-600 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full border-gray-200 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                            required>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('password.request') }}" class="text-sm text-sky-600 hover:underline">
                            Lupa Password?
                        </a>

                        <button type="submit"
                            class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg shadow-md transition">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>

            {{-- 🗑️ Hapus Akun --}}
            <div class="bg-white shadow rounded-xl p-8 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Hapus Akun</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Menghapus akun akan menghapus semua data yang terhubung. Tindakan ini tidak dapat dibatalkan.
                </p>

                <form id="deleteForm" method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-end">
                        <button type="button" id="deleteBtn"
                            class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md transition">
                            Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 🔔 Alert untuk success/error dari session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0ea5e9',
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#ef4444',
            });
        @endif

        // ⚠️ Konfirmasi sebelum hapus akun
        document.getElementById('deleteBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Yakin ingin menghapus akun?',
                text: "Data kamu akan hilang permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus akun',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        });
    </script>
</x-app-layout>
