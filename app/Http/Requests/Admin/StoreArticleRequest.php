<?php

namespace App\Http\Requests\Admin;

use App\Enums\ArticleStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $tags = collect(preg_split('/[,\s]+/', (string) $this->input('tags', '')))
            ->filter()
            ->map(fn (string $tag) => '#'.ltrim($tag, '#'))
            ->unique()
            ->values()
            ->all();

        $keywords = collect(preg_split('/\s*,\s*/', (string) $this->input('meta_keywords', '')))
            ->map(fn (string $k) => trim($k))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $this->merge(['tags' => $tags, 'meta_keywords' => $keywords]);
    }

    public function rules(): array
    {
        $articleId = $this->route('article')?->id;

        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200', 'regex:/^[a-z0-9-]+$/', Rule::unique('articles', 'slug')->ignore($articleId)],
            'excerpt' => ['required', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'meta_keywords' => ['nullable', 'array', 'max:15'],
            'meta_keywords.*' => ['string', 'max:40'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'category' => ['required', 'string', 'max:60'],
            'body' => ['required', 'string'],
            'hero_caption' => ['nullable', 'string', 'max:200'],
            'author_name' => ['required', 'string', 'max:120'],
            'author_role' => ['nullable', 'string', 'max:120'],
            'read_time_minutes' => ['nullable', 'integer', 'min:1', 'max:60'],
            'tags' => ['nullable', 'array', 'max:10'],
            'tags.*' => ['string', 'max:40'],
            'status' => ['required', Rule::enum(ArticleStatus::class)],
            'published_at' => ['nullable', 'date', Rule::requiredIf(fn () => $this->input('status') === ArticleStatus::Scheduled->value)],
            'is_featured' => ['nullable', 'boolean'],
            'cover' => ['nullable', 'image', 'max:4096'],
        ];
    }
}
