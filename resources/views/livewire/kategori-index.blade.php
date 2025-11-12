<div>
    <div class="p-3 sm:p-6 space-y-6">

        <!-- Header -->
        <section>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Kelola Kategori</h2>
                <button wire:click="openModal"
                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center text-sm sm:text-base">
                    + Tambah Kategori
                </button>
            </div>
        </section>

        <!-- Table -->
        <section>
            <div class="bg-white shadow rounded-2xl p-3 sm:p-6">

                <!-- Header & Search -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-3 mb-4">
                    <div class="text-center md:text-left">
                        <h1 class="text-lg sm:text-xl font-bold text-gray-800">Daftar Kategori</h1>
                        <p class="text-sm text-gray-500">Atur kategori transaksi Anda di sini.</p>
                    </div>

                    <div class="relative w-full md:w-1/3">
                        <input type="text" placeholder="Cari kategori..." wire:model.live="search"
                            class="w-full border rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />
                        <i class="bi bi-search absolute left-3 top-2.5 text-gray-400"></i>

                    </div>
                </div>

                <!-- Responsive Table -->
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-3 py-2 sm:px-4 sm:py-3">Nama</th>
                                <th class="px-3 py-2 sm:px-4 sm:py-3">Tipe</th>
                                <th class="px-3 py-2 sm:px-4 sm:py-3 hidden sm:table-cell">Keterangan</th>
                                <th class="px-3 py-2 sm:px-4 sm:py-3">Icon</th>
                                <th class="px-3 py-2 sm:px-4 sm:py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategoris as $kategori)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td
                                        class="px-3 py-2 sm:px-4 sm:py-3 font-medium whitespace-normal break-words max-w-[200px]">
                                        {{ $kategori->nama_kategori }}
                                    </td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $kategori->type }}</td>
                                    <td
                                        class="px-3 py-2 sm:px-4 sm:py-3 hidden sm:table-cell whitespace-normal break-words max-w-[250px]">
                                        {{ $kategori->keterangan ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3">
                                        @if ($kategori->gambar_icon)
                                            <img src="{{ asset('storage/' . $kategori->gambar_icon) }}"
                                                class="w-8 h-8 rounded object-cover">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 text-center">
                                        <div class="flex justify-center flex-wrap gap-2">
                                            <button wire:click="edit({{ $kategori->id }})"
                                                class="px-3 py-1 bg-sky-500 text-white rounded-lg hover:bg-sky-600 text-xs sm:text-sm">
                                                Edit
                                            </button>
                                            <button onclick="confirmDelete({{ $kategori->id }})"
                                                class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs sm:text-sm">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $kategoris->links() }}
                </div>
            </div>
        </section>

    </div>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-3 sm:p-4">
            <div
                class="bg-white rounded-2xl shadow-lg w-full max-w-lg relative overflow-y-auto max-h-[90vh] animate-fadeIn p-4 sm:p-6">
                <button wire:click="closeModal"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-lg">✕</button>

                <h3 class="text-base sm:text-lg font-semibold mb-4 text-gray-800">
                    {{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}
                </h3>

                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4 text-sm sm:text-base">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" wire:model.defer="nama_kategori"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        @error('nama_kategori')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                        <select wire:model.defer="type"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">Pilih tipe</option>
                            <option value="Masuk">Masuk</option>
                            <option value="Keluar">Keluar</option>
                            <option value="Withdraw">Withdraw</option>
                        </select>
                        @error('type')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea wire:model.defer="keterangan"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Icon (Opsional)</label>
                        <input type="file" wire:model="gambar_icon"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <div wire:loading wire:target="gambar_icon" class="text-xs text-gray-500">Mengupload...</div>

                        @if ($gambar_icon)
                            <div class="mt-2">
                                <p class="text-xs text-gray-500 mb-1">Preview gambar baru:</p>
                                <img src="{{ $gambar_icon->temporaryUrl() }}" class="w-16 h-16 rounded object-cover">
                            </div>
                        @elseif($isEdit && $kategori_id)
                            @php
                                $old = \App\Models\Kategori::find($kategori_id);
                            @endphp
                            @if ($old && $old->gambar_icon)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $old->gambar_icon) }}"
                                        class="w-16 h-16 rounded object-cover">
                                </div>
                            @endif
                        @endif

                        @error('gambar_icon')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-2">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data kategori akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteKategori', {
                        id: id
                    });
                }
            });
        }

        Livewire.on('successAlert', (message) => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
@endpush
