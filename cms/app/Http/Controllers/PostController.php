<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->filled('kategori')
            ? PostCategory::query()->where('slug', $request->string('kategori'))->first()
            : null;

        $posts = Post::published()
            ->with('category')
            ->when($category, fn ($query) => $query->where('post_category_id', $category->id))
            ->latestFirst()
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
            'categories' => PostCategory::query()->orderBy('sort')->get(),
            'activeCategory' => $category,
        ]);
    }

    public function show(Post $post): View
    {
        abort_unless(Post::published()->whereKey($post->getKey())->exists(), 404);

        return view('posts.show', [
            'post' => $post->load('category'),
            'related' => Post::published()->with('category')->whereKeyNot($post->getKey())->latestFirst()->limit(3)->get(),
        ]);
    }
}
