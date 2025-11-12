{{-- @extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found')) --}}

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="bg-gradient-to-br from-gray-50 to-gray-200 flex flex-col items-center justify-center min-h-screen text-center px-6">

    <!-- Icon / Number -->
    <div class="mb-6">
        <h1 class="text-[8rem] font-extrabold text-green-600 leading-none">404</h1>
    </div>

    <!-- Message -->
    <h2 class="text-2xl sm:text-3xl font-semibold text-gray-800">Halaman Tidak Ditemukan</h2>
    <p class="mt-3 text-gray-500 max-w-md">
        Sepertinya halaman yang kamu cari tidak tersedia atau sudah dipindahkan.
    </p>

    <!-- Button -->
    <a href="{{ url('/') }}"
        class="mt-8 inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-medium shadow hover:bg-green-700 transition-all duration-200">
        Kembali ke Beranda
    </a>

    <!-- Footer / Credit -->
    <p class="text-xs text-gray-400 mt-10">© {{ date('Y') }} LacakDuit. Semua hak dilindungi.</p>

</body>

</html>
