<x-app-layout>

    <!-- Section 1: Tombol & Modal Add Data -->
    <section>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Kelola Dompet</h2>
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
 
    <!-- Section: Tabel Dompet -->
    <section>
        <div class="overflow-x-auto bg-white shadow rounded-2xl p-4">
            <!-- Header dan Search -->
            <div class="m-4 flex flex-col md:flex-row justify-between items-center gap-3">
                <div class="text-center md:text-left">
                    <h1 class="text-xl font-bold text-gray-800">Daftar Dompet</h1>
                    <p class="text-sm text-gray-500">
                        Kelola daftar dompet yang kamu miliki.
                    </p>
                </div>
                <div class="relative w-full md:w-1/3">
                    <input type="text" id="searchInput" placeholder="Cari dompet..."
                        class="w-full border rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <i class="bi bi-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
            </div>

            <!-- Tabel Data -->
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="border-b text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Nama Dompet</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr class="border-b hover:bg-gray-50 transition relative">
                        <td class="px-4 py-3 font-medium text-gray-800">
                            Dompet Utama
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            Dompet pribadi untuk kebutuhan harian
                        </td>
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
                        <td class="px-4 py-3 font-medium text-gray-800">E-Wallet</td>
                        <td class="px-4 py-3 text-gray-600">
                            Dompet digital untuk transaksi online
                        </td>
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
                        <td class="px-4 py-3 font-medium text-gray-800">Bank BCA</td>
                        <td class="px-4 py-3 text-gray-600">
                            Rekening tabungan utama
                        </td>
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
                        ›
                    </button>
                </div>
            </div>
        </div>
    </section>

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

        // Fitur Search
        const searchInput = document.getElementById("searchInput");
        const tableBody = document.getElementById("tableBody");

        searchInput.addEventListener("keyup", function() {
            const searchValue = this.value.toLowerCase();
            const rows = tableBody.querySelectorAll("tr");

            rows.forEach((row) => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? "" : "none";
            });
        });
    </script>
    </main>

    <script>
        const modal = document.getElementById("modal");
        const openModal = document.getElementById("openModal");
        const closeModal = document.getElementById("closeModal");
        const closeModal2 = document.getElementById("closeModal2");

        openModal.addEventListener("click", () =>
            modal.classList.remove("hidden")
        );
        closeModal.addEventListener("click", () =>
            modal.classList.add("hidden")
        );
        closeModal2.addEventListener("click", () =>
            modal.classList.add("hidden")
        );
    </script>

</x-app-layout>
