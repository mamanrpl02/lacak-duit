<div class="p-6 space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Kategori</h1>
            <p class="text-gray-500 text-sm">Atur dan kelola kategori transaksi dengan mudah</p>
        </div>
        <div>
            <button wire:click="openModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Tambah Kategori
            </button>
        </div>
    </div>

    <!-- Filter dan Search -->
    <div
        class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 bg-gray-50 border border-gray-200 rounded-xl p-4">
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <select wire:model.live="filter_type"
                class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Tipe</option>
                <option value="Masuk">Masuk</option>
                <option value="Keluar">Keluar</option>
                <option value="Withdraw">Withdraw</option>
            </select>
        </div>
        <div class="relative w-full sm:w-72">
            <i class="bi bi-search absolute left-3 top-2.5 text-gray-400"></i>
            <input type="text" wire:model.live="search" placeholder="Cari kategori..."
                class="w-full border rounded-lg pl-10 pr-3 py-2 text-sm focus:ring-2 focus:ring-blue-500" />
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Nama Kategori</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3">Icon</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $kategori)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium">{{ $kategori->nama_kategori }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="px-2 py-1 rounded text-xs font-semibold
                                        @if ($kategori->type === 'Masuk') bg-green-100 text-green-700
                                        @elseif($kategori->type === 'Keluar') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ $kategori->type }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $kategori->keterangan ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if ($kategori->gambar_icon)
                                    <img src="{{ asset('storage/' . $kategori->gambar_icon) }}" class="w-8 h-8 rounded">
                                @else
                                    <span class="text-gray-400 text-sm">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center flex justify-center gap-2">
                                <button wire:click="edit({{ $kategori->id }})"
                                    class="px-3 py-1 bg-sky-500 text-white rounded-lg hover:bg-sky-600 text-xs">
                                    Edit
                                </button>
                                <button onclick="confirmDelete({{ $kategori->id }})"
                                    class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t bg-gray-50">
            {{ $kategoris->links() }}
        </div>
    </div>

    <!-- Modal Tambah/Edit -->
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg p-6 w-[90%] max-w-lg relative animate-fadeIn">
                <button wire:click="closeModal"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>

                <h3 class="text-lg font-semibold mb-4 text-gray-800">
                    {{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}
                </h3>

                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" wire:model.defer="nama_kategori"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        @error('nama_kategori')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipe</label>
                        <select wire:model.defer="type"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih tipe</option>
                            <option value="Masuk">Masuk</option>
                            <option value="Keluar">Keluar</option>
                            <option value="Withdraw">Withdraw</option>
                        </select>
                        @error('type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea wire:model.defer="keterangan"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Icon (Opsional)</label>
                        <input type="file" wire:model="gambar_icon"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <div wire:loading wire:target="gambar_icon" class="text-xs text-gray-500">Mengupload...</div>

                        @if ($gambar_icon)
                            <div class="mt-2">
                                <p class="text-xs text-gray-500 mb-1">Preview gambar baru:</p>
                                <img src="{{ $gambar_icon->temporaryUrl() }}" class="w-16 h-16 rounded">
                            </div>
                        @elseif($isEdit && $kategori_id)
                            @php
                                $old = \App\Models\Kategori::find($kategori_id);
                            @endphp
                            @if ($old && $old->gambar_icon)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $old->gambar_icon) }}" class="w-16 h-16 rounded">
                                </div>
                            @endif
                        @endif

                        @error('gambar_icon')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
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
                    Livewire.dispatch('deleteKategori', { id });
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
