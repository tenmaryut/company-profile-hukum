<?php

namespace App\Http\Controllers;

use App\Models\PracticeArea;
use Illuminate\View\View;

class PracticeAreaController extends Controller
{
    public function index(): View
    {
        return view('practice-areas.index', [
            'practiceAreas' => PracticeArea::published()->get(),
        ]);
    }

    public function show(PracticeArea $practiceArea): View
    {
        abort_unless($practiceArea->is_published, 404);

        return view('practice-areas.show', [
            'practiceArea' => $practiceArea,
            'others' => PracticeArea::published()->whereKeyNot($practiceArea->getKey())->get(),
        ]);
    }
}
