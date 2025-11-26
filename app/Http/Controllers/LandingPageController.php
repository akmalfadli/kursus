<?php
// app/Http/Controllers/LandingPageController.php

namespace App\Http\Controllers;

use App\Models\ContentBlock;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $content = [
            'hero_title' => ContentBlock::getValue('hero_title', 'Kursus Ujian Perangkat Desa'),
            'hero_subtitle' => ContentBlock::getValue('hero_subtitle', 'Persiapkan diri Anda untuk sukses dalam ujian perangkat desa dengan materi terlengkap dan terpercaya'),
            'about_title' => ContentBlock::getValue('about_title', 'Tentang Kursus'),
            'about_content' => ContentBlock::getValue('about_content', 'Kursus komprehensif yang dirancang khusus untuk membantu Anda lulus ujian perangkat desa'),
            'benefits' => ContentBlock::getJsonValue('benefits', $this->getDefaultBenefits()),
            'testimonials' => ContentBlock::getJsonValue('testimonials', $this->getDefaultTestimonials()),
            'price' => ContentBlock::getNumberValue('course_price', config('course.price', 299000)),
            'course_name' => config('course.name', 'Kursus Ujian Perangkat Desa'),
            'contact_email' => ContentBlock::getValue('contact_email', 'support@example.com'),
            'contact_phone' => ContentBlock::getValue('contact_phone', '+62 812-3456-7890'),
            'default_class' => ContentBlock::getValue('default_class', 'Batch 1'),

            // Stats for social proof
            'total_students' => User::where('role', 'customer')->count(),
            'total_graduates' => Transaction::where('payment_status', 'paid')->count(),
            'social_instagram' => ContentBlock::getValue('social_instagram', 'https://instagram.com'),
            'social_facebook' => ContentBlock::getValue('social_facebook', 'https://facebook.com'),
            'success_rate' => '98%', // You can calculate this based on your data
        ];

        $latestPosts = Post::where('is_published', true)
            // ->where(function ($query) {
            //     $query->whereNull('published_at')
            //           ->orWhere('published_at', '<=', now());
            // })
            ->with('category')
            ->latest('created_at')
            ->take(3)
            ->get();

        // Check if site is in maintenance mode
        if (ContentBlock::getBooleanValue('site_maintenance', false)) {
            return view('maintenance', compact('content'));
        }

        return view('landing', compact('content', 'latestPosts'));
    }

    private function getDefaultBenefits(): array
    {
        return [
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
        ];
    }

    private function getDefaultTestimonials(): array
    {
        return [
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
        ];
    }
}
