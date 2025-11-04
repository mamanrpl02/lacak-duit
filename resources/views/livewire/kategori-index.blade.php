<div>
    <section>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Kelola Kategori</h2>
            <button wire:click="openModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Tambah Kategori
            </button>
        </div>
    </section>

    <!-- Modal (Tambah / Edit) -->
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
                        <textarea wire:model.defer="keterangan" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Icon (Opsional)</label>
                        <input type="file" wire:model="gambar_icon"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <div wire:loading wire:target="gambar_icon" class="text-xs text-gray-500">Mengupload...</div>

                        {{-- Preview gambar --}}
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
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Table -->
    <section class="mt-6">
        <div class="overflow-x-auto bg-white shadow rounded-2xl p-4">

            <!-- Header dan Search -->
            <div class="m-4 flex flex-col md:flex-row justify-between items-center gap-3">
                <div class="text-center md:text-left">
                    <h1 class="text-xl font-bold text-gray-800">Daftar Kategori</h1>
                    <p class="text-sm text-gray-500">
                        Atur Kategori untuk transaksi Anda di sini.
                    </p>
                </div>
                <div class="relative w-full md:w-1/3">
                    <input type="text" id="searchInput" placeholder="Cari Kategori..."
                        class="w-full border rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <i class="bi bi-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
            </div>

            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="border-b text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Nama Kategori</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3">Icon</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategoris as $kategori)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $kategori->nama_kategori }}</td>
                            <td class="px-4 py-3">{{ $kategori->type }}</td>
                            <td class="px-4 py-3">{{ $kategori->keterangan ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if ($kategori->gambar_icon)
                                    <img src="{{ asset('storage/' . $kategori->gambar_icon) }}"
                                        class="w-8 h-8 rounded">
                                @else
                                    <span class="text-gray-400">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center flex justify-center gap-2">
                                <button wire:click="edit({{ $kategori->id }})"
                                    class="px-3 py-1 bg-sky-500 text-white rounded-lg hover:bg-sky-600">
                                    Edit
                                </button>
                                <button onclick="confirmDelete({{ $kategori->id }})"
                                    class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $kategoris->links() }}
            </div>
        </div>
    </section>
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
