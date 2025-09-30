@extends('layouts.app')

@section('title', 'Kebijakan Privasi - ' . config('app.name'))
@section('description', 'Kebijakan Privasi Kursus Ujian Perangkat Desa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-sm border-b border-blue-100 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 text-teal-600 hover:text-teal-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-medium">Kembali ke Beranda</span>
            </a>
        </div>
    </header>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 py-12 lg:py-20">
        <div class="bg-white rounded-xl shadow-lg p-8 lg:p-12">
            <h1 class="text-3xl lg:text-4xl font-light text-slate-800 mb-2">Kebijakan Privasi</h1>
            <p class="text-sm text-slate-500 mb-8">Terakhir diperbarui: {{ now()->format('d F Y') }}</p>

            <div class="prose prose-slate max-w-none space-y-6">
                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">1. Pendahuluan</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Selamat datang di Kursus Ujian Perangkat Desa. Kami menghargai kepercayaan Anda dan berkomitmen untuk melindungi privasi dan data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">2. Informasi yang Kami Kumpulkan</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">Kami mengumpulkan informasi berikut:</p>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">2.1. Informasi yang Anda Berikan</h3>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Nama lengkap</li>
                        <li>Alamat email</li>
                        <li>Nomor telepon/WhatsApp</li>
                        <li>Informasi pembayaran (diproses melalui payment gateway aman)</li>
                    </ul>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">2.2. Informasi yang Dikumpulkan Otomatis</h3>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Alamat IP</li>
                        <li>Jenis browser dan perangkat</li>
                        <li>Aktivitas pembelajaran (progress kursus, hasil ujian)</li>
                        <li>Log akses dan penggunaan platform</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">3. Penggunaan Informasi</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">Kami menggunakan informasi Anda untuk:</p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Menyediakan akses ke materi kursus</li>
                        <li>Memproses pembayaran dan transaksi</li>
                        <li>Mengirim konfirmasi pembelian dan akses kursus</li>
                        <li>Memberikan dukungan pelanggan</li>
                        <li>Mengirim update tentang kursus dan materi baru</li>
                        <li>Meningkatkan kualitas layanan kami</li>
                        <li>Mematuhi kewajiban hukum</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">4. Pembagian Informasi</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Kami tidak menjual atau menyewakan informasi pribadi Anda kepada pihak ketiga. Kami hanya membagikan informasi Anda dengan:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li><strong>Payment Gateway:</strong> Untuk memproses pembayaran (Duitku)</li>
                        <li><strong>Penyedia Layanan Email:</strong> Untuk mengirim email konfirmasi dan update</li>
                        <li><strong>Penyedia Hosting:</strong> Untuk menyimpan data platform secara aman</li>
                        <li><strong>Otoritas Hukum:</strong> Jika diwajibkan oleh hukum</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">5. Keamanan Data</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Kami menerapkan langkah-langkah keamanan teknis dan organisasi untuk melindungi data Anda:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Enkripsi SSL/TLS untuk semua transmisi data</li>
                        <li>Password terenkripsi dengan hashing algoritma</li>
                        <li>Akses terbatas ke data pribadi</li>
                        <li>Backup data berkala</li>
                        <li>Monitoring keamanan sistem 24/7</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">6. Hak Anda</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">Anda memiliki hak untuk:</p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li><strong>Akses:</strong> Meminta salinan data pribadi Anda</li>
                        <li><strong>Koreksi:</strong> Memperbarui atau memperbaiki data yang tidak akurat</li>
                        <li><strong>Penghapusan:</strong> Meminta penghapusan data pribadi Anda</li>
                        <li><strong>Portabilitas:</strong> Menerima data Anda dalam format yang dapat dibaca mesin</li>
                        <li><strong>Keberatan:</strong> Menolak pemrosesan data untuk tujuan tertentu</li>
                    </ul>
                    <p class="text-slate-600 leading-relaxed">
                        Untuk menggunakan hak-hak ini, hubungi kami di: <a href="mailto:support@kursusperangkatdesa.com" class="text-teal-600 hover:underline">support@kursusperangkatdesa.com</a>
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">7. Cookies dan Teknologi Pelacakan</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Kami menggunakan cookies dan teknologi serupa untuk meningkatkan pengalaman Anda:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li><strong>Cookies Esensial:</strong> Diperlukan untuk fungsi dasar platform</li>
                        <li><strong>Cookies Analitik:</strong> Membantu kami memahami cara penggunaan platform</li>
                        <li><strong>Cookies Preferensi:</strong> Menyimpan pengaturan Anda</li>
                    </ul>
                    <p class="text-slate-600 leading-relaxed">
                        Anda dapat mengatur preferensi cookies melalui pengaturan browser Anda.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">8. Retensi Data</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Kami menyimpan data pribadi Anda selama:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Akun Anda aktif</li>
                        <li>Diperlukan untuk memberikan layanan</li>
                        <li>Diwajibkan oleh hukum (minimal 5 tahun untuk data transaksi)</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">9. Privasi Anak</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Layanan kami ditujukan untuk pengguna berusia 18 tahun ke atas. Kami tidak dengan sengaja mengumpulkan informasi dari anak di bawah 18 tahun. Jika Anda adalah orang tua dan mengetahui anak Anda memberikan informasi pribadi kepada kami, silakan hubungi kami.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">10. Perubahan Kebijakan</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan akan diumumkan melalui:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Pemberitahuan di platform</li>
                        <li>Email ke alamat terdaftar</li>
                        <li>Update tanggal "Terakhir diperbarui" di halaman ini</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">11. Kontak</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, hubungi kami:
                    </p>
                    <div class="bg-blue-50 rounded-lg p-6 space-y-2">
                        <p class="text-slate-700"><strong>Email:</strong> <a href="mailto:kursus.digidesa@gmail.com" class="text-teal-600 hover:underline">kursus.digidesa@gmail.com</a></p>
                        <p class="text-slate-700"><strong>WhatsApp:</strong> +62 857-0713-730</p>
                        <p class="text-slate-700"><strong>Jam Operasional:</strong> Senin-Jumat, 09:00-17:00 WIB</p>
                    </div>
                </section>

                <section class="bg-teal-50 rounded-lg p-6 mt-8">
                    <p class="text-slate-700 text-sm leading-relaxed">
                        <strong>Perhatian:</strong> Dengan menggunakan layanan kami, Anda menyetujui pengumpulan dan penggunaan informasi sesuai dengan Kebijakan Privasi ini. Jika Anda tidak setuju dengan kebijakan ini, mohon untuk tidak menggunakan layanan kami.
                    </p>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
