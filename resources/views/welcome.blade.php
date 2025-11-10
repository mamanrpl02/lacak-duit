<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lacak Duit - Kelola Keuanganmu dengan Mudah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1170/1170627.png">
</head>
<body class="bg-white text-gray-800">

  <!-- Navbar -->
  <header class="fixed top-0 w-full bg-white/80 backdrop-blur-lg shadow-sm z-50">
    <div class="max-w-6xl mx-auto flex items-center justify-between px-6 py-4">
      <h1 class="text-2xl font-bold text-emerald-600">LacakDuit</h1>
      <nav class="hidden md:flex space-x-8 font-medium">
        <a href="#fitur" class="hover:text-emerald-600">Fitur</a>
        <a href="#screenshot" class="hover:text-emerald-600">Tampilan</a>
        <a href="#testimoni" class="hover:text-emerald-600">Testimoni</a>
        <a href="#cta" class="hover:text-emerald-600">Mulai</a>
      </nav>
      <a href="https://app.lacakduit.manzweb.my.id"
         class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-700 transition">
        Coba Sekarang
      </a>
    </div>
  </header>

  <!-- Hero -->
  <section class="pt-32 pb-20 text-center bg-gradient-to-b from-emerald-50 to-white">
    <div class="max-w-3xl mx-auto px-6">
      <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
        Kelola <span class="text-emerald-600">Keuanganmu</span> Lebih Cerdas dengan LacakDuit 💰
      </h1>
      <p class="text-gray-600 mb-8">
        Aplikasi pencatat keuangan yang memudahkanmu mengatur pengeluaran, mencatat pemasukan,
        dan melihat laporan keuangan harian dengan tampilan modern dan mudah digunakan.
      </p>
      <a href="https://app.lacakduit.manzweb.my.id"
         class="bg-emerald-600 text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-emerald-700 transition">
        Mulai Sekarang
      </a>
    </div>
    <div class="mt-16">
      <img src="https://cdn.dribbble.com/users/90241/screenshots/17352965/media/7ed262bc4f0fcbfbef176bc70366e7f1.png?compress=1&resize=1200x900"
           alt="Dashboard LacakDuit" class="mx-auto rounded-2xl shadow-lg w-10/12 md:w-8/12">
    </div>
  </section>

  <!-- Fitur -->
  <section id="fitur" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-12">✨ Fitur Unggulan</h2>
      <div class="grid md:grid-cols-3 gap-10">
        <div class="p-8 border rounded-2xl shadow-sm hover:shadow-md transition">
          <img src="https://cdn-icons-png.flaticon.com/512/3246/3246797.png" class="w-16 mx-auto mb-4" alt="">
          <h3 class="text-xl font-semibold mb-2">Catat Transaksi</h3>
          <p class="text-gray-600 text-sm">Tambahkan pemasukan dan pengeluaran dengan mudah, kapan pun dan di mana pun.</p>
        </div>
        <div class="p-8 border rounded-2xl shadow-sm hover:shadow-md transition">
          <img src="https://cdn-icons-png.flaticon.com/512/3228/3228641.png" class="w-16 mx-auto mb-4" alt="">
          <h3 class="text-xl font-semibold mb-2">Laporan Keuangan</h3>
          <p class="text-gray-600 text-sm">Dapatkan ringkasan keuangan otomatis untuk memantau kondisi finansialmu.</p>
        </div>
        <div class="p-8 border rounded-2xl shadow-sm hover:shadow-md transition">
          <img src="https://cdn-icons-png.flaticon.com/512/3600/3600913.png" class="w-16 mx-auto mb-4" alt="">
          <h3 class="text-xl font-semibold mb-2">Manajemen Dompet</h3>
          <p class="text-gray-600 text-sm">Kelola berbagai sumber uang (tunai, rekening, e-wallet) dalam satu tempat.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Screenshot -->
  <section id="screenshot" class="py-20 bg-emerald-50">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-10">📱 Tampilan Aplikasi</h2>
      <div class="grid md:grid-cols-3 gap-8">
        <img src="https://cdn.dribbble.com/users/2151923/screenshots/15597336/media/3d239eebc6b818a2601798c191929de1.png?compress=1&resize=800x600" class="rounded-xl shadow-md" alt="">
        <img src="https://cdn.dribbble.com/users/1355613/screenshots/11268157/media/08d10cd7283056b92a48d5a2ab0dd7d1.png?compress=1&resize=800x600" class="rounded-xl shadow-md" alt="">
        <img src="https://cdn.dribbble.com/users/2533294/screenshots/14712107/media/183c8a23e7506a891c7f60f2c4deaf6c.png?compress=1&resize=800x600" class="rounded-xl shadow-md" alt="">
      </div>
    </div>
  </section>

  <!-- Testimoni -->
  <section id="testimoni" class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-12">💬 Apa Kata Pengguna</h2>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="p-6 border rounded-2xl shadow-sm hover:shadow-md transition">
          <p class="italic text-gray-600 mb-4">“Sekarang aku bisa tahu ke mana aja uangku pergi tiap bulan. Super berguna!”</p>
          <h4 class="font-semibold text-emerald-600">— Rina, Mahasiswa</h4>
        </div>
        <div class="p-6 border rounded-2xl shadow-sm hover:shadow-md transition">
          <p class="italic text-gray-600 mb-4">“Desainnya clean banget, mudah dipakai. Cocok buat anak muda.”</p>
          <h4 class="font-semibold text-emerald-600">— Aldi, Freelancer</h4>
        </div>
        <div class="p-6 border rounded-2xl shadow-sm hover:shadow-md transition">
          <p class="italic text-gray-600 mb-4">“Aku bisa atur kas dan tabungan dengan lebih rapi. Mantap!”</p>
          <h4 class="font-semibold text-emerald-600">— Bima, Siswa SMK</h4>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section id="cta" class="py-20 bg-emerald-600 text-white text-center">
    <h2 class="text-4xl font-bold mb-6">Yuk mulai kelola uangmu sekarang!</h2>
    <p class="mb-8 text-lg">Bebas digunakan, ringan, dan membantu kamu jadi lebih hemat 💪</p>
    <a href="https://app.lacakduit.manzweb.my.id"
       class="bg-white text-emerald-700 font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 transition">
       Gunakan LacakDuit Sekarang
    </a>
  </section>

  <!-- Footer -->
  <footer class="py-8 text-center text-sm text-gray-500 bg-gray-50">
    © 2025 LacakDuit. Dibuat dengan 💚 oleh Mamman.
  </footer>

</body>
</html>
