<?php
// database/seeders/ContentBlockSeeder.php

namespace Database\Seeders;

use App\Models\ContentBlock;
use Illuminate\Database\Seeder;

class ContentBlockSeeder extends Seeder
{
    public function run(): void
    {
        $contentBlocks = [
                        // API Integration Settings
            [
                'key' => 'api_trigger_url',
                'title' => 'API Trigger URL',
                'content' => '',
                'type' => 'text',
                'description' => 'URL endpoint untuk trigger API setelah pembayaran sukses',
                'is_active' => true
            ],
            [
                'key' => 'api_bearer_token',
                'title' => 'API Bearer Token',
                'content' => '',
                'type' => 'text',
                'description' => 'Bearer token untuk autentikasi API',
                'is_active' => true
            ],
            [
                'key' => 'api_enabled',
                'title' => 'Enable API Integration',
                'content' => '0',
                'type' => 'boolean',
                'description' => 'Aktifkan integrasi API setelah pembayaran sukses',
                'is_active' => true
            ],
            [
                'key' => 'default_class',
                'title' => 'Default Class/Kelas',
                'content' => 'Kelas Umum',
                'type' => 'text',
                'description' => 'Kelas default untuk siswa baru',
                'is_active' => true
            ],

            [
                'key' => 'hero_title',
                'title' => 'Hero Title',
                'content' => 'Kursus Ujian Perangkat Desa',
                'type' => 'text',
                'description' => 'Judul utama pada halaman landing',
                'is_active' => true
            ],
            [
                'key' => 'hero_subtitle',
                'title' => 'Hero Subtitle',
                'content' => 'Persiapkan diri Anda untuk sukses dalam ujian perangkat desa dengan materi terlengkap dan terpercaya',
                'type' => 'textarea',
                'description' => 'Subjudul pada halaman landing',
                'is_active' => true
            ],
            [
                'key' => 'about_title',
                'title' => 'About Title',
                'content' => 'Tentang Kursus',
                'type' => 'text',
                'description' => 'Judul section tentang kursus',
                'is_active' => true
            ],
            [
                'key' => 'about_content',
                'title' => 'About Content',
                'content' => 'Kursus komprehensif yang dirancang khusus untuk membantu Anda lulus ujian perangkat desa dengan materi terkini dan metode pembelajaran yang efektif.',
                'type' => 'textarea',
                'description' => 'Konten section tentang kursus',
                'is_active' => true
            ],
            [
                'key' => 'course_price',
                'title' => 'Harga Kursus',
                'content' => '299000',
                'type' => 'number',
                'description' => 'Harga kursus dalam rupiah',
                'is_active' => true
            ],
            [
                'key' => 'benefits',
                'title' => 'Benefits',
                'content' => json_encode([
                    [
                        'icon' => '📚',
                        'title' => 'Materi Lengkap',
                        'description' => 'Materi ujian yang komprehensif dan up-to-date sesuai standar terbaru'
                    ],
                    [
                        'icon' => '🎯',
                        'title' => 'Latihan Soal',
                        'description' => 'Bank soal dengan ribuan pertanyaan dan pembahasan detail'
                    ],
                    [
                        'icon' => '👨‍🏫',
                        'title' => 'Mentor Berpengalaman',
                        'description' => 'Dibimbing oleh instruktur yang berpengalaman di bidang pemerintahan desa'
                    ],
                    [
                        'icon' => '📱',
                        'title' => 'Akses Fleksibel',
                        'description' => 'Belajar kapan saja dan dimana saja melalui platform online'
                    ]
                ]),
                'type' => 'json',
                'description' => 'Daftar keunggulan kursus',
                'is_active' => true
            ],
            [
                'key' => 'testimonials',
                'title' => 'Testimonials',
                'content' => json_encode([
                    [
                        'name' => 'Ahmad Rizki',
                        'role' => 'Sekretaris Desa',
                        'content' => 'Materi kursus sangat membantu saya mempersiapkan ujian. Alhamdulillah lulus dengan nilai memuaskan!'
                    ],
                    [
                        'name' => 'Siti Nurhaliza',
                        'role' => 'Bendahara Desa',
                        'content' => 'Penjelasan materi mudah dipahami dan latihan soalnya sangat mirip dengan ujian sebenarnya.'
                    ],
                    [
                        'name' => 'Budi Santoso',
                        'role' => 'Kepala Desa',
                        'content' => 'Kursus yang sangat rekomended untuk persiapan ujian perangkat desa. Instrukturnya profesional!'
                    ]
                ]),
                'type' => 'json',
                'description' => 'Testimonial dari alumni',
                'is_active' => true
            ],
            [
                'key' => 'contact_email',
                'title' => 'Email Support',
                'content' => 'support@kursusperangkatdesa.com',
                'type' => 'text',
                'description' => 'Email untuk customer support',
                'is_active' => true
            ],
            [
                'key' => 'contact_phone',
                'title' => 'Telepon Support',
                'content' => '+62 812-3456-7890',
                'type' => 'text',
                'description' => 'Nomor WhatsApp customer support',
                'is_active' => true
            ],
            [
                'key' => 'site_maintenance',
                'title' => 'Mode Maintenance',
                'content' => '0',
                'type' => 'boolean',
                'description' => 'Aktifkan untuk mode maintenance situs',
                'is_active' => true
            ]
        ];

        foreach ($contentBlocks as $block) {
            ContentBlock::updateOrCreate(
                ['key' => $block['key']],
                $block
            );
        }
    }
}
