<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Faq;
use App\Models\PageContent;
use App\Models\PracticeArea;
use App\Models\TeamMember;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'practiceAreas' => PracticeArea::published()->get(),
            'articles' => Article::published()->with('category')->latest('published_at')->take(3)->get(),
            'team' => TeamMember::published()->take(5)->get(),
            'faqs' => Faq::published()->take(4)->get(),
        ]);
    }

    public function profile(): View
    {
        return view('pages.profile', [
            'practiceAreas' => PracticeArea::published()->get(),
            'about' => PageContent::body('profil'),
            'ethics' => PageContent::body('etika'),
            'values' => config('firm.values'),
        ]);
    }

    public function team(): View
    {
        return view('pages.team', [
            'team' => TeamMember::published()->withCount(['articles' => fn ($query) => $query->published()])->get(),
        ]);
    }

    public function faq(): View
    {
        return view('pages.faq', [
            'faqs' => Faq::published()->get(),
        ]);
    }

    public function privacy(): View
    {
        return view('pages.privacy', [
            'body' => PageContent::body('privasi'),
            'updatedAt' => PageContent::query()->where('key', 'privasi')->value('updated_at'),
        ]);
    }
}
