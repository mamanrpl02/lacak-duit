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

            {{-- Rating Bintang --}}
            <div class="text-center">
                <label class="block text-sm font-medium text-gray-600 mb-2">Seberapa Puas Kamu?</label>
                <div class="flex justify-center space-x-2" id="ratingStars">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg data-value="{{ $i }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            stroke-width="1.5"
                            class="star w-10 h-10 cursor-pointer text-gray-300 hover:text-yellow-400 transition"
                            fill="none" stroke="#D1D5DB">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.48 3.499a.562.562 0 011.04 0l2.01 4.074a.563.563 0 00.424.308l4.502.654a.562.562 0 01.312.959l-3.257 3.176a.563.563 0 00-.162.497l.768 4.478a.562.562 0 01-.816.592L12 16.347l-4.032 2.12a.562.562 0 01-.816-.592l.768-4.478a.562.562 0 00-.162-.497L4.5 9.494a.562.562 0 01.312-.959l4.502-.654a.563.563 0 00.424-.308l2.01-4.074z" />
                        </svg>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="ratingValue" required>
                @error('rating')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pesan --}}
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
        const stars = document.querySelectorAll('.star');
        const ratingValue = document.getElementById('ratingValue');
        const form = document.getElementById('feedbackForm');
        const btn = document.getElementById('submitBtn');
        const spinner = document.getElementById('loadingSpinner');

        // === LOGIKA PILIH BINTANG ===
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                ratingValue.value = value;

                stars.forEach((s, i) => {
                    if (i < value) {
                        s.setAttribute('fill', '#FACC15');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.setAttribute('fill', 'none');
                        s.classList.add('text-gray-300');
                    }
                });
            });
        });

        // === AJAX SUBMIT ===
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!ratingValue.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Rating Dulu',
                    text: 'Silakan beri rating sebelum mengirim feedback.',
                    confirmButtonColor: '#facc15',
                });
                return;
            }

            btn.disabled = true;
            spinner.classList.remove('hidden');
            btn.classList.add('opacity-70', 'cursor-not-allowed');

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terima kasih!',
                        text: 'Feedback kamu sudah terkirim.',
                        showConfirmButton: false,
                        timer: 2500
                    });

                    form.reset();
                    ratingValue.value = '';
                    stars.forEach(s => {
                        s.setAttribute('fill', 'none');
                        s.classList.add('text-gray-300');
                    });
                } else {
                    const data = await response.json().catch(() => ({}));

                    if (response.status === 400 && data.error) {
                        // 🔥 Pesan spesifik untuk batas 5 feedback
                        Swal.fire({
                            icon: 'info',
                            title: 'Batas Feedback Tercapai',
                            text: data.error,
                            confirmButtonColor: '#2563eb'
                        });

                        btn.disabled = true;
                        btn.classList.add('opacity-50', 'cursor-not-allowed');
                    } else if (response.status === 422 && data.errors) {
                        const messages = Object.values(data.errors).flat().join('\n');
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validasi gagal',
                            text: messages,
                            confirmButtonColor: '#f59e0b'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Mengirim',
                            text: data.message ||
                                'Terjadi kesalahan saat mengirim feedback. Coba lagi nanti.',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Koneksi',
                    text: 'Tidak dapat terhubung ke server. Periksa koneksi internetmu.',
                    confirmButtonColor: '#ef4444'
                });
            } finally {
                spinner.classList.add('hidden');
                if (!btn.classList.contains('opacity-50')) {
                    btn.disabled = false;
                    btn.classList.remove('opacity-70', 'cursor-not-allowed');
                }
            }
        });
    </script>
</x-app-layout>
