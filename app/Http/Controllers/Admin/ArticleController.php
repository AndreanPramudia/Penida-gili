<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ArticleStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArticleRequest;
use App\Models\Article;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public const CATEGORIES = ['Travel Guides', 'Boat Tips', 'Activities', 'Culture', 'Hotels', 'Fast Boat Transfers'];

    /** Article listing — Figma node 1:9637. */
    public function index(Request $request): View
    {
        $articles = Article::query()
            ->search($request->string('q')->value())
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->value()))
            ->latest('published_at')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.articles', ['articles' => $articles, 'filters' => $request->only(['q', 'status'])]);
    }

    /** Add New Article — Figma node 1:8059. */
    public function create(): View
    {
        return $this->form(new Article(['status' => ArticleStatus::Published, 'read_time_minutes' => 5]));
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $article = Article::query()->create($this->payload($request));

        return redirect()->route('admin.articles')->with('flash', "\"{$article->title}\" saved.");
    }

    public function edit(Article $article): View
    {
        return $this->form($article);
    }

    public function update(StoreArticleRequest $request, Article $article): RedirectResponse
    {
        $article->update($this->payload($request, $article));

        return redirect()->route('admin.articles')->with('flash', "\"{$article->title}\" updated.");
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles')->with('flash', 'Article removed.');
    }

    private function form(Article $article): View
    {
        return view('admin.articles-create', [
            'article' => $article,
            'categories' => self::CATEGORIES,
            'publishModes' => [
                ['value' => ArticleStatus::Published->value, 'label' => 'Publish Immediately', 'description' => 'Live to all passenger channels right away'],
                ['value' => ArticleStatus::Scheduled->value, 'label' => 'Schedule for Later', 'description' => 'Automated release at designated time'],
                ['value' => ArticleStatus::Draft->value, 'label' => 'Save as Draft', 'description' => 'Internal review without public URL'],
            ],
        ]);
    }

    /** @return array<string, mixed> */
    private function payload(StoreArticleRequest $request, ?Article $existing = null): array
    {
        $data = $request->safe()->except(['cover']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['read_time_minutes'] = $data['read_time_minutes'] ?? max(1, (int) ceil(str_word_count(strip_tags($data['body'])) / 200));

        $status = ArticleStatus::from($data['status']);
        $data['published_at'] = match ($status) {
            ArticleStatus::Published => $existing?->published_at ?? now(),
            ArticleStatus::Scheduled => $data['published_at'],
            ArticleStatus::Draft => null,
        };

        if (blank($data['slug'] ?? null)) {
            unset($data['slug']);
        }

        if ($cover = Uploads::store($request->file('cover'), 'articles')) {
            $data['image'] = $cover;
        } elseif (! $existing) {
            $data['image'] = 'featured-fastboat.png';
        }

        return $data;
    }
}
