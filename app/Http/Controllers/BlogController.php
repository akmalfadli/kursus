<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\ContentBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
            ->where('is_published', true);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Get the featured post (latest one if no specific logic)
        $featuredPost = null;
        if (!$request->has('page') || $request->page == 1) {
             $featuredPost = $query->clone()->latest()->first();
             if ($featuredPost) {
                 $query->where('id', '!=', $featuredPost->id);
             }
        }

        $posts = $query->latest()->paginate(9);
        $categories = Category::withCount('posts')->get();

        // Screenshots mapping
        $screenshots = [];
        $screenshotPath = public_path('images/screenshots');
        if (File::exists($screenshotPath)) {
            $files = File::files($screenshotPath);
            $descriptions = [
                'dashboard-artikel' => ['title' => 'Artikel & Berita', 'desc' => 'Informasi terbaru seputar ujian dan materi.'],
                'dashboard-daftar-ujian' => ['title' => 'Daftar Ujian', 'desc' => 'Pilih berbagai jenis ujian sesuai kebutuhan Anda.'],
                'dashboard-riwayat-ujian' => ['title' => 'Riwayat Ujian', 'desc' => 'Pantau perkembangan nilai dan hasil ujian Anda.'],
                'login' => ['title' => 'Akses Mudah', 'desc' => 'Login cepat dan aman ke platform belajar.'],
                'materi' => ['title' => 'Materi Lengkap', 'desc' => 'Akses ribuan materi pembelajaran terupdate.'],
                'pembahasan-ujian' => ['title' => 'Pembahasan Detail', 'desc' => 'Pelajari pembahasan soal secara mendalam.'],
                'pemeringkatan-kelas' => ['title' => 'Ranking Kelas', 'desc' => 'Lihat posisi Anda di antara peserta lain.'],
            ];

            foreach ($files as $file) {
                $filename = $file->getFilename();
                // Extract key from filename (e.g. kursus.digidesa.id_dashboard-artikel.png -> dashboard-artikel)
                // Assuming format: domain_key.png
                $parts = explode('_', pathinfo($filename, PATHINFO_FILENAME));
                $key = end($parts); // Take the last part

                if (isset($descriptions[$key])) {
                    $screenshots[] = [
                        'url' => asset('images/screenshots/' . $filename),
                        'title' => $descriptions[$key]['title'],
                        'desc' => $descriptions[$key]['desc'],
                    ];
                } else {
                     // Fallback
                     $screenshots[] = [
                        'url' => asset('images/screenshots/' . $filename),
                        'title' => ucwords(str_replace('-', ' ', $key)),
                        'desc' => 'Platform belajar interaktif.',
                    ];
                }
            }
        }

        // Re-use content for promotion
        $content = [
             'course_name' => config('course.name', 'Kursus Ujian Perangkat Desa'),
             'contact_email' => ContentBlock::getValue('contact_email', 'support@example.com'),
             'contact_phone' => ContentBlock::getValue('contact_phone', '+62 812-3456-7890'),
             'social_instagram' => ContentBlock::getValue('social_instagram', 'https://instagram.com'),
             'social_facebook' => ContentBlock::getValue('social_facebook', 'https://facebook.com')

        ];

        return view('blog.index', compact('posts', 'categories', 'content', 'featuredPost', 'screenshots'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->with('user', 'category')
            ->where('is_published', true)
            // ->where(function ($query) {
            //     $query->whereNull('published_at')
            //           ->orWhere('published_at', '<=', now());
            // })
            ->firstOrFail();

        $post->increment('views');

        $categories = Category::withCount('posts')->get();

        $relatedPosts = Post::where('id', '!=', $post->id)
            ->where('is_published', true)
            ->where('category_id', $post->category_id) // Prioritize same category
            ->latest()
            ->take(3)
            ->get();

        // If not enough related posts, fill with recent
        if ($relatedPosts->count() < 3) {
             $morePosts = Post::where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->where('is_published', true)
                ->latest()
                ->take(3 - $relatedPosts->count())
                ->get();
             $relatedPosts = $relatedPosts->merge($morePosts);
        }

        $content = [
             'course_name' => config('course.name', 'Kursus Ujian Perangkat Desa'),
             'contact_email' => ContentBlock::getValue('contact_email', 'support@example.com'),
             'contact_phone' => ContentBlock::getValue('contact_phone', '+62 812-3456-7890'),
             'social_instagram' => ContentBlock::getValue('social_instagram', 'https://instagram.com'),
             'social_facebook' => ContentBlock::getValue('social_facebook', 'https://facebook.com')

        ];

        return view('blog.article', compact('post', 'content', 'relatedPosts', 'categories'));
    }
}
