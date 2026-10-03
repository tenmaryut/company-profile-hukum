<?php

namespace App\Filament\Widgets;

use App\Enums\ConsultationStatus;
use App\Filament\Resources\ConsultationRequests\ConsultationRequestResource;
use App\Models\Article;
use App\Models\PracticeArea;
use App\Models\TeamMember;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -1;

    protected ?string $heading = 'Ringkasan situs';

    protected function getStats(): array
    {
        $requests = ConsultationRequestResource::getEloquentQuery();

        return [
            Stat::make('Permintaan konsultasi baru', (clone $requests)->where('status', ConsultationStatus::Baru)->count())
                ->description('Dari '.(clone $requests)->count().' kiriman yang tersimpan')
                ->url(ConsultationRequestResource::getUrl('index')),
            Stat::make('Artikel terbit', Article::published()->count())
                ->description(Article::query()->whereNull('published_at')->count().' draf'),
            Stat::make('Bidang praktik aktif', PracticeArea::query()->where('is_published', true)->count()),
            Stat::make('Anggota tim', TeamMember::query()->where('is_published', true)->count()),
        ];
    }
}
