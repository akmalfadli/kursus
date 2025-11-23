<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\ContentBlock;
use Illuminate\Http\Request;

class BlogController extends Controller
{
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

        $relatedPosts = Post::where('id', '!=', $post->id)
            ->where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        $content = [
             'course_name' => config('course.name', 'Kursus Ujian Perangkat Desa'),
             'contact_email' => ContentBlock::getValue('contact_email', 'support@example.com'),
             'contact_phone' => ContentBlock::getValue('contact_phone', '+62 812-3456-7890'),
        ];

        return view('blog.show', compact('post', 'content', 'relatedPosts'));
    }
}
