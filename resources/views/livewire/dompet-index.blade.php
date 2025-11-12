<div>
    <div class="p-6 space-y-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dompet Saya</h1>
                <p class="text-gray-500 text-sm">Kelola semua dompet keuangan kamu di sini</p>
            </div>
            <div>
                <button wire:click="openModal"
                    class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                    + Tambah Dompet
                </button>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-xl shadow-sm border p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">

                <!-- Search -->
                <div class="relative w-full sm:w-1/3">
                    <input type="text" wire:model.live="search" placeholder="Cari dompet berdasarkan nama..."
                        class="w-full border rounded-lg px-4 py-2 pl-10 text-sm focus:ring-2 focus:ring-blue-500 outline-none" />
                    <i class="bi bi-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
            </div>

            <!-- Daftar Dompet -->
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Dompet</h2>

            @if ($dompets->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($dompets as $dompet)
                        <div
                            class="border rounded-xl p-4 hover:shadow-md transition bg-gray-50 flex flex-col justify-between space-y-3">
                            <div>
                                <h3 class="font-semibold text-gray-800 text-base mb-1">{{ $dompet->nama_dompet }}</h3>
                                <p class="text-gray-600 text-sm mb-3 break-words">
                                    {{ $dompet->keterangan ?: '-' }}
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-2 mt-auto">
                                <button wire:click="edit({{ $dompet->id }})"
                                    class="flex-1 md:flex-none px-3 py-2 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $dompet->id }})"
                                    class="flex-1 md:flex-none px-3 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-6">Tidak ditemukan dompet yang sesuai.</p>
            @endif

            <div class="mt-4">
                {{ $dompets->links() }}
            </div>
        </div>


    </div>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md relative animate-fadeIn">
                <button wire:click="closeModal"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✕</button>

                <div class="p-5">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        {{ $dompet_id ? 'Edit Dompet' : 'Tambah Dompet' }}
                    </h3>

                    <form wire:submit.prevent="store" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Dompet</label>
                            <input type="text" wire:model="nama_dompet"
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none" />
                            @error('nama_dompet')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea wire:model="keterangan"
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-end gap-2 pt-2">
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 w-full sm:w-auto">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 w-full sm:w-auto">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }
    </style>
</div>
