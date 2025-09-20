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
            [
                'key' => 'hero_title',
                'title' => 'Hero Title',
                'content' => 'Kursus Ujian Perangkat Desa',
                'type' => 'text'
            ],
            [
                'key' => 'hero_subtitle',
                'title' => 'Hero Subtitle',
                'content' => 'Persiapkan diri Anda untuk sukses dalam ujian perangkat desa dengan materi terlengkap dan terpercaya',
                'type' => 'textarea'
            ],
            [
                'key' => 'about_title',
                'title' => 'About Title',
                'content' => 'Tentang Kursus',
                'type' => 'text'
            ],
            [
                'key' => 'about_content',
                'title' => 'About Content',
                'content' => 'Kursus komprehensif yang dirancang khusus untuk membantu Anda lulus ujian perangkat desa dengan materi terkini dan metode pembelajaran yang efektif.',
                'type' => 'textarea'
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
                'type' => 'json'
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
                    ]
                ]),
                'type' => 'json'
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
