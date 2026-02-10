<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $selectedSlug = $request->query('category');

        $activeCategory = $selectedSlug
            ? Category::where('slug', $selectedSlug)->first()
            : $categories->first();

        $posts = Post::with('category')
            ->when($activeCategory, function ($query) use ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            })
            ->orderBy('title')
            ->get();

        return view('welcome', [
            'categories' => $categories,
            'posts' => $posts,
            'activeCategory' => $activeCategory,
        ]);
    }
}
