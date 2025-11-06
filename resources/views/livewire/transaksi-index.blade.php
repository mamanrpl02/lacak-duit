<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold text-gray-700">Daftar Transaksi</h1>
        <button wire:click="openModal" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">+
            Tambah</button>
    </div>

    <div class="bg-white shadow rounded-xl mt-2 p-4 overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 border-collapse">
            <thead class="border-b text-gray-600 uppercase text-xs text-left">
                <tr>
                    <th class="py-2 px-4">Keterangan</th>
                    <th class="py-2 px-4">Nominal</th>
                    <th class="py-2 px-4">Tanggal</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Kategori</th>
                    <th class="py-2 px-4">Dompet</th>
                    <th class="py-2 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $t)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $t->keterangan }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($t->nominal, 0, ',', '.') }}</td>

                        <td class="px-4 py-2">
                            @php
                                $warnaStatus = match ($t->status) {
                                    'Masuk' => 'bg-green-100 text-green-700',
                                    'Keluar' => 'bg-red-100 text-red-700',
                                    'Withdraw' => 'bg-purple-100 text-purple-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="px-3 py-1 text-sm font-medium rounded-lg {{ $warnaStatus }}">
                                {{ $t->status }}
                            </span>
                        </td>

                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') ?? '-' }}</td>

                        <td class="px-4 py-2">{{ $t->kategori->nama_kategori ?? '-' }}</td>

                        {{-- Dompet --}}
                        <td class="px-4 py-2">
                            @if ($t->status === 'Withdraw')
                                @php
                                    $asal = $t->dompetAsal->nama_dompet ?? null;
                                    $tujuan = $t->dompetTujuan->nama_dompet ?? null;
                                @endphp
                                @if ($asal && $tujuan)
                                    {{ $asal }} <span class="text-gray-400">➜</span> {{ $tujuan }}
                                @elseif ($asal)
                                    {{ $asal }}
                                @elseif ($tujuan)
                                    {{ $tujuan }}
                                @else
                                    -
                                @endif
                            @else
                                {{ $t->dompetAsal->nama_dompet ?? '-' }}
                            @endif
                        </td>

                        <td class="px-4 py-2 text-center">
                            <button wire:click="edit({{ $t->id }})"
                                class="px-3 py-1 bg-sky-500 text-white rounded-lg hover:bg-sky-600">Edit</button>
                            <button wire:click="confirmDelete({{ $t->id }})"
                                class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">
                            Belum ada data transaksi.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="mt-4">{{ $transaksis->links() }}</div>
    </div>

    {{-- Modal --}}
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
                <h2 class="text-xl font-semibold mb-4">
                    {{ $isEdit ? 'Edit Transaksi' : 'Tambah Transaksi' }}
                </h2>

                <form wire:submit.prevent="store">
                    <div class="mb-3">
                        <label class="block text-sm">Keterangan</label>
                        <input type="text" wire:model="keterangan" class="w-full border rounded p-2">
                        @error('keterangan')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm">Nominal</label>
                        <input type="number" wire:model="nominal" class="w-full border rounded p-2">
                        @error('nominal')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm">Tanggal</label>
                        <input type="date" wire:model="tanggal" class="w-full border rounded p-2">
                        @error('tanggal')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="block text-sm">Status</label>
                        <select wire:model.live="status" class="w-full border rounded p-2">
                            <option value="">Pilih Status</option>
                            <option value="Masuk">Masuk</option>
                            <option value="Keluar">Keluar</option>
                            <option value="Withdraw">Withdraw</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm">Kategori</label>
                        <select wire:model="kategori_id" class="w-full border rounded p-2">
                            <option value="">Pilih Kategori</option>
                            @foreach ($filteredKategoris as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($status === 'Withdraw')
                        <div class="mb-3">
                            <label class="block text-sm">Dompet Asal</label>
                            <select wire:model="dompet_asal_id" class="w-full border rounded p-2">
                                <option value="">Pilih Dompet Asal</option>
                                @foreach ($dompets as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_dompet }}</option>
                                @endforeach
                            </select>
                            @error('dompet_asal_id')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm">Dompet Tujuan</label>
                            <select wire:model="dompet_tujuan_id" class="w-full border rounded p-2">
                                <option value="">Pilih Dompet Tujuan</option>
                                @foreach ($dompets as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_dompet }}</option>
                                @endforeach
                            </select>
                            @error('dompet_tujuan_id')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                    @else
                        <div class="mb-3">
                            <label class="block text-sm">Dompet</label>
                            <select wire:model="dompet_asal_id" class="w-full border rounded p-2">
                                <option value="">Pilih Dompet</option>
                                @foreach ($dompets as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_dompet }}</option>
                                @endforeach
                            </select>
                            @error('dompet_asal_id')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="flex justify-end mt-4 space-x-2">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            {{ $isEdit ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:confirmDelete', ({
                id
            }) => {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteConfirmed', {
                            id: id
                        });
                    }
                });
            });

            Livewire.on('swal:success', ({
                message
            }) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: message,
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    </script>
</div>
