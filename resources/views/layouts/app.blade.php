<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind & JS dari Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .transition-all {
            transition: all 0.3s ease-in-out;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body class="bg-gray-50 min-h-screen flex text-gray-800 antialiased">


    @if (isset($showSetupModal) && $showSetupModal)
        <div id="setupModal"
            class="fixed inset-0 bg-black/20 flex items-center justify-center z-50 transition-opacity duration-300">
            <div class="bg-white rounded-2xl p-6 w-[90%] max-w-md relative shadow-lg animate-fade-in">
                <button onclick="closeModal()"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">✕</button>

                {{-- STEP KATEGORI --}}
                <div id="stepKategori" style="{{ !$hasKategori ? 'display:block;' : 'display:none;' }}">
                    <h3 class="text-xl font-bold mb-3 text-green-700">Pilih kategori pertamamu 🌟</h3>
                    <p class="mb-4 text-gray-600">
                        Kategori membantu kamu mencatat <b>pemasukan</b>, <b>pengeluaran</b>, dan <b>penarikan saldo</b>
                        agar catatan keuangan tetap rapi dan mudah dipahami.
                    </p>

                    <div id="kategoriContainer" class="grid grid-cols-2 gap-2 mb-3">
                        @php
                            $defaultKategori = [
                                ['nama' => 'Makanan', 'type' => 'Keluar'],
                                ['nama' => 'Minuman', 'type' => 'Keluar'],
                                ['nama' => 'Transportasi', 'type' => 'Keluar'],
                                ['nama' => 'Belanja', 'type' => 'Keluar'],
                                ['nama' => 'Gaji', 'type' => 'Masuk'],
                                ['nama' => 'Bonus', 'type' => 'Masuk'],
                            ];

                            $colorMap = [
                                'Masuk' => '#bbf7d0', // hijau muda
                                'Keluar' => '#fecaca', // merah muda
                                'Withdraw' => '#e9d5ff', // ungu muda
                            ];
                        @endphp

                        @foreach ($defaultKategori as $kat)
                            <div class="kategori-item border rounded-lg px-3 py-2 cursor-pointer transition"
                                data-value="{{ $kat['nama'] }}" data-type="{{ $kat['type'] }}"
                                data-color="{{ $colorMap[$kat['type']] }}"
                                style="border-color:#999;background-color:#fff;">
                                {{ $kat['nama'] }} ({{ $kat['type'] }})
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-2 flex gap-2">
                        <input type="text" id="kategoriLain" placeholder="Buat kategori baru..."
                            class="flex-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                        <select id="kategoriType" class="border rounded-lg px-2 py-2">
                            <option value="Masuk">Masuk</option>
                            <option value="Keluar">Keluar</option>
                            <option value="Withdraw">Withdraw</option>
                        </select>
                    </div>

                    <div class="flex justify-between gap-2">
                        <button id="tambahKategori"
                            class="flex-1 px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                            Tambah Kategori
                        </button>
                        <button id="selesaiKategori"
                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Selesai
                        </button>
                    </div>
                </div>

                {{-- STEP DOMPET --}}
                <div id="stepDompet" style="{{ $hasKategori && !$hasDompet ? 'display:block;' : 'display:none;' }}">
                    <h3 class="text-xl font-bold mb-3 text-blue-700">Buat dompet pertamamu 💰</h3>
                    <p class="mb-4 text-gray-600">
                        Dompet berfungsi sebagai tempat menyimpan catatan keuangan kamu.
                        Kamu bisa menambah lebih dari satu dompet, misalnya:
                        <b>Dompet Utama</b>, <b>Tabungan</b>, atau <b>Saldo E-Wallet</b>.
                    </p>

                    <form id="formDompet">
                        @csrf
                        <input type="text" id="namaDompet" name="nama_dompet" placeholder="Contoh: Dompet Utama"
                            class="w-full border rounded-lg px-3 py-2 mb-3 focus:ring-2 focus:ring-blue-500" required>

                        <div class="flex gap-2">
                            <button type="button" id="tambahDompet"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                + Tambah Dompet Lagi
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Selesai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function closeModal() {
                document.getElementById('setupModal').style.display = 'none';
            }

            // --- PILIH kategori ---
            function toggleKategori(item) {
                const color = item.dataset.color;
                if (item.classList.contains('selected')) {
                    item.classList.remove('selected');
                    item.style.backgroundColor = '#fff';
                } else {
                    item.classList.add('selected');
                    item.style.backgroundColor = color;
                }
            }

            document.querySelectorAll('.kategori-item').forEach(item =>
                item.addEventListener('click', () => toggleKategori(item))
            );

            // --- TAMBAH kategori baru ---
            document.getElementById('tambahKategori')?.addEventListener('click', () => {
                const input = document.getElementById('kategoriLain');
                const type = document.getElementById('kategoriType').value;
                const value = input.value.trim();
                if (!value) return;

                const colorMap = {
                    'Masuk': '#bbf7d0',
                    'Keluar': '#fecaca',
                    'Withdraw': '#e9d5ff'
                };

                const container = document.getElementById('kategoriContainer');
                const div = document.createElement('div');
                div.className = 'kategori-item border rounded-lg px-3 py-2 cursor-pointer transition selected';
                div.dataset.value = value;
                div.dataset.type = type;
                div.dataset.color = colorMap[type];
                div.style.backgroundColor = colorMap[type];
                div.style.borderColor = '#999';
                div.innerText = `${value} (${type})`;
                div.addEventListener('click', () => toggleKategori(div));
                container.appendChild(div);
                input.value = '';
            });

            // --- SELESAI kategori ---
            document.getElementById('selesaiKategori')?.addEventListener('click', async () => {
                const selected = Array.from(document.querySelectorAll('.kategori-item.selected')).map(el => ({
                    nama: el.dataset.value,
                    type: el.dataset.type
                }));

                if (selected.length === 0) {
                    Swal.fire('Peringatan', 'Pilih minimal satu kategori!', 'warning');
                    return;
                }

                try {
                    const res = await fetch("{{ route('setup.kategori') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            kategori: selected
                        })
                    });

                    const data = await res.json();
                    if (data.success) {
                        Swal.fire('Berhasil!', data.message, 'success').then(() => {
                            document.getElementById('stepKategori').style.display = 'none';
                            document.getElementById('stepDompet').style.display = 'block';
                        });
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                } catch (err) {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan kategori.', 'error');
                }
            });

            // --- SIMPAN & TAMBAH dompet ---
            document.getElementById('tambahDompet')?.addEventListener('click', async function() {
                const namaDompet = document.getElementById('namaDompet').value.trim();
                if (!namaDompet) {
                    Swal.fire('Peringatan', 'Nama dompet tidak boleh kosong!', 'warning');
                    return;
                }

                try {
                    const res = await fetch("{{ route('setup.dompet') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            nama_dompet: namaDompet
                        })
                    });
                    const data = await res.json();
                    if (data.success) {
                        Swal.fire('Berhasil!', 'Dompet berhasil ditambahkan.', 'success');
                        document.getElementById('namaDompet').value = '';
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                } catch {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menambah dompet.', 'error');
                }
            });

            document.getElementById('formDompet')?.addEventListener('submit', async function(e) {
                e.preventDefault();
                const namaDompet = document.getElementById('namaDompet').value.trim();

                if (!namaDompet) {
                    Swal.fire('Peringatan', 'Nama dompet tidak boleh kosong!', 'warning');
                    return;
                }

                try {
                    const res = await fetch("{{ route('setup.dompet') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            nama_dompet: namaDompet
                        })
                    });
                    const data = await res.json();
                    if (data.success) {
                        Swal.fire('Selesai!', 'Semua setup awal berhasil disimpan.', 'success').then(() => {
                            closeModal();
                            location.reload();
                        });
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                } catch {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan dompet.', 'error');
                }
            });
        </script>

        <style>
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: scale(0.95);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .animate-fade-in {
                animation: fade-in 0.3s ease-out forwards;
            }

            .kategori-item {
                transition: all 0.3s ease;
            }

            .kategori-item.selected {
                border-color: #22c55e;
            }
        </style>
    @endif



    <!-- Overlay (untuk mobile & tablet) -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-30 z-40 hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="bg-white shadow-md w-64 p-4 flex flex-col justify-between fixed h-screen transition-all duration-300 z-50 -translate-x-full lg:translate-x-0">
        <div>
            <!-- Logo -->
            <div class="flex align-middle items-center gap-2 mb-8">
                <img class="w-8" src="{{ asset('assets/images/logo-noname.png') }}" alt="Logo">
                <h1 id="logoText" class="text-lg font-semibold transition-all">Lacak Duit</h1>
            </div>

            <!-- Menu -->
            <nav class="flex flex-col gap-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition group">
                    <i class="bi bi-grid-1x2 text-blue-600"></i>
                    <span class="text-sm group-hover:font-medium transition-all menu-text">Dashboard</span>
                </a>

                <a href="{{ route('transaksi') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition group">
                    <i class="bi bi-arrow-left-right text-blue-600"></i>
                    <span class="text-sm group-hover:font-medium transition-all menu-text">Transaksi</span>
                </a>

                <a href="{{ route('dompet') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition group">
                    <i class="bi bi-wallet2 text-blue-600"></i>
                    <span class="text-sm group-hover:font-medium transition-all menu-text">Dompet</span>
                </a>

                <a href="{{ route('kategori') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition group">
                    <i class="bi bi-tags text-blue-600"></i>
                    <span class="text-sm group-hover:font-medium transition-all menu-text">Kategori</span>
                </a>

                <a href="#" onclick="showComingSoon()"
                    class="flex items-center gap-3 p-3 rounded-lg cursor-not-allowed opacity-60 hover:bg-gray-100 transition group">
                    <i class="bi bi-bell text-gray-400"></i>
                    <span class="text-sm group-hover:font-medium transition-all menu-text">Pengingat Rekap
                        Transaksi</span>
                    <span
                        class="ml-auto bg-yellow-100 text-yellow-700 text-xs font-medium px-2 py-0.5 rounded transition-all menu-text">Segera</span>
                </a>

                <!-- 🔹 Menu Feedback -->
                <a href="{{ route('feedback.create') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition group">
                    <i class="bi bi-chat-dots text-blue-600"></i>
                    <span class="text-sm group-hover:font-medium transition-all menu-text">Kirim Feedback</span>
                </a>
            </nav>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-400 watermark space-y-1">
            <p>© 2025 LacakDuit</p>
            <p>
                by
                <a class="underline text-sky-400" href="http://manzweb.my.id" target="_blank"
                    rel="noopener noreferrer">
                    manzweb.my.id
                </a>
            </p>
            <p class="text-gray-300 mt-2">v1.0.0</p>
        </div>
    </aside>

    <!-- Main Content -->
    <div id="mainContent" class="flex-1 transition-all duration-300 ml-0 lg:ml-64">

        <!-- Topbar -->
        <header id="topbar"
            class="flex items-center justify-between bg-white shadow-sm px-6 py-3 sticky top-0 z-30 transition-all duration-300">
            <div class="flex items-center gap-3">
                <!-- Hamburger -->
                <button id="toggleSidebar" class="p-2 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Search -->
                <div class="relative">
                    <input type="text" placeholder="Cari sesuatu..."
                        class="border rounded-lg pl-10 pr-4 py-2 text-sm w-64 focus:ring-2 focus:ring-blue-500 focus:outline-none transition" />
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                    </svg>
                </div>
            </div>

            <!-- Profile -->
            <div class="relative">
                <button id="profileBtn" class="flex items-center gap-3 hover:bg-gray-100 rounded-full p-2 transition">
                    <img src="{{ asset('assets/images/avatar.png') }}" alt="profile"
                        class="w-9 h-9 rounded-full" />
                    <i class="bi bi-gear w-5 h-5 text-gray-500"></i>
                </button>

                <div id="dropdownMenu"
                    class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border p-2 text-sm">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-3 py-2 hover:bg-gray-100 rounded">Profil</a>
                    <hr class="my-1" />
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-3 py-2 text-red-500 hover:bg-red-50 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Halaman Dinamis -->
        <main class="p-6">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="text-center text-sm text-gray-500 mt-10 mb-4">
            Dukung Lacak Duit melalui
            <a href="https://saweria.co/namakamu" target="_blank" class="text-blue-500 hover:underline">
                tautan ini
            </a>.
        </footer>
    </div>




    <!-- Script Sidebar -->
    <script>
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("mainContent");
        const toggleSidebar = document.getElementById("toggleSidebar");
        const profileBtn = document.getElementById("profileBtn");
        const dropdownMenu = document.getElementById("dropdownMenu");
        const overlay = document.getElementById("overlay");

        let collapsed = false;

        toggleSidebar.addEventListener("click", () => {
            if (window.innerWidth >= 1024) {
                collapsed = !collapsed;
                sidebar.classList.toggle("w-64");
                sidebar.classList.toggle("w-20");
                document.querySelectorAll(".menu-text").forEach((e) => e.classList.toggle("hidden"));
                document.querySelector(".watermark").classList.toggle("hidden");
                document.getElementById("logoText").classList.toggle("hidden");
                mainContent.style.marginLeft = collapsed ? "5rem" : "16rem";
            } else {
                sidebar.classList.remove("-translate-x-full");
                overlay.classList.remove("hidden");
            }
        });

        overlay.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
            overlay.classList.add("hidden");
        });

        profileBtn.addEventListener("click", () => dropdownMenu.classList.toggle("hidden"));

        document.addEventListener("click", (e) => {
            if (!profileBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });

        window.addEventListener("resize", () => {
            if (window.innerWidth < 1024) {
                sidebar.classList.add("-translate-x-full");
                overlay.classList.add("hidden");
                mainContent.style.marginLeft = "0";
            } else {
                sidebar.classList.remove("-translate-x-full");
                overlay.classList.add("hidden");
                mainContent.style.marginLeft = collapsed ? "5rem" : "16rem";
            }
        });
    </script>

    <script>
        function showComingSoon() {
            Swal.fire({
                icon: 'info',
                title: 'Segera Hadir!',
                text: 'Fitur pengingat rekap transaksi akan segera tersedia.',
                confirmButtonColor: '#3085d6'
            });
        }
    </script>

    @stack('scripts')
    @livewireScripts

</body>

</html>
