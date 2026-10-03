<?php

namespace App\Filament\Resources\ConsultationRequests;

use App\Enums\ConsultationStatus;
use App\Filament\Resources\ConsultationRequests\Pages\EditConsultationRequest;
use App\Filament\Resources\ConsultationRequests\Pages\ListConsultationRequests;
use App\Filament\Resources\ConsultationRequests\Pages\ViewConsultationRequest;
use App\Filament\Resources\ConsultationRequests\Schemas\ConsultationRequestForm;
use App\Filament\Resources\ConsultationRequests\Schemas\ConsultationRequestInfolist;
use App\Filament\Resources\ConsultationRequests\Tables\ConsultationRequestsTable;
use App\Models\ConsultationRequest;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ConsultationRequestResource extends Resource
{
    protected static ?string $model = ConsultationRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static string|UnitEnum|null $navigationGroup = 'Kotak masuk';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'permintaan konsultasi';

    protected static ?string $pluralModelLabel = 'permintaan konsultasi';

    protected static ?string $slug = 'permintaan-konsultasi';

    protected static ?string $recordTitleAttribute = 'name';

    /** Data pribadi tidak ikut pencarian global. */
    protected static bool $isGloballySearchable = false;

    public static function form(Schema $schema): Schema
    {
        return ConsultationRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ConsultationRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConsultationRequestsTable::configure($table);
    }

    /**
     * Akun demo hanya melihat data contoh dan kiriman dari browsernya sendiri
     * (cookie penanda yang dipasang saat form dikirim). Admin asli melihat semua.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('practiceArea')
            ->visibleTo(Filament::auth()->user(), request()->cookie(ConsultationRequest::SUBMITTER_COOKIE));
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getEloquentQuery()->where('status', ConsultationStatus::Baru)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'warning';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConsultationRequests::route('/'),
            'view' => ViewConsultationRequest::route('/{record}'),
            'edit' => EditConsultationRequest::route('/{record}/edit'),
        ];
    }
}
