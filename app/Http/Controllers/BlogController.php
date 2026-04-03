<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(string $locale, Request $request)
    {
        $query = BlogPost::published()->with(['category', 'author']);

        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->input('category'));
        }

        $posts = $query->latest('published_at')->paginate(9);
        $categories = BlogCategory::withCount(['posts' => fn($q) => $q->where('is_published', true)])->get();

        return view('blog.index', compact('posts', 'categories', 'locale'));
    }

    public function show(string $locale, string $slug)
    {
        $post = BlogPost::where('slug', $slug)->published()->with(['category', 'author'])->firstOrFail();

        $relatedPosts = BlogPost::published()
            ->where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts', 'locale'));
    }
}
