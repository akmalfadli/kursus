@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan - ' . config('app.name'))
@section('description', 'Syarat dan Ketentuan Kursus Ujian Perangkat Desa')

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
            <h1 class="text-3xl lg:text-4xl font-light text-slate-800 mb-2">Syarat dan Ketentuan</h1>
            <p class="text-sm text-slate-500 mb-8">Terakhir diperbarui: {{ now()->format('d F Y') }}</p>

            <div class="prose prose-slate max-w-none space-y-6">
                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">1. Penerimaan Syarat</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Dengan mengakses dan menggunakan layanan Kursus Ujian Perangkat Desa, Anda menyetujui untuk terikat oleh Syarat dan Ketentuan ini. Jika Anda tidak setuju dengan bagian manapun dari syarat ini, mohon untuk tidak menggunakan layanan kami.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">2. Definisi</h2>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li><strong>"Kami", "Kita"</strong> merujuk pada Kursus Ujian Perangkat Desa</li>
                        <li><strong>"Pengguna", "Anda"</strong> merujuk pada individu yang menggunakan layanan kami</li>
                        <li><strong>"Layanan"</strong> merujuk pada platform pembelajaran online dan semua materi kursus</li>
                        <li><strong>"Konten"</strong> merujuk pada semua materi pembelajaran, video, dokumen, dan sumber daya lainnya</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">3. Pendaftaran dan Akun</h2>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">3.1. Persyaratan Pendaftaran</h3>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Anda harus berusia minimal 18 tahun</li>
                        <li>Informasi yang diberikan harus akurat dan lengkap</li>
                        <li>Anda bertanggung jawab untuk menjaga kerahasiaan akun Anda</li>
                        <li>Satu akun hanya untuk satu pengguna (tidak boleh dibagikan)</li>
                    </ul>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">3.2. Keamanan Akun</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Anda bertanggung jawab atas semua aktivitas yang terjadi di akun Anda. Segera laporkan jika terjadi penggunaan tidak sah atau pelanggaran keamanan.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">4. Pembayaran dan Pengembalian Dana</h2>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">4.1. Harga dan Pembayaran</h3>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Harga kursus tertera dalam Rupiah (IDR)</li>
                        <li>Pembayaran diproses melalui payment gateway resmi (Duitku)</li>
                        <li>Kami berhak mengubah harga dengan pemberitahuan sebelumnya</li>
                        <li>Harga yang berlaku adalah harga saat pembelian</li>
                    </ul>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">4.2. Kebijakan Pengembalian Dana</h3>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Garansi uang kembali 30 hari jika tidak puas</li>
                        <li>Permintaan refund dapat diajukan melalui email support</li>
                        <li>Refund akan diproses maksimal 14 hari kerja</li>
                        <li>Akses kursus akan dicabut setelah refund disetujui</li>
                    </ul>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">4.3. Pembatalan Refund</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">Kami berhak menolak refund jika:</p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Permintaan diajukan lebih dari 30 hari setelah pembelian</li>
                        <li>Terbukti ada penyalahgunaan konten (download ilegal, pembagian akun)</li>
                        <li>Telah menyelesaikan lebih dari 80% materi kursus</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">5. Hak Kekayaan Intelektual</h2>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">5.1. Kepemilikan Konten</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Semua konten, termasuk namun tidak terbatas pada video, dokumen, soal latihan, desain, logo, dan materi pembelajaran adalah milik kami dan dilindungi oleh hak cipta.
                    </p>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">5.2. Lisensi Penggunaan</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">Kami memberikan lisensi terbatas untuk:</p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Mengakses dan melihat konten untuk keperluan pembelajaran pribadi</li>
                        <li>Download materi untuk penggunaan offline pribadi</li>
                        <li>Mencetak materi untuk keperluan belajar pribadi</li>
                    </ul>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">5.3. Larangan</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">Anda DILARANG untuk:</p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Membagikan, menjual, atau mendistribusikan konten</li>
                        <li>Merekam, mengunduh ulang, atau menyalin konten untuk tujuan komersial</li>
                        <li>Memodifikasi atau membuat karya turunan dari konten</li>
                        <li>Membagikan akun atau kredensial login</li>
                        <li>Menggunakan konten untuk membuat kursus kompetitor</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">6. Penggunaan yang Dapat Diterima</h2>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">6.1. Kode Etik</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">Dalam menggunakan layanan kami, Anda setuju untuk:</p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Menggunakan layanan hanya untuk tujuan yang sah</li>
                        <li>Tidak melakukan kecurangan dalam ujian atau latihan</li>
                        <li>Menghormati hak pengguna lain</li>
                        <li>Tidak mengirim spam atau konten berbahaya</li>
                        <li>Mematuhi semua hukum yang berlaku</li>
                    </ul>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">6.2. Konsekuensi Pelanggaran</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Pelanggaran terhadap syarat ini dapat mengakibatkan penangguhan atau penghentian akses ke layanan tanpa pengembalian dana.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">7. Akses dan Ketersediaan</h2>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">7.1. Akses Kursus</h3>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Akses seumur hidup ke materi kursus yang dibeli</li>
                        <li>Update materi secara berkala tanpa biaya tambahan</li>
                        <li>Akses melalui web browser dan aplikasi mobile (jika tersedia)</li>
                    </ul>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">7.2. Ketersediaan Layanan</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Kami berusaha menjaga layanan tersedia 24/7, namun tidak menjamin 100% uptime. Maintenance berkala mungkin dilakukan dengan atau tanpa pemberitahuan sebelumnya.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">8. Penafian dan Batasan Tanggung Jawab</h2>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">8.1. Penafian</h3>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Layanan disediakan "sebagaimana adanya" tanpa jaminan apapun</li>
                        <li>Kami tidak menjamin hasil ujian atau penerimaan pekerjaan</li>
                        <li>Konten bersifat edukatif dan tidak menggantikan konsultasi profesional</li>
                        <li>Kami tidak bertanggung jawab atas kerugian yang timbul dari penggunaan layanan</li>
                    </ul>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">8.2. Batasan Tanggung Jawab</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Tanggung jawab kami terbatas pada jumlah yang Anda bayarkan untuk kursus. Kami tidak bertanggung jawab atas kerugian tidak langsung, insidental, atau konsekuensial.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">9. Perubahan Layanan</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Kami berhak untuk:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Memodifikasi atau menghentikan layanan kapan saja</li>
                        <li>Mengubah konten kursus untuk peningkatan kualitas</li>
                        <li>Menambah atau mengurangi fitur platform</li>
                        <li>Mengubah struktur harga dengan pemberitahuan</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">10. Penghentian</h2>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">10.1. Penghentian oleh Pengguna</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Anda dapat menghentikan akun Anda kapan saja dengan menghubungi support kami. Penghentian tidak otomatis memberikan hak pengembalian dana.
                    </p>

                    <h3 class="text-xl font-medium text-slate-700 mb-3">10.2. Penghentian oleh Kami</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Kami berhak menghentikan akses Anda jika terjadi pelanggaran terhadap Syarat dan Ketentuan ini tanpa pengembalian dana.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">11. Hukum yang Berlaku</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Syarat dan Ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Republik Indonesia. Setiap perselisihan akan diselesaikan melalui pengadilan di wilayah hukum Indonesia.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">12. Perubahan Syarat dan Ketentuan</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Kami dapat memperbarui Syarat dan Ketentuan ini kapan saja. Perubahan akan diberitahukan melalui:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-4">
                        <li>Email notifikasi ke alamat terdaftar</li>
                        <li>Pengumuman di platform</li>
                        <li>Update tanggal "Terakhir diperbarui"</li>
                    </ul>
                    <p class="text-slate-600 leading-relaxed">
                        Penggunaan layanan setelah perubahan dianggap sebagai penerimaan Syarat dan Ketentuan yang baru.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-light text-slate-800 mb-4">13. Kontak</h2>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Untuk pertanyaan tentang Syarat dan Ketentuan ini, hubungi kami:
                    </p>
                    <div class="bg-blue-50 rounded-lg p-6 space-y-2">
                        <p class="text-slate-700"><strong>Email:</strong> <a href="mailto:kursus.digidesa@gmail.com" class="text-teal-600 hover:underline">kursus.digidesa@gmail.com</a></p>
                        <p class="text-slate-700"><strong>WhatsApp:</strong> +62 857-0713-730</p>
                        <p class="text-slate-700"><strong>Jam Operasional:</strong> Senin-Jumat, 09:00-17:00 WIB</p>
                    </div>
                </section>

                <section class="bg-teal-50 rounded-lg p-6 mt-8">
                    <p class="text-slate-700 text-sm leading-relaxed">
                        <strong>Penting:</strong> Dengan melakukan pembelian atau menggunakan layanan kami, Anda menyatakan telah membaca, memahami, dan menyetujui seluruh Syarat dan Ketentuan ini. Jika Anda tidak setuju, mohon untuk tidak melanjutkan pembelian atau penggunaan layanan.
                    </p>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
