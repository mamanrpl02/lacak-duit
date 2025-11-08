<div class="p-6">

    <!-- Header -->
    <section>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Kelola Transaksi</h2>
            <button wire:click="openModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Tambah Transaksi
            </button>
        </div>
    </section>

    <!-- Filter & Search -->
    <section class="mt-6">
        <div
            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-gradient-to-r from-white to-blue-50 shadow-md rounded-2xl p-5 border border-gray-200">

            <!-- Filter Dropdowns -->
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative">
                    <select wire:model.live="filterKategori"
                        class="appearance-none border border-gray-300 rounded-xl pl-4 pr-10 py-2 text-sm text-gray-700 bg-white focus:ring-2 focus:ring-blue-400 shadow-sm transition w-full sm:w-auto">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <i
                        class="bi bi-tags absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none"></i>
                </div>

                <div class="relative">
                    <select wire:model.live="filterStatus"
                        class="appearance-none border border-gray-300 rounded-xl pl-4 pr-10 py-2 text-sm text-gray-700 bg-white focus:ring-2 focus:ring-blue-400 shadow-sm transition w-full sm:w-auto">
                        <option value="">Semua Status</option>
                        <option value="Masuk">Masuk</option>
                        <option value="Keluar">Keluar</option>
                        <option value="Withdraw">Withdraw</option>
                    </select>
                    <i
                        class="bi bi-funnel-fill absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none"></i>
                </div>

                <div class="flex gap-2">
                    <div class="relative">
                        <i
                            class="bi bi-calendar-event absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="date" wire:model.live="filterTanggalAwal"
                            class="border border-gray-300 rounded-xl pl-9 pr-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-400 shadow-sm transition w-full sm:w-auto"
                            placeholder="Dari Tanggal">
                    </div>

                    <div class="relative">
                        <i
                            class="bi bi-calendar-check absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="date" wire:model.live="filterTanggalAkhir"
                            class="border border-gray-300 rounded-xl pl-9 pr-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-400 shadow-sm transition w-full sm:w-auto"
                            placeholder="Sampai Tanggal">
                    </div>
                </div>
            </div>

            <!-- Search Input -->
            <div class="relative w-full md:w-1/3">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base"></i>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari keterangan atau nominal..."
                    class="w-full border border-gray-300 rounded-xl pl-11 pr-4 py-2 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm transition" />
            </div>
        </div>
    </section>



    <!-- Table -->
    <section class="mt-4">
        <div class="bg-white shadow rounded-2xl p-4 border">
            <!-- ✅ Tabel untuk layar besar -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="border-b text-gray-600 uppercase text-xs bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">Keterangan</th>
                            <th class="px-4 py-3 whitespace-nowrap">Nominal</th>
                            <th class="px-4 py-3 whitespace-nowrap">Tanggal</th>
                            <th class="px-4 py-3 whitespace-nowrap">Status</th>
                            <th class="px-4 py-3 whitespace-nowrap">Kategori</th>
                            <th class="px-4 py-3 whitespace-nowrap">Dompet</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $t)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium break-words max-w-[150px]">{{ $t->keterangan }}</td>
                                <td class="px-4 py-3 font-semibold">Rp{{ number_format($t->nominal, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $warnaStatus = match ($t->status) {
                                            'Masuk' => 'bg-green-100 text-green-700',
                                            'Keluar' => 'bg-red-100 text-red-700',
                                            'Withdraw' => 'bg-purple-100 text-purple-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $warnaStatus }}">
                                        {{ $t->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $t->kategori->nama_kategori ?? '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if ($t->status === 'Withdraw')
                                        @php
                                            $asal = $t->dompetAsal->nama_dompet ?? null;
                                            $tujuan = $t->dompetTujuan->nama_dompet ?? null;
                                        @endphp
                                        @if ($asal && $tujuan)
                                            {{ $asal }} <span class="text-gray-400">➜</span> {{ $tujuan }}
                                        @else
                                            {{ $asal ?? ($tujuan ?? '-') }}
                                        @endif
                                    @else
                                        {{ $t->dompetAsal->nama_dompet ?? '-' }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button wire:click="edit({{ $t->id }})"
                                            class="px-3 py-1 bg-sky-500 text-white rounded-lg hover:bg-sky-600 text-xs">
                                            Edit
                                        </button>
                                        <button onclick="confirmDelete({{ $t->id }})"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ✅ Card view untuk mobile & tablet -->
            <div class="block md:hidden space-y-3">
                @forelse ($transaksis as $t)
                    @php
                        $warnaStatus = match ($t->status) {
                            'Masuk' => 'bg-green-100 text-green-700',
                            'Keluar' => 'bg-red-100 text-red-700',
                            'Withdraw' => 'bg-purple-100 text-purple-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <div class="border rounded-xl shadow-sm p-4 bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $t->keterangan }}</h4>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                                </p>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $warnaStatus }}">
                                {{ $t->status }}
                            </span>
                        </div>

                        <p class="mt-2 font-bold text-blue-700">
                            Rp{{ number_format($t->nominal, 0, ',', '.') }}
                        </p>

                        <div class="mt-1 text-sm text-gray-600">
                            <p><span class="font-medium">Kategori:</span> {{ $t->kategori->nama_kategori ?? '-' }}</p>
                            <p>
                                <span class="font-medium">Dompet:</span>
                                @if ($t->status === 'Withdraw')
                                    {{ $t->dompetAsal->nama_dompet ?? '-' }} ➜
                                    {{ $t->dompetTujuan->nama_dompet ?? '-' }}
                                @else
                                    {{ $t->dompetAsal->nama_dompet ?? '-' }}
                                @endif
                            </p>
                        </div>

                        <div class="mt-3 flex justify-end gap-2">
                            <button wire:click="edit({{ $t->id }})"
                                class="px-3 py-1 bg-sky-500 text-white rounded-lg hover:bg-sky-600 text-xs">
                                Edit
                            </button>
                            <button onclick="confirmDelete({{ $t->id }})"
                                class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs">
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Belum ada data transaksi.</p>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $transaksis->links() }}
            </div>
        </div>
    </section>


    <!-- Modal (Tambah / Edit) -->
    <!-- Modal Form -->
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg p-6 w-[90%] max-w-lg relative animate-fadeIn">
                <!-- Tombol close -->
                <button wire:click="closeModal"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 transition">
                    ✕
                </button>

                <!-- Judul -->
                <h3 class="text-lg font-semibold mb-5 text-gray-800 border-b pb-2">
                    {{ $isEdit ? 'Edit Transaksi' : 'Tambah Transaksi' }}
                </h3>

                <!-- Form -->
                <form wire:submit.prevent="store" class="space-y-4">
                    <!-- Keterangan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" wire:model.defer="keterangan"
                            class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition" />
                        @error('keterangan')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nominal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nominal</label>
                        <input type="number" wire:model.defer="nominal"
                            class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition" />
                        @error('nominal')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" wire:model.defer="tanggal"
                            class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition" />
                        @error('tanggal')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select wire:model.live="status"
                            class="w-full border rounded-xl px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition">
                            <option value="">Pilih Status</option>
                            <option value="Masuk">Masuk</option>
                            <option value="Keluar">Keluar</option>
                            <option value="Withdraw">Withdraw</option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Kategori (otomatis menyesuaikan status) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select wire:model.defer="kategori_id"
                            class="w-full border rounded-xl px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition">
                            <option value="">Pilih Kategori</option>
                            @foreach ($filteredKategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Dompet -->
                    @if ($status === 'Withdraw')
                        <!-- Dompet Asal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dompet Asal</label>
                            <select wire:model.defer="dompet_asal_id"
                                class="w-full border rounded-xl px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition">
                                <option value="">Pilih Dompet Asal</option>
                                @foreach ($dompets as $dompet)
                                    <option value="{{ $dompet->id }}">{{ $dompet->nama_dompet }}</option>
                                @endforeach
                            </select>
                            @error('dompet_asal_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Dompet Tujuan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dompet Tujuan</label>
                            <select wire:model.defer="dompet_tujuan_id"
                                class="w-full border rounded-xl px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition">
                                <option value="">Pilih Dompet Tujuan</option>
                                @foreach ($dompets as $dompet)
                                    <option value="{{ $dompet->id }}">{{ $dompet->nama_dompet }}</option>
                                @endforeach
                            </select>
                            @error('dompet_tujuan_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <!-- Dompet Tunggal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dompet</label>
                            <select wire:model.defer="dompet_asal_id"
                                class="w-full border rounded-xl px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition">
                                <option value="">Pilih Dompet</option>
                                @foreach ($dompets as $dompet)
                                    <option value="{{ $dompet->id }}">{{ $dompet->nama_dompet }}</option>
                                @endforeach
                            </select>
                            @error('dompet_asal_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <!-- Tombol Aksi -->
                    <div class="text-end pt-2">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-gray-700 mr-2 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            {{ $isEdit ? 'Update' : 'Simpan' }}
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
        // Konfirmasi hapus
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data transaksi akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteConfirmed', {
                        id: id
                    });
                }
            });
        }

        // ✅ Listener SweetAlert sukses (Livewire v3)
        Livewire.on('successAlert', ({
            message
        }) => {
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
