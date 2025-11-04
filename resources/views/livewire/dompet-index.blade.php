<div>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Kelola Dompet</h2>
            <button wire:click="openModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Tambah Data
            </button>
        </div>

        {{-- Modal --}}
        @if ($isModalOpen)
            <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl shadow-lg p-6 w-[90%] max-w-lg relative animate-fadeIn">
                    <button wire:click="closeModal"
                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        {{ $dompet_id ? 'Edit Dompet' : 'Tambah Dompet' }}
                    </h3>

                    <form wire:submit.prevent="store" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Dompet</label>
                            <input type="text" wire:model="nama_dompet"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('nama_dompet')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea wire:model="keterangan"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="text-end">
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 mr-2">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto bg-white shadow rounded-2xl p-4">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="border-b text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Nama Dompet</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dompets as $dompet)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $dompet->nama_dompet }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $dompet->keterangan }}</td>
                            <td class="px-4 py-3 text-center">
                                <button wire:click="edit({{ $dompet->id }})"
                                    class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>
                                <button wire:click="delete({{ $dompet->id }})"
                                    class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">Belum ada data dompet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $dompets->links() }}
            </div>
        </div>
    </div>

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
