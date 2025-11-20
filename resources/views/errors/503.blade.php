
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- TAILWIND CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Maintenance Mode</title>
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen p-6">
    <div class="text-center max-w-md">

        <!-- ICON -->
        <div class="animate-bounce mb-6">
            <svg class="mx-auto w-20 h-20 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m0 3.75h.007v.008H12v-.008zm9-3.75a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <!-- TITLE -->
        <h1 class="text-3xl font-bold mb-3">Sedang Maintenance ðŸš§</h1>

        <!-- DESCRIPTION -->
        <p class="text-gray-300 leading-relaxed">
            Kami sedang melakukan pemeliharaan sistem untuk memberikan pengalaman terbaik.
            Silakan kembali beberapa saat lagi.
        </p>

        <!-- LOADING ANIMATION -->
        <div class="mt-8 flex justify-center space-x-2">
            <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
            <div class="w-3 h-3 bg-blue-500 rounded-full animate-ping"></div>
            <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
        </div>

        <!-- FOOTER -->
        <p class="mt-8 text-sm text-gray-500">
             © {{ date('Y') }} — Website dalam perbaikan
        </p>
    </div>
</body>
</html>
