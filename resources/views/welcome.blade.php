<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lacak Duit - Aplikasi Pencatat Keuangan Pribadi & Dompet Digital</title>

    <!-- ✅ Meta SEO -->
    <meta name="description"
        content="LacakDuit membantu kamu mengatur keuangan harian dengan mudah. Catat pengeluaran, kelola dompet, dan pantau laporan keuanganmu kapan saja!">
    <meta name="keywords"
        content="LacakDuit, aplikasi keuangan, catatan keuangan, dompet digital, manajemen uang, keuangan pribadi, tabungan, keuangan harian">
    <meta name="author" content="Mamman">
    <meta name="robots" content="index, follow">

    <!-- ✅ Open Graph (untuk dibagikan di WhatsApp, Instagram, Facebook, dll) -->
    <meta property="og:title" content="Lacak Duit - Aplikasi Keuangan Pribadi Modern" />
    <meta property="og:description"
        content="Catat pengeluaran, kelola dompet, dan lihat laporan keuangan dengan mudah lewat LacakDuit. Gratis & modern!" />
    <meta property="og:image" content="https://i.imgur.com/4U3EvK7.png" />
    <meta property="og:url" content="https://lacakduit.manzweb.my.id" />
    <meta property="og:type" content="website" />

    <!-- ✅ Favicon -->
    <link rel="icon" href="assets/image/logo-noname.png">

    <!-- ✅ Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>


    <style>
        /* ✅ Animasi Modern */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-fadeIn {
            animation: fadeIn 1s ease-in-out both;
        }

        .animate-fadeInUp {
            animation: fadeInUp 1s ease-out both;
        }

        .animate-delay-1 {
            animation-delay: 0.3s;
        }

        .animate-delay-2 {
            animation-delay: 0.6s;
        }

        .animate-delay-3 {
            animation-delay: 0.9s;
        }
    </style>
</head>

