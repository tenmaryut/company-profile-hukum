<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\PracticeArea;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $latestArticle = Article::published()->max('updated_at');

        $urls = collect([
            ['loc' => route('home'), 'lastmod' => $latestArticle],
            ['loc' => route('profile')],
            ['loc' => route('practice-areas.index')],
            ['loc' => route('team')],
            ['loc' => route('articles.index'), 'lastmod' => $latestArticle],
            ['loc' => route('faq')],
            ['loc' => route('contact')],
            ['loc' => route('privacy')],
        ])
            ->merge(PracticeArea::published()->get()->map(fn (PracticeArea $area) => [
                'loc' => route('practice-areas.show', $area),
                'lastmod' => $area->updated_at,
            ]))
            ->merge(ArticleCategory::query()->whereHas('articles', fn ($query) => $query->published())->get()->map(fn (ArticleCategory $category) => [
                'loc' => route('articles.category', $category),
            ]))
            ->merge(Article::published()->latest('published_at')->get()->map(fn (Article $article) => [
                'loc' => route('articles.show', $article),
                'lastmod' => $article->updated_at,
            ]));

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /livewire',
            'Allow: /',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n")->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
