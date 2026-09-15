<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Article listing — Figma node 1:2095.
     */
    public function index(Request $request): View
    {
        $term = $request->string('q')->trim()->value();

        // The featured card only makes sense on the unfiltered index.
        $featured = $term ? null : (Article::query()->published()->where('is_featured', true)->latest('published_at')->first()
            ?? Article::query()->published()->latest('published_at')->first());

        $articles = Article::query()
            ->published()
            ->search($term)
            ->when($featured && ! $term, fn ($q) => $q->whereKeyNot($featured->id))
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        return view('pages.articles', ['featured' => $featured, 'articles' => $articles, 'term' => $term]);
    }

    /**
     * Article detail — Figma node 1:2380.
     */
    public function show(Article $article): View
    {
        abort_unless(Article::query()->published()->whereKey($article->id)->exists(), 404);

        $article->increment('views');

        $related = Article::query()->published()->whereKeyNot($article->id)->latest('published_at')->take(3)->get();

        return view('pages.article-detail', ['article' => $article, 'related' => $related]);
    }
}
