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
</head>

<body class="bg-gray-50 min-h-screen flex text-gray-800 antialiased">

    <!-- Overlay (untuk mobile) -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-30 z-40 hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="bg-white shadow-md w-64 p-4 flex flex-col justify-between fixed h-screen transition-all duration-300 z-50 -translate-x-full md:translate-x-0">
        <div>
            <!-- Logo -->
            <div class="flex align-middle items-center gap-2 mb-8">
                {{-- <div class="bg-blue-600 text-white p-2 rounded-lg text-xl font-bold">F</div> --}}
                <img class="w-8" src="{{ asset('assets/images/logo-noname.png') }}" alt="Logo">

                <h1 id="logoText" class="text-lg font-semibold transition-all">Lacak Duit</h1>
            </div>

            <!-- Menu -->
            <nav class="flex flex-col gap-2 ">
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
                        class="ml-auto bg-yellow-100 text-yellow-700 text-xs font-medium px-2 py-0.5 rounded">Segera</span>
                </a>

            </nav>
        </div>

        <!-- Footer / Watermark -->
        <div class="text-center text-xs text-gray-400 watermark space-y-1">
            <p>© 2025 LacakDuit</p>
            <p>
                by
                <a class="underline text-sky-400" href="http://manzweb.my.id" target="_blank" rel="noopener noreferrer">
                    manzweb.my.id
                </a>
            </p>

            <!-- Link ke halaman feedback -->
            <a href="{{ route('feedback.create') }}" class="text-sky-400 underline hover:text-sky-500">
                Kirim Feedback 💬
            </a>

        </div>
    </aside>

    <!-- Main Content -->
    <div id="mainContent" class="flex-1 transition-all duration-300 ml-0 md:ml-64">

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
                    <img src="https://i.pravatar.cc/40" alt="profile" class="w-9 h-9 rounded-full" />
                    <i class="bi bi-gear w-5 h-5 text-gray-500"></i>
                </button>

                <div id="dropdownMenu"
                    class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border p-2 text-sm">
                    <a href="#" class="block px-3 py-2 hover:bg-gray-100 rounded">Profil</a>
                    <a href="#" class="block px-3 py-2 hover:bg-gray-100 rounded">Pengaturan</a>
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

        <!-- Halaman dinamis -->
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>

    <!-- Script Sidebar -->
    <script>
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("mainContent");
        const toggleSidebar = document.getElementById("toggleSidebar");
        const profileBtn = document.getElementById("profileBtn");
        const dropdownMenu = document.getElementById("dropdownMenu");
        const overlay = document.getElementById("overlay");
        const topbar = document.getElementById("topbar");

        let collapsed = false;

        toggleSidebar.addEventListener("click", () => {
            if (window.innerWidth >= 768) {
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
            if (!profileBtn.contains(e.target) && !dropdownMenu.contains(e.target)) dropdownMenu.classList.add(
                "hidden");
        });

        window.addEventListener("resize", () => {
            if (window.innerWidth < 768) {
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

    {{-- sweet allert --}}
    <script>
        function showComingSoon() {
            Swal.fire({
                title: 'Fitur Segera Hadir 🚧',
                text: 'Fitur pengingat rekap transaksi sedang dalam pengembangan.',
                icon: 'info',
                confirmButtonText: 'Oke, Saya Tunggu 😁',
                confirmButtonColor: '#2563eb',
            });
        }
    </script>

    @stack('scripts')
    @livewireScripts

</body>

</html>
