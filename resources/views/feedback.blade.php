<x-app-layout>
    <div class="max-w-3xl mx-auto mt-12 bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-semibold text-gray-800">Bantu Kami Jadi Lebih Baik</h2>
            <p class="text-gray-500 mt-2 max-w-md mx-auto">
                Kami sangat menghargai pendapat dan saran kamu untuk meningkatkan kualitas LacakDuit.
            </p>
        </div>

        <form method="POST" action="{{ route('feedback.store') }}" class="space-y-6" id="feedbackForm">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" readonly
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" readonly
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Pesan atau Masukan</label>
                <textarea name="feedback" required rows="5"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-400 transition placeholder:text-gray-400"
                    placeholder="Tuliskan saran, kritik, atau pengalaman kamu menggunakan LacakDuit..."></textarea>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-sky-500 transition">
                    ← Kembali ke Dashboard
                </a>
                <button type="submit" id="submitBtn"
                    class="bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <span>Kirim Feedback</span>
                    <svg id="loadingSpinner" class="hidden animate-spin h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <script>
        const form = document.getElementById('feedbackForm');
        const btn = document.getElementById('submitBtn');
        const spinner = document.getElementById('loadingSpinner');

        form.addEventListener('submit', () => {
            btn.disabled = true;
            spinner.classList.remove('hidden');
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        });
    </script>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444'
            });
        </script>
    @endif


    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    @endif


</x-app-layout>
