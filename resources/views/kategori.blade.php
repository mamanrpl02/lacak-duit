<x-app-layout>
    <!-- Section 1: Tombol & Modal Add Data -->
    <section>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">
                Kelola Kategori
            </h2>
            <button id="openModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Tambah Data
            </button>
        </div>

        <!-- Modal -->
        <div id="modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg p-6 w-[90%] max-w-lg relative animate-fadeIn">
                <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                    ✕
                </button>
                <h3 class="text-lg font-semibold mb-4 text-gray-800">
                    Tambah Data Baru
                </h3>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <input type="text"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: Makan siang" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nominal</label>
                        <input type="number"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Rp" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>Masuk</option>
                                <option>Keluar</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <input type="text"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dompet</label>
                            <input type="text"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" id="closeModal2"
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
    </section>

    <!-- Section 2: Tabel Data -->
    <section>
        <div class="overflow-x-auto bg-white shadow rounded-2xl p-4">
            <table class="min-w-full text-sm text-left text-gray-700">
                <!-- Tombol Filter -->
                <div class="m-4 flex justify-between items-center">
                    <div class="text">
                        <h1 class="text-xl font-bold">asdasd</h1>
                        <p class="text-sm">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Doloribus magni cupiditate cum.
                        </p>
                    </div>
                    <div class="button">
                        <button id="openFilter"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </div>

                <!-- Popup Filter -->
                <div id="filterPopup" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                    <div class="bg-white rounded-2xl shadow-xl p-6 w-[90%] max-w-md relative animate-fadeIn">
                        <!-- Tombol Close -->
                        <button id="closeFilter" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                            ✕
                        </button>

                        <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center gap-2">
                            <i class="bi bi-funnel"></i> Filter Data
                        </h3>

                        <!-- Form Filter -->
                        <form class="space-y-4">
                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua</option>
                                    <option value="Masuk">Masuk</option>
                                    <option value="Keluar">Keluar</option>
                                </select>
                            </div>

                            <!-- Dompet -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dompet</label>
                                <select
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua</option>
                                    <option value="Dompet Utama">Dompet Utama</option>
                                    <option value="E-Wallet">E-Wallet</option>
                                    <option value="Bank">Bank</option>
                                </select>
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date"
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" id="resetFilter"
                                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                                    Reset
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Terapkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <thead class="border-b text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3">Nominal</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Dompet</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50 transition relative">
                        <td class="px-4 py-3">Makan Siang</td>
                        <td class="px-4 py-3">Rp25.000</td>
                        <td class="px-4 py-3 text-green-600 font-medium">Masuk</td>
                        <td class="px-4 py-3">2025-10-31</td>
                        <td class="px-4 py-3">Makanan</td>
                        <td class="px-4 py-3">Dompet Utama</td>
                        <td class="px-4 py-3 text-center relative">
                            <button class="action-btn p-2 rounded hover:bg-gray-100 text-gray-600 transition">
                                <i class="bi bi-three-dots-vertical text-lg"></i>
                            </button>
                            <div
                                class="dropdown hidden absolute right-4 top-10 bg-white border rounded-lg shadow-md text-sm z-10 animate-fadeIn">
                                <button class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                    Edit
                                </button>
                                <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition relative">
                        <td class="px-4 py-3">Beli Kopi</td>
                        <td class="px-4 py-3">Rp15.000</td>
                        <td class="px-4 py-3 text-red-600 font-medium">Keluar</td>
                        <td class="px-4 py-3">2025-10-30</td>
                        <td class="px-4 py-3">Minuman</td>
                        <td class="px-4 py-3">E-Wallet</td>
                        <td class="px-4 py-3 text-center relative">
                            <button class="action-btn p-2 rounded hover:bg-gray-100 text-gray-600 transition">
                                <i class="bi bi-three-dots-vertical text-lg"></i>
                            </button>
                            <div
                                class="dropdown hidden absolute right-4 top-10 bg-white border rounded-lg shadow-md text-sm z-10 animate-fadeIn">
                                <button class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                    Edit
                                </button>
                                <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-3 mt-6 text-sm">
                <p class="text-gray-500">Menampilkan 1–10 dari 25 data</p>
                <div class="flex items-center gap-1">
                    <button class="px-3 py-1 border rounded-lg text-gray-600 hover:bg-gray-100 transition">
                        ‹
                    </button>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        1
                    </button>
                    <button class="px-3 py-1 border rounded-lg text-gray-600 hover:bg-gray-100 transition">
                        2
                    </button>
                    <button class="px-3 py-1 border rounded-lg text-gray-600 hover:bg-gray-100 transition">
                        3
                    </button>
                    <button class="px-3 py-1 border rounded-lg text-gray-600 hover:bg-gray-100 transition">
                        ›
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter -->
    <script>
        const openFilter = document.getElementById("openFilter");
        const filterPopup = document.getElementById("filterPopup");
        const closeFilter = document.getElementById("closeFilter");
        const resetFilter = document.getElementById("resetFilter");

        openFilter.addEventListener("click", () => {
            filterPopup.classList.remove("hidden");
        });

        closeFilter.addEventListener("click", () => {
            filterPopup.classList.add("hidden");
        });

        resetFilter.addEventListener("click", () => {
            filterPopup
                .querySelectorAll("select, input")
                .forEach((el) => (el.value = ""));
        });

        // Klik di luar popup untuk menutup
        filterPopup.addEventListener("click", (e) => {
            if (e.target === filterPopup) {
                filterPopup.classList.add("hidden");
            }
        });
    </script>

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

    <script>
        // Dropdown aksi tiga titik
        document.querySelectorAll(".action-btn").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.stopPropagation();
                document
                    .querySelectorAll(".dropdown")
                    .forEach((d) => d.classList.add("hidden"));
                btn.nextElementSibling.classList.toggle("hidden");
            });
        });

        document.addEventListener("click", () => {
            document
                .querySelectorAll(".dropdown")
                .forEach((d) => d.classList.add("hidden"));
        });
    </script>
</x-app-layout>
