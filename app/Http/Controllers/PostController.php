<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function create()
    {
        $categories = Category::all();
        return view('post.create', compact('categories'));
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tags' => ['nullable', 'string'],
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['description'],
            'category_id' => $validated['category_id'],
        ]);

        // Обрабатываем теги для корректного внесения в БД (Убираем пустые символы)
        if (!empty($validated['tags'])) {
            $tagNames = array_map('trim', explode(',', $validated['tags']));

            $tagNames = array_filter($tagNames, function ($name) {
                return !empty($name);
            });

            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['title' => $tagName]);
                $post->tags()->attach($tag->id);
            }
        }

        return redirect()->route('home')->with('success', 'Пост успешно создан!');
    }


    public function index()
    {
        //  $posts = Post::all();
        $posts = Post::with('category')->paginate(10);
        return view('home', compact('posts'));
    }


    public function show($id)
    {
        $post = Post::with('category', 'tags')->findOrFail($id);
        return view('post.show', compact('post'));
    }
}
