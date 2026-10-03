<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        return $this->listing($request);
    }

    public function category(Request $request, ArticleCategory $category): View
    {
        return $this->listing($request, $category);
    }

    public function show(Article $article): View
    {
        abort_unless($article->isPublished(), 404);

        $article->load(['category', 'author']);

        return view('articles.show', [
            'article' => $article,
            'related' => Article::published()
                ->with('category')
                ->whereKeyNot($article->getKey())
                ->orderByRaw('article_category_id = ? desc', [$article->article_category_id])
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }

    protected function listing(Request $request, ?ArticleCategory $category = null): View
    {
        $search = Str::of((string) $request->query('q'))->squish()->limit(100, '')->toString();

        $articles = Article::published()
            ->with('category')
            ->when($category, fn ($query) => $query->whereBelongsTo($category, 'category'))
            ->search($search)
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('articles.index', [
            'articles' => $articles,
            'categories' => ArticleCategory::query()
                ->withCount(['articles' => fn ($query) => $query->published()])
                ->orderBy('sort_order')
                ->get(),
            'activeCategory' => $category,
            'search' => $search,
        ]);
    }
}