<body class="bg-white text-gray-800 scroll-smooth">

    <!-- Navbar -->
    <header class="fixed top-0 w-full bg-white/80 backdrop-blur-lg shadow-sm z-50 animate-fadeIn">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-6 py-4">
            <a href="#" class="text-2xl font-bold text-emerald-600">LacakDuit</a>
            <nav class="hidden md:flex space-x-8 font-medium">
                <a href="#fitur" class="hover:text-emerald-600">Fitur</a>
                <a href="#screenshot" class="hover:text-emerald-600">Tampilan</a>
                <a href="#testimoni" class="hover:text-emerald-600">Testimoni</a>
                <a href="#faq" class="hover:text-emerald-600">FAQ</a>
            </nav>
            <a href="{{ route('login') }}"
                class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-700 transition">
                Coba Sekarang
            </a>
        </div>
    </header>

    <!-- Hero -->
    <section class="pt-32 pb-20 text-center bg-gradient-to-b from-emerald-50 to-white">
        <div class="max-w-3xl mx-auto px-6 animate-fadeInUp">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                Kelola <span class="text-emerald-600">Keuanganmu</span> Lebih Cerdas dengan LacakDuit 💰
            </h1>
            <p class="text-gray-600 mb-8 text-lg">
                Aplikasi pencatat keuangan yang membantu kamu mengatur pengeluaran, mencatat pemasukan,
                dan melihat laporan keuangan harian dengan tampilan modern dan mudah digunakan.
            </p>
            <a href="https://app.lacakduit.manzweb.my.id"
                class="bg-emerald-600 text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-emerald-700 transition">
                Mulai Sekarang
            </a>
        </div>
        <div class="mt-16 animate-fadeInUp animate-delay-2">
            <img src="https://cdn.dribbble.com/userupload/11357115/file/original-fb91fc0d58f7a44660d0a5234688b8ed.png?resize=752x&vertical=center" alt="Dashboard LacakDuit"
                class="mx-auto rounded-2xl shadow-xl w-10/12 md:w-8/12">
        </div>
    </section>

    <!-- Fitur -->
    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-12 animate-fadeInUp">✨ Fitur Unggulan</h2>
            <div class="grid md:grid-cols-3 gap-10">
                <div
                    class="p-8 border rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-2 transition animate-fadeInUp animate-delay-1">
                    <img src="https://cdn-icons-png.flaticon.com/512/3246/3246797.png" class="w-16 mx-auto mb-4"
                        alt="">
                    <h3 class="text-xl font-semibold mb-2">Catat Transaksi</h3>
                    <p class="text-gray-600 text-sm">Tambahkan pemasukan dan pengeluaran dengan mudah, kapan pun dan di
                        mana pun.</p>
                </div>
                <div
                    class="p-8 border rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-2 transition animate-fadeInUp animate-delay-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/3228/3228641.png" class="w-16 mx-auto mb-4"
                        alt="">
                    <h3 class="text-xl font-semibold mb-2">Laporan Keuangan</h3>
                    <p class="text-gray-600 text-sm">Dapatkan ringkasan keuangan otomatis untuk memantau kondisi
                        finansialmu.</p>
                </div>
                <div
                    class="p-8 border rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-2 transition animate-fadeInUp animate-delay-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/3600/3600913.png" class="w-16 mx-auto mb-4"
                        alt="">
                    <h3 class="text-xl font-semibold mb-2">Manajemen Dompet</h3>
                    <p class="text-gray-600 text-sm">Kelola berbagai sumber uang (tunai, rekening, e-wallet) dalam satu
                        tempat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Screenshot -->
    <section id="screenshot" class="py-20 bg-emerald-50">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-10 animate-fadeInUp">📱    Tampilan Aplikasi</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <img src="https://cdn.dribbble.com/userupload/11357115/file/original-fb91fc0d58f7a44660d0a5234688b8ed.png?resize=752x&vertical=center"
                    class="rounded-xl shadow-lg hover:scale-105 transition animate-fadeInUp" alt="">
                <img src="https://cdn.dribbble.com/userupload/11357115/file/original-fb91fc0d58f7a44660d0a5234688b8ed.png?resize=752x&vertical=center"
                    class="rounded-xl shadow-lg hover:scale-105 transition animate-fadeInUp animate-delay-1"
                    alt="">
                <img src="https://cdn.dribbble.com/userupload/11357115/file/original-fb91fc0d58f7a44660d0a5234688b8ed.png?resize=752x&vertical=center"
                    class="rounded-xl shadow-lg hover:scale-105 transition animate-fadeInUp animate-delay-2"
                    alt="">
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section id="testimoni" class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-12 animate-fadeInUp">💬 Apa Kata Pengguna</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 border rounded-2xl shadow-sm hover:shadow-md transition animate-fadeInUp">
                    <p class="italic text-gray-600 mb-4">“Sekarang aku bisa tahu ke mana aja uangku pergi tiap bulan.
                        Super berguna!”</p>
                    <h4 class="font-semibold text-emerald-600">— Rina, Mahasiswa</h4>
                </div>
                <div
                    class="p-6 border rounded-2xl shadow-sm hover:shadow-md transition animate-fadeInUp animate-delay-1">
                    <p class="italic text-gray-600 mb-4">“Desainnya clean banget, mudah dipakai. Cocok buat anak muda.”
                    </p>
                    <h4 class="font-semibold text-emerald-600">— Aldi, Freelancer</h4>
                </div>
                <div
                    class="p-6 border rounded-2xl shadow-sm hover:shadow-md transition animate-fadeInUp animate-delay-2">
                    <p class="italic text-gray-600 mb-4">“Aku bisa atur kas dan tabungan dengan lebih rapi. Mantap!”</p>
                    <h4 class="font-semibold text-emerald-600">— Bima, Siswa SMK</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-20 bg-emerald-50">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-10 animate-fadeInUp">❓ Pertanyaan yang Sering Diajukan</h2>
            <div class="space-y-4">
                <details class="bg-white p-5 rounded-xl shadow-sm animate-fadeInUp">
                    <summary class="font-semibold text-emerald-700 cursor-pointer">Apakah LacakDuit gratis digunakan?
                    </summary>
                    <p class="mt-3 text-gray-600">Ya, LacakDuit bisa digunakan secara gratis tanpa batas fitur dasar.
                    </p>
                </details>
                <details class="bg-white p-5 rounded-xl shadow-sm animate-fadeInUp animate-delay-1">
                    <summary class="font-semibold text-emerald-700 cursor-pointer">Apakah data saya aman?</summary>
                    <p class="mt-3 text-gray-600">
                        Ya, aman digunakan 👍 <strong>Lacak Duit</strong> tidak menyimpan data sensitif pengguna.
                        Semua data keuangan hanya berupa catatan umum seperti pemasukan, pengeluaran, dan saldo dompet,
                        sedangkan kata sandi kamu dilindungi dengan enkripsi.
                    </p>
                </details>
                <details class="bg-white p-5 rounded-xl shadow-sm animate-fadeInUp animate-delay-2">
                    <summary class="font-semibold text-emerald-700 cursor-pointer">Apakah bisa digunakan di HP?
                    </summary>
                    <p class="mt-3 text-gray-600">Bisa banget! LacakDuit sudah dioptimalkan agar tampil sempurna di
                        layar smartphone.</p>
                </details>
                <details class="bg-white p-5 rounded-xl shadow-sm animate-fadeInUp animate-delay-5">
    <summary class="font-semibold text-emerald-700 cursor-pointer">Apakah ada fitur pengingat harian, target tabungan, atau catatan utang?</summary>
    <p class="mt-3 text-gray-600">
        Saat ini fitur seperti pengingat rekap harian, target tabungan bulanan (to-do list), serta pencatatan utang dan piutang masih dalam tahap pengembangan.
        Nantinya, semua fitur ini akan membantu kamu memantau keuangan lebih detail dan teratur setiap hari.
    </p>
</details>

<details class="bg-white p-5 rounded-xl shadow-sm animate-fadeInUp animate-delay-7">
    <summary class="font-semibold text-emerald-700 cursor-pointer">Apakah ada versi premium?</summary>
    <p class="mt-3 text-gray-600">
                Belum ada rencana untuk fitur premium atau berbayar. Saat ini, LacakDuit sepenuhnya gratis dan fokus menghadirkan pengalaman terbaik untuk mengatur keuangan pribadi anda.
    </p>
</details>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="cta" class="py-20 bg-emerald-600 text-white text-center animate-fadeInUp">
        <h2 class="text-4xl font-bold mb-6">Yuk mulai kelola uangmu sekarang!</h2>
        <p class="mb-8 text-lg">Bebas digunakan, ringan, dan membantu kamu jadi lebih hemat 💪</p>
        <a href="https://app.lacakduit.manzweb.my.id"
            class="bg-white text-emerald-700 font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 transition">
            Gunakan LacakDuit Sekarang
        </a>
    </section>

    <!-- Footer -->
    <footer class="py-8 text-center text-sm text-gray-500 bg-gray-50 animate-fadeIn">
        © 2025 LacakDuit. Dibuat dengan 💚 oleh <a href="https://manzweb.my.id">Maman</a>.
    </footer>

</body>

</html>
