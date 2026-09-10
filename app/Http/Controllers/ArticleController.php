<?php

namespace App\Http\Controllers;

use App\Support\ArticleDetails;
use App\Support\Articles;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Article listing — Figma node 1:2095.
     */
    public function index(Request $request): View
    {
        return view('pages.articles', [
            'featured' => Articles::featured(),
            'articles' => $this->paginateCollection(Articles::all(), $request, perPage: 6),
        ]);
    }

    /**
     * Article detail — Figma node 1:2380.
     */
    public function show(string $article): View
    {
        return view('pages.article-detail', ['article' => ArticleDetails::find($article)]);
    }
}
